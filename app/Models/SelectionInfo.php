<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $procedure_number
 * @property string $lot_number
 * @property string|null $lot_subject
 * @property string $status_name
 * @property string|null $step_name
 * @property int|null $proposals_number
 *
 * @property Carbon $started_at
 * @property Carbon $ended_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @mixin Eloquent
 */
class SelectionInfo extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'procedure_number',
        'lot_number',
        'lot_subject',
        'status_name',
        'step_name',
        'proposals_number',
        'started_at',
        'ended_at',
        'created_at',
    ];

    public function getFormattedCreatedAtAttribute(): string
    {
        return $this->created_at ? Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format(config('app.datetime_format')) : '';
    }

    public function getFormattedStartedAtAttribute(): string
    {
        return $this->started_at ? Carbon::createFromFormat('Y-m-d H:i:s', $this->started_at)->format(config('app.datetime_format_short')) : '';
    }

    public function getFormattedEndedAtAttribute(): string
    {
        return $this->ended_at ? Carbon::createFromFormat('Y-m-d H:i:s', $this->ended_at)->format(config('app.datetime_format_short')) : '';
    }
}
