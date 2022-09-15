<div class="card-footer chat-form">
    <form id="chat_form" method="POST" target="myIFR">
        @csrf
        <div class="text-center chat-control">
            <input type="text" name="messageChat" id="messageChat" class="form-control" placeholder="Сообщение">
            <br>
            <button class="btn btn-secondary" id="message" name="message" type="submit">
                Отправить
            </button>
        </div>
    </form>
</div>
