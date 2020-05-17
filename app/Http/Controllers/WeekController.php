<?php

namespace App\Http\Controllers;

use App\Week;
use Illuminate\Http\Request;

class WeekController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $weeks = Week::all();

        return response()->json($weeks);
    }
}
