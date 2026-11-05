@php
    $setting = getSuperAdminAllSetting();
    $company_logo = get_file('storage/uploads/logo/logo-dark.png');
    $favicon = get_file('storage/uploads/logo/favicon.png');
@endphp
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'eCommerceGo BD') }} - @yield('page-title')</title>

    <!-- Favicon icon -->
    <link rel="icon" href="{{ url('storage/uploads/logo/favicon.png') }}?v={{ time() }}" type="image/png" />

    <!-- Google Fonts: Hind Siliguri & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="{{ url('packages/workdo/LandingPage/src/Resources/assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ url('packages/workdo/LandingPage/src/Resources/assets/fonts/feather.css') }}">

    <style>
        :root {
            --primary: #4f46e5;
            --primary-light: #6366f1;
            --accent: #10b981;
            --accent-pink: #ec4899;
            --bg-dark: #070b14;
            --bg-card: rgba(15, 23, 42, 0.75);
            --border-card: rgba(255, 255, 255, 0.1);
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --font-bn: 'Hind Siliguri', sans-serif;
            --font-en: 'Plus Jakarta Sans', sans-serif;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--font-bn);
            background-color: var(--bg-dark);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            position: relative;
        }

        /* Ambient Glow & Mesh Background */
        .ambient-mesh {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            pointer-events: none;
            z-index: 0;
            background: 
                radial-gradient(circle at 10% 20%, rgba(99, 102, 241, 0.18) 0%, transparent 45%),
                radial-gradient(circle at 90% 40%, rgba(236, 72, 153, 0.15) 0%, transparent 45%),
                radial-gradient(circle at 50% 80%, rgba(16, 185, 129, 0.12) 0%, transparent 50%);
        }

        .grid-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-image: linear-gradient(rgba(255, 255, 255, 0.02) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
            background-size: 45px 45px;
            pointer-events: none;
            z-index: 0;
        }

        /* Auth Header Navigation */
        .auth-nav {
            position: relative;
            z-index: 10;
            padding: 24px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #ffffff;
            font-size: 22px;
            font-weight: 800;
            font-family: var(--font-en);
        }

        .brand-icon-box {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, #4f46e5 0%, #ec4899 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
            color: #fff;
        }

        .back-home-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            border-radius: 50px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: #cbd5e1;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.2s;
        }

        .back-home-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            transform: translateX(-3px);
        }

        /* Auth Main Container */
        .auth-container {
            position: relative;
            z-index: 10;
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 24px 60px 24px;
            width: 100%;
            max-width: 1180px;
            margin: 0 auto;
        }

        .auth-split-wrapper {
            display: grid;
            grid-template-columns: 1.1fr 1fr;
            gap: 50px;
            align-items: center;
            width: 100%;
        }

        /* Left Side: Brand Visuals & Benefits */
        .auth-left-side {
            padding-right: 20px;
        }

        .auth-pill-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            border-radius: 50px;
            background: rgba(99, 102, 241, 0.15);
            border: 1px solid rgba(99, 102, 241, 0.35);
            color: #c7d2fe;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .pulse-mini {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #10b981;
            box-shadow: 0 0 10px #10b981;
            animation: pulse-ring 2s infinite;
        }

        @keyframes pulse-ring {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        .auth-headline {
            font-size: 38px;
            font-weight: 800;
            line-height: 1.3;
            margin-bottom: 16px;
            color: #ffffff;
        }

        .gradient-text {
            background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 50%, #f472b6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .auth-desc {
            font-size: 16px;
            color: var(--text-muted);
            line-height: 1.7;
            margin-bottom: 30px;
        }

        .auth-benefit-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-bottom: 32px;
        }

        .auth-benefit-item {
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 15px;
            color: #e2e8f0;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.06);
            padding: 12px 18px;
            border-radius: 14px;
            transition: all 0.3s;
        }

        .auth-benefit-item:hover {
            background: rgba(99, 102, 241, 0.08);
            border-color: rgba(99, 102, 241, 0.25);
            transform: translateX(4px);
        }

        .b-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: rgba(16, 185, 129, 0.15);
            color: #10b981;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            flex-shrink: 0;
        }

        /* Right Side: Form Card */
        .auth-card-box {
            background: var(--bg-card);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid var(--border-card);
            border-radius: 24px;
            padding: 40px 36px;
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.7);
            position: relative;
            overflow: hidden;
        }

        .auth-card-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, #4f46e5, #ec4899, #10b981);
        }

        /* Form Inputs & Controls */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #cbd5e1;
        }

        .input-group-custom {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon-prefix {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            display: flex;
            align-items: center;
            pointer-events: none;
            z-index: 5;
        }

        .input-icon-suffix {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            padding: 4px;
            border-radius: 6px;
            transition: all 0.2s;
            user-select: none;
        }

        .input-icon-suffix:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.1);
        }

        /* Dark mode browser autofill fix */
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 1000px #0b1120 inset !important;
            -webkit-text-fill-color: #f8fafc !important;
            caret-color: #ffffff !important;
            border-color: rgba(99, 102, 241, 0.4) !important;
            transition: background-color 5000s ease-in-out 0s;
        }

        .form-control {
            width: 100%;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 12px;
            padding: 13px 16px 13px 44px;
            color: #ffffff;
            font-size: 15px;
            font-family: inherit;
            outline: none;
            transition: all 0.3s;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.25);
        }

        .form-control::placeholder {
            color: #64748b;
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            padding: 14px 24px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            font-family: var(--font-bn);
            color: #ffffff;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.45);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            margin-top: 10px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px -5px rgba(99, 102, 241, 0.65);
            background: linear-gradient(135deg, #4338ca 0%, #6d28d9 100%);
        }

        /* Quick Demo Login Chips */
        .demo-chips-box {
            margin-top: 22px;
            padding-top: 20px;
            border-top: 1px dashed rgba(255, 255, 255, 0.1);
        }

        .demo-chips-title {
            font-size: 12px;
            color: #94a3b8;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .chips-list {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .demo-chip {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #cbd5e1;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .demo-chip:hover {
            background: rgba(99, 102, 241, 0.18);
            border-color: #6366f1;
            color: #ffffff;
            transform: translateY(-1px);
        }

        /* Footer Credit */
        .auth-footer {
            position: relative;
            z-index: 10;
            text-align: center;
            padding: 20px 24px;
            font-size: 13px;
            color: #64748b;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1180px;
            margin: 0 auto;
            width: 100%;
            flex-wrap: wrap;
            gap: 12px;
        }

        .credit-link {
            color: #a5b4fc;
            font-weight: 700;
            text-decoration: none;
            transition: color 0.2s;
        }

        .credit-link:hover {
            color: #38bdf8;
        }

        @media (max-width: 900px) {
            .auth-split-wrapper {
                grid-template-columns: 1fr;
                gap: 30px;
            }
            .auth-left-side {
                display: none;
            }
            .auth-card-box {
                padding: 30px 24px;
            }
        }
    </style>
</head>
<body>

    <div class="ambient-mesh"></div>
    <div class="grid-overlay"></div>

    <!-- Top Minimal Navigation -->
    <header class="auth-nav">
        <a href="{{ url('/') }}" class="brand-logo" style="text-decoration: none;">
            <img src="{{ url('storage/uploads/logo/logo-light.png') }}?v={{ time() }}" onerror="this.onerror=null; this.src='{{ url('storage/uploads/logo/edokanpro-horizontal-transparent.png') }}';" alt="edokanpro" style="height: 48px; width: auto; object-fit: contain;" />
        </a>

        <a href="{{ url('/') }}" class="back-home-btn">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            হোমপেজে ফিরে যান
        </a>
    </header>

    <!-- Main Auth Content Area -->
    <main class="auth-container">
        <div class="auth-split-wrapper">
            
            <!-- Left Side Branding Showcase -->
            <div class="auth-left-side">
                <div class="auth-pill-tag">
                    <span class="pulse-mini"></span>
                    <span>🇧🇩 বাংলাদেশের #১ ক্লাউড ই-কমার্স সমাধান</span>
                </div>

                <h1 class="auth-headline">
                    আপনার অনলাইন ব্যবসাকে <br>
                    পরিচালনা করুন <span class="gradient-text">সহজে ও স্মার্টলি</span>
                </h1>

                <p class="auth-desc">
                    নিরাপদ ক্লাউড ড্যাশবোর্ড থেকে এক ক্লিকে অর্ডার প্রসেস করুন, পেমেন্ট ট্র্যাকিং দেখুন এবং অফলাইন শপের ক্যাশ কাউন্টার পরিচালনা করুন।
                </p>

                <ul class="auth-benefit-list">
                    <li class="auth-benefit-item">
                        <span class="b-icon">✓</span>
                        <span>বিকাশ, নগদ ও কার্ডে অটোমেটিক পেমেন্ট ভেরিফিকেশন</span>
                    </li>
                    <li class="auth-benefit-item">
                        <span class="b-icon">✓</span>
                        <span>পাঠাও ও স্টেডফাস্ট কুরিয়ারের সাথে রিয়েল-টাইম ট্র্যাকিং</span>
                    </li>
                    <li class="auth-benefit-item">
                        <span class="b-icon">✓</span>
                        <span>ইন-বিল্ট POS মেমো প্রিন্ট ও অনলাইন স্টক সমন্বয়</span>
                    </li>
                    <li class="auth-benefit-item">
                        <span class="b-icon">✓</span>
                        <span>২৪/৭ সার্বক্ষণিক ডেডিকেটেড বাংলা কাস্টমার সাপোর্ট</span>
                    </li>
                </ul>

                <div style="font-size: 13px; color: #94a3b8; display: flex; align-items: center; gap: 8px;">
                    <span style="color: #fbbf24;">★★★★★</span>
                    <span>২,৫০০+ সফল বাংলাদেশি মার্চেন্টদের বিশ্বস্ত প্ল্যাটফর্ম</span>
                </div>
            </div>

            {{-- Right Side Form Content --}}
            <div class="auth-right-side">
                <div class="auth-card-box">
                    @yield('content')
                </div>
            </div>

        </div>
    </main>

    <!-- Bottom Footer -->
    <footer class="auth-footer">
        <div>
            &copy; {{ date('Y') }} <strong>edokanpro</strong> — সর্বস্বত্ব সংরক্ষিত।
        </div>
        <div>
            ডিজাইন ও ডেভেলপমেন্টে: 
            <a href="https://mrdeveloper.xyz/" target="_blank" class="credit-link">
                ⚡ MR Developer
            </a>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ url('js/jquery-3.6.0.min.js') }}"></script>
    @stack('scripts')
</body>
</html>
