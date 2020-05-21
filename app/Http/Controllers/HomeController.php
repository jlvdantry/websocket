<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Correo;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $html = view('correotemplate')->render();
        $correo = [
        'tx_from' => env('MAIL_FROM_ADDRESS', 'no-reply@cdmx.gob.mx')
        ,'tx_to' => 'memito__1981@hotmail.com'
        ,'tx_subject' => 'Asunto del correo'
        ,'tx_body' => $html
        ,'nu_priority' => 0
        ];
        Correo::create($correo);
        \Artisan::call('llave:enviar-correos');
        return view('home');
    }
}
