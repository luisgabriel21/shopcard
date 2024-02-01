<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class Admin extends User
{
    

    //Sobreescribir la consulta base del modelo

    public function newQuery($excludeDeleted = true): Builder
    {
        return parent::newQuery($excludeDeleted)
        ->where('role_id', Role::ADMIN);
    }

}
