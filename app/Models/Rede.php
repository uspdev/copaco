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

}
