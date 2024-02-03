<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Pqrs extends Model
{

    protected $fillable = ['user_id', 'target_user_id', 'type', 'description', 'is_active'];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function targetUser() : BelongsTo
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Pqrsmessage::class, 'pqrs_id');
    }

    public function scopeForLoggedUser(Builder $builder): Builder
    {
        return $builder->where('user_id', auth()->id())->orWhere('target_user_id', auth()->id());
    }
}
