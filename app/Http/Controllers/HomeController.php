<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Correo;
use App\AdipUtils\MailFactory;

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
        $foo = MailFactory::sendMail(
            new Correo([
                'tx_from' => config('mail.from.adderss', 'no-reply@cdmx.gob.mx')
                ,'tx_to' => 'memito__1981@hotmail.com'
                ,'tx_subject' => 'Asunto del correo'
                ,'tx_body' => 'Prueba de mensaje'
                ,'nu_priority' => 0        
            ])
        );
        return view('home');
    }
}
