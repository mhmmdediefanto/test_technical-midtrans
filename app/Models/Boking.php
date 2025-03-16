<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Boking extends Model
{
    protected $guarded = ['id'];
    protected $table = 'bokings';


    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
