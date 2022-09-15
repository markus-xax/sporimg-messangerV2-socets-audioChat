<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Duels;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DuelsController extends Controller
{
    public function AllDuels()
    {
        return view('home', ['AllDuels' => Duels::all()]);
    }

    public function redirectDuel($id)
    {
        $users = new User();
        $auth = Auth::user()->name;
        $userName = $users->find($id)->name;

        $nameSchema = $auth.$userName;
        $nameSchemaRef = $userName.$auth;

        if (Schema::hasTable("$nameSchema")) {
            return view('oneDuel', [
                'data' => $users->find($id),
                'AllDuels' => Duels::all(),
                'allChat' => Chat::all(),
                'messages'=>DB::table("$nameSchema")->get(),
                'oneDUelForChat'=>DB::table('duels')
                    ->where('name', '=', $nameSchema)
                    ->first()]);
        } elseif (Schema::hasTable("$nameSchemaRef")) {
            return view('oneDuel', [
                'data' => $users->find($id),
                'AllDuels' => Duels::all(),
                'allChat' => Chat::all(),
                'messages'=>DB::table("$nameSchemaRef")->get(),
                'oneDUelForChat'=>DB::table('duels')
                    ->where('name', '=', $nameSchema)
                    ->first()]);
        }
        return view('oneDuel', [
            'data' => $users->find($id),
            'AllDuels' => Duels::all(),
            'allChat' => Chat::all(),
            'oneDUelForChat'=>DB::table('duels')
                ->where('name', '=', $nameSchema)
                ->first()]);


    }

    public function check()
    {
        $users = new User();
        $id = Auth::user()->idGo;
        $auth = Auth::user()->name;
        $userName = $users->find($id)->name;

        $nameSchema = $auth.$userName;
        $nameSchemaRef = $userName.$auth;

        sleep(60);

        if($userName->inDuel == 1)
        {
            return view('oneDuel');
        }

        if($userName->inDuel == 0) {
            if (Schema::hasTable("$nameSchema")) {
                DB::table("$nameSchema")->delete();
                Auth::user()->invite = 0;
                Auth::user()->inDuel = 0;
                $users->find($id)->invite = 0;
                $users->find($id)->inDuel = 0;
                return redirect()->to('/home');
            }
            if(Schema::hasTable("$nameSchemaRef"))
            {
                DB::table("$nameSchemaRef")->delete();
                Auth::user()->invite = 0;
                Auth::user()->inDuel = 0;
                $users->find($id)->invite = 0;
                $users->find($id)->inDuel = 0;
                return redirect()->to('/home');
            }
        }

        return 0;

    }



}
