<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduLMS - Modern Learning Platform</title>

    @vite(['resources/css/app.css'])

    @livewireStyles
</head>
<body class="font-sans bg-[#182023] text-[#f4f4f4] antialiased min-h-screen flex flex-col">
    @livewire("header")

    @livewire("nav")

    <main class="flex-1">
        @yield("main")
    </main>

    @livewire("footer")
    
    @livewireScripts
</body>
</html>