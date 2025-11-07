<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduLMS - Modern Learning Platform</title>

    @vite(['resources/css/app.css', 'resources/js/search.js'])
    @livewireStyles
</head>
<body class="font-sans bg-gray-900 text-gray-100 antialiased">
    @livewire("header")
    @livewire("nav")
    
    <main>
        @yield("main")
    </main>

    @livewire("footer")
    
    @livewireScripts
</body>
</html>