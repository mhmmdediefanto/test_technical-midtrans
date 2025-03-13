<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = ['id'];
    protected $tables = 'payments';


    public function boking()
    {
        return $this->belongsTo(Boking::class);
    }
}
