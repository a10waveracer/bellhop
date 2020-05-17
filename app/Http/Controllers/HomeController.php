<?php

namespace App\Http\Controllers;

use App\User;
use App\Week;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $now = Carbon::now('America/New_York');
        $weeks = Week::where('year', '=', $now->year)
            ->where('week', '=', $now->week)->get();
        return view('home', compact('weeks'));
    }
}
