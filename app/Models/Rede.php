<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use App\Models\Role;
use App\Models\Equipamento;
use App\Models\User;
use App\Observers\RedeObserver;
use OwenIt\Auditing\Contracts\Auditable;

class Rede extends Model implements Auditable
{  
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = ['id'];

    protected static function booted()
    {
        Rede::observe(RedeObserver::class);
    }

    public function equipamentos()
    {
        return $this->hasMany(Equipamento::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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
