<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>@yield('title','FCC') — FIKOM Certification Center UMI</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}"/>
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
    @stack('styles')
    <style>
        *,*::before,*::after{box-sizing:border-box;}
        body{margin:0;padding:0;font-family:'Inter',sans-serif;}
        select,textarea,input{font-family:'Inter',sans-serif;}
    </style>
</head>
<body>
    @yield('content')
    @stack('page-data')
    @stack('scripts')
</body>
</html>
