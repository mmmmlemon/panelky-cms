<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    //index
    //домашаняя страница сайта
    public function index()
    {
        $site_title = Settings::get()[0]->site_title;
        return view('index', compact('site_title'));
    }
}
