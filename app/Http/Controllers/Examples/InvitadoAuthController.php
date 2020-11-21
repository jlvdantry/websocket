<?php

namespace App\Http\Controllers\Examples;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvitadoAuthController extends Controller
{
    public function __construct(){
        $this->middleware('auth:invitado');
    }

    public function index(){
        echo 'Hi';
    }
}
