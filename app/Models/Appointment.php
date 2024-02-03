<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Appointment extends Model
{
    protected $fillable = ['user_id', 'affiliate_id','professional_id', 'service_id', 'appointment_datetime', 'status'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function afilliate(): BelongsTo
    {
        return $this->belongsTo(User::class, 'affiliate_id');
    }

    public function professional(): BelongsTo
    {
        return $this->belongsTo(Professional::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Appointment_Messages::class, 'appointment_id');
    }

    public function scopeForLoggedUser(Builder $builder): Builder
    {
        return $builder->where('user_id', auth()->id());
    }

}
