<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>{{ isset($title) ? $title.' — ' : '' }}FCC UMI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css','resources/js/app.js'])
    {{-- Livewire auto-inject styles di sini jika inject_assets=true --}}
</head>
<body style="margin:0;padding:0;font-family:'Inter',sans-serif;min-height:100vh;background:#131218;position:relative;overflow-x:hidden;">

    {{-- Grid background pattern --}}
    <div style="position:fixed;inset:0;opacity:.04;pointer-events:none;
        background-image:linear-gradient(rgba(255,200,26,1) 1px,transparent 1px),
                         linear-gradient(90deg,rgba(255,200,26,1) 1px,transparent 1px);
        background-size:64px 64px;z-index:0;"></div>

    {{-- Konten Livewire component --}}
    <div style="position:relative;z-index:1;">
        {{ $slot }}
    </div>

    {{-- Livewire auto-inject scripts di sini jika inject_assets=true --}}
</body>
</html>
