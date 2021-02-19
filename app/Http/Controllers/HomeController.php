<?php

namespace App\Http\Controllers;

use App\Models\Estimate;

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
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $count = [];
        $count['estimates'] = Estimate::all()->count();
        return view('dashboard',['count' => $count]);
    }
}
