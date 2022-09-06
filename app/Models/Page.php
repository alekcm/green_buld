<?php

namespace App\Models;

use App\Enums\UserRoleEnum;
use Cviebrock\EloquentSluggable\Sluggable;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kalnoy\Nestedset\NodeTrait;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @property int $id
 * @property int $parent_id
 * @property bool $show_main
 * @property bool $is_published
 * @property string $title
 * @property string $slug
 * @property string $path
 * @property int $order
 * @property string $icon
 * @property string $content
 * @property array $content_table
 * @property array $breadcrumbs
 * @property array $available
 *
 * @property-read array $icon_path
 *
 * @property-read Page $parent
 * @property-read Page[]|Collection $children
 * @property-read Page[]|Collection $availableChildren
 *
 * @method static Builder|Page showMain()
 * @method static Builder|Page sortByOrder()
 * @method static Builder|Page available(User $user)
 *
 * @mixin Eloquent
 */
class Page extends Model
{
    use NodeTrait, Sluggable {
        NodeTrait::replicate as replicateNodeTrait;
        Sluggable::replicate as replicateSluggable;
    }

    public function replicate(array $except = null)
    {
        $this->replicateNodeTrait();
        $this->replicateSluggable();
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function (self $model) {

            if ($model->isDirty('slug', 'parent_id')) {
                $model->generatePath();
            }
        });

        static::saved(function (self $model) {
            static $updating = false;

            if (!$updating && $model->isDirty('path', 'available',)) {
                $updating = true;
                $model->updateDescendantsPaths();
                $updating = false;
            }
        });
    }

    public function generatePath(): static
    {
        $slug = $this->slug;

        $this->path = $this->isRoot() ? $slug : $this->parent->path . '/' . $slug;

        $this->available = $this->isRoot() ? $this->available : $this->parent->available;

        $breadcrumb = ['title' => $this->title, 'path' => $this->path];

        if ($this->isRoot()) {
            $this->breadcrumbs = [$breadcrumb];

        } else {
            $tempBreadcrumbs = $this->parent->breadcrumbs;
            $tempBreadcrumbs[] = $breadcrumb;
            $this->breadcrumbs = $tempBreadcrumbs;
        }

        return $this;
    }

    public function updateDescendantsPaths()
    {
        $descendants = $this->descendants()->defaultOrder()->get();
        $descendants->push($this)->linkNodes()->pop();
        foreach ($descendants as $model) {
            $model->generatePath()->save();
        }
    }

    protected $fillable = [
        'parent_id',
        'show_main',
        'is_published',
        'title',
        'slug',
        'order',
        'icon',
        'content',
        'content_table',
        'path',
        'breadcrumbs',
        'available',
        '_lft',
        '_rgt',
    ];

    protected $casts = [
        'content_table' => 'array',
        'breadcrumbs' => 'array',
        'available' => 'array',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function scopeShowMain(Builder $query): Builder
    {
        return $query->where('show_main', true);
    }

    public function scopeAvailable(Builder $query, User $user): Builder
    {
        if ($user->role === UserRoleEnum::ADMIN) {
            return $query;
        }

        return $query->where('is_published', true)->whereJsonContains('available', $user->role);
    }

    public function scopeSortByOrder(Builder $query): Builder
    {
        return $query->orderBy('order');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Page::class, 'parent_id', 'id');
    }

    public function availableChildren(User $user): HasMany
    {
        if ($user->role === UserRoleEnum::ADMIN) {
            return $this->children();
        }

        return $this->children()->where('is_published', true);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'parent_id', 'id');
    }

    public function getIconPathAttribute(): ?string
    {
        return is_null($this->icon) ? null : config('app.page.icon.path') . '/' . $this->icon;
    }
}
