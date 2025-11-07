@extends("layout")

@section("main")
    <h1>Login</h1>

    <form method='post' action="{{ route('loginPost') }}">
        @csrf

        <input type="email" name='email' placeholder='Email'>
        @error('email')
            <p>{{ $message }}</p>
        @enderror

        <input type="password" name='password' placeholder='Password'>
        @error('password')
            <p>{{ $message }}</p>
        @enderror

        <label>
            <input type="checkbox" name="remember"> Запомнить меня
        </label>

        <button type='submit'>Login</button>
    </form>
@endsection