<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Rede;
use Carbon\Carbon;
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

    public function setEquipamento(Equipamento $equipamento, $validated,$action){
        $validated['vencimento'] = $this->getDataVencimento($validated);
        $resultado = $this->setRede($validated, $this->getIpRede($validated));
        if($action == 'store'){
            $user = Auth::user();
            $validated['user_id'] = $user->id;
            $equipamento = Equipamento::create($validated);
        }
        else{
            $equipamento->update($validated);
        }
        $data = [
            'equipamento' => $equipamento,
            'erro' => $resultado,
        ];    
        return $data;
    }
    
    public function getDataVencimento($equipamento){
        /*  tratamento da data de vencimento. default: 10 anos
         *   TODO: colocar no .env um default e usar de lá.
         */
        if($equipamento['vencimento'] == '') {
            $data = Carbon::now()->addYears(10);
        }
        else{
            $data = Carbon::createFromFormat('d/m/Y', $equipamento['vencimento']);
        }
        return $data;
    }

    public function getIpRede($equipamento){
        /* aqui lidamos com o usuário */
        //$user = Auth::user();
        //$user_id = $user->id;

        /*  aqui a gente lida com obtenção de IP */
        $ip = $equipamento['ip'];
        $rede_id = $equipamento['rede_id'];
        /*  se estiver vazio, será falso */
        $fixarip = $equipamento['fixarip'] ? $equipamento['fixarip'] : 0;

        if (!$fixarip) {
            $ip = null;
        }

        $redes = Rede::allowed()->get();
        if (!$redes->contains('id', $rede_id)) {
            $rede_id = null;
            $ip = null;
        }
        $dados_rede = [
            'rede_id' => $rede_id,
            'ip' => $ip,
            'fixarip' => $fixarip,
        ];

        return $dados_rede;
    }

    public function setRede($equipamento, $dados_rede){
        /*  na primeira vez, trocaremos da rede vazia para alguma
            ou não mexeremos com rede, pois '' != 0 devolve false

            neste momento:
                $ip == null => alocar automático
                $ip != null => tentar alocar $ip
        */
        $cadastra = false;
        $erro = '';
        /* cadastra se redes diferentes */
        if ($equipamento['rede_id'] != $dados_rede['rede_id']) {
            $cadastra = true;
        }
        /* ou se ips diferentes dado redes iguais */
        elseif ($equipamento['ip'] != $dados_rede['ip']) {
            $cadastra = true;
        }

        if ($cadastra) {
            $aloca = NetworkOps::aloca($dados_rede['rede_id'], $dados_rede['ip']);
            if (empty($aloca['danger'])) {
                $equipamento['rede_id'] = $aloca['rede'];
                $equipamento['ip'] = $aloca['ip'];
            }
            else {
                $erro = $aloca['danger'];
                $equipamento['rede_id'] = null;
                $equipamento['ip'] = null;
            }
        }
        return $erro;
    }    
            
}
