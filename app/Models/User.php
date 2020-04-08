<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Auth\NoRememberTokenAuthenticable;
use App\Models\Permiso;
use \Arr;

class User extends Authenticatable
{
    use Notifiable;
    use NoRememberTokenAuthenticable;

    public $timestamps = FALSE;
    protected $primaryKey = 'idUsuario';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idUsuario',
        'login',
        'nombre',
        'primerApellido',
        'segundoApellido',
        'telVigente', 
        'curp',
        'fechaNacimiento',
        'sexo',
        'idEstadoNacimiento',
        'estadoNacimiento',
        'idRolUsuario', 
        'descripcionRol'
    ];



    /*
     * Relacion con Permisos
     */
    public function permisos()
    {
        return $this->belongsToMany(\App\Models\Permiso::class,'permiso_user', 'id_usuario','id_permiso');
    }


    public function authorizeRoles($roles)
    {
        if ($this->hasAnyRole($roles)) {
            return true;
        }
        abort(403, 'No tienes permiso para realizar esta operación.');
    }
    
    /**
     * Función que determina si un usuario tiene determinado permiso
     * 
     * @param String|Array $roles Nombre de un permiso o array con nombres de permisos.
     *                            Si $roles es una cadena vacía, verifica que el usuario
     *                            tenga por lo menos un rol
     * @return bool TRUE si tiene el permiso o uno de los permisos. FALSE si no
     */
    public function hasAnyRole($roles=''){
        if(is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        }else{
            if(strlen(trim($roles))===0){
                $roles = Permiso::NB_CIUDADANO;
            }
            if($this->hasRole($roles)) {
                return true;
            }
        }
        return false;
    }

    public function hasRole($role){
        if ($this->permisos()->where('nb_permiso', $role)->first()) {
            return true;
        }
        return false;
    }


}
