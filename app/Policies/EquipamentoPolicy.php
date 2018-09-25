<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

use App\Equipamento;

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
        $codpesAdmins = explode(',', trim(env('SUPERADMIN_IDS')));
        $this->is_superAdmin = Auth::check() && in_array(Auth::user()->id, $codpesAdmins);
    }

    public function update(User $user, Equipamento $equipamento)
    {
        $owner = $user->id === $equipamento->user_id;
        return $owner || $this->is_superAdmin;
    }

    public function view(User $user, Equipamento $equipamento)
    {
        $owner = $user->id === $equipamento->user_id;
        return $owner || $this->is_superAdmin;
    }

    public function delete(User $user, Equipamento $equipamento)
    {
        $owner = $user->id === $equipamento->user_id;
        $admin = $user->role('admin');
        return $owner || $this->is_superAdmin;
    }

    public function create(User $user, Equipamento $equipamento)
    {
        return true;
    }
}
