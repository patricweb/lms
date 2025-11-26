@extends('layout')

@section('main')
    <div class="min-h-screen py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto bg-[#1f2326] border border-gray-700 rounded-2xl shadow-md p-6">
            <h1 class="text-2xl font-bold text-white mb-6">Пользователь: {{ $user->name }}</h1>
            <div class="space-y-3 text-gray-300">
                <p><span class="font-semibold text-white">Email:</span> {{ $user->email }}</p>
                <p><span class="font-semibold text-white">Роль:</span> {{ ucfirst($user->role) }}</p>
                <p><span class="font-semibold text-white">Super Admin:</span> {{ $user->isSuperAdmin() ? 'Да' : 'Нет' }}</p>
                <p><span class="font-semibold text-white">Курсы (как учитель):</span> {{ $user->courses->count() }}</p>
                <p><span class="font-semibold text-white">Дата регистрации:</span> {{ $user->created_at->format('d.m.Y H:i') }}</p>
            </div>
            @if(!$user->isSuperAdmin())
                <h3 class="mt-6 mb-3 text-white font-semibold text-lg">Изменить роль</h3>
                <form method="POST" action="{{ route('usersUpdateRole', $user) }}" class="space-y-4">
                    @csrf
                    @method('PATCH')
                    <div>
                        <select name="role" class="w-full md:w-1/3 bg-[#25292c] border border-gray-600 rounded-lg text-white py-2 px-3 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                            <option value="student" {{ $user->role == 'student' ? 'selected' : '' }}>Ученик</option>
                            <option value="teacher" {{ $user->role == 'teacher' ? 'selected' : '' }}>Учитель</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Админ</option>
                        </select>
                    </div>
                    <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white font-medium py-2 px-4 rounded-lg transition-all duration-200 shadow hover:shadow-emerald-500/25">
                        Сохранить
                    </button>
                </form>
            @endif
        </div>
    </div>
@endsection
