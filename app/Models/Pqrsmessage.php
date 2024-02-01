<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pqrsmessage extends Model
{

    protected $fillable = ['pqrs_id', 'sender_id', 'message'];

    public function pqrs(): BelongsTo
    {
        return $this->belongsTo(Pqrs::class, 'pqrs_id');
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

}
