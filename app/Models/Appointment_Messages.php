<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment_Messages extends Model
{
    protected $fillable = ['appointment_id', 'user_id', 'message'];
    protected $table = 'appointment_messages';

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


}
