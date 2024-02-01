<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subscription extends Model
{
    
    protected $fillable = [
        'user_id',
        'plan_id',
        'start_date',
        'end_date',
        'status',
        'payment_method',
        'is_active',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function scopeForLoggedUser(Builder $builder): Builder
    {
        return $builder->where('user_id', auth()->id());
    }



/**
 * 
    public function scopeForLoggedUser(Builder $builder): Builder
    {
        return $builder
            ->whereHas('students', fn (Builder $query) => $query->where('user_id', auth()->id()));
    }


 **/

}
