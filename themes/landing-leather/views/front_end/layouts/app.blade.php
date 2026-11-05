<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) ?? 'bn' }}" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1" />
    <meta name="author" content="{{ $store->name ?? 'edokanpro' }}">
    <meta name="base-url" content="{{ URL::to('/') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {!! metaKeywordSetting($metakeyword ?? null, $metadesc ?? null, $metaimage ?? null, $slug) !!}
    <title>@yield('page-title') - {{ $store->name ?? 'Genuine Leather Accessories' }}</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Poppins:wght@400;500;600;700;800&family=Outfit:wght@400;600;700;900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('themes/' . $currentTheme . '/assets/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/' . $currentTheme . '/assets/css/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('themes/' . $currentTheme . '/assets/css/main-style.css') }}">

    <script src="{{ asset('themes/' . $currentTheme . '/assets/js/tailwind.js') }}"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#78350f',
                        'primary-dark': '#451a03',
                        secondary: '#d97706',
                        accent: '#b91c1c',
                    },
                    fontFamily: {
                        sans: ['Hind Siliguri', 'Outfit', 'Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    @php
        $favicon = $themeSettings['header_favicon'] ?? '';
        $faviconUrl = !empty($favicon) ? get_file($favicon) : asset('storage/uploads/logo/favicon.png');
    @endphp
    <link rel="icon" href="{{ $faviconUrl }}" type="image/x-icon" />
    <link rel="apple-touch-icon" href="{{ $faviconUrl }}">
    
    <style>
        body {
            font-family: 'Hind Siliguri', 'Outfit', 'Poppins', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }
        .pulse-btn {
            animation: pulse-glow 2s infinite;
        }
        @keyframes pulse-glow {
            0% { box-shadow: 0 0 0 0 #78350fb3; }
            70% { box-shadow: 0 0 0 16px rgba(0, 0, 0, 0); }
            100% { box-shadow: 0 0 0 0 rgba(0, 0, 0, 0); }
        }
        .theme-gradient {
            background: linear-gradient(135deg, #78350f 0%, #d97706 100%);
        }
        {!! $storecss ?? '' !!}
    </style>
    @stack('page-style')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
</head>

<body class="antialiased">
    @include('front_end.partison.announcement')
    @include('front_end.partison.header')

    @if(isset($pixelScript))
        @foreach ($pixelScript as $script)
            <?= $script ?>
        @endforeach
    @endif

    @yield('content')

    @include('front_end.partison.footer')

    @stack('custom-scripts')
</body>
</html>