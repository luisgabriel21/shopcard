<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    
    protected $fillable = [
        'name',
        'description',
        'price',
        'duration_months',
        'image',
    ];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function subscribers(): HasMany
    {
        return $this->HasMany(Subscription::class);
    }

}
