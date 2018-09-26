<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rede extends Model
{  
    public function equipamentos()
    {
        return $this->hasMany('App\Equipamento');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function roles()
    {
      return $this->belongsToMany(Role::class,'role_rede');
    }

    public function hasRole($role)
    {
      return null !== $this->roles()->where('nome', $role)->first();
    }
}
