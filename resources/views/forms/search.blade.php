<form method="POST">
    @csrf
    <div class="form-floating">
        Поиск: <input type="text"  id="search" name="search" placeholder="Имя">
        <button class="btn btn-secondary btn-sm" type="submit">Поиск</button>
    </div>
</form>
