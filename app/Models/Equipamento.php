<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Rede;
use App\Models\User;
use Carbon\Carbon;
use Session;
use App\Utils\NetworkOps;
use App\Observers\EquipamentoObserver;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\File;

class Equipamento extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    protected $guarded = [
        'id',
    ];
   
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        Equipamento::observe(EquipamentoObserver::class);
    }

    public function rede()
    {
        return $this->belongsTo(Rede::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
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
        /* 0. Usuário administradores acessam todas redes */
        if (Gate::allows('admin')) {
            return $query;
        }

        /* 1. E não administradores acessam equipamentos que são donos */
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

    public function setVencimentoAttribute($value) {
        if($value){
            $this->attributes['vencimento'] = Carbon::createFromFormat('d/m/Y', $value);
        }
        else {
            $this->attributes['vencimento'] = Carbon::now()->addYears(10);
        }
    }

    public function getVencimentoAttribute($value) {
        if($value){
            $Ymd = substr($value,0,10);
            return Carbon::CreateFromFormat('Y-m-d', $Ymd)->format('d/m/Y');
        }
    }

    /* Quando a rede está zerada, temos que zerar o campo IP */
    public function setRedeIpAttribute($value){
        !empty($value) ?: $this->attributes['ip'] = null;
    }

    public function setIpAttribute($value){
        $aloca = NetworkOps::aloca($this->rede_id, $value, $this->ip);
        $this->attributes['rede_id'] = $aloca['rede'];
        $this->attributes['ip'] = $aloca['ip'];
        empty($aloca['danger']) ?: Session::flash('alert-danger', $aloca['danger']);
    }    
}
