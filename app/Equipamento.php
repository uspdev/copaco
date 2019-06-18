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

    public function scopeAllowed($query)
    {
        $user = Auth::user();
        if (!Gate::allows('admin')) {
        
            $query->OrWhere('user_id', '=', $user->id);
            foreach ($user->roles()->get() as $role) {
                if ($role->grupoadmin) {
                    $query->OrWhere(function($q) use ($role, $user) {
                        foreach ($role->redes()->get() as $rede) {
                            $q->OrWhere('rede_id', '=', $rede->id);
                        }
                        $q->OrWhere('user_id', '=', $user->id);
                    });
                }
            }
        }
        return $query;
    }
 
}
