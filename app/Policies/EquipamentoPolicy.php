<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

use App\Models\Equipamento;

class EquipamentoPolicy
{
    use HandlesAuthorization;

    public $is_superAdmin;
    
    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->is_superAdmin = Gate::allows('admin') ;
    }

    public function update(User $user, Equipamento $equipamento)
    {
        $owner = $user->id === $equipamento->user_id;
        return $owner || $this->is_superAdmin || $this->temAcessoNaRedeDeUmAdminGrupo($user,$equipamento);
    }

    public function view(User $user, Equipamento $equipamento)
    {
        $owner = $user->id === $equipamento->user_id;
        return $owner || $this->is_superAdmin || $this->temAcessoNaRedeDeUmAdminGrupo($user,$equipamento);
    }

    public function delete(User $user, Equipamento $equipamento)
    {
        $owner = $user->id === $equipamento->user_id;
        return $owner || $this->is_superAdmin || $this->temAcessoNaRedeDeUmAdminGrupo($user,$equipamento);
    }

    public function create(User $user)
    {
        return true;
    }

    public function temAcessoNaRedeDeUmAdminGrupo($user,$equipamento)
    {   
        $rede_id = $equipamento->rede_id;
        foreach($user->roles()->get() as $role){       
            foreach($role->redes()->get() as $rede){
                if($role && $rede->id==$rede_id) {
                    return true;
                }
            }
        }
        return false;
    }

}
