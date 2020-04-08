<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class ApiController extends Controller
{
    public function register(){
        dd(Auth::user());
    }
}
