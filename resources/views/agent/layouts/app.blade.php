<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page-title', 'মার্কেটিং এজেন্ট ড্যাশবোর্ড') - edokanpro</title>
    
    <!-- Google Font: Inter / Hind Siliguri -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    
    <style>
        body {
            font-family: 'Hind Siliguri', 'Inter', sans-serif;
            background-color: #f4f6fa;
            color: #2d3748;
        }
        .agent-navbar {
            background: #ffffff;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            border-bottom: 1px solid #edf2f7;
            position: sticky;
            top: 0;
            z-index: 1020;
        }
        .nav-link.agent-nav-link {
            font-weight: 600;
            font-size: 14.5px;
            color: #4a5568;
            padding: 10px 14px !important;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
        }
        .nav-link.agent-nav-link:hover, .nav-link.agent-nav-link.active {
            color: #4338ca !important;
            background-color: #eef2ff;
        }
        .stat-card {
            border: 0;
            border-radius: 14px;
            box-shadow: 0 4px 18px rgba(0,0,0,0.04);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            background: #ffffff;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 22px rgba(0,0,0,0.07);
        }
        .rank-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 700;
        }
        .copy-box {
            background: #f8fafc;
            border: 1.5px dashed #cbd5e1;
            border-radius: 10px;
            padding: 10px 14px;
        }
        .script-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 14px;
            position: relative;
            font-size: 14px;
            white-space: pre-wrap;
            line-height: 1.6;
        }
        .btn-copy-code {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .brand-badge {
            font-size: 11px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            font-weight: 800;
            background: #eef2ff;
            color: #4f46e5;
            padding: 2px 8px;
            border-radius: 6px;
        }
    </style>
    @stack('custom-css')
</head>
<body>
    <!-- Main Top Navbar -->
    <nav class="navbar navbar-expand-lg agent-navbar py-2">
        <div class="container-fluid px-lg-4">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('agent.dashboard') }}">
                <span class="fs-4 font-weight-bold text-primary" style="letter-spacing: -0.5px;">edokan<span class="text-dark">pro</span></span>
                <span class="brand-badge">{{ __('Agent Portal') }}</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#agentNavbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="agentNavbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-3 gap-1">
                    <li class="nav-item">
                        <a class="nav-link agent-nav-link {{ request()->routeIs('agent.dashboard') ? 'active' : '' }}" href="{{ route('agent.dashboard') }}">
                            <i class="ti ti-layout-dashboard fs-5"></i> {{ __('ড্যাশবোর্ড') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link agent-nav-link {{ request()->routeIs('agent.leaderboard') ? 'active' : '' }}" href="{{ route('agent.leaderboard') }}">
                            <i class="ti ti-trophy fs-5 text-warning"></i> {{ __('লিডারবোর্ড') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link agent-nav-link {{ request()->routeIs('agent.leads*') ? 'active' : '' }}" href="{{ route('agent.leads') }}">
                            <i class="ti ti-users fs-5 text-info"></i> {{ __('লিড ম্যানেজার (CRM)') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link agent-nav-link {{ request()->routeIs('agent.resources') ? 'active' : '' }}" href="{{ route('agent.resources') }}">
                            <i class="ti ti-bookmarks fs-5 text-success"></i> {{ __('মার্কেটিং টুলকিট ও স্ক্রিপ্ট') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link agent-nav-link {{ request()->routeIs('agent.wallet*') ? 'active' : '' }}" href="{{ route('agent.wallet') }}">
                            <i class="ti ti-wallet fs-5 text-primary"></i> {{ __('ওয়ালেট ও পেআউট') }}
                        </a>
                    </li>
                </ul>

                @php
                    $authAgent = Auth::guard('agent')->user();
                    $rank = $authAgent ? $authAgent->rank_details : null;
                @endphp

                <div class="d-flex align-items-center gap-3">
                    @if($rank)
                    <div class="rank-pill {{ $rank['badge_class'] }} d-none d-md-inline-flex" title="আপনার বর্তমান পার্টনার লেভেল">
                        <span>{{ $rank['badge'] }}</span>
                        <span>{{ $rank['name'] }}</span>
                    </div>
                    @endif

                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center gap-2 py-1 px-2 rounded-pill" type="button" data-bs-toggle="dropdown">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-weight: bold; font-size: 13px;">
                                {{ strtoupper(substr($authAgent->name ?? 'A', 0, 1)) }}
                            </div>
                            <span class="d-none d-md-inline font-weight-bold text-dark">{{ $authAgent->name ?? 'Agent' }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                            <li class="px-3 py-2 border-bottom">
                                <div class="font-weight-bold">{{ $authAgent->name ?? '' }}</div>
                                <small class="text-muted font-monospace">রেফারেল: {{ $authAgent->referral_code ?? '' }}</small>
                            </li>
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('agent.profile') }}">
                                    <i class="ti ti-user me-2 text-primary"></i> {{ __('আমার প্রোফাইল') }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('agent.wallet') }}">
                                    <i class="ti ti-cash me-2 text-success"></i> {{ __('উইথড্রয়াল হিস্ট্রি') }}
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('agent.logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 text-danger">
                                        <i class="ti ti-logout me-2"></i> {{ __('লগআউট') }}
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content Container -->
    <main class="py-4">
        <div class="container-fluid px-lg-4">
            <!-- Flash Alerts -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                    <i class="ti ti-check fs-4"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                    <i class="ti ti-alert-circle fs-4"></i>
                    <div>{{ session('error') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                    <i class="ti ti-info-circle fs-4"></i>
                    <div>{{ session('info') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="py-3 text-center text-muted border-top bg-white mt-auto">
        <small>© {{ date('Y') }} <strong>edokanpro</strong> — মার্কেটিং পার্টনার ও এফিলিয়েট প্ল্যাটফর্ম। সর্বস্বত্ব সংরক্ষিত।</small>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>

    <!-- Global Copy Referral Script -->
    <script>
    function copyTextToClipboard(text, btnElement) {
        navigator.clipboard.writeText(text).then(function() {
            var originalHtml = btnElement.innerHTML;
            btnElement.innerHTML = '<i class="ti ti-check"></i> কপি হয়েছে!';
            btnElement.classList.add('btn-success');
            setTimeout(function() {
                btnElement.innerHTML = originalHtml;
                btnElement.classList.remove('btn-success');
            }, 2000);
        });
    }
    </script>
    @stack('custom-script')
</body>
</html>

