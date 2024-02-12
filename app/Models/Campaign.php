<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Campaign extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'service_id',
        'title',
        'description',
        'image',
        'start_date',
        'end_date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function scopeForLoggedUser(Builder $builder): Builder
    {
        return $builder->where('user_id', auth()->id());
    }
}
