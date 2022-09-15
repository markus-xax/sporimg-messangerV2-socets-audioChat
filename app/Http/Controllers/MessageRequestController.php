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

class MessageRequestController extends Controller
{
    public function index(Request $request, $id = 0)
    {
        $usersDb = new User();
        $messages = new Duels();
        $auth = Auth::user()->name;

        if($id>0)
        {
            $userName = $usersDb->find($id)->name;
        } else {
            $userName = 'null';
        }


        $nameSchema = $auth.$userName;
        $nameSchemaRef = $userName.$auth;

        $data = ['name'=>Auth::user()->name, 'message'=>$request->input('messageChat'),
            'productSub'=>Auth::user()->name, 'product'=>$request->input('OneDuelMessage')];

        if($data['message'] !== null){
            $chat = new Chat();
            $chat->name = Auth::user()->name;
            $chat->message = $request->input('messageChat');
            $chat->save();
        }

        if($data['product'] !== null)
        {
            $users = new User();
            $duels = new Duels();


            $user = $users->find($id);

            if(Auth::user()->inDuel == 0 && $user->invite == 0)
            {
                Auth::user()->inDuel = 1;
                $user->invite = 1;
                $user->idGo = $user->id;
                $user->save();
                Auth::user()->save();

            }
            if (!Schema::hasTable("$nameSchema") || !Schema::hasTable("$nameSchemaRef")) {
                Schema::create("$nameSchema", function (Blueprint $table) {
                    $table->bigIncrements('id');
                    $table->string('nameAuth');
                    $table->text('text');
                });

                $duels->name = $nameSchema;
                $duels->id1 = Auth::user()->id;
                $duels->id2 = $user->id;

                $duels->save();

                $duel = DB::table('duels')
                    ->where('name', '=', $nameSchema)
                    ->first();

                $user->idDuel = $duel->id;

                $user->save();

                $messages->name = $nameSchema;

                $messages->save();



            } else {

                if (Schema::hasTable("$nameSchema")) {
                    DB::table("$nameSchema")->insert(
                        array(
                            'nameAuth' => $auth,
                            'text' => $data['product']
                        )
                    );
                } elseif (Schema::hasTable("$nameSchemaRef")) {
                        DB::table("$nameSchemaRef")->insert(
                            array(
                                'nameAuth' => $auth,
                                'text' => $data['product']
                            )
                        );
                }

            }
        }


        $client = new \WebSocket\Client("ws://192.168.0.41:8080");
        $client->text(json_encode($data));
        $client->receive();
        $client->close();

        return response()->redirectTo('/home');

    }


}
