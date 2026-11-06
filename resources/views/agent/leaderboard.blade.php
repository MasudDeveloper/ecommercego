@extends('agent.layouts.app')

@section('page-title')
    {{ __('মার্কেটিং এজেন্ট লিডারবোর্ড') }}
@endsection

@push('custom-css')
<style>
    /* Leaderboard Modern Styles */
    .leaderboard-hero-banner {
        background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%);
        border-radius: 20px;
        padding: 24px 28px;
        color: #ffffff;
        box-shadow: 0 10px 30px rgba(67, 56, 202, 0.2);
        position: relative;
        overflow: hidden;
    }

    .timeframe-pill-group {
        background: #ffffff;
        padding: 5px;
        border-radius: 50px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        display: inline-flex;
        gap: 4px;
        border: 1px solid var(--agent-border);
    }

    .timeframe-pill-btn {
        padding: 7px 18px;
        border-radius: 50px;
        font-size: 13.5px;
        font-weight: 700;
        color: #64748b;
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .timeframe-pill-btn:hover {
        color: #4f46e5;
        background: #f1f5f9;
    }

    .timeframe-pill-btn.active {
        background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.35);
    }

    /* Podium 3D Cards */
    .podium-container {
        display: flex;
        align-items: flex-end;
        justify-content: center;
        gap: 18px;
        margin-bottom: 35px;
        flex-wrap: wrap;
    }

    .podium-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 24px 20px 20px 20px;
        text-align: center;
        position: relative;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        flex: 1;
        min-width: 250px;
        max-width: 320px;
    }

    .podium-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 35px rgba(0, 0, 0, 0.08);
    }

    /* 1st Place Champion Styling */
    .podium-card-1 {
        border: 2px solid #f59e0b;
        background: linear-gradient(180deg, #fffbeb 0%, #ffffff 60%);
        box-shadow: 0 12px 35px rgba(245, 158, 11, 0.18);
        order: 2;
        margin-bottom: 20px; /* Elevated */
    }

    @media (min-width: 768px) {
        .podium-card-1 {
            transform: translateY(-16px);
        }
        .podium-card-1:hover {
            transform: translateY(-22px);
        }
    }

    .podium-card-2 {
        border: 2px solid #94a3b8;
        background: linear-gradient(180deg, #f8fafc 0%, #ffffff 60%);
        box-shadow: 0 8px 25px rgba(148, 163, 184, 0.12);
        order: 1;
    }

    .podium-card-3 {
        border: 2px solid #d97706;
        background: linear-gradient(180deg, #fef3c7 0%, #ffffff 60%);
        box-shadow: 0 8px 25px rgba(217, 119, 6, 0.12);
        order: 3;
    }

    /* Podium Avatars */
    .podium-avatar-wrapper {
        position: relative;
        display: inline-block;
        margin-bottom: 12px;
    }

    .podium-avatar {
        width: 70px;
        height: 70px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        font-weight: 800;
        margin: 0 auto;
    }

    .podium-avatar-1 {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: #ffffff;
        box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
        width: 82px;
        height: 82px;
        font-size: 28px;
    }

    .podium-crown {
        position: absolute;
        top: -18px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 26px;
        filter: drop-shadow(0 2px 6px rgba(0,0,0,0.2));
        animation: floatCrown 3s ease-in-out infinite;
    }

    @keyframes floatCrown {
        0%, 100% { transform: translateX(-50%) translateY(0); }
        50% { transform: translateX(-50%) translateY(-5px); }
    }

    .podium-avatar-2 {
        background: linear-gradient(135deg, #64748b 0%, #475569 100%);
        color: #ffffff;
        box-shadow: 0 6px 18px rgba(100, 116, 139, 0.35);
    }

    .podium-avatar-3 {
        background: linear-gradient(135deg, #b45309 0%, #78350f 100%);
        color: #ffffff;
        box-shadow: 0 6px 18px rgba(180, 83, 9, 0.35);
    }

    .podium-badge-ribbon {
        position: absolute;
        bottom: -8px;
        left: 50%;
        transform: translateX(-50%);
        padding: 3px 12px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        white-space: nowrap;
    }

    /* Podium Pedestal Stand */
    .podium-stand {
        padding: 14px 10px;
        border-radius: 12px;
        margin-top: 14px;
        display: flex;
        justify-content: space-around;
        align-items: center;
    }

    .podium-stand-1 {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(245, 158, 11, 0.05) 100%);
        border: 1px dashed #f59e0b;
    }

    .podium-stand-2 {
        background: linear-gradient(135deg, rgba(148, 163, 184, 0.15) 0%, rgba(148, 163, 184, 0.05) 100%);
        border: 1px dashed #94a3b8;
    }

    .podium-stand-3 {
        background: linear-gradient(135deg, rgba(217, 119, 6, 0.15) 0%, rgba(217, 119, 6, 0.05) 100%);
        border: 1px dashed #d97706;
    }

    /* Table Design */
    .leaderboard-table-card {
        border-radius: 20px;
        border: 1px solid var(--agent-border);
        background: #ffffff;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    }

    .table-rank-pill {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 16px;
        margin: 0 auto;
    }

    .row-current-agent {
        background-color: #f5f3ff !important;
        border-left: 4px solid #4f46e5;
    }
</style>
@endpush

@section('content')

<!-- Header & Timeframe Switcher -->
<div class="row align-items-center mb-4 g-3">
    <div class="col-lg-6">
        <h3 class="font-weight-bold text-dark mb-1 d-flex align-items-center gap-2">
            <span class="p-2 rounded-3 bg-warning bg-opacity-10 text-warning d-inline-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                <i class="ti ti-trophy fs-3"></i>
            </span>
            <span>{{ __('মার্কেটিং পার্টনার চ্যাম্পিয়নশিপ') }}</span>
        </h3>
        <p class="text-muted mb-0">সর্বোচ্চ সফল পেইড মার্চেন্ট রেফারকারী শীর্ষ পার্টনারদের লাইভ লিডারবোর্ড</p>
    </div>

    <div class="col-lg-6 text-lg-end">
        <div class="timeframe-pill-group">
            <a href="{{ route('agent.leaderboard', ['timeframe' => 'weekly']) }}" class="timeframe-pill-btn {{ $timeframe == 'weekly' ? 'active' : '' }}">
                <i class="ti ti-bolt"></i> {{ __('এই সপ্তাহে') }}
            </a>
            <a href="{{ route('agent.leaderboard', ['timeframe' => 'monthly']) }}" class="timeframe-pill-btn {{ $timeframe == 'monthly' ? 'active' : '' }}">
                <i class="ti ti-calendar"></i> {{ __('চলতি মাসে') }}
            </a>
            <a href="{{ route('agent.leaderboard', ['timeframe' => 'all_time']) }}" class="timeframe-pill-btn {{ $timeframe == 'all_time' ? 'active' : '' }}">
                <i class="ti ti-crown"></i> {{ __('সর্বকালের সেরা') }}
            </a>
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- PERSONAL RANK ACHIEVEMENT BANNER               -->
<!-- ============================================== -->
@if($myRankPosition)
<div class="leaderboard-hero-banner mb-4">
    <div class="row align-items-center g-3">
        <div class="col-md-8">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle bg-white text-dark font-weight-bold fs-3 d-flex align-items-center justify-content-center shadow-lg" style="width: 56px; height: 56px; border: 3px solid rgba(255,255,255,0.4);">
                    #{{ $myRankPosition }}
                </div>
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <h4 class="mb-0 text-white font-weight-bold">
                            আপনার বর্তমান অবস্থান: #{{ $myRankPosition }}
                        </h4>
                        <span class="badge bg-white text-primary font-weight-bold px-2 py-1" style="font-size: 11px; border-radius: 20px;">
                            {{ $timeframe == 'weekly' ? 'সাপ্তাহিক র‍্যাংক' : ($timeframe == 'monthly' ? 'মাসিক র‍্যাংক' : 'লাইফটাইম র‍্যাংক') }}
                        </span>
                    </div>

                    @php
                        $topLeader = $topThree->first();
                        $currentAgentStats = $allRankings->firstWhere('is_current', true);
                        $conversions = $currentAgentStats ? $currentAgentStats->conversions : 0;
                        $diffToFirst = $topLeader ? max(0, $topLeader->conversions - $conversions + 1) : 0;
                    @endphp

                    @if($myRankPosition == 1)
                        <p class="mb-0 text-warning font-weight-bold text-sm">
                            👑 অভিনন্দন! আপনি বর্তমানে লিডারবোর্ডের ১ম স্থানে শীর্ষ চ্যাম্পিয়ন হিসেবে অবস্থান করছেন!
                        </p>
                    @else
                        <p class="mb-0 text-sm" style="color: rgba(255, 255, 255, 0.95); font-weight: 500;">
                            ১ম স্থান দখল করতে আর মাত্র <strong class="text-warning">{{ $diffToFirst }}টি</strong> সফল পেইড সাবস্ক্রিপশন প্রয়োজন। লিংক শেয়ার করে দ্রুত এগিয়ে যান!
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4 text-md-end">
            <div class="d-inline-flex align-items-center gap-2">
                <span class="rank-pill shadow-sm" style="{{ $currentAgent->rank_details['badge_style'] ?? '' }}">
                    {{ $currentAgent->rank_details['badge'] }} {{ $currentAgent->rank_details['name'] }}
                </span>
                <a href="{{ route('agent.dashboard') }}" class="btn btn-sm font-weight-bold px-3 py-1.5 rounded-pill shadow-sm" style="background: #ffffff !important; color: #4338ca !important; border: 1px solid #ffffff;">
                    <i class="ti ti-link me-1"></i> {{ __('রেফারেল লিংক') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endif

<!-- ============================================== -->
<!-- OLYMPIC PODIUM: Top 3 Champions                -->
<!-- ============================================== -->
@if($topThree->count() > 0)
<div class="podium-container">

    <!-- 2nd Place (Silver) -->
    @if(isset($topThree[1]))
    <div class="podium-card podium-card-2">
        <div class="podium-avatar-wrapper">
            <div class="podium-avatar podium-avatar-2">
                {{ strtoupper(substr($topThree[1]->name, 0, 1)) }}
            </div>
            <span class="podium-badge-ribbon shadow-sm" style="background: linear-gradient(135deg, #475569 0%, #334155 100%) !important; color: #ffffff !important;">
                🥈 ২য় স্থান
            </span>
        </div>

        <h5 class="font-weight-bold text-dark mb-1 mt-2 text-truncate" title="{{ $topThree[1]->name }}">
            {{ $topThree[1]->name }}
        </h5>

        <div class="mb-2">
            <span class="badge" style="{{ $topThree[1]->rank_details['badge_style'] ?? '' }} font-size: 11px; padding: 4px 10px; border-radius: 20px;">
                {{ $topThree[1]->rank_details['badge'] }} {{ $topThree[1]->rank_details['name'] }}
            </span>
        </div>

        <div class="podium-stand podium-stand-2">
            <div>
                <small class="text-muted text-xs d-block">পেইড কনভার্সন</small>
                <span class="fs-5 font-weight-bold text-dark">🔥 {{ $topThree[1]->conversions }} টি</span>
            </div>
            <div class="border-start ps-3">
                <small class="text-muted text-xs d-block">অর্জিত কমিশন</small>
                <span class="font-weight-bold text-success text-sm">৳{{ number_format($topThree[1]->earnings, 2) }}</span>
            </div>
        </div>
    </div>
    @endif

    <!-- 1st Place (Gold Champion) -->
    @if(isset($topThree[0]))
    <div class="podium-card podium-card-1">
        <div class="podium-avatar-wrapper">
            <div class="podium-crown">👑</div>
            <div class="podium-avatar podium-avatar-1">
                {{ strtoupper(substr($topThree[0]->name, 0, 1)) }}
            </div>
            <span class="podium-badge-ribbon shadow-sm" style="background: linear-gradient(135deg, #b45309 0%, #78350f 100%) !important; color: #ffffff !important; box-shadow: 0 4px 10px rgba(180, 83, 9, 0.4);">
                🥇 চ্যাম্পিয়ন (#১)
            </span>
        </div>

        <h4 class="font-weight-bold text-dark mb-1 mt-2 text-truncate" title="{{ $topThree[0]->name }}" style="font-size: 20px;">
            {{ $topThree[0]->name }}
        </h4>

        <div class="mb-2">
            <span class="badge" style="{{ $topThree[0]->rank_details['badge_style'] ?? '' }} font-size: 11px; padding: 4px 10px; border-radius: 20px;">
                {{ $topThree[0]->rank_details['badge'] }} {{ $topThree[0]->rank_details['name'] }}
            </span>
        </div>

        <div class="podium-stand podium-stand-1">
            <div>
                <small class="text-muted text-xs d-block font-weight-bold">পেইড কনভার্সন</small>
                <span class="fs-4 font-weight-bold text-dark">🔥 {{ $topThree[0]->conversions }} টি</span>
            </div>
            <div class="border-start border-warning ps-3">
                <small class="text-muted text-xs d-block font-weight-bold">মোট আয়</small>
                <span class="fs-6 font-weight-bold text-success">৳{{ number_format($topThree[0]->earnings, 2) }}</span>
            </div>
        </div>
    </div>
    @endif

    <!-- 3rd Place (Bronze) -->
    @if(isset($topThree[2]))
    <div class="podium-card podium-card-3">
        <div class="podium-avatar-wrapper">
            <div class="podium-avatar podium-avatar-3">
                {{ strtoupper(substr($topThree[2]->name, 0, 1)) }}
            </div>
            <span class="podium-badge-ribbon shadow-sm" style="background: linear-gradient(135deg, #92400e 0%, #78350f 100%) !important; color: #ffffff !important;">
                🥉 ৩য় স্থান
            </span>
        </div>

        <h5 class="font-weight-bold text-dark mb-1 mt-2 text-truncate" title="{{ $topThree[2]->name }}">
            {{ $topThree[2]->name }}
        </h5>

        <div class="mb-2">
            <span class="badge" style="{{ $topThree[2]->rank_details['badge_style'] ?? '' }} font-size: 11px; padding: 4px 10px; border-radius: 20px;">
                {{ $topThree[2]->rank_details['badge'] }} {{ $topThree[2]->rank_details['name'] }}
            </span>
        </div>

        <div class="podium-stand podium-stand-3">
            <div>
                <small class="text-muted text-xs d-block">পেইড কনভার্সন</small>
                <span class="fs-5 font-weight-bold text-dark">🔥 {{ $topThree[2]->conversions }} টি</span>
            </div>
            <div class="border-start ps-3">
                <small class="text-muted text-xs d-block">অর্জিত কমিশন</small>
                <span class="font-weight-bold text-success text-sm">৳{{ number_format($topThree[2]->earnings, 2) }}</span>
            </div>
        </div>
    </div>
    @endif

</div>
@endif

<!-- ============================================== -->
<!-- FULL LEADERBOARD RANKINGS TABLE                -->
<!-- ============================================== -->
<div class="leaderboard-table-card">
    <div class="card-header bg-white p-4 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h5 class="mb-0 font-weight-bold text-dark d-flex align-items-center gap-2">
                <i class="ti ti-list-numbers text-primary fs-4"></i> {{ __('সকল পার্টনারের পূর্ণাঙ্গ র‍্যাঙ্কিং তালিকা') }}
            </h5>
            <small class="text-muted">পেইড সাবস্ক্রিপশন সংখ্যা এবং সর্বোচ্চ কমিশনের ভিত্তিতে ক্রমবিন্যাস</small>
        </div>
        <span class="badge bg-light text-muted border px-3 py-1 font-monospace">
            মোট পার্টনার: {{ $allRankings->count() }} জন
        </span>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th style="width: 90px;" class="text-center">{{ __('র‍্যাঙ্ক') }}</th>
                        <th class="ps-3">{{ __('এজেন্টের নাম ও কোড') }}</th>
                        <th>{{ __('পার্টনার লেভেল') }}</th>
                        <th class="text-center">{{ __('সফল পেইড কনভার্সন') }}</th>
                        <th class="text-end pe-4">{{ __('অর্জিত মোট কমিশন') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($allRankings as $row)
                    <tr class="{{ $row->is_current ? 'row-current-agent' : '' }}">
                        <td class="text-center">
                            @if($row->position == 1)
                                <div class="table-rank-pill" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); color: #b45309; border: 1px solid #f59e0b;">
                                    🥇
                                </div>
                            @elseif($row->position == 2)
                                <div class="table-rank-pill" style="background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%); color: #475569; border: 1px solid #94a3b8;">
                                    🥈
                                </div>
                            @elseif($row->position == 3)
                                <div class="table-rank-pill" style="background: linear-gradient(135deg, #ffedd5 0%, #fed7aa 100%); color: #9a3412; border: 1px solid #d97706;">
                                    🥉
                                </div>
                            @else
                                <div class="table-rank-pill bg-light text-muted border">
                                    #{{ $row->position }}
                                </div>
                            @endif
                        </td>
                        <td class="ps-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle {{ $row->is_current ? 'bg-primary text-white' : 'bg-light text-dark border' }} d-flex align-items-center justify-content-center font-weight-bold" style="width: 42px; height: 42px; font-size: 15px;">
                                    {{ strtoupper(substr($row->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h6 class="mb-0 font-weight-bold text-dark">
                                        {{ $row->name }}
                                        @if($row->is_current)
                                            <span class="badge ms-1" style="font-size: 10px; background: #4f46e5; color: #ffffff;">✨ আপনি</span>
                                        @endif
                                    </h6>
                                    <small class="text-muted font-monospace">{{ $row->referral_code }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge" style="{{ $row->rank_details['badge_style'] ?? '' }} font-size: 12px; padding: 5px 12px; border-radius: 20px;">
                                {{ $row->rank_details['badge'] }} {{ $row->rank_details['name'] }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge font-weight-bold px-3 py-2" style="background: #eef2ff; color: #4338ca; border: 1px solid #c7d2fe; font-size: 13.5px; border-radius: 8px;">
                                🔥 {{ $row->conversions }} টি
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <span class="font-weight-bold text-success fs-6">৳{{ number_format($row->earnings, 2) }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="ti ti-trophy-off fs-1 d-block mb-2 text-gray-400"></i>
                            <h6 class="font-weight-bold">{{ __('এই সময়ের জন্য কোনো র‍্যাঙ্কিং ডাটা পাওয়া যায়নি') }}</h6>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
