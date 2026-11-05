<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page-title', 'মার্কেটিং এজেন্ট ড্যাশবোর্ড') - edokanpro</title>
    
    <!-- Google Fonts: Hind Siliguri (Bengali) + Plus Jakarta Sans / Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- CSS Assets -->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    
    <style>
        :root {
            --agent-primary: #4f46e5;
            --agent-primary-hover: #4338ca;
            --agent-sidebar-bg: #0f172a;
            --agent-sidebar-hover: #1e293b;
            --agent-sidebar-active: #4f46e5;
            --agent-sidebar-text: #94a3b8;
            --agent-body-bg: #f8fafc;
            --agent-card-bg: #ffffff;
            --agent-border: #e2e8f0;
        }

        body {
            font-family: 'Hind Siliguri', 'Plus Jakarta Sans', sans-serif;
            background-color: var(--agent-body-bg);
            color: #1e293b;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Layout Structure */
        .agent-layout {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styling */
        .agent-sidebar {
            width: 270px;
            background-color: var(--agent-sidebar-bg);
            color: #ffffff;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-right: 1px solid rgba(255, 255, 255, 0.06);
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.08);
        }

        .agent-sidebar-brand {
            padding: 24px 20px 20px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255, 255, 255, 0.07);
        }

        .brand-logo-text {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: #ffffff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .brand-logo-text span {
            color: #818cf8;
        }

        .portal-badge {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            padding: 3px 8px;
            border-radius: 6px;
            background: rgba(99, 102, 241, 0.2);
            color: #a5b4fc;
            border: 1px solid rgba(99, 102, 241, 0.3);
        }

        /* Sidebar Agent Card */
        .sidebar-agent-profile {
            padding: 18px 20px;
            margin: 14px 16px;
            background: linear-gradient(145deg, #1e293b 0%, #0f172a 100%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 14px;
        }

        .agent-avatar-circle {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 800;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.35);
        }

        /* Navigation List */
        .sidebar-nav-container {
            flex: 1;
            overflow-y: auto;
            padding: 10px 14px;
        }

        .nav-category-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #64748b;
            padding: 12px 12px 6px 12px;
            margin: 0;
        }

        .agent-side-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            border-radius: 10px;
            color: var(--agent-sidebar-text);
            text-decoration: none;
            font-size: 14.5px;
            font-weight: 600;
            transition: all 0.2s ease;
            margin-bottom: 4px;
        }

        .agent-side-link i {
            font-size: 19px;
            transition: transform 0.2s ease;
        }

        .agent-side-link:hover {
            color: #ffffff;
            background-color: var(--agent-sidebar-hover);
            transform: translateX(3px);
        }

        .agent-side-link:hover i {
            transform: scale(1.15);
        }

        .agent-side-link.active {
            color: #ffffff;
            background: linear-gradient(90deg, #4f46e5 0%, #6366f1 100%);
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);
        }

        .agent-side-link.active i {
            color: #ffffff !important;
        }

        /* Sidebar Footer / Wallet Box */
        .sidebar-footer-card {
            padding: 16px;
            margin: 12px 14px 16px 14px;
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.12) 0%, rgba(99, 102, 241, 0.05) 100%);
            border: 1px dashed rgba(99, 102, 241, 0.3);
            border-radius: 12px;
            text-align: center;
        }

        /* Main Content Container */
        .agent-main-wrapper {
            flex: 1;
            margin-left: 270px;
            display: flex;
            flex-direction: column;
            min-width: 0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Top Header */
        .agent-top-header {
            height: 72px;
            background: #ffffff;
            border-bottom: 1px solid var(--agent-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            position: sticky;
            top: 0;
            z-index: 1030;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
        }

        .top-referral-bar {
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            padding: 6px 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            max-width: 440px;
            width: 100%;
        }

        .top-referral-bar input {
            background: transparent;
            border: 0;
            font-size: 13px;
            font-family: monospace;
            font-weight: 600;
            color: #334155;
            width: 100%;
            outline: none;
        }

        .rank-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 14px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 700;
        }

        /* Modern Tier Badges */
        .tier-badge-bronze {
            background: linear-gradient(135deg, #b45309 0%, #d97706 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 2px 8px rgba(217, 119, 6, 0.3);
        }
        .tier-badge-silver {
            background: linear-gradient(135deg, #0284c7 0%, #38bdf8 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 2px 8px rgba(2, 132, 199, 0.3);
        }
        .tier-badge-gold {
            background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 2px 10px rgba(245, 158, 11, 0.4);
        }
        .tier-badge-diamond {
            background: linear-gradient(135deg, #4f46e5 0%, #818cf8 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 2px 10px rgba(79, 70, 229, 0.4);
        }
        .tier-badge-legend {
            background: linear-gradient(135deg, #0f172a 0%, #7c3aed 100%) !important;
            color: #fbbf24 !important;
            border: 1px solid rgba(251, 191, 36, 0.5) !important;
            box-shadow: 0 4px 14px rgba(124, 58, 237, 0.4);
        }

        /* Modern Card Styling */
        .stat-card {
            background: #ffffff;
            border: 1px solid var(--agent-border);
            border-radius: 16px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
        }

        .icon-badge {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        /* Mobile Backdrop */
        .sidebar-backdrop {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            z-index: 1035;
        }

        @media (max-width: 991.98px) {
            .agent-sidebar {
                transform: translateX(-100%);
            }
            .agent-sidebar.show {
                transform: translateX(0);
            }
            .agent-main-wrapper {
                margin-left: 0;
            }
            .sidebar-backdrop.show {
                display: block;
            }
            .top-referral-bar {
                display: none;
            }
        }
    </style>
    @stack('custom-css')
</head>
<body>

@php
    $authAgent = Auth::guard('agent')->user();
    $rank = $authAgent ? $authAgent->rank_details : null;
    $availableBal = $authAgent ? $authAgent->pendingBalance() : 0;
@endphp

<div class="agent-layout">

    <!-- Mobile Sidebar Backdrop -->
    <div class="sidebar-backdrop" id="sidebarBackdrop" onclick="toggleAgentSidebar()"></div>

    <!-- ============================================== -->
    <!-- MODERN SIDEBAR NAVIGATION                      -->
    <!-- ============================================== -->
    <aside class="agent-sidebar" id="agentSidebar">
        <!-- Brand Header -->
        <div class="agent-sidebar-brand">
            <a href="{{ route('agent.dashboard') }}" class="brand-logo-text">
                edokan<span>pro</span>
            </a>
            <span class="portal-badge">Agent Portal</span>
        </div>

        <!-- Agent Profile Overview Card -->
        <div class="sidebar-agent-profile">
            <div class="d-flex align-items-center gap-3">
                <div class="agent-avatar-circle">
                    {{ strtoupper(substr($authAgent->name ?? 'A', 0, 1)) }}
                </div>
                <div class="overflow-hidden">
                    <h6 class="mb-0 text-white font-weight-bold text-truncate" style="font-size: 15px;">{{ $authAgent->name ?? 'Agent' }}</h6>
                    <div class="d-flex align-items-center gap-1 mt-1">
                        <span class="badge bg-secondary font-monospace text-xs" style="font-size: 11px;">{{ $authAgent->referral_code ?? '' }}</span>
                        <button type="button" class="btn btn-xs p-0 text-white-50 hover-text-white" onclick="copyTextToClipboard('{{ $authAgent->referral_code ?? '' }}', this)" title="কোড কপি">
                            <i class="ti ti-copy" style="font-size: 13px;"></i>
                        </button>
                    </div>
                </div>
            </div>

            @if($rank)
            <div class="mt-3 pt-2 border-top border-white border-opacity-10 d-flex align-items-center justify-content-between">
                <span class="text-xs text-white-50">বর্তমান লেভেল:</span>
                <span class="badge {{ $rank['badge_class'] }}" style="font-size: 11px;">
                    {{ $rank['badge'] }} {{ $rank['name'] }}
                </span>
            </div>
            @endif
        </div>

        <!-- Sidebar Navigation Menu -->
        <div class="sidebar-nav-container">
            <p class="nav-category-title">{{ __('প্রধান মেনু') }}</p>

            <a href="{{ route('agent.dashboard') }}" class="agent-side-link {{ request()->routeIs('agent.dashboard') ? 'active' : '' }}">
                <i class="ti ti-smart-home text-primary"></i>
                <span>{{ __('ড্যাশবোর্ড') }}</span>
            </a>

            <a href="{{ route('agent.leaderboard') }}" class="agent-side-link {{ request()->routeIs('agent.leaderboard') ? 'active' : '' }}">
                <i class="ti ti-trophy text-warning"></i>
                <span class="flex-grow-1">{{ __('লিডারবোর্ড') }}</span>
                <span class="badge bg-warning text-dark text-xs font-weight-bold">র‍্যাঙ্কিং</span>
            </a>

            <a href="{{ route('agent.leads') }}" class="agent-side-link {{ request()->routeIs('agent.leads*') ? 'active' : '' }}">
                <i class="ti ti-users text-info"></i>
                <span class="flex-grow-1">{{ __('লিড ম্যানেজার (CRM)') }}</span>
                @if($authAgent && $authAgent->leads()->where('status', 'new')->count() > 0)
                    <span class="badge bg-info text-white text-xs">{{ $authAgent->leads()->where('status', 'new')->count() }}</span>
                @endif
            </a>

            <a href="{{ route('agent.resources') }}" class="agent-side-link {{ request()->routeIs('agent.resources') ? 'active' : '' }}">
                <i class="ti ti-book-2 text-success"></i>
                <span>{{ __('মার্কেটিং টুলকিট ও স্ক্রিপ্ট') }}</span>
            </a>

            <p class="nav-category-title mt-3">{{ __('অর্থ ও অ্যাকাউন্ট') }}</p>

            <a href="{{ route('agent.wallet') }}" class="agent-side-link {{ request()->routeIs('agent.wallet*') ? 'active' : '' }}">
                <i class="ti ti-wallet text-warning"></i>
                <span>{{ __('ওয়ালেট ও পেআউট') }}</span>
            </a>

            <a href="{{ route('agent.profile') }}" class="agent-side-link {{ request()->routeIs('agent.profile') ? 'active' : '' }}">
                <i class="ti ti-user-circle text-primary"></i>
                <span>{{ __('প্রোফাইল ও সেটিংস') }}</span>
            </a>
        </div>

        <!-- Sidebar Bottom Quick Wallet Widget -->
        <div class="sidebar-footer-card">
            <div class="text-xs text-white-50 mb-1">{{ __('উত্তোলনযোগ্য ব্যালেন্স') }}</div>
            <h5 class="text-warning font-weight-bold mb-2">৳{{ number_format($availableBal, 2) }}</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('agent.wallet') }}" class="btn btn-xs btn-warning flex-grow-1 font-weight-bold text-dark py-1">
                    <i class="ti ti-cash me-1"></i> {{ __('উত্তোলন') }}
                </a>
                <form method="POST" action="{{ route('agent.logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-xs btn-outline-danger py-1 px-2" title="লগআউট">
                        <i class="ti ti-logout"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- ============================================== -->
    <!-- MAIN CONTENT WRAPPER                           -->
    <!-- ============================================== -->
    <div class="agent-main-wrapper">

        <!-- Top Header Navbar -->
        <header class="agent-top-header">
            <div class="d-flex align-items-center gap-3">
                <button type="button" class="btn btn-sm btn-light border d-lg-none" onclick="toggleAgentSidebar()">
                    <i class="ti ti-menu-2 fs-5"></i>
                </button>
                <div>
                    <h5 class="mb-0 font-weight-bold text-dark">@yield('page-title', 'ড্যাশবোর্ড')</h5>
                    <small class="text-muted d-none d-sm-block">মার্কেটিং পার্টনার ইকোসিস্টেম</small>
                </div>
            </div>

            <!-- Center: Quick Referral Link Copy -->
            <div class="top-referral-bar d-none d-md-flex">
                <i class="ti ti-link text-primary fs-5"></i>
                <input type="text" id="topHeaderRefLink" value="{{ $authAgent ? $authAgent->referral_url : '' }}" readonly>
                <button type="button" class="btn btn-xs btn-primary d-flex align-items-center gap-1 text-nowrap px-2" onclick="copyReferralLinkTop(this)">
                    <i class="ti ti-copy"></i> <span>কপি</span>
                </button>
            </div>

            <!-- Right Controls & Profile Dropdown -->
            <div class="d-flex align-items-center gap-3">
                @if($rank)
                <div class="rank-pill {{ $rank['badge_class'] }} d-none d-xl-inline-flex shadow-sm">
                    <span>{{ $rank['badge'] }}</span>
                    <span>{{ $rank['name'] }}</span>
                </div>
                @endif

                <div class="dropdown">
                    <button class="btn btn-light border rounded-pill d-flex align-items-center gap-2 py-1 px-2 shadow-sm" type="button" data-bs-toggle="dropdown">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center font-weight-bold" style="width: 32px; height: 32px; font-size: 13px;">
                            {{ strtoupper(substr($authAgent->name ?? 'A', 0, 1)) }}
                        </div>
                        <span class="d-none d-md-inline font-weight-bold text-dark text-sm me-1">{{ $authAgent->name ?? 'Agent' }}</span>
                        <i class="ti ti-chevron-down text-muted text-xs"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3 mt-2" style="min-width: 220px;">
                        <li class="px-3 py-2 border-bottom">
                            <div class="font-weight-bold text-dark">{{ $authAgent->name ?? '' }}</div>
                            <small class="text-muted font-monospace">{{ $authAgent->phone ?? '' }}</small>
                        </li>
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('agent.profile') }}">
                                <i class="ti ti-user me-2 text-primary"></i> {{ __('আমার প্রোফাইল') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('agent.wallet') }}">
                                <i class="ti ti-wallet me-2 text-success"></i> {{ __('ওয়ালেট ও উইথড্র') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('agent.resources') }}">
                                <i class="ti ti-book me-2 text-info"></i> {{ __('মার্কেটিং স্ক্রিপ্ট') }}
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('agent.logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 text-danger">
                                    <i class="ti ti-logout me-2"></i> {{ __('লগআউট করুন') }}
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-grow-1 p-3 p-lg-4">
            <!-- Flash Alerts -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 border-0 shadow-sm rounded-3 mb-4" role="alert">
                    <i class="ti ti-circle-check fs-4 text-success"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 border-0 shadow-sm rounded-3 mb-4" role="alert">
                    <i class="ti ti-alert-circle fs-4 text-danger"></i>
                    <div>{{ session('error') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show d-flex align-items-center gap-2 border-0 shadow-sm rounded-3 mb-4" role="alert">
                    <i class="ti ti-info-circle fs-4 text-info"></i>
                    <div>{{ session('info') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Modern Footer -->
        <footer class="py-3 px-4 bg-white border-top text-center text-muted text-sm mt-auto">
            © {{ date('Y') }} <strong class="text-dark">edokanpro</strong> — মার্কেটিং এজেন্ট ও এফিলিয়েট প্ল্যাটফর্ম। সর্বস্বত্ব সংরক্ষিত।
        </footer>

    </div>
</div>

<!-- JS Assets -->
<script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>

<!-- Global Helpers -->
<script>
function toggleAgentSidebar() {
    var sidebar = document.getElementById('agentSidebar');
    var backdrop = document.getElementById('sidebarBackdrop');
    sidebar.classList.toggle('show');
    backdrop.classList.toggle('show');
}

function copyTextToClipboard(text, btnElement) {
    navigator.clipboard.writeText(text).then(function() {
        var originalHtml = btnElement.innerHTML;
        btnElement.innerHTML = '<i class="ti ti-check"></i>';
        setTimeout(function() {
            btnElement.innerHTML = originalHtml;
        }, 1500);
    });
}

function copyReferralLinkTop(btn) {
    var input = document.getElementById('topHeaderRefLink');
    navigator.clipboard.writeText(input.value).then(function() {
        var span = btn.querySelector('span');
        var originalText = span.innerText;
        span.innerText = 'কপি!';
        btn.classList.remove('btn-primary');
        btn.classList.add('btn-success');
        setTimeout(function() {
            span.innerText = originalText;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-primary');
        }, 2000);
    });
}
</script>
@stack('custom-script')
</body>
</html>
