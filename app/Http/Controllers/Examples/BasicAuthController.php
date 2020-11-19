<?php

namespace App\Http\Controllers\Examples;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BasicAuthController extends Controller
{
    public function __construct(){
        $this->middleware('basicAuth');
    }


    public function index(){
        return view('examples.homeBA');
    }
}
