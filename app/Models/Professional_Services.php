<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Professional_Services extends Model
{
    protected $fillable = ['professional_id', 'service_id'];
    protected $table = 'professional_services';
    
    public function service() : BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function professional() : BelongsTo
    {
        return $this->belongsTo(Professional::class);
    }
}
