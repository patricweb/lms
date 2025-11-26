@extends('layout')
@section('main')
<div class="min-h-screen py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto bg-[#1f2326] border border-gray-700 rounded-2xl shadow-md p-6">
        <h1 class="text-2xl font-bold text-white mb-6">Список пользователей</h1>

        @if(session('error'))
            <div class="bg-red-600 text-white px-4 py-2 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
        @if(session('success'))
            <div class="bg-emerald-600 text-white px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-[#25292c]">
                    <tr>
                        <th class="px-4 py-2 text-left text-gray-400 text-sm font-medium">ID</th>
                        <th class="px-4 py-2 text-left text-gray-400 text-sm font-medium">Имя</th>
                        <th class="px-4 py-2 text-left text-gray-400 text-sm font-medium">Email</th>
                        <th class="px-4 py-2 text-left text-gray-400 text-sm font-medium">Роль</th>
                        <th class="px-4 py-2 text-left text-gray-400 text-sm font-medium">Super Admin</th>
                        <th class="px-4 py-2 text-left text-gray-400 text-sm font-medium">Создан</th>
                        <th class="px-4 py-2 text-left text-gray-400 text-sm font-medium">Действия</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach($users as $user)
                    <tr class="hover:bg-gray-800">
                        <td class="px-4 py-2 text-gray-300">{{ $user->id }}</td>
                        <td class="px-4 py-2 text-gray-300">{{ $user->name }}</td>
                        <td class="px-4 py-2 text-gray-300">{{ $user->email }}</td>
                        <td class="px-4 py-2 text-gray-300">{{ ucfirst($user->role) }}</td>
                        <td class="px-4 py-2 text-gray-300">{{ $user->isSuperAdmin() ? 'Да' : 'Нет' }}</td>
                        <td class="px-4 py-2 text-gray-300">{{ $user->created_at->format('d.m.Y') }}</td>
                        <td class="px-4 py-2 space-x-2">
                            @if(!$user->isSuperAdmin())
                                <a href="{{ route('usersShow', $user) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm px-3 py-1 rounded transition">Просмотр</a>
                                <form method="POST" action="{{ route('usersDestroy', $user) }}" class="inline" onsubmit="return confirm('Удалить?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-sm px-3 py-1 rounded transition">Удалить</button>
                                </form>
                            @else
                                <span class="text-gray-500 text-sm">Защищён</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
