@extends('layout')

@section('main')
<div class="container mt-4">
    <h1>Курсы (всего: {{ $totalCourses }})</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Категория</th>
                <th>Учитель</th>
                <th>Цена</th>
                <th>Опубликовано</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses as $course)
            <tr>
                <td>{{ $course->id }}</td>
                <td>{{ $course->title }}</td>
                <td>{{ $course->category->name ?? 'Нет' }}</td>
                <td>{{ $course->teacher->name ?? 'Нет' }}</td>
                <td>{{ $course->price }} ₽</td>
                <td>{{ $course->is_published ? 'Да' : 'Нет' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $courses->links() }}
</div>
@endsection