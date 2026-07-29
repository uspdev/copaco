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
