<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

use App\Equipamento;

class EquipamentoPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Equipamento $equipamento)
    {
        $owner = $user->id === $equipamento->user_id;
        $admin = $user->role('admin');
        return $owner || $admin;
    }

    public function view(User $user, Equipamento $equipamento)
    {
        $owner = $user->id === $equipamento->user_id;
        $admin = $user->role('admin');
        return $owner || $admin;
    }

    public function delete(User $user, Equipamento $equipamento)
    {
        $owner = $user->id === $equipamento->user_id;
        $admin = $user->role('admin');
        return $owner || $admin;
    }

    public function create(User $user, Equipamento $equipamento)
    {
        return true;
    }
}
