@php
    $settings = \Workdo\LandingPage\Entities\LandingPageSetting::settings();
    $logo = get_file('storage/uploads/landing_page_image');
    $sup_logo = get_file('storage/uploads/logo');
    $superadmin = \App\Models\User::where('type', 'super admin')->first();
    $setting = getSuperAdminAllSetting();
    $plans = \App\Models\Plan::where('is_disable', 1)->orderBy('price', 'asc')->get();
@endphp
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ \App\Models\Utility::GetValueByName('title_text', 1) ?: 'eCommerceGo BD — বাংলাদেশের সেরা অল-ইন-ওয়ান ই-কমার্স প্ল্যাটফর্ম' }}</title>
    
    <!-- Meta Tags for SEO -->
    <meta name="description" content="বাংলাদেশের উদ্যোক্তাদের জন্য সবচেয়ে সহজ ও আধুনিক মাল্টি-স্টোর ই-কমার্স প্ল্যাটফর্ম। বিকাশ, নগদ, রকেট, POS এবং কুরিয়ার ইন্টিগ্রেশনসহ ৫ মিনিটে নিজের ওয়েবসাইট তৈরি করুন।">
    <meta name="keywords" content="eCommerce SaaS Bangladesh, অনলাইন শপ, ই-কমার্স ওয়েবসাইট, বিকাশ পেমেন্ট গেটওয়ে, POS সফটওয়্যার, শপিফাই বিকল্প বাংলাদেশ">
    
    <!-- Google Fonts: Hind Siliguri (বাংলা টাইপোগ্রাফির জন্য সেরা) & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tabler & Feather Icons -->
    <link rel="stylesheet" href="{{ url('packages/workdo/LandingPage/src/Resources/assets/fonts/tabler-icons.min.css') }}" />
    <link rel="stylesheet" href="{{ url('packages/workdo/LandingPage/src/Resources/assets/fonts/feather.css') }}" />
    
    <!-- Favicon -->
    <link rel="icon" href="{{ url('storage/uploads/logo/favicon.png') }}?v={{ time() }}" type="image/png" />

    <style>
        :root {
            --primary: #4f46e5;
            --primary-light: #6366f1;
            --primary-dark: #3730a3;
            --secondary: #06b6d4;
            --accent: #10b981;
            --accent-pink: #ec4899;
            --bg-dark: #070b14;
            --bg-card: rgba(15, 23, 42, 0.7);
            --border-card: rgba(255, 255, 255, 0.08);
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
            overflow-x: hidden;
            line-height: 1.6;
            scroll-behavior: smooth;
        }

        /* Ambient Glow & Mesh Background */
        .ambient-mesh {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            pointer-events: none;
            z-index: -1;
            background: 
                radial-gradient(circle at 15% 20%, rgba(99, 102, 241, 0.15) 0%, transparent 45%),
                radial-gradient(circle at 85% 30%, rgba(236, 72, 153, 0.12) 0%, transparent 45%),
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
            background-size: 50px 50px;
            pointer-events: none;
            z-index: -1;
        }

        /* Container & Utilities */
        .container {
            width: 100%;
            max-width: 1240px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* Typography */
        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-bn);
            font-weight: 700;
            line-height: 1.3;
        }

        .gradient-text {
            background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 50%, #f472b6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .gradient-text-emerald {
            background: linear-gradient(135deg, #34d399 0%, #10b981 50%, #06b6d4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 12px 26px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            border: 1px solid transparent;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: #ffffff;
            box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 32px -5px rgba(99, 102, 241, 0.6);
            background: linear-gradient(135deg, #4338ca 0%, #6d28d9 100%);
            color: #ffffff;
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.05);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.12);
            border-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            color: #ffffff;
        }

        .btn-emerald {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            color: #ffffff;
            box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.4);
        }

        .btn-emerald:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 32px -5px rgba(16, 185, 129, 0.6);
            color: #ffffff;
        }

        /* Top Announcement Bar */
        .top-bar {
            background: linear-gradient(90deg, #1e1b4b 0%, #311042 50%, #1e1b4b 100%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            padding: 10px 0;
            font-size: 14px;
            text-align: center;
        }

        .top-bar-inner {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .pill-badge {
            background: rgba(99, 102, 241, 0.25);
            border: 1px solid rgba(99, 102, 241, 0.5);
            color: #a5b4fc;
            padding: 3px 10px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
        }

        /* Navbar */
        .navbar {
            position: sticky;
            top: 0;
            width: 100%;
            background: rgba(7, 11, 20, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            z-index: 1000;
            padding: 18px 0;
            transition: all 0.3s ease;
        }

        .nav-wrapper {
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
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: linear-gradient(135deg, #4f46e5 0%, #ec4899 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 28px;
            list-style: none;
        }

        .nav-menu a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            transition: color 0.2s;
        }

        .nav-menu a:hover {
            color: #ffffff;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        /* Hero Section */
        .hero {
            padding: 90px 0 70px 0;
            position: relative;
            text-align: center;
        }

        .hero-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            border-radius: 50px;
            background: rgba(99, 102, 241, 0.12);
            border: 1px solid rgba(99, 102, 241, 0.35);
            color: #c7d2fe;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 24px;
        }

        .pulse-dot {
            width: 8px;
            height: 8px;
            background-color: #10b981;
            border-radius: 50%;
            box-shadow: 0 0 10px #10b981;
            animation: pulse-ring 2s infinite;
        }

        @keyframes pulse-ring {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        .hero h1 {
            font-size: 54px;
            font-weight: 800;
            letter-spacing: -0.5px;
            max-width: 950px;
            margin: 0 auto 24px auto;
        }

        .hero p.lead {
            font-size: 20px;
            color: var(--text-muted);
            max-width: 760px;
            margin: 0 auto 36px auto;
            font-weight: 400;
        }

        .hero-cta {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 18px;
            flex-wrap: wrap;
            margin-bottom: 48px;
        }

        .trust-metrics {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 36px;
            color: var(--text-muted);
            font-size: 14px;
            flex-wrap: wrap;
        }

        .trust-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Mockup & Floating Cards */
        .hero-mockup-wrapper {
            position: relative;
            max-width: 1050px;
            margin: 50px auto 0 auto;
            border-radius: 24px;
            padding: 10px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.02) 100%);
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 30px 100px -20px rgba(79, 70, 229, 0.35);
        }

        .mockup-inner {
            border-radius: 18px;
            overflow: hidden;
            background: #0f172a;
            border: 1px solid rgba(255, 255, 255, 0.05);
            position: relative;
        }

        /* Live Simulated Dashboard in Hero */
        .live-dash-mockup {
            background: #090e1a;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.08);
            text-align: left;
            font-family: var(--font-bn);
        }

        .dash-top-bar {
            background: #0c1322;
            padding: 12px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .dash-top-left {
            display: flex;
            align-items: center;
        }

        .dash-store-selector {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 5px 12px;
            font-size: 13px;
            color: #cbd5e1;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .dash-top-search {
            flex-grow: 1;
            max-width: 320px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 8px;
            padding: 6px 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: #64748b;
        }

        .dash-top-right {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .dash-badge-status {
            font-size: 11px;
            color: #34d399;
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.2);
            padding: 4px 10px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .dash-avatar {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #cbd5e1;
        }

        .dash-avatar img {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: 1px solid #6366f1;
        }

        .dash-body {
            padding: 24px;
            background: #090e1a;
        }

        .dash-metrics-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 20px;
        }

        .d-metric-card {
            background: rgba(15, 23, 42, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 14px;
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .d-metric-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 12px;
            color: #94a3b8;
        }

        .d-growth-badge {
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
            font-size: 11px;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: 700;
        }

        .d-info-badge {
            background: rgba(99, 102, 241, 0.15);
            color: #818cf8;
            font-size: 11px;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: 700;
        }

        .d-orange-badge {
            background: rgba(245, 158, 11, 0.15);
            color: #fbbf24;
            font-size: 11px;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: 700;
        }

        .d-metric-val {
            font-size: 24px;
            font-weight: 800;
            color: #ffffff;
            font-family: var(--font-en);
        }

        .d-metric-sub {
            font-size: 11px;
            color: #64748b;
        }

        .dash-split-row {
            display: grid;
            grid-template-columns: 1.4fr 1.6fr;
            gap: 18px;
        }

        .dash-chart-card, .dash-orders-card {
            background: rgba(15, 23, 42, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 14px;
            padding: 18px 20px;
        }

        .d-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
        }

        .svg-sales-chart {
            width: 100%;
            height: auto;
            display: block;
        }

        .chart-days {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            color: #64748b;
            margin-top: 6px;
        }

        .recent-orders-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .order-item-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 12px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.04);
            gap: 12px;
        }

        .order-item-avatar {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .order-item-info {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .order-item-info strong {
            font-size: 13px;
            color: #f1f5f9;
        }

        .order-item-info small {
            font-size: 11px;
            color: #94a3b8;
        }

        .order-item-price {
            text-align: right;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .order-item-price span {
            font-size: 13px;
            font-weight: 700;
            color: #ffffff;
            font-family: var(--font-en);
        }

        .d-status-pill {
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: 600;
        }

        .pill-success {
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
        }

        .pill-warning {
            background: rgba(245, 158, 11, 0.15);
            color: #fbbf24;
        }

        @media (max-width: 900px) {
            .dash-metrics-grid { grid-template-columns: repeat(2, 1fr); }
            .dash-split-row { grid-template-columns: 1fr; }
            .dash-top-search { display: none; }
        }

        /* Floating Badges with Keyframe Animations */
        .float-card {
            position: absolute;
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 16px;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            gap: 14px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
            z-index: 10;
        }

        .float-card-1 {
            top: -25px;
            left: -35px;
            animation: float-slow 4s ease-in-out infinite;
        }

        .float-card-2 {
            bottom: 40px;
            right: -40px;
            animation: float-reverse 5s ease-in-out infinite;
        }

        .float-card-3 {
            bottom: -25px;
            left: 50px;
            animation: float-slow 4.5s ease-in-out infinite;
        }

        @keyframes float-slow {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
        }

        @keyframes float-reverse {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(12px); }
        }

        /* Partner Logos Bar */
        .partners-bar {
            padding: 50px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            text-align: center;
            margin-top: 40px;
        }

        .partners-title {
            font-size: 14px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 24px;
        }

        .partners-list {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 40px;
            flex-wrap: wrap;
            opacity: 0.85;
        }

        .partner-pill {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 10px 22px;
            font-weight: 600;
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
        }

        .partner-pill:hover {
            border-color: rgba(99, 102, 241, 0.4);
            background: rgba(99, 102, 241, 0.08);
            transform: translateY(-2px);
        }

        /* Feature Section */
        .section-padding {
            padding: 100px 0;
        }

        .section-header {
            text-align: center;
            max-width: 760px;
            margin: 0 auto 60px auto;
        }

        .section-tag {
            font-size: 13px;
            font-weight: 700;
            color: #818cf8;
            text-transform: uppercase;
            letter-spacing: 2px;
            display: block;
            margin-bottom: 12px;
        }

        .section-title {
            font-size: 40px;
            font-weight: 800;
            margin-bottom: 16px;
        }

        .section-subtitle {
            font-size: 18px;
            color: var(--text-muted);
        }

        /* Feature Grid Cards */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 28px;
        }

        .feature-card {
            background: var(--bg-card);
            border: 1px solid var(--border-card);
            border-radius: 20px;
            padding: 34px 28px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at top left, rgba(99, 102, 241, 0.12), transparent 70%);
            opacity: 0;
            transition: opacity 0.3s;
            pointer-events: none;
        }

        .feature-card:hover {
            transform: translateY(-6px);
            border-color: rgba(99, 102, 241, 0.35);
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.5);
        }

        .feature-card:hover::before {
            opacity: 1;
        }

        .feature-icon {
            width: 58px;
            height: 58px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 22px;
            font-size: 26px;
            transition: transform 0.3s;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(4deg);
        }

        .icon-indigo { background: rgba(99, 102, 241, 0.15); color: #818cf8; border: 1px solid rgba(99, 102, 241, 0.3); }
        .icon-emerald { background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); }
        .icon-pink { background: rgba(236, 72, 153, 0.15); color: #f472b6; border: 1px solid rgba(236, 72, 153, 0.3); }
        .icon-cyan { background: rgba(6, 182, 212, 0.15); color: #22d3ee; border: 1px solid rgba(6, 182, 212, 0.3); }
        .icon-amber { background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.3); }
        .icon-purple { background: rgba(168, 85, 247, 0.15); color: #c084fc; border: 1px solid rgba(168, 85, 247, 0.3); }

        .feature-title {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .feature-desc {
            color: var(--text-muted);
            font-size: 15px;
            line-height: 1.7;
        }

        /* Themes Showcase Section */
        .theme-showcase-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 32px;
        }

        .theme-card {
            background: rgba(15, 23, 42, 0.75);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 22px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            display: flex;
            flex-direction: column;
        }

        .theme-card:hover {
            transform: translateY(-8px);
            border-color: rgba(99, 102, 241, 0.45);
            box-shadow: 0 25px 60px -15px rgba(99, 102, 241, 0.35);
        }

        /* Mockup Browser Window Header */
        .theme-browser-top {
            background: #0f172a;
            padding: 10px 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .window-dots {
            display: flex;
            gap: 6px;
        }

        .window-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }
        .dot-red { background: #ef4444; }
        .dot-yellow { background: #f59e0b; }
        .dot-green { background: #10b981; }

        .browser-address {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 6px;
            padding: 3px 12px;
            font-size: 11px;
            font-family: var(--font-en);
            color: #94a3b8;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .browser-badge-live {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            font-weight: 600;
            color: #34d399;
            background: rgba(16, 185, 129, 0.12);
            padding: 2px 8px;
            border-radius: 50px;
            border: 1px solid rgba(16, 185, 129, 0.25);
        }

        .pulse-mini {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #10b981;
            animation: pulse-ring 2s infinite;
        }

        /* Interactive Long Screenshot Scroll Container */
        .theme-preview-box {
            height: 290px;
            background: #0b0f19;
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .theme-long-screen {
            width: 100%;
            height: auto;
            display: block;
            transition: transform 6s cubic-bezier(0.2, 0.8, 0.2, 1);
            transform: translateY(0);
        }

        .theme-card:hover .theme-long-screen {
            transform: translateY(calc(-100% + 290px));
        }

        /* Overlay with quick view prompt */
        .theme-preview-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 65%, rgba(7, 11, 20, 0.9) 100%);
            display: flex;
            align-items: flex-end;
            justify-content: center;
            padding-bottom: 14px;
            transition: all 0.3s ease;
            pointer-events: none;
        }

        .theme-card:hover .theme-preview-overlay {
            background: rgba(7, 11, 20, 0.45);
            align-items: center;
            padding-bottom: 0;
            backdrop-filter: blur(2px);
            pointer-events: auto;
        }

        .hover-scroll-hint {
            font-size: 11px;
            color: #cbd5e1;
            background: rgba(15, 23, 42, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.15);
            padding: 4px 12px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: opacity 0.3s;
        }

        .theme-card:hover .hover-scroll-hint {
            display: none;
        }

        .hover-visit-btn {
            display: none;
            padding: 10px 22px;
            background: #ffffff;
            color: #0f172a;
            border-radius: 50px;
            font-weight: 700;
            font-size: 14px;
            text-decoration: none;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.6);
            align-items: center;
            gap: 8px;
            transform: scale(0.9);
            transition: transform 0.2s, background 0.2s, color 0.2s;
        }

        .theme-card:hover .hover-visit-btn {
            display: inline-flex;
            transform: scale(1);
        }

        .hover-visit-btn:hover {
            background: #4f46e5;
            color: #ffffff;
        }

        /* Theme Info Box */
        .theme-info {
            padding: 22px 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.5) 0%, rgba(15, 23, 42, 0.9) 100%);
            border-top: 1px solid rgba(255, 255, 255, 0.06);
        }

        .theme-title-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
            flex-wrap: wrap;
            gap: 8px;
        }

        .theme-title {
            font-size: 19px;
            font-weight: 800;
            color: #ffffff;
        }

        .theme-category-pill {
            font-size: 12px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 50px;
        }

        .pill-pink {
            background: rgba(236, 72, 153, 0.15);
            color: #f472b6;
            border: 1px solid rgba(236, 72, 153, 0.3);
        }

        .pill-emerald {
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .pill-cyan {
            background: rgba(6, 182, 212, 0.15);
            color: #22d3ee;
            border: 1px solid rgba(6, 182, 212, 0.3);
        }

        .theme-desc {
            font-size: 13.5px;
            color: var(--text-muted);
            margin-bottom: 16px;
            line-height: 1.6;
        }

        .theme-feature-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 20px;
        }

        .tag-item {
            font-size: 11.5px;
            color: #cbd5e1;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 6px;
            padding: 3px 8px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .theme-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: auto;
        }

        /* How it works (৩ সহজ ধাপ) */
        .steps-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            position: relative;
        }

        .step-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px dashed rgba(255, 255, 255, 0.12);
            border-radius: 20px;
            padding: 36px 28px;
            text-align: center;
            position: relative;
        }

        .step-number {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #4f46e5 0%, #ec4899 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 20px;
            margin: 0 auto 20px auto;
            color: #ffffff;
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.4);
        }

        /* Pricing Section */
        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 28px;
            align-items: stretch;
            justify-content: center;
        }

        .price-card {
            background: var(--bg-card);
            border: 1px solid var(--border-card);
            border-radius: 24px;
            padding: 38px 30px;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: all 0.3s;
        }

        .price-card.popular {
            border-color: #6366f1;
            background: linear-gradient(180deg, rgba(99, 102, 241, 0.12) 0%, rgba(15, 23, 42, 0.8) 100%);
            box-shadow: 0 25px 60px -15px rgba(99, 102, 241, 0.3);
            transform: scale(1.04);
        }

        .popular-pill {
            position: absolute;
            top: -14px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(90deg, #4f46e5 0%, #ec4899 100%);
            color: #ffffff;
            font-size: 12px;
            font-weight: 700;
            padding: 4px 16px;
            border-radius: 50px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .plan-name {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .plan-price-box {
            display: flex;
            align-items: baseline;
            gap: 6px;
            margin: 20px 0;
        }

        .plan-amount {
            font-size: 44px;
            font-weight: 800;
            font-family: var(--font-en);
            color: #ffffff;
        }

        .plan-duration {
            color: var(--text-muted);
            font-size: 15px;
        }

        .plan-features {
            list-style: none;
            margin: 26px 0 34px 0;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .plan-features li {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 15px;
            color: #cbd5e1;
        }

        .check-icon {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: rgba(16, 185, 129, 0.15);
            color: #10b981;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* FAQ Accordion */
        .faq-grid {
            max-width: 850px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .faq-item {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s;
        }

        .faq-question {
            padding: 22px 26px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            user-select: none;
        }

        .faq-question:hover {
            color: #818cf8;
        }

        .faq-answer {
            padding: 0 26px 24px 26px;
            color: var(--text-muted);
            font-size: 15px;
            line-height: 1.7;
            display: none;
        }

        .faq-item.active .faq-answer {
            display: block;
        }

        .faq-item.active .faq-toggle {
            transform: rotate(180deg);
        }

        .faq-toggle {
            transition: transform 0.3s;
            font-size: 20px;
        }

        /* Comparison Section: Facebook Page vs eCommerceGo Website */
        .comparison-wrapper {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 44px 36px;
            margin: 40px 0 0 0;
            position: relative;
            overflow: hidden;
        }

        .comparison-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 32px;
            margin-top: 30px;
        }

        .comp-card {
            border-radius: 18px;
            padding: 30px 26px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .comp-card-bad {
            background: rgba(239, 68, 68, 0.05);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .comp-card-good {
            background: rgba(16, 185, 129, 0.08);
            border: 1px solid rgba(16, 185, 129, 0.3);
            box-shadow: 0 15px 35px -10px rgba(16, 185, 129, 0.2);
        }

        .comp-header {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 20px;
            font-weight: 700;
        }

        .comp-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .comp-list li {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            font-size: 15px;
            line-height: 1.5;
        }

        /* Final CTA Banner (Ultra Sleek) */
        .cta-banner-wrapper {
            margin: 100px 0 60px 0;
            position: relative;
        }

        .cta-banner {
            background: radial-gradient(circle at 50% 0%, rgba(99, 102, 241, 0.45) 0%, rgba(79, 70, 229, 0.15) 50%, rgba(15, 23, 42, 0.9) 100%), #0b0f19;
            border: 1px solid rgba(99, 102, 241, 0.4);
            border-radius: 32px;
            padding: 70px 48px;
            text-align: center;
            position: relative;
            overflow: hidden;
            box-shadow: 0 30px 90px -20px rgba(79, 70, 229, 0.45);
        }

        .cta-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        }

        .cta-badge-top {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px;
            border-radius: 50px;
            background: rgba(99, 102, 241, 0.15);
            border: 1px solid rgba(99, 102, 241, 0.35);
            color: #c7d2fe;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 22px;
        }

        .cta-banner h2 {
            font-size: 46px;
            font-weight: 800;
            margin-bottom: 18px;
            color: #ffffff;
            letter-spacing: -0.5px;
        }

        .cta-banner p {
            font-size: 19px;
            max-width: 720px;
            margin: 0 auto 34px auto;
            color: #cbd5e1;
            line-height: 1.7;
        }

        .cta-trust-checklist {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 36px;
            color: #94a3b8;
            font-size: 14px;
        }

        .cta-trust-checklist span {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .cta-action-btns {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
            align-items: center;
        }

        .btn-shimmer {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%);
            color: #1e1b4b !important;
            font-weight: 800;
            box-shadow: 0 10px 25px rgba(255, 255, 255, 0.25);
        }

        .btn-shimmer:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(255, 255, 255, 0.4);
            color: #4f46e5 !important;
        }

        .btn-shimmer::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(60deg, transparent, rgba(255, 255, 255, 0.6), transparent);
            transform: rotate(30deg);
            animation: shimmer-effect 4s infinite;
        }

        @keyframes shimmer-effect {
            0% { transform: translateX(-100%) rotate(30deg); }
            30%, 100% { transform: translateX(100%) rotate(30deg); }
        }

        /* Modernized Footer */
        .footer {
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding: 80px 0 30px 0;
            background: #04070e;
            color: var(--text-muted);
            position: relative;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2.2fr 1fr 1.2fr 1.6fr;
            gap: 48px;
            margin-bottom: 50px;
        }

        .footer-col h4 {
            color: #ffffff;
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 20px;
            letter-spacing: 0.5px;
        }

        .footer-col ul {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .footer-col ul a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 14px;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .footer-col ul a:hover {
            color: #818cf8;
            transform: translateX(4px);
        }

        .footer-contact-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: #cbd5e1;
            margin-bottom: 12px;
        }

        .social-icons-row {
            display: flex;
            gap: 12px;
            margin-top: 22px;
        }

        .social-btn {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            text-decoration: none;
            transition: all 0.3s;
        }

        .social-btn:hover {
            background: #4f46e5;
            color: #ffffff;
            border-color: #6366f1;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.4);
        }

        /* Payment Partner Badges Strip */
        .footer-payment-strip {
            padding: 24px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 30px;
        }

        .payment-pills-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .pay-pill-mini {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 8px;
            padding: 5px 12px;
            font-size: 12px;
            font-weight: 700;
            color: #cbd5e1;
        }

        /* Footer Bottom Bar & Credit Link */
        .footer-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 14px;
            flex-wrap: wrap;
            gap: 16px;
            color: #94a3b8;
        }

        .credit-badge-box {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(99, 102, 241, 0.1);
            border: 1px solid rgba(99, 102, 241, 0.25);
            padding: 4px 14px;
            border-radius: 50px;
            color: #cbd5e1;
        }

        .credit-link {
            color: #a5b4fc;
            font-weight: 800;
            text-decoration: none;
            transition: all 0.2s;
            position: relative;
        }

        .credit-link:hover {
            color: #38bdf8;
            text-shadow: 0 0 10px rgba(56, 189, 248, 0.6);
        }

        /* Floating WhatsApp Chat Widget */
        .floating-whatsapp {
            position: fixed;
            bottom: 28px;
            right: 28px;
            z-index: 9999;
            display: flex;
            align-items: center;
            gap: 10px;
            background: #25d366;
            color: #ffffff;
            padding: 12px 20px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
            box-shadow: 0 10px 25px rgba(37, 211, 102, 0.4);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            animation: float-slow 3s ease-in-out infinite;
        }

        .floating-whatsapp:hover {
            background: #20ba5a;
            color: #ffffff;
            transform: translateY(-4px) scale(1.04);
            box-shadow: 0 15px 35px rgba(37, 211, 102, 0.6);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .features-grid, .theme-showcase-grid, .pricing-grid, .steps-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .hero h1 { font-size: 42px; }
            .footer-grid { grid-template-columns: repeat(2, 1fr); }
            .float-card { display: none; }
        }

        @media (max-width: 768px) {
            .features-grid, .theme-showcase-grid, .pricing-grid, .steps-grid {
                grid-template-columns: 1fr;
            }
            .hero h1 { font-size: 32px; }
            .hero p.lead { font-size: 17px; }
            .nav-menu { display: none; }
            .footer-grid { grid-template-columns: 1fr; }
            .price-card.popular { transform: none; }
        }
    </style>
</head>
<body>

    <!-- Ambient Glow and Mesh -->
    <div class="ambient-mesh"></div>
    <div class="grid-overlay"></div>

    <!-- 1. Top Announcement Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="top-bar-inner">
                <span class="pill-badge">🇧🇩 বিশেষ অফার</span>
                <span>বাংলাদেশের অনলাইন উদ্যোক্তাদের জন্য <strong>১৪ দিনের ফ্রি ট্রায়াল</strong> চালু হয়েছে! কোনো ক্রেডিট কার্ড লাগবে না।</span>
                <a href="{{ route('register') }}" style="color: #a5b4fc; font-weight: 700; text-decoration: underline; margin-left: 6px;">এখনই শুরু করুন &rarr;</a>
            </div>
        </div>
    </div>

    <!-- 2. Modern Glassmorphic Navbar -->
    <nav class="navbar">
        <div class="container">
            <div class="nav-wrapper">
                <a href="{{ url('/') }}" class="brand-logo" style="text-decoration: none;">
                    <img src="{{ url('storage/uploads/logo/logo-light.png') }}?v={{ time() }}" onerror="this.onerror=null; this.src='{{ url('storage/uploads/logo/edokanpro-horizontal-transparent.png') }}';" alt="edokanpro" style="height: 48px; width: auto; object-fit: contain;" />
                </a>

                <ul class="nav-menu">
                    <li><a href="#features">ফিচারসমূহ</a></li>
                    <li><a href="#themes">রেডি থিম ও ল্যান্ডিং পেজ</a></li>
                    <li><a href="#how-it-works">কীভাবে কাজ করে</a></li>
                    <li><a href="#pricing">প্যাকেজ ও মূল্য</a></li>
                    <li><a href="#faq">প্রশ্ন-উত্তর</a></li>
                </ul>

                <div class="nav-actions">
                    <a href="{{ route('login') }}" class="btn btn-secondary" style="padding: 9px 20px; font-size: 15px;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                            <polyline points="10 17 15 12 10 7"></polyline>
                            <line x1="15" y1="12" x2="3" y2="12"></line>
                        </svg>
                        লগইন
                    </a>
                    @if ($setting['SIGNUP'] == 'on')
                    <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 9px 22px; font-size: 15px;">
                        ফ্রি শুরু করুন
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- 3. Hero Section with Animated SVG Badges -->
    <section class="hero">
        <div class="container">
            <div class="hero-tag">
                <span class="pulse-dot"></span>
                <span>কোডিং ছাড়া নিজের অনলাইন শপ তৈরি করুন মাত্র ৫ মিনিটে</span>
            </div>

            <h1>
                আপনার ব্যবসাকে রূপান্তর করুন <br>
                <span class="gradient-text">পূর্ণাঙ্গ ই-কমার্স ব্র্যান্ডে</span>
            </h1>

            <p class="lead">
                ফেসবুক পেজ বা অফলাইন দোকানের জন্য আধুনিক ওয়েবসাইট। বিকাশ, নগদ, রকেট অটোমেশন, পিওএস (POS) ক্যাশ কাউন্টার বিলিং, কুরিয়ার ইন্টিগ্রেশন এবং হোয়াটসঅ্যাপ অর্ডার — সবকিছু এক প্ল্যাটফর্মে।
            </p>

            <div class="hero-cta">
                <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 16px 36px; font-size: 18px;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                    </svg>
                    ১৪ দিনের ফ্রি ট্রায়াল নিন
                </a>
                <a href="{{ url('stylique/home') }}" target="_blank" class="btn btn-secondary" style="padding: 16px 30px; font-size: 18px;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polygon points="10 8 16 12 10 16 10 8"></polygon>
                    </svg>
                    লাইভ ডেমো স্টোর দেখুন
                </a>
            </div>

            <div class="trust-metrics">
                <div class="trust-item">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span>কোনো সেটআপ ফি নেই</span>
                </div>
                <div class="trust-item">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span>বিকাশ / নগদ পেমেন্ট গেটওয়ে রেডি</span>
                </div>
                <div class="trust-item">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span>কাস্টম ডোমেইন (.com, .com.bd) সাপোর্ট</span>
                </div>
                <div class="trust-item">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span>২৪/৭ বাংলা কাস্টমার সাপোর্ট</span>
                </div>
            </div>

            <!-- Dashboard Preview & Floating Live Cards -->
            <div class="hero-mockup-wrapper">
                
                <!-- Floating Card 1: Live Order Confirmed -->
                <div class="float-card float-card-1">
                    <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(16, 185, 129, 0.2); display: flex; align-items: center; justify-content: center; color: #10b981;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    </div>
                    <div style="text-align: left;">
                        <span style="font-size: 12px; color: #94a3b8; display: block;">নতুন সেলস অ্যালার্ট</span>
                        <strong style="font-size: 15px; color: #ffffff;">৳ ২,৪৫০ • পেমেন্ট সফল (বিকাশ)</strong>
                    </div>
                </div>

                <!-- Floating Card 2: Growth Analytics -->
                <div class="float-card float-card-2">
                    <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(99, 102, 241, 0.2); display: flex; align-items: center; justify-content: center; color: #818cf8;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                    </div>
                    <div style="text-align: left;">
                        <span style="font-size: 12px; color: #94a3b8; display: block;">মাসিক বিক্রয় বৃদ্ধি</span>
                        <strong style="font-size: 16px; color: #34d399;">+৮৪.৬% বৃদ্ধি পেয়েছে 🚀</strong>
                    </div>
                </div>

                <!-- Floating Card 3: Courier Delivery -->
                <div class="float-card float-card-3">
                    <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(236, 72, 153, 0.2); display: flex; align-items: center; justify-content: center; color: #f472b6;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                    </div>
                    <div style="text-align: left;">
                        <span style="font-size: 12px; color: #94a3b8; display: block;">কুরিয়ার ট্র্যাকিং</span>
                        <strong style="font-size: 15px; color: #ffffff;">পার্সেল পিকড • স্টেডফাস্ট / পাঠাও</strong>
                    </div>
                </div>

                <div class="mockup-inner">
                    <!-- Live Simulated E-Commerce Admin Dashboard -->
                    <div class="live-dash-mockup">
                        <!-- Dashboard Top Bar -->
                        <div class="dash-top-bar">
                            <div class="dash-top-left">
                                <div class="window-dots" style="margin-right: 14px;">
                                    <span class="window-dot dot-red"></span>
                                    <span class="window-dot dot-yellow"></span>
                                    <span class="window-dot dot-green"></span>
                                </div>
                                <div class="dash-store-selector">
                                    <span style="display: flex; align-items: center; gap: 6px;">
                                        <span class="pulse-mini"></span>
                                        <strong>আমার ফ্যাশন ও লাইফস্টাইল শপ</strong> (Stylique Theme)
                                    </span>
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                </div>
                            </div>

                            <div class="dash-top-search">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                <span>অর্ডার, প্রোডাক্ট বা কাস্টমার খুঁজুন...</span>
                            </div>

                            <div class="dash-top-right">
                                <div class="dash-badge-status">
                                    <span class="pulse-mini"></span> লাইভ স্টোর সচল
                                </div>
                                <div class="dash-avatar">
                                    <img src="{{ url('uploads/profile/avatar.png') }}" alt="Admin Avatar">
                                    <span>রফিকুল ইসলাম (মার্চেন্ট)</span>
                                </div>
                            </div>
                        </div>

                        <!-- Dashboard Content Body -->
                        <div class="dash-body">
                            <!-- 4 Key Metrics Cards -->
                            <div class="dash-metrics-grid">
                                <div class="d-metric-card">
                                    <div class="d-metric-header">
                                        <span>আজকের মোট বিক্রি</span>
                                        <span class="d-growth-badge">+২৮.৪% 📈</span>
                                    </div>
                                    <div class="d-metric-val">৳ ৪২,৫৫০</div>
                                    <div class="d-metric-sub">গতকাল ছিল ৳৩৩,১০০</div>
                                </div>

                                <div class="d-metric-card">
                                    <div class="d-metric-header">
                                        <span>নতুন অর্ডারসমূহ</span>
                                        <span class="d-info-badge">১৮ টি</span>
                                    </div>
                                    <div class="d-metric-val">৳ ৬৪,২০০</div>
                                    <div class="d-metric-sub">বিকাশ: ১২ | নগদ: ৪ | কার্ড: ২</div>
                                </div>

                                <div class="d-metric-card">
                                    <div class="d-metric-header">
                                        <span>কুরিয়ার ডেলিভারি</span>
                                        <span class="d-orange-badge">৭ টি পিকড</span>
                                    </div>
                                    <div class="d-metric-val">পাঠাও / স্টেডফাস্ট</div>
                                    <div class="d-metric-sub">আজকের ট্র্যাকিং অ্যাক্টিভ</div>
                                </div>

                                <div class="d-metric-card">
                                    <div class="d-metric-header">
                                        <span>লাইভ কাস্টমার ভিজিট</span>
                                        <span class="d-growth-badge">সচল ⚡</span>
                                    </div>
                                    <div class="d-metric-val">১,৪২০ জন</div>
                                    <div class="d-metric-sub">৮৫% মোবাইল ইউজার</div>
                                </div>
                            </div>

                            <!-- Chart & Recent Orders Split Row -->
                            <div class="dash-split-row">
                                <!-- Left: Interactive Sales Graph -->
                                <div class="dash-chart-card">
                                    <div class="d-card-header">
                                        <div>
                                            <h4 style="font-size: 15px; font-weight: 700; color: #fff;">📊 সাপ্তাহিক সেলস অ্যানালিটিক্স</h4>
                                            <span style="font-size: 12px; color: #94a3b8;">সর্বমোট সাপ্তাহিক রাজস্ব: ৳ ১,৮৪,০০০</span>
                                        </div>
                                        <span class="pill-badge" style="background: rgba(16,185,129,0.15); border-color: rgba(16,185,129,0.3); color: #34d399;">+৬৪% প্রবৃদ্ধি</span>
                                    </div>
                                    <div class="svg-chart-container">
                                        <svg viewBox="0 0 500 130" class="svg-sales-chart">
                                            <defs>
                                                <linearGradient id="chartGrad" x1="0" y1="0" x2="0" y2="1">
                                                    <stop offset="0%" stop-color="#6366f1" stop-opacity="0.45"/>
                                                    <stop offset="100%" stop-color="#ec4899" stop-opacity="0.0"/>
                                                </linearGradient>
                                            </defs>
                                            <path d="M0,110 C50,95 80,105 130,70 C180,35 210,60 260,40 C310,20 360,55 420,25 C460,5 480,15 500,8 L500,130 L0,130 Z" fill="url(#chartGrad)"/>
                                            <path d="M0,110 C50,95 80,105 130,70 C180,35 210,60 260,40 C310,20 360,55 420,25 C460,5 480,15 500,8" fill="none" stroke="#818cf8" stroke-width="3" stroke-linecap="round"/>
                                            <circle cx="130" cy="70" r="4" fill="#6366f1" stroke="#fff" stroke-width="2"/>
                                            <circle cx="260" cy="40" r="4" fill="#a855f7" stroke="#fff" stroke-width="2"/>
                                            <circle cx="420" cy="25" r="4" fill="#ec4899" stroke="#fff" stroke-width="2"/>
                                            <circle cx="500" cy="8" r="5" fill="#10b981" stroke="#fff" stroke-width="2"/>
                                        </svg>
                                        <div class="chart-days">
                                            <span>শনি</span>
                                            <span>রবি</span>
                                            <span>সোম</span>
                                            <span>মঙ্গল</span>
                                            <span>বুধ</span>
                                            <span>বৃহস্পতি</span>
                                            <span>শুক্র</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right: Recent Orders Live Table -->
                                <div class="dash-orders-card">
                                    <div class="d-card-header">
                                        <h4 style="font-size: 15px; font-weight: 700; color: #fff;">🛍️ সাম্প্রতিক অর্ডারসমূহ</h4>
                                        <span style="font-size: 12px; color: #818cf8; font-weight: 600;">অটোমেটিক সিঙ্ক</span>
                                    </div>

                                    <div class="recent-orders-list">
                                        <div class="order-item-row">
                                            <div class="order-item-avatar" style="background: rgba(236,72,153,0.2); color: #f472b6;">
                                                👗
                                            </div>
                                            <div class="order-item-info">
                                                <strong>প্রিমিয়াম জর্জেট শাড়ি</strong>
                                                <small>আয়েশা সিদ্দিকা • ঢাকা</small>
                                            </div>
                                            <div class="order-item-price">
                                                <span>৳ ৩,৪৫০</span>
                                                <span class="d-status-pill pill-success">বিকাশ সফল</span>
                                            </div>
                                        </div>

                                        <div class="order-item-row">
                                            <div class="order-item-avatar" style="background: rgba(99,102,241,0.2); color: #818cf8;">
                                                👟
                                            </div>
                                            <div class="order-item-info">
                                                <strong>মেনস ক্লাসিক স্নিকার্স</strong>
                                                <small>তানভীর আহমেদ • চট্টগ্রাম</small>
                                            </div>
                                            <div class="order-item-price">
                                                <span>৳ ২,২০০</span>
                                                <span class="d-status-pill pill-success">নগদ সফল</span>
                                            </div>
                                        </div>

                                        <div class="order-item-row">
                                            <div class="order-item-avatar" style="background: rgba(16,185,129,0.2); color: #34d399;">
                                                ⌚
                                            </div>
                                            <div class="order-item-info">
                                                <strong>স্মার্ট গ্যাজেট T900</strong>
                                                <small>মো: শাকিল • সিলেট</small>
                                            </div>
                                            <div class="order-item-price">
                                                <span>৳ ১,৮৫০</span>
                                                <span class="d-status-pill pill-warning">কুরিয়ারে হস্তান্তর</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- 4. Partners & Integrations Bar -->
    <div class="partners-bar">
        <div class="container">
            <div class="partners-title">যেসব পেমেন্ট ও ডেলিভারি পার্টনারদের সাথে সমন্বিত</div>
            <div class="partners-list">
                <div class="partner-pill">
                    <span style="color: #e2136e; font-weight: 800;">bKash</span>
                    <span>বিকাশ পেমেন্ট</span>
                </div>
                <div class="partner-pill">
                    <span style="color: #f7941d; font-weight: 800;">Nagad</span>
                    <span>নগদ পেমেন্ট</span>
                </div>
                <div class="partner-pill">
                    <span style="color: #8c3494; font-weight: 800;">Rocket</span>
                    <span>রকেট</span>
                </div>
                <div class="partner-pill">
                    <span style="color: #0077b6; font-weight: 800;">SSLCommerz</span>
                    <span>কার্ড ও ইন্টারনেট ব্যাংকিং</span>
                </div>
                <div class="partner-pill">
                    <span style="color: #10b981; font-weight: 800;">AamarPay</span>
                    <span>আমারপে</span>
                </div>
                <div class="partner-pill">
                    <span style="color: #ef4444; font-weight: 800;">Courier</span>
                    <span>স্টেডফাস্ট ও পাঠাও রেডি</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 5. Features Grid Section -->
    <section class="section-padding" id="features">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">শক্তিশালী ফিচারসমূহ</span>
                <h2 class="section-title">অনলাইন ব্যবসার প্রতিটি প্রয়োজন <br><span class="gradient-text">এক ছাতার নিচে</span></h2>
                <p class="section-subtitle">আলাদা আলাদা সফটওয়্যার কেনার দিন শেষ। eCommerceGo আপনাকে দিচ্ছে ব্যবসা বড় করার সব কয়টি আধুনিক ডিজিটাল টুলস।</p>
            </div>

            <div class="features-grid">
                
                <!-- Feature 1 -->
                <div class="feature-card">
                    <div class="feature-icon icon-indigo">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                            <line x1="8" y1="21" x2="16" y2="21"></line>
                            <line x1="12" y1="17" x2="12" y2="21"></line>
                        </svg>
                    </div>
                    <h3 class="feature-title">রেডিমেড প্রিমিয়াম থিম</h3>
                    <p class="feature-desc">ফ্যাশন, গ্যাজেট, গ্রোসারি বা রেস্তোরাঁ — যেকোনো ব্যবসার জন্য আকর্ষণীয় ও দ্রুতগতির প্রফেশনাল মোবাইল ফ্রেন্ডলি থিম এক ক্লিকে একটিভ করুন।</p>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card">
                    <div class="feature-icon icon-emerald">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                            <line x1="1" y1="10" x2="23" y2="10"></line>
                        </svg>
                    </div>
                    <h3 class="feature-title">বিকাশ ও নগদ অটোমেশন</h3>
                    <p class="feature-desc">ম্যানুয়ালি ট্রানজেকশন আইডি চেক করার ঝামেলা নেই। কাস্টমার বিকাশ, নগদ বা ভিসা/মাস্টারকার্ডে পেমেন্ট করলেই অটোমেটিক অর্ডার কনফার্ম হবে।</p>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card">
                    <div class="feature-icon icon-pink">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="2" width="20" height="20" rx="2"></rect>
                            <line x1="8" y1="6" x2="16" y2="6"></line>
                            <line x1="8" y1="10" x2="16" y2="10"></line>
                            <line x1="8" y1="14" x2="12" y2="14"></line>
                        </svg>
                    </div>
                    <h3 class="feature-title">ইন-বিল্ট POS বিলিং সিস্টেম</h3>
                    <p class="feature-desc">অনলাইনের পাশাপাশি অফলাইন শোরুম বা দোকানের ক্যাশ কাউন্টারে বারকোড স্ক্যানার দিয়ে সরাসরি ইনভয়েস ও মেমো প্রিন্ট করুন। স্টক সিঙ্ক থাকবে একসাথে।</p>
                </div>

                <!-- Feature 4 -->
                <div class="feature-card">
                    <div class="feature-icon icon-cyan">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                        </svg>
                    </div>
                    <h3 class="feature-title">হোয়াটসঅ্যাপ ডিরেক্ট সেলস</h3>
                    <p class="feature-desc">কাস্টমাররা সরাসরি ১ ক্লিকে আপনার হোয়াটসঅ্যাপে প্রোডাক্ট লিঙ্কসহ ইনবক্স করে দ্রুত অর্ডার সম্পন্ন করতে পারবে। কনভার্সন বাড়বে দ্বিগুণ।</p>
                </div>

                <!-- Feature 5 -->
                <div class="feature-card">
                    <div class="feature-icon icon-amber">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="2" y1="12" x2="22" y2="12"></line>
                            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                        </svg>
                    </div>
                    <h3 class="feature-title">কাস্টম ডোমেইন ব্র্যান্ডিং</h3>
                    <p class="feature-desc">আপনার নিজস্ব ডোমেইন (যেমন: `www.yourbrand.com`) কানেক্ট করুন। আপনার সাইটে আমাদের কোনো লোগো বা ওয়াটারমার্ক থাকবে না — সম্পূর্ণ আপনার ব্র্যান্ড।</p>
                </div>

                <!-- Feature 6 -->
                <div class="feature-card">
                    <div class="feature-icon icon-purple">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect>
                            <line x1="12" y1="18" x2="12.01" y2="18"></line>
                        </svg>
                    </div>
                    <h3 class="feature-title">মোবাইল PWA অ্যাপ</h3>
                    <p class="feature-desc">কাস্টমাররা প্লে-স্টোর ছাড়াই আপনার ওয়েবসাইটকে মোবাইল অ্যাপের মতো হোমস্ক্রিনে ইনস্টল করতে পারবে এবং অফলাইনেও ব্রাউজ করতে পারবে।</p>
                </div>

            </div>
        </div>
    </section>

    <!-- 5.5. Comparison Section: Facebook Page vs eCommerceGo Website -->
    <section class="section-padding" style="padding-top: 20px;">
        <div class="container">
            <div class="comparison-wrapper">
                <div class="section-header" style="margin-bottom: 30px;">
                    <span class="section-tag">কেন ওয়েবসাইট সেরা?</span>
                    <h2 class="section-title">সাধারণ ফেসবুক পেজ <br><span class="gradient-text">বনাম আপনার নিজস্ব ব্র্যান্ড ওয়েবসাইট</span></h2>
                    <p class="section-subtitle">ফেসবুক ইনবক্সে ঘণ্টার পর ঘণ্টা সময় অপচয় বন্ধ করে ব্যবসার স্বয়ংক্রিয় সেলস ইঞ্জিন চালু করুন।</p>
                </div>

                <div class="comparison-grid">
                    <!-- Bad: Facebook Page Alone -->
                    <div class="comp-card comp-card-bad">
                        <div class="comp-header" style="color: #f87171;">
                            <span style="width: 32px; height: 32px; border-radius: 50%; background: rgba(239, 68, 68, 0.2); display: flex; align-items: center; justify-content: center; font-weight: 800;">✕</span>
                            <span>শুধু ফেসবুক বা সোশ্যাল পেজে ব্যবসা</span>
                        </div>
                        <ul class="comp-list">
                            <li><span style="color: #ef4444; font-weight: bold;">✕</span> কাস্টমার ইনবক্সে "দাম কত?" লিখে ঘণ্টার পর ঘণ্টা আটকে রাখে।</li>
                            <li><span style="color: #ef4444; font-weight: bold;">✕</span> বিকাশ/নগদে লাস্ট ৪ ডিজিট ম্যানুয়ালি মেলাতে সময় ও ভুলের সম্ভাবনা থাকে।</li>
                            <li><span style="color: #ef4444; font-weight: bold;">✕</span> রাতে বা ছুটির দিনে অফলাইনে থাকলে কোনো সেল হয় না, কাস্টমার চলে যায়।</li>
                            <li><span style="color: #ef4444; font-weight: bold;">✕</span> কুরিয়ারে নাম, ঠিকানা ও ফোন নাম্বার একে একে টাইপ করার বাড়তি ঝামেলা।</li>
                            <li><span style="color: #ef4444; font-weight: bold;">✕</span> ফেসবুক পেজ যেকোনো সময় রেস্ট্রিকশন বা ডিজেবল হওয়ার চরম ঝুঁকি।</li>
                        </ul>
                    </div>

                    <!-- Good: eCommerceGo BD Store -->
                    <div class="comp-card comp-card-good">
                        <div class="comp-header" style="color: #34d399;">
                            <span style="width: 32px; height: 32px; border-radius: 50%; background: rgba(16, 185, 129, 0.2); display: flex; align-items: center; justify-content: center; font-weight: 800;">✓</span>
                            <span>eCommerceGo ফুল অটোমেশন ওয়েবসাইট</span>
                        </div>
                        <ul class="comp-list">
                            <li><span style="color: #10b981; font-weight: 800;">✓</span> স্বয়ংক্রিয় ২৪/৭ ক্যাটালগ ও মাত্র ৩০ সেকেন্ডে কাস্টমার নিজে চেকআউট করে।</li>
                            <li><span style="color: #10b981; font-weight: 800;">✓</span> বিকাশ, নগদ ও কার্ডে অটোমেটিক পেমেন্ট কনফার্মেশন ও ইনভয়েস জেনারেট।</li>
                            <li><span style="color: #10b981; font-weight: 800;">✓</span> আপনি ঘুমিয়ে থাকলেও ওয়েবসাইট দিনরাত চব্বিশ ঘণ্টা আপনার সেলস ম্যানেজার।</li>
                            <li><span style="color: #10b981; font-weight: 800;">✓</span> পাঠাও ও স্টেডফাস্ট কুরিয়ারের সাথে সরাসরি সিঙ্ক, অটোমেটিক পার্সেল ট্র্যাকিং।</li>
                            <li><span style="color: #10b981; font-weight: 800;">✓</span> সম্পূর্ণ নিজস্ব ডোমেইন ও কাস্টমার ডাটাবেজের ১০০% স্থায়ী মালিকানা।</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. Themes Showcase Section -->
    <section class="section-padding" id="themes" style="background: rgba(15, 23, 42, 0.4); border-top: 1px solid rgba(255, 255, 255, 0.05); border-bottom: 1px solid rgba(255, 255, 255, 0.05);">
        <div class="container">
            <div class="section-header">
                <span class="section-tag" style="display: inline-flex; align-items: center; gap: 8px;">
                    <span class="pulse-dot"></span> প্রি-বিল্ট রেডিমেড ডিজাইন
                </span>
                <h2 class="section-title">পছন্দমতো বেছে নিন আপনার <br><span class="gradient-text-emerald">স্বপ্নের স্টোর থিম</span></h2>
                <p class="section-subtitle">কোনো ডিজাইনার ছাড়া মাত্র ১ ক্লিকে ইনস্টল করুন। মাউস হোভার করে পুরো ওয়েবসাইটের স্ক্রল প্রিভিউ দেখুন।</p>
            </div>

            <div class="theme-showcase-grid">
                
                <!-- Theme 1: Stylique -->
                <div class="theme-card">
                    <!-- Browser Chrome Header -->
                    <div class="theme-browser-top">
                        <div class="window-dots">
                            <span class="window-dot dot-red"></span>
                            <span class="window-dot dot-yellow"></span>
                            <span class="window-dot dot-green"></span>
                        </div>
                        <div class="browser-address">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                            stylique.store.bd
                        </div>
                        <div class="browser-badge-live">
                            <span class="pulse-mini"></span> লাইভ
                        </div>
                    </div>

                    <!-- Long Scroll Screenshot Preview -->
                    <div class="theme-preview-box">
                        <img src="{{ url('themes/stylique/theme_img/img_1.png') }}" class="theme-long-screen" alt="Stylique Fashion Theme Preview">
                        <div class="theme-preview-overlay">
                            <span class="hover-scroll-hint">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="7 13 12 18 17 13"></polyline><polyline points="7 6 12 11 17 6"></polyline></svg>
                                মাউস রেখে স্ক্রল প্রিভিউ দেখুন
                            </span>
                            <a href="{{ url('stylique/home') }}" target="_blank" class="hover-visit-btn">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polygon points="10 8 16 12 10 16 10 8"></polygon></svg>
                                লাইভ স্টোর ভিজিট করুন
                            </a>
                        </div>
                    </div>

                    <!-- Theme Details & Actions -->
                    <div class="theme-info">
                        <div>
                            <div class="theme-title-row">
                                <h4 class="theme-title">Stylique Fashion</h4>
                                <span class="theme-category-pill pill-pink">👗 ফ্যাশন ও ক্লথিং</span>
                            </div>
                            <p class="theme-desc">পোশাক, জুতো, কসমেটিকস ও লাইফস্টাইল ব্র্যান্ডের জন্য দৃষ্টিনন্দন মিনিমালিস্টিক স্টোর।</p>
                            
                            <div class="theme-feature-tags">
                                <span class="tag-item">✓ কালার ও সাইজ ভ্যারিয়েন্ট</span>
                                <span class="tag-item">✓ লুকবুক স্লাইডার</span>
                                <span class="tag-item">✓ কুইক কার্ট ভিউ</span>
                            </div>
                        </div>

                        <div class="theme-actions">
                            <a href="{{ url('stylique/home') }}" target="_blank" class="btn btn-secondary" style="padding: 10px 14px; font-size: 14px;">
                                👁️ ডেমো দেখুন
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 10px 14px; font-size: 14px;">
                                🚀 থিমটি নিন
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Theme 2: Greentic -->
                <div class="theme-card">
                    <!-- Browser Chrome Header -->
                    <div class="theme-browser-top">
                        <div class="window-dots">
                            <span class="window-dot dot-red"></span>
                            <span class="window-dot dot-yellow"></span>
                            <span class="window-dot dot-green"></span>
                        </div>
                        <div class="browser-address">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                            greentic.store.bd
                        </div>
                        <div class="browser-badge-live">
                            <span class="pulse-mini"></span> লাইভ
                        </div>
                    </div>

                    <!-- Long Scroll Screenshot Preview -->
                    <div class="theme-preview-box">
                        <img src="{{ url('themes/greentic/theme_img/img_1.png') }}" class="theme-long-screen" alt="Greentic Grocery Theme Preview">
                        <div class="theme-preview-overlay">
                            <span class="hover-scroll-hint">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="7 13 12 18 17 13"></polyline><polyline points="7 6 12 11 17 6"></polyline></svg>
                                মাউস রেখে স্ক্রল প্রিভিউ দেখুন
                            </span>
                            <a href="{{ url('greentic/home') }}" target="_blank" class="hover-visit-btn">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polygon points="10 8 16 12 10 16 10 8"></polygon></svg>
                                লাইভ স্টোর ভিজিট করুন
                            </a>
                        </div>
                    </div>

                    <!-- Theme Details & Actions -->
                    <div class="theme-info">
                        <div>
                            <div class="theme-title-row">
                                <h4 class="theme-title">Greentic Grocery</h4>
                                <span class="theme-category-pill pill-emerald">🥦 গ্রোসারি ও ডেইলি শপ</span>
                            </div>
                            <p class="theme-desc">কাঁচাবাজার, ফলমূল, মধু ও অর্গানিক ফ্রেশ ফুড বিক্রির জন্য আধুনিক সুপারশপ লেআউট।</p>
                            
                            <div class="theme-feature-tags">
                                <span class="tag-item">✓ কেজি/গ্রাম ইউনিট ফিল্টার</span>
                                <span class="tag-item">✓ এক্সপ্রেস ডেলিভারি মোড</span>
                                <span class="tag-item">✓ ডেইলি অফার কাউন্টার</span>
                            </div>
                        </div>

                        <div class="theme-actions">
                            <a href="{{ url('greentic/home') }}" target="_blank" class="btn btn-secondary" style="padding: 10px 14px; font-size: 14px;">
                                👁️ ডেমো দেখুন
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-emerald" style="padding: 10px 14px; font-size: 14px;">
                                🚀 থিমটি নিন
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Theme 3: Techzonix -->
                <div class="theme-card">
                    <!-- Browser Chrome Header -->
                    <div class="theme-browser-top">
                        <div class="window-dots">
                            <span class="window-dot dot-red"></span>
                            <span class="window-dot dot-yellow"></span>
                            <span class="window-dot dot-green"></span>
                        </div>
                        <div class="browser-address">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                            techzonix.store.bd
                        </div>
                        <div class="browser-badge-live">
                            <span class="pulse-mini"></span> লাইভ
                        </div>
                    </div>

                    <!-- Long Scroll Screenshot Preview -->
                    <div class="theme-preview-box">
                        <img src="{{ url('themes/techzonix/theme_img/img_1.png') }}" class="theme-long-screen" alt="Techzonix Electronics Theme Preview">
                        <div class="theme-preview-overlay">
                            <span class="hover-scroll-hint">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="7 13 12 18 17 13"></polyline><polyline points="7 6 12 11 17 6"></polyline></svg>
                                মাউস রেখে স্ক্রল প্রিভিউ দেখুন
                            </span>
                            <a href="{{ url('techzonix/home') }}" target="_blank" class="hover-visit-btn">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polygon points="10 8 16 12 10 16 10 8"></polygon></svg>
                                লাইভ স্টোর ভিজিট করুন
                            </a>
                        </div>
                    </div>

                    <!-- Theme Details & Actions -->
                    <div class="theme-info">
                        <div>
                            <div class="theme-title-row">
                                <h4 class="theme-title">Techzonix Tech</h4>
                                <span class="theme-category-pill pill-cyan">⚡ ইলেকট্রনিক্স ও গ্যাজেট</span>
                            </div>
                            <p class="theme-desc">স্মার্টফোন, গ্যাজেট, কম্পিউটার সামগ্রী ও হোম অ্যাপ্লায়েন্স ব্যবসার উপযোগী টেক ডিজাইন।</p>
                            
                            <div class="theme-feature-tags">
                                <span class="tag-item">✓ ব্র্যান্ড ফিল্টারিং</span>
                                <span class="tag-item">✓ টেকনিক্যাল স্পেক্স টেবিল</span>
                                <span class="tag-item">✓ ওয়ারেন্টি ব্যাজ</span>
                            </div>
                        </div>

                        <div class="theme-actions">
                            <a href="{{ url('techzonix/home') }}" target="_blank" class="btn btn-secondary" style="padding: 10px 14px; font-size: 14px;">
                                👁️ ডেমো দেখুন
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 10px 14px; font-size: 14px;">
                                🚀 থিমটি নিন
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Subsection: 1-Page High-Converting Single Product Landing Pages -->
            <div class="section-header" style="margin-top: 60px; padding-top: 40px; border-top: 1px dashed rgba(255, 255, 255, 0.1);">
                <span class="section-tag" style="display: inline-flex; align-items: center; gap: 8px; background: rgba(239, 68, 68, 0.12); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.25);">
                    <span class="pulse-mini" style="background: #ef4444;"></span> ১-ক্লিক ফাস্ট ক্যাশ অন ডেলিভারি
                </span>
                <h2 class="section-title">সোশ্যাল মিডিয়া ও ভাইরাল প্রোডাক্টের জন্য <br><span class="gradient-text" style="background: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">সিঙ্গেল প্রোডাক্ট ল্যান্ডিং পেজ</span></h2>
                <p class="section-subtitle">লগইন বা অ্যাড-টু-কার্টের কোনো ঝামেলা নেই! মাত্র ১ পৃষ্ঠায় কাউন্টডাউন টাইমার, কাস্টমার রিভিউ ও ৩-ক্লিক ক্যাশ অন ডেলিভারি অর্ডার ফর্ম।</p>
            </div>

            <div class="theme-showcase-grid">

                <!-- Landing Page 1: Panjabi Special -->
                <div class="theme-card">
                    <!-- Browser Chrome Header -->
                    <div class="theme-browser-top">
                        <div class="window-dots">
                            <span class="window-dot dot-red"></span>
                            <span class="window-dot dot-yellow"></span>
                            <span class="window-dot dot-green"></span>
                        </div>
                        <div class="browser-address">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                            eid-panjabi.edokanpro.bd
                        </div>
                        <div class="browser-badge-live" style="color: #f59e0b; background: rgba(245, 158, 11, 0.12); border-color: rgba(245, 158, 11, 0.25);">
                            <span class="pulse-mini" style="background: #f59e0b;"></span> হট ডেমো
                        </div>
                    </div>

                    <!-- Long Scroll Screenshot Preview -->
                    <div class="theme-preview-box">
                        <img src="{{ url('themes/landing-panjabi/theme_img/img_1.png') }}" class="theme-long-screen" alt="Panjabi Single Product Landing Page Preview">
                        <div class="theme-preview-overlay">
                            <span class="hover-scroll-hint">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="7 13 12 18 17 13"></polyline><polyline points="7 6 12 11 17 6"></polyline></svg>
                                মাউস রেখে স্ক্রল প্রিভিউ দেখুন
                            </span>
                            <a href="{{ url('landing-preview/landing-panjabi') }}" target="_blank" class="hover-visit-btn">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polygon points="10 8 16 12 10 16 10 8"></polygon></svg>
                                লাইভ ল্যান্ডিং পেজ দেখুন
                            </a>
                        </div>
                    </div>

                    <!-- Theme Details & Actions -->
                    <div class="theme-info">
                        <div>
                            <div class="theme-title-row">
                                <h4 class="theme-title">Eid & Festival Panjabi</h4>
                                <span class="theme-category-pill pill-pink">👑 এথনিক ও ফ্যাশন</span>
                            </div>
                            <p class="theme-desc">ঈদ ও উৎসব কালেকশনের পাঞ্জাবির জন্য হাই-কনভার্টিং ল্যান্ডিং পেজ। কলারে কারচুপির কাজ ও প্রিমিয়াম জ্যাকার্ড ফেব্রিক প্রেজেন্টেশন।</p>
                            
                            <div class="theme-feature-tags">
                                <span class="tag-item">✓ কাউন্টডাউন অফার টাইমার</span>
                                <span class="tag-item">✓ নিখুঁত সাইজ ও কালার সিলেক্টর</span>
                                <span class="tag-item">✓ ১-পেজ ফাস্ট COD চেকআউট</span>
                            </div>
                        </div>

                        <div class="theme-actions">
                            <a href="{{ url('landing-preview/landing-panjabi') }}" target="_blank" class="btn btn-secondary" style="padding: 10px 14px; font-size: 14px;">
                                👁️ ডেমো দেখুন
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 10px 14px; font-size: 14px;">
                                🚀 পেজটি নিন
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Landing Page 2: Organic Food & Honey -->
                <div class="theme-card">
                    <!-- Browser Chrome Header -->
                    <div class="theme-browser-top">
                        <div class="window-dots">
                            <span class="window-dot dot-red"></span>
                            <span class="window-dot dot-yellow"></span>
                            <span class="window-dot dot-green"></span>
                        </div>
                        <div class="browser-address">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                            organic-food.edokanpro.bd
                        </div>
                        <div class="browser-badge-live">
                            <span class="pulse-mini"></span> লাইভ
                        </div>
                    </div>

                    <!-- Long Scroll Screenshot Preview -->
                    <div class="theme-preview-box">
                        <img src="{{ url('themes/single-product/theme_img/img_1.png') }}" class="theme-long-screen" alt="Organic Mustard Oil & Honey Landing Page Preview">
                        <div class="theme-preview-overlay">
                            <span class="hover-scroll-hint">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="7 13 12 18 17 13"></polyline><polyline points="7 6 12 11 17 6"></polyline></svg>
                                মাউস রেখে স্ক্রল প্রিভিউ দেখুন
                            </span>
                            <a href="{{ url('landing-preview/single-product') }}" target="_blank" class="hover-visit-btn">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polygon points="10 8 16 12 10 16 10 8"></polygon></svg>
                                লাইভ ল্যান্ডিং পেজ দেখুন
                            </a>
                        </div>
                    </div>

                    <!-- Theme Details & Actions -->
                    <div class="theme-info">
                        <div>
                            <div class="theme-title-row">
                                <h4 class="theme-title">Pure Organic & Honey</h4>
                                <span class="theme-category-pill pill-green">🌿 অর্গানিক ও গ্রোসারি</span>
                            </div>
                            <p class="theme-desc">ঘানিতে ভাঙানো খাঁটি সরিষার তেল ও সুন্দরবনের চাকভাঙা মধু। পুষ্টি ও বিশুদ্ধতার স্পেসিফিকেশন চার্ট সহ পরীক্ষিত সেলস ফানেল।</p>
                            
                            <div class="theme-feature-tags">
                                <span class="tag-item">✓ উপাদানের বিশুদ্ধতা স্পেক্স</span>
                                <span class="tag-item">✓ সিঙ্গেল ও মেগা ফ্যামিলি প্যাক</span>
                                <span class="tag-item">✓ ঢাকা ৳৭০ / বাইরে ৳১৩০ ক্যালকুলেটর</span>
                            </div>
                        </div>

                        <div class="theme-actions">
                            <a href="{{ url('landing-preview/single-product') }}" target="_blank" class="btn btn-secondary" style="padding: 10px 14px; font-size: 14px;">
                                👁️ ডেমো দেখুন
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 10px 14px; font-size: 14px;">
                                🚀 পেজটি নিন
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Landing Page 3: T9 Ultra AMOLED Gadget -->
                <div class="theme-card">
                    <!-- Browser Chrome Header -->
                    <div class="theme-browser-top">
                        <div class="window-dots">
                            <span class="window-dot dot-red"></span>
                            <span class="window-dot dot-yellow"></span>
                            <span class="window-dot dot-green"></span>
                        </div>
                        <div class="browser-address">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                            t9-gadget.edokanpro.bd
                        </div>
                        <div class="browser-badge-live" style="color: #38bdf8; background: rgba(56, 189, 248, 0.12); border-color: rgba(56, 189, 248, 0.25);">
                            <span class="pulse-mini" style="background: #38bdf8;"></span> ট্রেন্ডিং
                        </div>
                    </div>

                    <!-- Long Scroll Screenshot Preview -->
                    <div class="theme-preview-box">
                        <img src="{{ url('themes/landing-gadget/theme_img/img_1.png') }}" class="theme-long-screen" alt="T9 AMOLED Smartwatch Gadget Landing Page Preview">
                        <div class="theme-preview-overlay">
                            <span class="hover-scroll-hint">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="7 13 12 18 17 13"></polyline><polyline points="7 6 12 11 17 6"></polyline></svg>
                                মাউস রেখে স্ক্রল প্রিভিউ দেখুন
                            </span>
                            <a href="{{ url('landing-preview/landing-gadget') }}" target="_blank" class="hover-visit-btn">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polygon points="10 8 16 12 10 16 10 8"></polygon></svg>
                                লাইভ ল্যান্ডিং পেজ দেখুন
                            </a>
                        </div>
                    </div>

                    <!-- Theme Details & Actions -->
                    <div class="theme-info">
                        <div>
                            <div class="theme-title-row">
                                <h4 class="theme-title">T9 Ultra AMOLED Watch</h4>
                                <span class="theme-category-pill pill-cyan">⚡ গ্যাজেট ও ইলেকট্রনিক্স</span>
                            </div>
                            <p class="theme-desc">স্মার্টওয়াচ, ইয়ারবাডস ও টেক ড্রপশিপিংয়ের জন্য দৃষ্টিনন্দন সাইবার ডার্ক ল্যান্ডিং পেজ। টেকনিক্যাল স্পেক্স ও সরাসরি কলিং সুবিধা।</p>
                            
                            <div class="theme-feature-tags">
                                <span class="tag-item">✓ সাইবার ডার্ক মোড ডিজাইন</span>
                                <span class="tag-item">✓ কালার সোয়াচ পিল সিলেক্টর</span>
                                <span class="tag-item">✓ ৪টি গোল্ড স্টার কাস্টমার রিভিউ</span>
                            </div>
                        </div>

                        <div class="theme-actions">
                            <a href="{{ url('landing-preview/landing-gadget') }}" target="_blank" class="btn btn-secondary" style="padding: 10px 14px; font-size: 14px;">
                                👁️ ডেমো দেখুন
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 10px 14px; font-size: 14px;">
                                🚀 পেজটি নিন
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <!-- All 10 Landing Themes Category Strip -->
            <div style="margin-top: 36px; padding: 20px 24px; background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 16px; text-align: center;">
                <p style="margin: 0; color: #cbd5e1; font-size: 14.5px;">
                    ✨ এছাড়াও পাচ্ছেন <strong>ঢাকাই জামদানি শাড়ি (Saree)</strong>, <strong>রূপচর্চা ও সিরাম (Skincare)</strong>, <strong>কিচেন চপার (Kitchen)</strong>, <strong>কাউ লেদার গিফট সেট (Leather)</strong>, <strong>ডিজিটাল কুরআন স্পিকার (Islamic)</strong>, <strong>ফিটনেস ব্যান্ড (Fitness)</strong> ও <strong>কিডস লার্নিং বুক (Kids)</strong> সহ <u>১০টি ক্যাটাগরির রেডি ল্যান্ডিং পেজ</u>!
                </p>
            </div>
        </div>
    </section>

    <!-- 7. How it works (৩ সহজ ধাপ) -->
    <section class="section-padding" id="how-it-works">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">সহজ প্রক্রিয়া</span>
                <h2 class="section-title">মাত্র ৩টি পদক্ষেপে শুরু করুন <br><span class="gradient-text">আপনার অনলাইন জার্নি</span></h2>
                <p class="section-subtitle">কোনো সফটওয়্যার ইনস্টল করতে হবে না। ক্লাউড সার্ভারে সরাসরি সাইনআপ করে আজ থেকেই বিক্রি শুরু করুন।</p>
            </div>

            <div class="steps-grid">
                
                <div class="step-card">
                    <div class="step-number">১</div>
                    <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 12px;">অ্যাকাউন্ট তৈরি করুন</h3>
                    <p style="color: var(--text-muted); font-size: 15px;">আপনার নাম, ইমেইল ও দোকানের নাম দিয়ে মাত্র ৩০ সেকেন্ডে রেজিস্ট্রেশন সম্পন্ন করুন।</p>
                </div>

                <div class="step-card">
                    <div class="step-number">২</div>
                    <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 12px;">প্রোডাক্ট ও পেমেন্ট যুক্ত করুন</h3>
                    <p style="color: var(--text-muted); font-size: 15px;">পণ্যের ছবি, দাম ও বিবরণ আপলোড করুন এবং আপনার বিকাশ/নগদ মার্চেন্ট নাম্বার বসিয়ে দিন।</p>
                </div>

                <div class="step-card">
                    <div class="step-number">৩</div>
                    <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 12px;">অর্ডার নিন ও ব্যবসা বাড়ান</h3>
                    <p style="color: var(--text-muted); font-size: 15px;">সোশ্যাল মিডিয়ায় ওয়েবসাইটের লিঙ্ক শেয়ার করুন এবং অটোমেটিক অর্ডার রিসিভ করে ডেলিভারি দিন।</p>
                </div>

            </div>
        </div>
    </section>

    <!-- 8. Pricing Section -->
    <section class="section-padding" id="pricing" style="background: rgba(15, 23, 42, 0.4);">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">সাশ্রয়ী প্যাকেজ</span>
                <h2 class="section-title">আপনার ব্যবসার উপযোগী <br><span class="gradient-text">প্রাইসিং প্ল্যান</span></h2>
                <p class="section-subtitle">লুকানো কোনো চার্জ নেই। যেকোনো সময় প্ল্যান আপগ্রেড বা ক্যান্সেল করতে পারবেন।</p>
            </div>

            <!-- Monthly / Yearly Billing Cycle Switcher -->
            <div class="pricing-switcher-wrapper" style="display: flex; justify-content: center; margin-bottom: 40px;">
                <div style="background: rgba(255, 255, 255, 0.08); padding: 6px; border-radius: 50px; display: inline-flex; align-items: center; border: 1px solid rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px);">
                    <button type="button" id="lpBtnMonthly" class="lp-billing-btn active" style="padding: 10px 24px; border-radius: 40px; border: none; font-weight: 700; font-size: 14.5px; cursor: pointer; transition: all 0.3s ease; background: #ffffff; color: #0f172a; box-shadow: 0 4px 15px rgba(0,0,0,0.15);">
                        মাসিক (Monthly)
                    </button>
                    <button type="button" id="lpBtnYearly" class="lp-billing-btn" style="padding: 10px 24px; border-radius: 40px; border: none; font-weight: 700; font-size: 14.5px; cursor: pointer; transition: all 0.3s ease; background: transparent; color: #94a3b8;">
                        বাৎসরিক (Yearly)
                        <span style="background: linear-gradient(135deg, #e2136e 0%, #be125a 100%); color: #ffffff; font-size: 11px; font-weight: 800; padding: 3px 9px; border-radius: 20px; margin-left: 6px;">
                            ২ মাস ফ্রি! 🎉
                        </span>
                    </button>
                </div>
            </div>

            <div class="pricing-grid">
                @php
                    $activePlans = \App\Models\Plan::where('is_disable', 1)->where('price', '>', 0)->orderBy('price', 'asc')->get();
                    $currencySymbol = !empty($setting['CURRENCY']) ? $setting['CURRENCY'] : (!empty($setting['CURRENCYCURRENCY']) ? $setting['CURRENCYCURRENCY'] : '৳');
                @endphp

                @forelse($activePlans as $index => $plan)
                    @php
                        // Highlight the best-selling / popular plan
                        $isPopular = ($plan->price == 599 || $plan->price == 5990);
                    @endphp
                    <div class="price-card {{ $isPopular ? 'popular' : '' }} lp-plan-card lp-plan-{{ strtolower($plan->duration) }}" style="{{ $plan->duration == 'Year' ? 'display: none;' : '' }}">
                        @if($isPopular)
                            <span class="popular-pill">সবচেয়ে জনপ্রিয়</span>
                        @elseif($plan->trial == 1 && $plan->trial_days > 0)
                            <span class="popular-pill" style="background: linear-gradient(90deg, #059669 0%, #10b981 100%);">🎁 {{ $plan->trial_days }} দিন ফ্রি ট্রায়াল</span>
                        @endif

                        <div>
                            <h4 class="plan-name" @if($isPopular) style="color: #ffffff;" @endif>{{ $plan->name }}</h4>
                            <p style="color: {{ $isPopular ? '#cbd5e1' : 'var(--text-muted)' }}; font-size: 13.5px; min-height: 42px; margin-bottom: 12px; line-height: 1.5;">
                                {{ $plan->description ?: 'অনলাইন উদ্যোক্তাদের জন্য সাশ্রয়ী ও কার্যকরী ই-কমার্স সলিউশন।' }}
                            </p>
                            
                            @if($plan->duration == 'Year')
                                <div style="background: rgba(16, 185, 129, 0.2); border: 1px solid rgba(16, 185, 129, 0.4); color: #34d399; font-size: 11.5px; font-weight: 700; padding: 3px 10px; border-radius: 20px; margin-bottom: 12px; display: inline-flex; align-items: center; gap: 6px;">
                                    <span>🎁</span> <span>বাৎসরিক স্পেশাল: ১০ মাসের মূল্যে ১২ মাস!</span>
                                </div>
                            @endif

                            <div class="plan-price-box" style="margin-bottom: 16px;">
                                <span class="plan-amount" @if($isPopular) style="color: #ffffff;" @endif>
                                    {{ $currencySymbol }}{{ number_format($plan->price) }}
                                </span>
                                <span class="plan-duration" @if($isPopular) style="color: #cbd5e1;" @endif>
                                    /{{ $plan->duration == 'Month' ? 'মাস' : ($plan->duration == 'Year' ? 'বছর' : 'লাইফটাইম') }}
                                </span>
                            </div>

                            @if($plan->trial == 1 && $plan->trial_days > 0)
                                <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); color: #34d399; font-size: 12px; font-weight: 600; padding: 4px 10px; border-radius: 6px; margin-bottom: 16px; display: inline-flex; align-items: center; gap: 6px;">
                                    <span>✓</span> <span>{{ $plan->trial_days }} দিনের নো-রিস্ক ফ্রি ট্রায়াল সুবিধা</span>
                                </div>
                            @endif

                            <ul class="plan-features">
                                <li>
                                    <span class="check-icon" @if($isPopular) style="background: #10b981; color: #fff;" @endif>✓</span>
                                    <span><strong>{{ $plan->max_products == -1 ? 'আনলিমিটেড' : $plan->max_products . 'টি' }}</strong> প্রোডাক্ট আপলোড</span>
                                </li>
                                <li>
                                    <span class="check-icon" @if($isPopular) style="background: #10b981; color: #fff;" @endif>✓</span>
                                    <span><strong>{{ $plan->max_stores == -1 ? 'আনলিমিটেড' : $plan->max_stores . 'টি' }}</strong> অনলাইন স্টোর</span>
                                </li>
                                @if($plan->enable_domain == 'on')
                                    <li>
                                        <span class="check-icon" @if($isPopular) style="background: #10b981; color: #fff;" @endif>✓</span>
                                        <span><strong>কাস্টম ডোমেইন (.com)</strong> সাপোর্ট</span>
                                    </li>
                                @endif
                                <li>
                                    <span class="check-icon" @if($isPopular) style="background: #10b981; color: #fff;" @endif>✓</span>
                                    <span>ফ্রি সাব-ডোমেইন কানেকশন</span>
                                </li>
                                <li>
                                    <span class="check-icon" @if($isPopular) style="background: #10b981; color: #fff;" @endif>✓</span>
                                    <span>১-ক্লিক ফাস্ট ক্যাশ অন ডেলিভারি (COD)</span>
                                </li>
                                <li>
                                    <span class="check-icon" @if($isPopular) style="background: #10b981; color: #fff;" @endif>✓</span>
                                    <span>বিকাশ, নগদ ও কার্ড অটো পেমেন্ট</span>
                                </li>
                                @if($plan->shipping_method == 'on')
                                    <li>
                                        <span class="check-icon" @if($isPopular) style="background: #10b981; color: #fff;" @endif>✓</span>
                                        <span>কুরিয়ার ও ডেলিভারি চার্জ সিস্টেম</span>
                                    </li>
                                @endif
                                @if($plan->pwa_store == 'on')
                                    <li>
                                        <span class="check-icon" @if($isPopular) style="background: #10b981; color: #fff;" @endif>✓</span>
                                        <span>PWA মোবাইল অ্যাপ সুবিধা</span>
                                    </li>
                                @endif

                                <li>
                                    <span class="check-icon" @if($isPopular) style="background: #10b981; color: #fff;" @endif>✓</span>
                                    <span>{{ $plan->storage_limit ?? 500 }}MB ক্লাউড স্টোরেজ</span>
                                </li>
                                <li>
                                    <span class="check-icon" @if($isPopular) style="background: #10b981; color: #fff;" @endif>✓</span>
                                    <span>২৪/৭ প্রায়োরিটি বাংলা সাপোর্ট</span>
                                </li>
                            </ul>
                        </div>

                        <div style="margin-top: 24px;">
                            <a href="{{ route('register', ['plan_id' => \Illuminate\Support\Facades\Crypt::encrypt($plan->id)]) }}" class="btn {{ $isPopular ? 'btn-primary' : 'btn-secondary' }}" style="width: 100%; text-align: center; justify-content: center;">
                                @if($plan->trial == 1 && $plan->trial_days > 0)
                                    {{ $plan->trial_days }} দিন ফ্রি ট্রায়াল নিন ➜
                                @elseif($plan->price == 0)
                                    ফ্রিতে শুরু করুন ➜
                                @else
                                    প্যাকেজটি বেছে নিন ➜
                                @endif
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center" style="grid-column: 1 / -1; padding: 40px; color: #94a3b8;">
                        <p>বর্তমানে কোনো প্ল্যান সক্রিয় নেই। সুপার অ্যাডমিন প্যানেল থেকে প্ল্যান যোগ করুন।</p>
                    </div>
                @endforelse
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const btnM = document.getElementById('lpBtnMonthly');
                    const btnY = document.getElementById('lpBtnYearly');
                    const monthCards = document.querySelectorAll('.lp-plan-month');
                    const yearCards = document.querySelectorAll('.lp-plan-year');

                    if (btnM && btnY) {
                        btnM.addEventListener('click', function () {
                            monthCards.forEach(c => c.style.display = '');
                            yearCards.forEach(c => c.style.display = 'none');
                            btnM.style.background = '#ffffff';
                            btnM.style.color = '#0f172a';
                            btnM.style.boxShadow = '0 4px 15px rgba(0,0,0,0.15)';
                            btnY.style.background = 'transparent';
                            btnY.style.color = '#94a3b8';
                            btnY.style.boxShadow = 'none';
                        });

                        btnY.addEventListener('click', function () {
                            monthCards.forEach(c => c.style.display = 'none');
                            yearCards.forEach(c => c.style.display = '');
                            btnY.style.background = '#ffffff';
                            btnY.style.color = '#0f172a';
                            btnY.style.boxShadow = '0 4px 15px rgba(0,0,0,0.15)';
                            btnM.style.background = 'transparent';
                            btnM.style.color = '#94a3b8';
                            btnM.style.boxShadow = 'none';
                        });
                    }
                });
            </script>
        </div>
    </section>

    <!-- 9. FAQ Section -->
    <section class="section-padding" id="faq">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">সাধারণ জিজ্ঞাসা</span>
                <h2 class="section-title">সচরাচর জানতে চাওয়া <br><span class="gradient-text">প্রশ্ন ও উত্তর</span></h2>
                <p class="section-subtitle">আপনার মনে কি কোনো প্রশ্ন আছে? নিচের উত্তরগুলো দেখুন।</p>
            </div>

            <div class="faq-grid">
                
                <div class="faq-item active">
                    <div class="faq-question">
                        <span>১. ওয়েবসাইট বানাতে আমার কি কোনো প্রোগ্রামিং বা কোডিং জানা লাগবে?</span>
                        <span class="faq-toggle">▼</span>
                    </div>
                    <div class="faq-answer">
                        একদমই না! আমাদের প্ল্যাটফর্ম এমনভাবে তৈরি যাতে যে কেউ কোনো প্রকার কোডিং জ্ঞান ছাড়াই ফেসবুক পেজ চালানোর মতোই সহজে প্রোডাক্ট যোগ করতে, অর্ডার নিতে এবং সম্পূর্ণ ওয়েবসাইট পরিচালনা করতে পারেন।
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span>২. আমি কি আমার নিজের ডোমেইন (যেমন: mybrand.com) ব্যবহার করতে পারব?</span>
                        <span class="faq-toggle">▼</span>
                    </div>
                    <div class="faq-answer">
                        হ্যাঁ, অবশ্যই! আপনি যেকোনো ডোমেইন প্রোভাইডার থেকে কেনা কাস্টম ডোমেইন (.com, .com.bd ইত্যাদি) খুব সহজেই আপনার স্টোরের সাথে যুক্ত করতে পারবেন।
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span>৩. কাস্টমারদের বিকাশ বা নগদে পাঠানো টাকা সরাসরি আমার অ্যাকাউন্টে যাবে?</span>
                        <span class="faq-toggle">▼</span>
                    </div>
                    <div class="faq-answer">
                        হ্যাঁ! কাস্টমাররা যখন পেমেন্ট করবে, সম্পূর্ণ টাকা সরাসরি আপনার বিকাশ মার্চেন্ট, নগদ অথবা ব্যাংক অ্যাকাউন্টে জমা হবে। আমরা কোনো ট্রানজেকশন ফি বা কমিশন কাটি না।
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span>৪. ট্রায়াল পিরিয়ড কি আসলেই ফ্রি?</span>
                        <span class="faq-toggle">▼</span>
                    </div>
                    <div class="faq-answer">
                        হ্যাঁ, আপনি প্রথম ১৪ দিন সম্পূর্ণ বিনামূল্যে সব প্রিমিয়াম ফিচার ব্যবহার করে দেখতে পারবেন। কোনো ক্রেডিট কার্ডের প্রয়োজন নেই।
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 10. Final Call To Action Banner (Ultra Sleek & High Conversion) -->
    <div class="container">
        <div class="cta-banner-wrapper">
            <div class="cta-banner">
                <div class="cta-badge-top">
                    <span class="pulse-dot"></span>
                    <span>🇧🇩 বাংলাদেশের উদ্যোক্তাদের এক নম্বর পছন্দের ই-কমার্স ইঞ্জিন</span>
                </div>

                <h2>
                    আজই শুরু করুন আপনার <br>
                    <span class="gradient-text">অনলাইন ব্যবসার নতুন জয়যাত্রা!</span>
                </h2>

                <p>
                    ফেসবুক ইনবক্সে আটকে না থেকে আপনার দোকানকে নিয়ে আসুন নিজস্ব ওয়েবসাইটের ছাতায়। বিকাশ, নগদ পেমেন্ট, POS কাউন্টার ও কুরিয়ার ট্র্যাকিং দিয়ে শুরু করুন ১০০% প্রফেশনাল বিজনেস।
                </p>

                <div class="cta-trust-checklist">
                    <span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        ১৪ দিনের আনলিমিটেড ফ্রি ট্রায়াল
                    </span>
                    <span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        কোনো ক্রেডিট কার্ড বা হিডেন চার্জ নেই
                    </span>
                    <span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        ৫ মিনিটে রেডিমেড স্টোর লাইভ
                    </span>
                    <span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        ২৪/৭ সরাসরি বাংলা হেল্পলাইন
                    </span>
                </div>

                <div class="cta-action-btns">
                    <a href="{{ route('register') }}" class="btn btn-shimmer" style="padding: 16px 38px; font-size: 17px; border-radius: 14px;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                        ১৪ দিনের ফ্রি ট্রায়াল শুরু করুন
                    </a>
                    <a href="https://wa.me/8801800000000?text=Hello%20eCommerceGo%20Support" target="_blank" class="btn btn-emerald" style="padding: 16px 30px; font-size: 17px; border-radius: 14px;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                        হোয়াটসঅ্যাপে কথা বলুন
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- 11. Bengali Modern World-Class Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                
                <!-- Brand & Bio Column -->
                <div class="footer-col">
                    <a href="{{ url('/') }}" class="brand-logo" style="margin-bottom: 20px; text-decoration: none;">
                        <img src="{{ url('storage/uploads/logo/logo-light.png') }}?v={{ time() }}" onerror="this.onerror=null; this.src='{{ url('storage/uploads/logo/edokanpro-horizontal-transparent.png') }}';" alt="edokanpro" style="height: 44px; width: auto; object-fit: contain;" />
                    </a>
                    <p style="font-size: 14px; line-height: 1.8; margin-bottom: 22px; color: #94a3b8;">
                        বাংলাদেশের ক্ষুদ্র ও মাঝারি ব্যবসায়ী, এফ-কমার্স ও নতুন উদ্যোক্তাদের জন্য সবচেয়ে নির্ভরযোগ্য অল-ইন-ওয়ান ক্লাউড ই-কমার্স প্ল্যাটফর্ম।
                    </p>

                    <div class="footer-contact-item">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#818cf8" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        <span>সাপোর্ট ইমেইল: <strong>support@mrdeveloper.xyz</strong></span>
                    </div>
                    <div class="footer-contact-item">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        <span>হেল্পলাইন: <strong>+৮৮০ ১৮০০-০০০০০০ (সকাল ১০টা - রাত ১০টা)</strong></span>
                    </div>

                    <div class="social-icons-row">
                        <a href="https://facebook.com" target="_blank" class="social-btn" title="Facebook">
                            <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="https://youtube.com" target="_blank" class="social-btn" title="YouTube">
                            <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                        <a href="https://linkedin.com" target="_blank" class="social-btn" title="LinkedIn">
                            <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                        </a>
                        <a href="https://wa.me/8801800000000" target="_blank" class="social-btn" title="WhatsApp" style="color: #25d366;">
                            <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="footer-col">
                    <h4>পণ্য ও প্ল্যাটফর্ম</h4>
                    <ul>
                        <li><a href="#features">ফিচার ওভারভিউ &rarr;</a></li>
                        <li><a href="#themes">স্টোর থিমসমূহ &rarr;</a></li>
                        <li><a href="#how-it-works">কীভাবে কাজ করে &rarr;</a></li>
                        <li><a href="#pricing">প্যাকেজ ও মূল্যতালিকা &rarr;</a></li>
                        <li><a href="#faq">সচরাচর প্রশ্ন-উত্তর &rarr;</a></li>
                    </ul>
                </div>

                <!-- Support & Legal -->
                <div class="footer-col">
                    <h4>সাপোর্ট ও পলিসি</h4>
                    <ul>
                        <li><a href="{{ route('login') }}">মার্চেন্ট লগইন</a></li>
                        <li><a href="{{ route('register') }}">নতুন অ্যাকাউন্ট খুলুন</a></li>
                        <li><a href="#">বিকাশ গেটওয়ে গাইড</a></li>
                        <li><a href="#">কুরিয়ার বুকিং টিউটোরিয়াল</a></li>
                        <li><a href="#">প্রাইভেসি ও রিফান্ড পলিসি</a></li>
                    </ul>
                </div>

                <!-- Newsletter & Updates -->
                <div class="footer-col">
                    <h4>আপডেট পেতে যুক্ত থাকুন</h4>
                    <p style="font-size: 14px; margin-bottom: 14px; color: #94a3b8; line-height: 1.6;">
                        ই-কমার্স ব্যবসার গোপন গ্রোথ টিপস এবং নতুন ফিচার নোটিফিকেশন পেতে আপনার ইমেইল দিয়ে সাবস্ক্রাইব করুন।
                    </p>
                    <form method="post" action="{{ route('join_us_store') }}" style="display: flex; gap: 8px; flex-direction: column;">
                        @csrf
                        <div style="display: flex; gap: 8px;">
                            <input type="email" name="email" placeholder="আপনার ব্যবসায়িক ইমেইল..." required style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12); border-radius: 10px; padding: 11px 16px; color: #fff; width: 100%; outline: none; font-size: 14px;">
                            <button type="submit" class="btn btn-primary" style="padding: 11px 20px; font-size: 14px; flex-shrink: 0; border-radius: 10px;">যোগ দিন</button>
                        </div>
                    </form>
                </div>

            </div>

            <!-- Payment & Logistics Partners Strip -->
            <div class="footer-payment-strip">
                <span style="font-size: 13px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px;">সাপোর্টেড পেমেন্ট ও কুরিয়ার:</span>
                <div class="payment-pills-wrap">
                    <span class="pay-pill-mini" style="color: #e2136e;">bKash</span>
                    <span class="pay-pill-mini" style="color: #f7941d;">Nagad</span>
                    <span class="pay-pill-mini" style="color: #8c3494;">Rocket</span>
                    <span class="pay-pill-mini" style="color: #0077b6;">SSLCommerz</span>
                    <span class="pay-pill-mini" style="color: #10b981;">AamarPay</span>
                    <span class="pay-pill-mini" style="color: #3b82f6;">VISA / Master</span>
                    <span class="pay-pill-mini" style="color: #ef4444;">Steadfast</span>
                    <span class="pay-pill-mini" style="color: #f59e0b;">Pathao</span>
                </div>
            </div>

            <!-- Footer Bottom Bar & Credit -->
            <div class="footer-bottom">
                <div>
                    &copy; {{ date('Y') }} <strong>edokanpro</strong> — সর্বস্বত্ব সংরক্ষিত।
                </div>

                <div class="credit-badge-box">
                    <span>ডিজাইন ও ডেভেলপমেন্টে:</span>
                    <a href="https://mrdeveloper.xyz/" target="_blank" class="credit-link">
                        ⚡ MR Developer
                    </a>
                </div>

                <div style="display: flex; align-items: center; gap: 8px;">
                    <span class="pulse-dot"></span>
                    <span>🇧🇩 গর্বের সাথে বাংলাদেশের জন্য নির্মিত</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp Quick Support Widget -->
    <a href="https://wa.me/8801800000000?text=Hi%20MR%20Developer,%20I%20want%20to%20know%20more%20about%20eCommerceGo" target="_blank" class="floating-whatsapp" title="হোয়াটসঅ্যাপে কথা বলুন">
        <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
        <span>হোয়াটসঅ্যাপ সাপোর্ট</span>
    </a>

    <!-- Required Javascript & Interactivity -->
    <script src="{{ url('js/jquery-3.6.0.min.js') }}"></script>
    <script>
        // Interactive FAQ Accordion
        document.querySelectorAll('.faq-question').forEach(item => {
            item.addEventListener('click', () => {
                const parent = item.parentElement;
                const wasActive = parent.classList.contains('active');
                
                document.querySelectorAll('.faq-item').forEach(el => el.classList.remove('active'));
                
                if (!wasActive) {
                    parent.classList.add('active');
                }
            });
        });

        // Smooth Scroll for Nav Links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    </script>
</body>
</html>
