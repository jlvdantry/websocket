<?php

namespace App\Models;
//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
//use Illuminate\Notifications\Notifiable;
//use App\Auth\NoRememberTokenAuthenticable;
use App\Models\Permiso;
use \Arr;

use Illuminate\Database\Eloquent\Model;

class ApiApp extends Authenticatable
{
    public $timestamps = FALSE;
    protected $primaryKey = 'id';
    protected $table = 'apps_api';
    protected $hidden = ['created_at', 'updated_at', 'api_token'];
    
}

