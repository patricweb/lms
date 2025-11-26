@extends('layout')

@section('main')
<div class="container mt-4">
    <h1>Админский дашборд</h1>
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5>Пользователи: {{ $totalUsers }}</h5>
                    <ul class="list-unstyled mb-0">
                        @foreach($usersByRole as $role => $count)
                            <li>{{ ucfirst($role) }}: {{ $count }}</li>
                        @endforeach
                    </ul>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-light btn-sm mt-2">Управление</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5>Категорий: {{ $totalCategories }}</h5>
                    <ul class="list-unstyled mb-0">
                        @foreach($categoriesWithCourses as $cat)
                            <li>{{ $cat->name }}: {{ $cat->courses_count }}</li>
                        @endforeach
                    </ul>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-light btn-sm mt-2">Управление</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5>Курсов: {{ $totalCourses }}</h5>
                    <p>Опубликовано: {{ $publishedCourses }}</p>
                    <a href="{{ route('courses') }}" class="btn btn-light btn-sm">Управление</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection