<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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

    /* Escopo local: https://laravel.com/docs/7.x/eloquent#local-scopes
     * O escopo retorna a cláusula where da query em questão.
     * Nesse caso, o usuário pode acessar os equipamentos que ele é dono
     * ou equipamentos de uma rede que está associada a um grupo que ele
     * faz parte. Porém, existem dois tipos de grupos:
     *  - grupo admin: permite qualquer usuário do grupo acessar e administratar
     *                 os equipamentos das redes do grupo em questão
     *  - grupo normal: permite os usuários pertencente ao grupo apenas inserir
     *                     equipamentos nas redes associadas, mas não da acesso
     *                     a outras máquinas que não as dele.
     * 
     * Como o método se chama scopeAllowed, ele deve ser chamado:
     *   App\Equipamento::allowed();
     * Podemos inspecionar a query gerada assim:
     *   dd(Equipamento::allowed()->toSql());
     */
    public function scopeAllowed($query,$type='normal')
    {
        /* 0. Usuário administadores acessam todas redes */
        if (Gate::allows('admin')) {
            return $query;
        }

        /* 1. E não administradores acessam equipamentos que ele é dono */
        $user = auth()->user();
        $query->where('user_id', '=', $user->id);
        
        /* 2. E não administradores também podem ver Equipamentos das redes dos grupos
         *    que ele pertence. Mas temos que verificar se a chamada do scope quer um retorno
         *    do tipo admin, isto é, só vamos retornar os equipamentos dos grupos administrativos, 
         *    ou normal, que retorna todas equipamentos das redes de todos grupos que usuário pertence,
         *    sem restrição.
         */
        $redes = [];
        foreach ($user->roles()->get() as $role) {
            if($type == 'normal') {
                foreach($role->redes()->get() as $rede){
                    array_push($redes,$rede->id);
                }    
            } else if ($type == 'admin' & $role->grupoadmin) {
                foreach($role->redes()->get() as $rede){
                    array_push($redes,$rede->id);
                }
            }
        }

        /* Se uma dada rede aparece em mais que um grupo ela será adicionada ao array 
         * $redes com array_push múltiplas vezes, assim, temos que usar array_unique 
         * para evitar repetições
         */
        $query->OrWhereIn('rede_id',array_unique($redes));
        return $query;
    }
 
}
