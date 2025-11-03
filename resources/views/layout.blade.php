<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS - By Matei Patric</title>

    @vite(['resources/css/app.css', 'resources/js/search.js'])

    @livewireStyles
</head>
<body>
    <main>
        @yield("main")
    </main>

    @livewireScripts
</body>
</html>