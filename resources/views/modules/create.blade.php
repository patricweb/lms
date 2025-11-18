@extends("layout")

@section("main")
    <form action="{{ route('saveModule', $course) }}" method="POST">
    @csrf

    <label>Название модуля</label>
    <input type="text" name="title" required>

    <label>Описание</label>
    <textarea name="description"></textarea>

    <label>Порядок</label>
    <input type="number" name="order" value="1">

    <button type="submit">Создать модуль</button>
</form>

@endsection