@extends("layout")

@section("main")
    <h1>Register</h1>

    <form method="post" action="{{ route('registerPost') }}">
        @csrf

        <input type="text" name="name" placeholder="Name" value="{{ old('name') }}">
        @error("name")
            <p>{{ $message }}</p>
        @enderror

        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
        @error("email")
            <p>{{ $message }}</p>
        @enderror

        <input type="password" name="password" placeholder="Password">
        @error("password")
            <p>{{ $message }}</p>
        @enderror

        <input type="password" name="password_confirmation" placeholder="Confirm Password">
        @error("password_confirmation")
            <p>{{ $message }}</p>
        @enderror

        <button type="submit">Register</button>
    </form>
@endsection