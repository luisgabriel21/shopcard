<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{

    const ADMIN = 1;
    const PARTNER = 2;
    const AFFILIATE = 3;

    protected $fillable =[
        'name',
    ];
    public $timestamps =false;

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

}
