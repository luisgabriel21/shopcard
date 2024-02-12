<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relaciones de usuario
     */
    
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function subscription(): BelongsToMany
    {
        return $this->belongsToMany(Subscription::class);
    }

    // Relación con el modelo Professional (un usuario puede tener muchos profesionales asociados)
    public function professionals(): HasMany
    {
        return $this->hasMany(Professional::class);
    }

    // Relación con el modelo PQR (un usuario puede tener muchas PQRs)
    public function pqrs(): HasMany
    {
        return $this->hasMany(Pqrs::class. 'user_id', 'target_user_id');
    }



    // Relación con el modelo PQRMessage (un usuario puede tener muchos mensajes de PQR)
    public function pqrsMessages(): HasMany
    {
        return $this->hasMany(Pqrsmessage::class);
    }

    // Relación con el modelo Service (un usuario puede tener muchos servicios)
    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    // Relación con el modelo ProfessionalService (un usuario puede tener muchos servicios asociados a profesionales)
    public function professionalServices(): HasManyThrough
    {
        return $this->hasManyThrough(Professional_Services::class, Professional::class);
    }

    // Relación con el modelo Schedule (un usuario puede tener muchas agendas)
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    // Relación con el modelo Appointment (un usuario puede tener muchas citas como aliado o afiliado)
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'user_id', 'affiliate_id'); // 'user_id' es la clave foránea en la tabla Appointment
    }

    // Relación con el modelo AppointmentMessage (un usuario puede tener muchos mensajes de citas)
    public function appointmentMessages(): HasMany
    {
        return $this->hasMany(Appointment_Messages::class);
    }

    public function campaigns(): HasMany
    {
        return $this->hasMany(Campaign::class);
    }

}
