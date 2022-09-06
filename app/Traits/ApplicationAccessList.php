<?php

namespace App\Traits;

use App\Enums\UserRoleEnum;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method static Builder admins()
 * @method static Builder operators()
 * @method static Builder typical_users()
 */
trait ApplicationAccessList
{
    protected array $webAccessList = [
        UserRoleEnum::ADMIN,
        UserRoleEnum::ORGANIZER,
        UserRoleEnum::TYPICAL_USER,
    ];

    /**
     * Returns does the user has access to web portal
     *
     * @return bool
     */
    public function authWeb(): bool
    {
        return $this->roleIn($this->webAccessList) && !$this->is_blocked;
    }

    /**
     * @param array|int $roles
     * @return bool
     */
    public function roleIn(array|int $roles): bool
    {
        return is_array($roles)
            ? in_array($this->role, $roles)
            : $this->role === $roles;
    }

    /**
     * @param Builder $b
     * @return Builder
     */
    public function scopeAdmins(Builder $b): Builder
    {
        return $b->where(['role' => UserRoleEnum::ADMIN]);
    }

    /**
     * @param Builder $b
     * @return Builder
     */
    public function scopeOrganizers(Builder $b): Builder
    {
        return $b->where(['role' => UserRoleEnum::ORGANIZER]);
    }

    /**
     * @param Builder $b
     * @return Builder
     */
    public function scopeTypicalUsers(Builder $b): Builder
    {
        return $b->where(['role' => UserRoleEnum::TYPICAL_USER]);
    }
}
