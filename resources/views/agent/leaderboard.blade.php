@extends('agent.layouts.app')

@section('page-title')
    {{ __('মার্কেটিং এজেন্ট লিডারবোর্ড ও র‍্যাঙ্কিং') }}
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h3 class="font-weight-bold mb-1 d-flex align-items-center gap-2">
                    <i class="ti ti-trophy text-warning fs-2"></i> {{ __('পার্টনার লিডারবোর্ড ও চ্যাম্পিয়নশিপ') }}
                </h3>
                <p class="text-muted mb-0">সর্বোচ্চ সফল পেইড মার্চেন্ট কনভার্সনকারী শীর্ষ পার্টনারদের তালিকা</p>
            </div>
            <!-- Timeframe Filter -->
            <div class="btn-group shadow-sm">
                <a href="{{ route('agent.leaderboard', ['timeframe' => 'weekly']) }}" class="btn btn-sm btn-outline-primary {{ $timeframe == 'weekly' ? 'active' : '' }}">
                    {{ __('এই সপ্তাহে') }}
                </a>
                <a href="{{ route('agent.leaderboard', ['timeframe' => 'monthly']) }}" class="btn btn-sm btn-outline-primary {{ $timeframe == 'monthly' ? 'active' : '' }}">
                    {{ __('এই মাসে') }}
                </a>
                <a href="{{ route('agent.leaderboard', ['timeframe' => 'all_time']) }}" class="btn btn-sm btn-outline-primary {{ $timeframe == 'all_time' ? 'active' : '' }}">
                    {{ __('সর্বকালের সেরা') }}
                </a>
            </div>
        </div>
    </div>
</div>

<!-- My Position Alert Banner -->
@if($myRankPosition)
<div class="card stat-card mb-4 border-0" style="background: linear-gradient(135deg, #312e81 0%, #4338ca 100%); color: #ffffff;">
    <div class="card-body p-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-circle bg-white text-dark font-weight-bold fs-4 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                #{{ $myRankPosition }}
            </div>
            <div>
                <h5 class="mb-0 text-white font-weight-bold">আপনার বর্তমান অবস্থান: #{{ $myRankPosition }}</h5>
                <small class="text-white-50">লিডারবোর্ডের শীর্ষে উঠতে আরও বেশি মার্চেন্টকে edokanpro-তে আমন্ত্রণ জানান।</small>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="rank-pill {{ $currentAgent->rank_details['badge_class'] }}">
                {{ $currentAgent->rank_details['badge'] }} {{ $currentAgent->rank_details['name'] }}
            </span>
        </div>
    </div>
</div>
@endif

<!-- Top 3 Podium Cards -->
@if($topThree->count() > 0)
<div class="row g-3 mb-4 justify-content-center align-items-end">
    <!-- 2nd Place -->
    @if(isset($topThree[1]))
    <div class="col-md-4 col-sm-6 order-2 order-md-1">
        <div class="card stat-card text-center p-3 border-top border-4 border-info">
            <div class="fs-1 mb-1">🥈</div>
            <div class="badge bg-info text-white mb-2 px-3 py-1 font-weight-bold rounded-pill">২য় স্থান (2nd)</div>
            <h5 class="font-weight-bold mb-1">{{ $topThree[1]->name }}</h5>
            <span class="rank-pill {{ $topThree[1]->rank_details['badge_class'] }} mb-2">
                {{ $topThree[1]->rank_details['badge'] }} {{ $topThree[1]->rank_details['name'] }}
            </span>
            <div class="p-2 bg-light rounded-3 mt-2">
                <span class="text-muted text-xs d-block">পেইড কনভার্সন</span>
                <span class="fs-5 font-weight-bold text-dark">{{ $topThree[1]->conversions }} টি</span>
            </div>
        </div>
    </div>
    @endif

    <!-- 1st Place (Champion) -->
    @if(isset($topThree[0]))
    <div class="col-md-4 col-sm-6 order-1 order-md-2">
        <div class="card stat-card text-center p-4 border-top border-4 border-warning shadow-lg" style="background: linear-gradient(180deg, #fffbeb 0%, #ffffff 100%);">
            <div class="fs-1 mb-1" style="font-size: 3rem !important;">👑 🥇</div>
            <div class="badge bg-warning text-dark mb-2 px-3 py-1 font-weight-bold rounded-pill fs-6">চ্যাম্পিয়ন (1st Place)</div>
            <h4 class="font-weight-bold mb-1 text-dark">{{ $topThree[0]->name }}</h4>
            <span class="rank-pill {{ $topThree[0]->rank_details['badge_class'] }} mb-2">
                {{ $topThree[0]->rank_details['badge'] }} {{ $topThree[0]->rank_details['name'] }}
            </span>
            <div class="p-3 bg-white border border-warning rounded-3 mt-2">
                <span class="text-muted text-xs d-block">পেইড কনভার্সন</span>
                <span class="fs-3 font-weight-bold text-warning">{{ $topThree[0]->conversions }} টি</span>
            </div>
        </div>
    </div>
    @endif

    <!-- 3rd Place -->
    @if(isset($topThree[2]))
    <div class="col-md-4 col-sm-6 order-3 order-md-3">
        <div class="card stat-card text-center p-3 border-top border-4 border-secondary">
            <div class="fs-1 mb-1">🥉</div>
            <div class="badge bg-secondary text-white mb-2 px-3 py-1 font-weight-bold rounded-pill">৩য় স্থান (3rd)</div>
            <h5 class="font-weight-bold mb-1">{{ $topThree[2]->name }}</h5>
            <span class="rank-pill {{ $topThree[2]->rank_details['badge_class'] }} mb-2">
                {{ $topThree[2]->rank_details['badge'] }} {{ $topThree[2]->rank_details['name'] }}
            </span>
            <div class="p-2 bg-light rounded-3 mt-2">
                <span class="text-muted text-xs d-block">পেইড কনভার্সন</span>
                <span class="fs-5 font-weight-bold text-dark">{{ $topThree[2]->conversions }} টি</span>
            </div>
        </div>
    </div>
    @endif
</div>
@endif

<!-- Full Leaderboard Table -->
<div class="card stat-card">
    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
        <h5 class="mb-0 font-weight-bold">{{ __('সকল পার্টনারের র‍্যাঙ্কিং তালিকা') }}</h5>
        <span class="text-muted text-xs">{{ $timeframe == 'weekly' ? 'এই সপ্তাহের ফলাফল' : ($timeframe == 'monthly' ? 'এই চলতি মাসের ফলাফল' : 'সর্বকালের ফলাফল') }}</span>
    </div>
    <div class="card-body table-border-style p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th style="width: 80px;" class="text-center">{{ __('র‍্যাঙ্ক') }}</th>
                        <th>{{ __('এজেন্টের নাম') }}</th>
                        <th>{{ __('পার্টনার লেভেল') }}</th>
                        <th class="text-center">{{ __('পেইড কনভার্সন') }}</th>
                        <th class="text-end">{{ __('অর্জিত কমিশন') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($allRankings as $row)
                    <tr class="{{ $row->is_current ? 'table-primary bg-primary bg-opacity-10' : '' }}">
                        <td class="text-center">
                            @if($row->position == 1)
                                <span class="fs-4">🥇</span>
                            @elseif($row->position == 2)
                                <span class="fs-4">🥈</span>
                            @elseif($row->position == 3)
                                <span class="fs-4">🥉</span>
                            @else
                                <span class="badge bg-light text-dark font-monospace fs-6">#{{ $row->position }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle {{ $row->is_current ? 'bg-primary text-white' : 'bg-light text-dark' }} d-flex align-items-center justify-content-center me-2 font-weight-bold" style="width: 38px; height: 38px;">
                                    {{ strtoupper(substr($row->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h6 class="mb-0 font-weight-bold">
                                        {{ $row->name }}
                                        @if($row->is_current)
                                            <span class="badge bg-primary ms-1 text-xs">{{ __('আপনি') }}</span>
                                        @endif
                                    </h6>
                                    <small class="text-muted font-monospace">{{ $row->referral_code }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="rank-pill {{ $row->rank_details['badge_class'] }}">
                                {{ $row->rank_details['badge'] }} {{ $row->rank_details['name'] }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-light-primary text-primary fs-6 px-3 py-1 font-weight-bold">
                                {{ $row->conversions }} টি
                            </span>
                        </td>
                        <td class="text-end">
                            <span class="font-weight-bold text-dark fs-6">৳{{ number_format($row->earnings, 2) }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            {{ __('এখনও কোনো র‍্যাঙ্কিং ডাটা পাওয়া যায়নি।') }}
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

