@extends("layout")

@section("main")
    <h2>Profile Page!</h2>

    <p>{{ $user->name }}</p>
    <p>{{ $user->email }}</p>
    <p>{{ $user->role }}</p>
@endsection