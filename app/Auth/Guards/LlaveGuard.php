<?php

namespace App\Auth\Guards;

use App\Models\{User,LlaveSesion, LogSesion, Permiso};
use App\AdipUtils\{LlaveCDMX,Network};
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Log;
use Auth;
use App\AdipUtils\ErrorLoggerService as Logg;


/**
 * Class LlaveGuard
 * 
 */
class LlaveGuard implements Guard{
    /**
     * @var null|Authenticatable|User
     */
    protected $user;

    /**
     * @var Request
     */
    protected $request;

    /**
     * OpenAPIGuard constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        //$request->session()->regenerate();
        $this->request = $request;
        $requuid = Str::uuid()->toString();
        session()->put('requuid', $requuid);
        
    }

    /**
     * Check whether user is logged in.
     *
     * @return bool
     */
    public function check(): bool
    {
        return (bool)$this->user();
    }

    /**
     * Check whether user is not logged in.
     *
     * @return bool
     */
    public function guest(): bool
    {
        return !$this->check();
    }

    /**
     * Return user id or null.
     *
     * @return null|int
     */
    public function id(): ?int
    {
        $user = $this->user();
        return $user->idUsuario ?? null;
    }

    /**
     * Manually set user as logged in.
     * 
     * @param  null|\App\User|\Illuminate\Contracts\Auth\Authenticatable $user
     * @return $this
     */
    public function setUser(?Authenticatable $user): self
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @param  array $credentials
     * @return bool
     */
    public function validate(array $credentials = []): bool
    {
        throw new \BadMethodCallException('Unexpected method call');
    }

    /**
     * Return user or throw AuthenticationException.
     *
     * @throws AuthenticationException
     * @return \App\User
     */
    public function authenticate(): User{
        $user = $this->user();
        if ($user instanceof User) {
            return $user;
        }
        throw new AuthenticationException();
    }

    /**
     * Return cached user or newly authenticate user.
     *
     * @return null|\App\User|\Illuminate\Contracts\Auth\Authenticatable
     */
    public function user(): ?User
    {
        return $this->user ?: $this->signInWithLlave();
    }

    /**
     * Sign in using LlaveCDMX.
     *
     * @return null|User
     */
    protected function signInWithLlave(): ?User{
        $_code = $this->request->code;

        $tk = session()->get('ix_token');
        // Ver si la URL trae código
        if(strlen(trim($_code))===0){
            //No trae, ver si hay sesion
            return $this->searchSession();
        }else{
            $oSession = LlaveSesion::where('tx_code', $_code)->first();
            //Log::info('Sesion: '.$oSession);
            if ($oSession instanceof LlaveSesion){
                if(NULL === $tk){
                    $html = view('redirect')->render();
                    die($html);
                }else{
                    return $this->validateSession($oSession);
                }
            }else{
                // Autenticación usando Llave CDMX
                $cdmxAuth = new LlaveCDMX;
                $res = $cdmxAuth->authenticate($_code);
                if(isset($res->error)){
                    //Logg::log(__METHOD__,$res->errorDescription, 401);
                    // abort(401,$res->errorDescription);
                    header('HTTP/1.1 401 '.$res->errorDescription,TRUE,401);
                    $e = view('llave.auth-error')->with(compact('res'))->render();
                    die ($e);
                }
                if(isset($res->accessToken)){
                    // Obtener el user
                    $u=$cdmxAuth->getUser($res->accessToken);
                    if($u instanceof User){
                        $u->fechaNacimiento = Carbon::createFromFormat('d/m/Y', $u->fechaNacimiento);
                        $uBase = User::where('idUsuario',$u->idUsuario)->first();
                        if(!$uBase instanceof User){
                            $permisosLlave = $cdmxAuth->getRoles($res->accessToken, $u);
                            $u->save();
                            for($p=0;$p<$permisosLlave->size();$p++){
                                $u->permisos()->attach($permisosLlave->getItem($p));
                            }
                            $u->descripcionRol = $permisosLlave->getItem(0)->nb_permiso;
                            $u->update();
                        }else{
                            if($u->login !== $uBase->login){
                                $uBase->login = $u->login;
                            }
                            $permisosLlave = $cdmxAuth->getRoles($res->accessToken, $uBase);
                            $uBase->permisos()->detach();
                            for($p=0;$p<$permisosLlave->size();$p++){
                                $uBase->permisos()->attach($permisosLlave->getItem($p));
                            }
                            $u->descripcionRol = $permisosLlave->getItem(0)->nb_permiso;
                            $uBase->descripcionRol = $permisosLlave->getItem(0)->nb_permiso;
                            $uBase->update();
                        }
                        $ixToken=hash('sha256', microtime(true).'ADIP/CDMX'.Network::getClientIP().Network::getClientUA().Str::random(30));;
                        $tsIni=microtime(true);
                        $tsFin=$tsIni + ((int)config('session.lifetime'))*60;
                        $pSesion=[
                            'tx_code' => $_code
                            ,'tx_token' => $res->accessToken
                            ,'ix_token' => $ixToken
                            ,'id_usuario' => $u->idUsuario
                            ,'tx_user_agent' => Network::getClientUA()
                            ,'tx_ip' => Network::getClientIP()
                            ,'tx_stamp_inicia' => $tsIni
                            ,'tx_stamp_caduca' => $tsFin
                            ,'st_abierta' => LlaveSesion::OPEN
                            ,'fh_registra' => date("Y-m-d h:i:s")
                        ];
                        $log = new LlaveSesion($pSesion);
                        if($log->save()){
                            // Log aqui
                            LogSesion::create([
                                'ix_token' => $ixToken
                                ,'tx_mensaje' => 'Sesión iniciada ('.Network::getClientIP().')'
                                ,'fh_registra' => date("Y-m-d H:i:s")
                            ]);
                            session()->put('LlaveUser', $u);
                            session()->put('ix_token', $ixToken);
                        }else{
                            //Logg::log(__METHOD__,'No se inició la sesión', 500);
                            //abort(500, 'No pudimos iniciar la sesión. Por favor intenta de nuevo');
                            header('HTTP/1.1 500 No pudimos iniciar la sesión',TRUE,500);
                            die('<pre>No pudimos iniciar la sesión</pre>');
                        }
                        
                    }
                    return $u;
                    
                }else{
                    //Logg::log(__METHOD__,'No se inició la sesión. Error en LlaveCDMX '.$res, 500);
                    //abort(500,'Ocurrió un error al comunicarnos con los servicios de LlaveCDMX. Ya lo estamos solucionando.');
                    header('HTTP/1.1 500 Ocurrió un error al comunicarnos con los servicios de LlaveCDMX',TRUE,500);
                    die('<pre>Ocurrió un error al comunicarnos con los servicios de LlaveCDMX</pre>');
                }
            }
        }
    }

    /**
     * Logout user.
     */
    public function logout(): void{
        $oSesion = LlaveSesion::where('ix_token',session()->get('ix_token'))->first();
        $oSesion->st_abierta = LlaveSesion::CLOSED;
        $oSesion->update();
        // session()->forget('ix_token');
        // session()->forget('LlaveUser');
        session()->flush();
        
        if ($this->user) {
            $this->setUser(null);
        }
    }

    private function validateSession(LlaveSesion $oSession): ?User{
        // Hay sesion con ese código, ver si es válida
        
        if(!(session()->get('ix_token')==$oSession->ix_token)){
            LogSesion::create([
                'ix_token' => session()->get('ix_token')
                ,'tx_mensaje' => 'El token de la sesión cliente no coincide.'
                ,'fh_registra' => date("Y-m-d H:i:s")
            ]);
            $this->logout();
            return NULL;
        }
        
        // Ver si está abierta
        if($oSession->st_abierta !== LlaveSesion::OPEN){
            LogSesion::create([
                'ix_token' => $oSession->ix_token
                ,'tx_mensaje' => 'La sesión fue cerrada'
                ,'fh_registra' => date("Y-m-d H:i:s")
            ]);
            $this->logout();
            return NULL;
        }
        
        // Ver si no ha caducado
        $finn = (float)$oSession->tx_stamp_caduca;
        $ahora = microtime(true);
        if($ahora>$finn){
            LogSesion::create([
                'ix_token' => $oSession->ix_token
                ,'tx_mensaje' => 'La sesión ha caducado'
                ,'fh_registra' => date("Y-m-d H:i:s")
            ]);
            $this->logout();
            return NULL;
        }
        
        // User agent
        if($oSession->tx_user_agent !== Network::getClientUA()){
            LogSesion::create([
                'ix_token' => $oSession->ix_token
                ,'tx_mensaje' => 'Posible intento de sesion hijacking, el agente de usuario no coincide.  Se esperaba '.$oSession->tx_user_agent.' pero se envió '.Network::getClientUA()
                ,'fh_registra' => date("Y-m-d H:i:s")
            ]);
            if(config('engine.validate_ua')){
                $this->logout();
                abort(418,'El agente de usuario no coincide. Cerramos tu sesión por seguridad.');
            }
        }
        
        // IP        
        if($oSession->tx_ip != Network::getClientIP()){
            LogSesion::create([
                'ix_token' => $oSession->ix_token
                ,'tx_mensaje' => 'Se detectó un cambio de red. Posible intento de session hijacking.  Se esperaba '.$oSession->tx_ip.' pero se envió '.Network::getClientIP()
                ,'fh_registra' => date("Y-m-d H:i:s")
            ]);
            if(config('engine.validate_ip')){
                $this->logout();
                abort(418,'Detectamos un cambio de red. Cerramos tu sesión por seguridad');
            }
        }
        
        // Armar user aquí
        if(session()->get('LlaveUser') instanceof User){
            return session()->get('LlaveUser');
        }
    }

    private function searchSession(): ?User{
        $ix = session()->get('ix_token');
        if(strlen(trim($ix))===0){
            return NULL;
        }

        $oSession = LlaveSesion::where('ix_token', $ix)->first();
        if ($oSession instanceof LlaveSesion){
            return $this->validateSession($oSession);
        }
        //Log::info("Session es NULL");
        return NULL;
    }

}