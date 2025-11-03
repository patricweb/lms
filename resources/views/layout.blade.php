<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS - By Matei Patric</title>

    @vite(['resources/css/app.css', 'resources/js/search.js'])

    @livewireStyles
</head>
<body class="font-sans bg-[#252525] text-[#d4d4d4]">
    @livewire("header")
    @livewire("nav")
    
    <main class="container mx-auto px-4 py-8">
        @yield("main")
    </main>

    @livewire("footer")
    
    @livewireScripts

</body>
</html>