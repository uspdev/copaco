<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Support\Facades\Gate;
use App\Rede;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','username',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
      return $this->belongsToMany(Role::class);
    }

    /**
    * Check multiple roles
    * @param array $roles
    */
    public function hasAnyRole($roles)
    {
      return null !== $this->roles()->whereIn('nome', $roles)->first();
    }
    /**
    * Check one role
    * @param string $role
    */
    public function hasRole($role)
    {
      return null !== $this->roles()->where('nome', $role)->first();
    }

    /* Método que retorna as redes que o usuário logado tem acesso */
    public function redesComAcesso()
    {
        /* Usuários administradores podem acessar todas redes */
        if( Gate::allows('admin') ) {
            return Rede::all();
        }

        /* Se o usuário não for administrador, vamos filtrar as redes que ele tem acesso.
         * Assim verificamos quais os grupos (roles) que o usuário pertente e quais redes estão
         * associadas a esses grupos. 
         * Se uma dada rede aparece em mais que um grupo ela será adicionada ao array 
         * $redes com array_push múltiplas vezes, assim, temos que usar array_unique 
         * para evitar repetições
         */
        $redes = [];
        foreach($this->roles()->get() as $role){       
            foreach($role->redes()->get() as $rede){
                array_push($redes,$rede);
            }
        }
        return collect(array_unique($redes));
    }

}
