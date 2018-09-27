<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function users()
    {
      return $this->belongsToMany(User::class);
    }

    public function redes()
    {
      return $this->belongsToMany(Rede::class,'role_rede');
    }

    public function hasAnyRede($redes)
    {
      return null !== $this->redes()->whereIn('nome', $redes)->first();
    }

    public function hasRede($rede_id)
    {
      return null !== $this->redes()->where('rede_id', $rede_id)->first();
    }
}
