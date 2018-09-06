<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipamento extends Model
{
    protected $guarded = [
        'id',
    ];
    
    public function rede()
    {
        return $this->belongsTo('App\Rede');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
