@extends('layouts.app')

@section('content')
    <script>
        let socket = new WebSocket("ws://192.168.0.41:8080");
        let data;

        socket.onopen = function(e) {
            console.log("[open] Соединение установлено");
        };

        socket.onmessage = function(event) {
            data = JSON.parse(event.data);
            if((data.name && data.message) !== (null && undefined))
            {
                var messages = document.getElementById('chat');
                var message = ''+
                    '<div class="chat">'+
                    '<small><p>'+data.name+'</p></small>'+
                    '<p>'+data.message+'</p>'+
                    '</div>'+
                    '';
                messages.insertAdjacentHTML('beforeend', message);
            }

            if((data.product && data.productSub) !== (null && undefined))
            {
                var messagesDuel = document.getElementById('duel');
                var messageDuel = ''+
                    '<div class="duel">'+
                    '<small><p>'+data.productSub+'</p></small>'+
                    '<p>'+data.product+'</p>'+
                    '</div>'+
                    '';
                messagesDuel.insertAdjacentHTML('beforeend', messageDuel);
            }

        };


        socket.onclose = function(event) {
            if (event.wasClean) {
                console.log(`[close] Соединение закрыто чисто, код=${event.code} причина=${event.reason}`);
            } else {
                // например, сервер убил процесс или сеть недоступна
                // обычно в этом случае event.code 1006
                console.log('[close] Соединение прервано');
            }
        };

        socket.onerror = function(error) {
            console.log(`[error] ${error.message}`);
        };

    </script>
    <iframe name="myIFR" style="display: none"></iframe>
    <div class="row">
            <div class="col">
                <div class="card">
                    <div class=" card-header">
                @include('forms.search')
                    </div>
                    <div class="card-body">
                <div class="duels">
                    <h5>Сейчас в дуэли:</h5><br>
                     @foreach($AllDuels as $duel)
                        <a href="{{ route('showOneDuel', $duel->id2) }}">{{ $duel->name }}</a><br>
                    @endforeach
                </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="duel">
                    <div class="card chat-box " name="duel-box">
                        <div class="card-header">
                            <h4>Дуэль</h4>
                        </div>
                    <div class="card-body chat-content">
                        <div class="duel-card" id="duel">

                        </div>
                    </div>
                        @if(\Illuminate\Support\Facades\Auth::check())
                            <p class="text-center">Добро пожаловать на наш сайт
                                @if(\Illuminate\Support\Facades\Auth::user()->invite == 0)
                                    <form class="text-center" method="POST">
                                        <input type="text" name="invite"/>
                                        <input type="submit"/>
                                    </form>
                            @if(\Illuminate\Support\Facades\Auth::user()->invite == 0)
                                <p class="text-center">Кого вы бы хотелм пригласить на дуэль</p>
                                @foreach($users as $oneUser)
                                    <p class="text-center"> <a class="btn btn-secondary" href="{{ route('showOneDuel', $oneUser->id) }}">{{ $oneUser->name }}</a></p>
                                    @endforeach
                                @endif
                                </p>
                                        @endif
                            @if(\Illuminate\Support\Facades\Auth::user()->invite == 1)
                                <div class="text-center">
                                <a href="{{ route('showOneDuel', $user->id) }}">Принять</a>
                                            <p><b>Если вы не приймите приглашение, через минуту инвайт будет автоматически удален!</b></p>
                                </div>
                            @endif
                        @else
                            <h5 class="text-center"><b>Зарегестрируйтесь<br> и пишите сообщения!</b></h5>
                        @endif
                </div>
                </div>
            </div>

            <div class="col-3">
                <div class="card chat-box" id="chat-box" >
                    <div class="card-header">
                        <h5>Чат</h5>
                    </div>
                    <div class="card-body chat-content">
                <div class="chat " id="chat">
                    @isset($allChat)
                        @foreach($allChat as $chat)
                            <small><p>{{ $chat->name ?? 'None' }}</p></small>
                            <p>{{ $chat->message }}</p>
                        @endforeach
                    @endisset
                 </div>
                    </div>
                    @if(\Illuminate\Support\Facades\Auth::check())
                    @include('forms.chat')
                    @else
                        <h5 class="text-center"><b>Зарегестрируйтесь<br> и пишите сообщения!</b></h5>
                    @endif
                </div>
            </div>

@endsection
