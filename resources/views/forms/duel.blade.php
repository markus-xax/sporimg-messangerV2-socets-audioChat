<div class="card-footer chat-form" >
    <form id="chat_form" method="POST" target="myIFR">
        @csrf
        <div class="text-center chat-control">
        <input type="text" name="OneDuelMessage" id="OneDuelMessage" class="form-control" placeholder="Сообщение">
            <br>
        <button class="btn btn-secondary" type="submit">
            Отправить
        </button>
        </div>
    </form>
</div>
