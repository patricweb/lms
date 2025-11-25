@extends('layout')

@section('main')
<div class="container mt-4">
    <h1>Пользователь: {{ $user->name }}</h1>
    <div class="row">
        <div class="col-md-6">
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Роль:</strong> {{ ucfirst($user->role) }}</p>
            <p><strong>Super Admin:</strong> {{ $user->isSuperAdmin() ? 'Да' : 'Нет' }}</p>
            <p><strong>Курсы (как учитель):</strong> {{ $user->courses->count() }}</p>
            <p><strong>Дата регистрации:</strong> {{ $user->created_at->format('d.m.Y H:i') }}</p>
        </div>
    </div>

    @if(!$user->isSuperAdmin())
        <h3 class="mt-4">Изменить роль</h3>
        <form method="POST" action="{{ route('admin.users.updateRole', $user) }}">
            @csrf
            @method('PATCH')
            <div class="mb-3">
                <select name="role" class="form-select w-25">
                    <option value="student" {{ $user->role == 'student' ? 'selected' : '' }}>Ученик</option>
                    <option value="teacher" {{ $user->role == 'teacher' ? 'selected' : '' }}>Учитель</option>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Админ</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>
    @endif
</div>
@endsection