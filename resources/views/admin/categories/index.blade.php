@extends('layout')

@section('main')
<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h1>Категории</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Создать</a>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Slug</th>
                <th>Курсов</th>
                <th>Описание</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->slug }}</td>
                <td>{{ $category->courses_count }}</td>
                <td>{{ Str::limit($category->description ?? '', 50) }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="d-inline" onsubmit="return confirm('Удалить категорию и все курсы?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $categories->links() }}
</div>
@endsection