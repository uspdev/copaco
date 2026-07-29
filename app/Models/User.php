<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Traits\HasRoles;
use Uspdev\SenhaunicaSocialite\Traits\HasSenhaunica;

class User extends Authenticatable
{
    use Notifiable, HasFactory, HasRoles, HasSenhaunica;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
