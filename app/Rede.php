<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rede extends Model
{
    //

        
    public function equipamentos()
    {
        return $this->hasMany('App\Equipamento');
    }
}
