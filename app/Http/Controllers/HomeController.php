<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\AdipUtils\FileService;


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
        // $f = new \SplFileInfo(
        //     storage_path('app'.DIRECTORY_SEPARATOR.'cron_manual_3.log')
        // );
        // $res = FileService::addToStorage($f);

        return view('home');
    }
}
