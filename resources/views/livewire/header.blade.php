<header>
    <h1 class='text-emerald-500'>My LMS</h1>

    <ul>
        @auth
            <li>
                <a class='hover:text-orange-600 duration-200' href="">Account</a>
            </li>
            <li>
                <a class='hover:text-orange-600 duration-200' href="{{ route('logout') }}">Logout</a>
            </li>
        @endauth
        @guest
            <li>
                <a class='hover:text-orange-600 duration-200' href="{{ route('login') }}">Login</a>
            </li>
            <li>
                <a class='hover:text-orange-600 duration-200' href="{{ route('register') }}">Register</a>
            </li>
        @endguest
    </ul>
</header>