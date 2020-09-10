<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;

class Rede extends Model
{  
    protected $guarded = ['id'];

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

    /* Método que retorna as redes que o usuário logado tem acesso */
    public function scopeAllowed($query)
    {
        /* Usuários administradores podem acessar todas redes */
        if( Gate::allows('admin') ) {
            return $query;
        }

        $user = auth()->user();
        $redes = [];
        foreach($user->roles()->get() as $role){       
            foreach($role->redes()->get() as $rede){
                array_push($redes,$rede->id);
            }
        }
        $query->OrWhereIn('id',array_unique($redes));
        return $query;
    }
}
