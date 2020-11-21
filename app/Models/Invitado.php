<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Auth\NoRememberTokenAuthenticable;
use App\Models\Permiso;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Arr;

class Invitado extends Authenticatable
{
    /**
     * Traits
     */
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tx_apellido_paterno', 'tx_apellido_materno', 'tx_nombre', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];



    protected $guard = 'invitado';

}
