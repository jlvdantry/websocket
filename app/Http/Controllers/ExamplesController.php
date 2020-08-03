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
            $public = isset($r->chkPublic) && $r->chkPublic == 1;
            $saved = FileService::store($r->file('biArchivo'), $public);
            return view('examples.file-uploaded')->with(compact('saved', 'public'));
        }
    }
}
