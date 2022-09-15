<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Duels;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function allChat(Request $request)
    {

        return view('home', ['allChat'=>Chat::all(),
            'AllDuels'=>Duels::all(),
            'users'=>User::all(),
            'user'=>Auth::user()]);
    }
}
