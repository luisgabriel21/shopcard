<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Schedule extends Model
{

    protected $fillable = ['professional_id', 'schedule_date', 'start_time', 'end_time', 'user_id'];

    public function professional() : BelongsTo
    {
        return $this->belongsTo(Professional::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeForLoggedUser(Builder $builder): Builder
    {
        return $builder->where('user_id', auth()->id());
    }
}
