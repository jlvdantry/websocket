<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AdipUtils\FileService;

class ExamplesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    
    public function uploadFile(Request $r){        
        if($r->hasFile('biArchivo')){
            $saved = FileService::store($r->file('biArchivo'));
            return view('examples.file-uploaded')->with(compact('saved'));
        }
    }
}
