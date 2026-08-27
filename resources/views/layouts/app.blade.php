<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="description" content="@yield('meta-description','FIKOM Certification Center UMI Makassar — Platform pelatihan dan sertifikasi kompetensi teknologi terpercaya. Dapatkan sertifikasi resmi berstandar BNSP dan industri.')"/>
    <meta name="theme-color" content="#131218"/>
    <title>@yield('title','FCC') — FIKOM Certification Center UMI</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}"/>
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}"/>

    {{-- Open Graph / WhatsApp / Facebook / LinkedIn Link Preview Meta Tags --}}
    @php
        $defaultOgTitle = View::hasSection('title') ? View::getSection('title') . ' — FIKOM Certification Center UMI' : 'FIKOM Certification Center UMI Makassar';
        $defaultOgDesc  = View::hasSection('meta-description') ? View::getSection('meta-description') : 'FIKOM Certification Center UMI Makassar — Platform pelatihan dan sertifikasi kompetensi teknologi terpercaya. Dapatkan sertifikasi resmi berstandar BNSP dan industri.';
        $defaultOgImage = asset('images/herosection.webp');
    @endphp
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="{{ url()->current() }}"/>
    <meta property="og:site_name" content="FIKOM Certification Center UMI"/>
    <meta property="og:title" content="@yield('og-title', $defaultOgTitle)"/>
    <meta property="og:description" content="@yield('og-description', $defaultOgDesc)"/>
    <meta property="og:image" content="@yield('og-image', $defaultOgImage)"/>
    <meta property="og:image:secure_url" content="@yield('og-image', $defaultOgImage)"/>
    <meta property="og:image:width" content="1200"/>
    <meta property="og:image:height" content="630"/>
    <meta property="og:image:alt" content="FIKOM Certification Center UMI Makassar"/>

    {{-- Twitter & Telegram Large Card Preview --}}
    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:title" content="@yield('og-title', $defaultOgTitle)"/>
    <meta name="twitter:description" content="@yield('og-description', $defaultOgDesc)"/>
    <meta name="twitter:image" content="@yield('og-image', $defaultOgImage)"/>

    {{-- Preconnect for Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link rel="dns-prefetch" href="https://fonts.googleapis.com"/>

    {{-- Non-render-blocking Google Fonts --}}
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" media="print" onload="this.media='all'"/>
    <noscript><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/></noscript>

    {{-- Preload critical resources --}}
    @stack('preloads')

    {{-- CSS & JS Bundles --}}
    @if(file_exists(public_path('build/manifest.json')) && !file_exists(public_path('hot')))
        @php
            $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
            $cssFile = $manifest['resources/css/app.css']['file'] ?? null;
            $jsFile  = $manifest['resources/js/app.js']['file'] ?? null;
        @endphp
        @if($cssFile)
            <link rel="stylesheet" href="{{ asset('build/'.$cssFile) }}"/>
        @endif
        @if($jsFile)
            <script type="module" src="{{ asset('build/'.$jsFile) }}"></script>
        @endif
    @else
        @vite(['resources/css/app.css','resources/js/app.js'])
    @endif

    {{-- Livewire: skip on public pages where no Livewire components are used --}}
    @unless(View::hasSection('no-livewire'))
        @livewireStyles
    @endunless

    @stack('styles')

    {{-- Critical inline CSS: prevents FOUC when CSS is async --}}
    <style>
        *,*::before,*::after{box-sizing:border-box;}
        body{margin:0;padding:0;font-family:'Inter',ui-sans-serif,system-ui,sans-serif;}
        select,textarea,input{font-family:'Inter',ui-sans-serif,system-ui,sans-serif;}
        /* Global Autofill Dark Override */
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 1000px #1A1922 inset !important;
            -webkit-text-fill-color: #FFFFFF !important;
            caret-color: #FFFFFF !important;
            transition: background-color 5000s ease-in-out 0s;
        }
        .reveal{opacity:0;transform:translateY(24px);transition:opacity .7s cubic-bezier(0.16,1,0.3,1),transform .7s cubic-bezier(0.16,1,0.3,1);}
        .reveal.vis{opacity:1;transform:translateY(0);}
        .rl{opacity:0;transform:translateX(-54px);transition:opacity .8s cubic-bezier(0.16,1,0.3,1),transform .8s cubic-bezier(0.16,1,0.3,1);}
        .rl.vis{opacity:1;transform:translateX(0);}
        .rr{opacity:0;transform:translateX(54px);transition:opacity .8s cubic-bezier(0.16,1,0.3,1),transform .8s cubic-bezier(0.16,1,0.3,1);}
        .rr.vis{opacity:1;transform:translateX(0);}
        .spring-up{opacity:0;}.spring-up.vis{opacity:1;}
        .spring-left{opacity:0;}.spring-left.vis{opacity:1;}
        .spring-right{opacity:0;}.spring-right.vis{opacity:1;}
        .btn-magnetic{display:inline-block;transition:transform .2s cubic-bezier(.23,1,.32,1);}
        .nav-lnk:not(.nav-active){color:rgba(255,255,255,.82);}
        .nav-lnk.nav-active{color:#131218!important;background:#FFC81A;font-weight:800;}
        .nav-lnk:hover:not(.nav-active){color:#FFC81A;}
        .hidden{display:none!important;}
    </style>
</head>
<body>
    @yield('content')
    @stack('page-data')
    @unless(View::hasSection('no-livewire'))
        @livewireScripts
    @endunless
    @stack('scripts')
</body>
</html>

