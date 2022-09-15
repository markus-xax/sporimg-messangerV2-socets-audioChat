<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class winnerController extends Controller
{
    public function index()
    {
        return view('winner');
    }
}
