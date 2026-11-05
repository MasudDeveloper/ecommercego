@extends('agent.layouts.app')

@section('page-title')
    {{ __('মার্কেটিং এজেন্ট ড্যাশবোর্ড') }}
@endsection

@section('content')
<!-- Top Hero / Referral Link Banner -->
<div class="card stat-card mb-4 border-0" style="background: linear-gradient(135deg, #1e1b4b 0%, #312e81 60%, #4338ca 100%); color: #ffffff;">
    <div class="card-body p-4">
        <div class="row align-items-center">
            <div class="col-lg-7 mb-3 mb-lg-0">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="rank-pill {{ $rank['badge_class'] }}">
                        {{ $rank['badge'] }} {{ $rank['name'] }}
                    </span>
                    <span class="badge bg-white text-dark font-monospace px-2 py-1">কোড: {{ $agent->referral_code }}</span>
                </div>
                <h3 class="mb-1 text-white font-weight-bold">স্বাগতম, {{ $agent->name }}! 👋</h3>
                <p class="text-white-50 mb-3 text-sm">
                    আপনার ইউনিক রেফারেল লিংক দিয়ে মার্চেন্টদের edokanpro-তে যুক্ত করুন এবং প্রতি সফল পেইড সাবস্ক্রিপশনে আকর্ষণীয় {{ $agent->commission_rate }}{{ $agent->commission_type == 'percentage' ? '%' : ' ৳' }} কমিশন ও টার্গেট বোনাস উপভোগ করুন।
                </p>

                <!-- Referral Link Box -->
                <div class="d-flex align-items-center gap-2 bg-white p-2 rounded-3 text-dark">
                    <i class="ti ti-link text-primary fs-5 ms-1"></i>
                    <input type="text" id="agentReferralLinkInput" class="form-control form-control-sm border-0 font-monospace text-dark bg-transparent" value="{{ $agent->referral_url }}" readonly>
                    <button type="button" class="btn btn-sm btn-primary d-flex align-items-center gap-1 text-nowrap px-3" onclick="copyReferralLink()">
                        <i class="ti ti-copy"></i> <span id="copyBtnText">{{ __('লিংক কপি') }}</span>
                    </button>
                    <a href="https://api.whatsapp.com/send?text={{ urlencode('দেশীয় সেরা ই-কমার্স প্ল্যাটফর্ম edokanpro-তে আপনার অনলাইন শপ তৈরি করুন মাত্র ৫ মিনিটে: ' . $agent->referral_url) }}" target="_blank" class="btn btn-sm btn-success d-flex align-items-center gap-1" title="হোয়াটসঅ্যাপে শেয়ার">
                        <i class="ti ti-brand-whatsapp"></i>
                    </a>
                </div>
            </div>

            <!-- Rank Progress Card -->
            <div class="col-lg-5">
                <div class="bg-white bg-opacity-10 p-3 rounded-3 border border-white border-opacity-10 text-white">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="text-xs text-uppercase font-weight-bold opacity-75">পার্টনার লেভেল অগ্রগতি</span>
                        <span class="badge bg-warning text-dark font-weight-bold text-xs">{{ $rank['progress_percent'] }}% সম্পন্ন</span>
                    </div>
                    <h5 class="mb-2 text-white">{{ $rank['badge'] }} {{ $rank['name'] }}</h5>
                    <div class="progress mb-2" style="height: 8px; background: rgba(255,255,255,0.2);">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $rank['progress_percent'] }}%"></div>
                    </div>
                    @if($rank['next_target'])
                        <small class="text-white-50 text-xs">পরবর্তী লেভেলে পৌঁছাতে আর মাত্র <strong>{{ $rank['target_remaining'] }}</strong> টি পেইড সাবস্ক্রিপশন প্রয়োজন।</small>
                    @else
                        <small class="text-warning text-xs">🎉 অভিনন্দন! আপনি সর্বোচ্চ 'লিজেন্ড এলিট' র‍্যাংকে অবস্থান করছেন।</small>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 4 Key Financial & Activity Metric Cards -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-sm-6">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted text-sm font-weight-bold">{{ __('উত্তোলনযোগ্য ব্যালেন্স') }}</span>
                    <div class="rounded-circle bg-warning bg-opacity-10 text-warning p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="ti ti-wallet fs-4"></i>
                    </div>
                </div>
                <h3 class="mb-1 font-weight-bold text-dark">৳{{ number_format($pendingBalance, 2) }}</h3>
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <small class="text-muted text-xs">মিনিমাম উইথড্র: ৳৫০০</small>
                    @if($pendingBalance >= 500)
                        <a href="{{ route('agent.wallet') }}" class="btn btn-xs btn-outline-warning font-weight-bold">
                            <i class="ti ti-cash me-1"></i> {{ __('উত্তোলন করুন') }}
                        </a>
                    @else
                        <span class="badge bg-light text-muted text-xs">উত্তোলনে আর ৳{{ number_format(max(0, 500 - $pendingBalance), 2) }} বাকি</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted text-sm font-weight-bold">{{ __('পেইড সাবস্ক্রিপশন') }}</span>
                    <div class="rounded-circle bg-success bg-opacity-10 text-success p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="ti ti-check fs-4"></i>
                    </div>
                </div>
                <h3 class="mb-1 font-weight-bold text-success">{{ $totalPaidOrders }} <small class="text-sm font-weight-normal text-muted">টি কনভার্সন</small></h3>
                <small class="text-muted text-xs">সফল পেইড মার্চেন্টদের থেকে প্রাপ্ত</small>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted text-sm font-weight-bold">{{ __('মোট অর্জিত কমিশন') }}</span>
                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="ti ti-coins fs-4"></i>
                    </div>
                </div>
                <h3 class="mb-1 font-weight-bold text-primary">৳{{ number_format($totalEarnings, 2) }}</h3>
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <small class="text-muted text-xs">পরিশোধিত: ৳{{ number_format($paidEarnings, 2) }}</small>
                    @if($inProcessing > 0)
                        <span class="badge bg-info text-white text-xs">প্রসেসিং: ৳{{ number_format($inProcessing, 2) }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted text-sm font-weight-bold">{{ __('মোট রেফারেল স্টোর') }}</span>
                    <div class="rounded-circle bg-info bg-opacity-10 text-info p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="ti ti-building-store fs-4"></i>
                    </div>
                </div>
                <h3 class="mb-1 font-weight-bold text-dark">{{ $totalMerchants }} <small class="text-sm font-weight-normal text-muted">টি দোকান</small></h3>
                <small class="text-muted text-xs">আপনার লিংকের মাধ্যমে সাইনআপ করেছে</small>
            </div>
        </div>
    </div>
</div>

<!-- Active Targets & Challenges Section -->
@if($targets->count() > 0)
<div class="row mb-4">
    <div class="col-12">
        <div class="card stat-card border-0">
            <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h5 class="mb-0 font-weight-bold d-flex align-items-center gap-2">
                    <i class="ti ti-target text-danger fs-4"></i> {{ __('সচল টার্গেট ও নগদ ক্যাশ বোনাস চ্যালেঞ্জ') }}
                </h5>
                <span class="badge bg-light-danger text-danger text-xs font-weight-bold">টার্গেট পূরণ করলেই এককালীন বোনাস</span>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @foreach($targets as $target)
                        @php
                            $prog = $target->progress;
                        @endphp
                        <div class="col-md-6 col-lg-4">
                            <div class="p-3 border rounded-3 bg-light {{ $prog['completed'] ? 'border-success bg-light-success' : '' }}">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="mb-0 font-weight-bold">{{ $target->title }}</h6>
                                    <span class="badge bg-success font-weight-bold text-xs">+৳{{ number_format($target->bonus_amount, 2) }} বোনাস</span>
                                </div>
                                <p class="text-muted text-xs mb-2">
                                    টার্গেট: <strong>{{ $target->target_count }}টি</strong> পেইড সাবস্ক্রিপশন ({{ $target->period_type == 'weekly' ? 'এই সপ্তাহে' : ($target->period_type == 'monthly' ? 'এই মাসে' : 'ক্যাম্পেইনে') }})
                                </p>
                                <div class="progress mb-2" style="height: 7px;">
                                    <div class="progress-bar {{ $prog['completed'] ? 'bg-success' : 'bg-primary' }}" style="width: {{ $prog['percent'] }}%"></div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center text-xs">
                                    <span class="text-muted">অর্জিত: <strong>{{ $prog['achieved'] }}</strong> / {{ $prog['target'] }}</span>
                                    @if($prog['completed'])
                                        <span class="text-success font-weight-bold"><i class="ti ti-circle-check"></i> টার্গেট সম্পন্ন!</span>
                                    @else
                                        <span class="text-primary font-weight-bold">{{ $prog['percent'] }}%</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Quick Mini CRM Section & Quick Shortcuts -->
<div class="row g-3 mb-4">
    <!-- Lead Pipeline Snapshot -->
    <div class="col-lg-7">
        <div class="card stat-card h-100">
            <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h5 class="mb-0 font-weight-bold d-flex align-items-center gap-2">
                    <i class="ti ti-users text-info fs-4"></i> {{ __('আপনার লিড পাইপলাইন (Mini CRM)') }}
                </h5>
                <a href="{{ route('agent.leads') }}" class="btn btn-sm btn-outline-info">
                    {{ __('সকল লিড দেখুন') }} <i class="ti ti-arrow-right"></i>
                </a>
            </div>
            <div class="card-body">
                <div class="row g-2 mb-3 text-center">
                    <div class="col-3">
                        <div class="p-2 border rounded-2 bg-light">
                            <span class="text-muted text-xs d-block">{{ __('নতুন লিড') }}</span>
                            <span class="fs-5 font-weight-bold text-dark">{{ $leadCounts['new'] }}</span>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="p-2 border rounded-2 bg-light">
                            <span class="text-muted text-xs d-block">{{ __('যোগাযোগকৃত') }}</span>
                            <span class="fs-5 font-weight-bold text-primary">{{ $leadCounts['contacted'] }}</span>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="p-2 border rounded-2 bg-light">
                            <span class="text-muted text-xs d-block">{{ __('ট্রায়াল স্টার্ট') }}</span>
                            <span class="fs-5 font-weight-bold text-warning">{{ $leadCounts['trial_started'] }}</span>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="p-2 border rounded-2 bg-light">
                            <span class="text-muted text-xs d-block">{{ __('কনভার্টেড 🎉') }}</span>
                            <span class="fs-5 font-weight-bold text-success">{{ $leadCounts['converted'] }}</span>
                        </div>
                    </div>
                </div>

                <div class="p-3 bg-light rounded-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1 font-weight-bold">{{ __('নতুন কোনো ফেসবুক পেজ বা শপ পেয়েছেন?') }}</h6>
                        <small class="text-muted">{{ __('লিড হিসেবে সেভ করে রাখুন এবং ১-ক্লিকে হোয়াটসঅ্যাপে মেসেজ পাঠিয়ে সেলস ক্লোজ করুন।') }}</small>
                    </div>
                    <a href="{{ route('agent.leads') }}" class="btn btn-primary btn-sm text-nowrap">
                        <i class="ti ti-plus"></i> {{ __('লিড যোগ করুন') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Ready Resources & Playbook Shortcuts -->
    <div class="col-lg-5">
        <div class="card stat-card h-100">
            <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h5 class="mb-0 font-weight-bold d-flex align-items-center gap-2">
                    <i class="ti ti-bolt text-warning fs-4"></i> {{ __('রেডিমেড মার্কেটিং স্ক্রিপ্ট') }}
                </h5>
                <a href="{{ route('agent.resources') }}" class="btn btn-sm btn-outline-primary">
                    {{ __('টুলকিট দেখুন') }}
                </a>
            </div>
            <div class="card-body">
                <p class="text-muted text-sm mb-3">
                    ফেসবুক ইনবক্সে পেজ ওনারদের কী মেসেজ পাঠাবেন, আপত্তি কীভাবে হ্যান্ডেল করবেন তার রেডিমেড কপি স্ক্রিপ্ট:
                </p>
                <div class="d-flex flex-column gap-2">
                    <a href="{{ route('agent.resources') }}#inbox-tab" class="p-2 border rounded-2 d-flex justify-content-between align-items-center text-decoration-none text-dark bg-light hover-shadow">
                        <div class="d-flex align-items-center gap-2">
                            <i class="ti ti-message-dots text-primary fs-5"></i>
                            <span class="font-weight-bold text-sm">{{ __('ফেসবুক ইনবক্স পিচ স্ক্রিপ্ট') }}</span>
                        </div>
                        <span class="badge bg-light-primary text-primary text-xs">৮৫% রিপ্লাই রেট</span>
                    </a>
                    <a href="{{ route('agent.resources') }}#comment-tab" class="p-2 border rounded-2 d-flex justify-content-between align-items-center text-decoration-none text-dark bg-light hover-shadow">
                        <div class="d-flex align-items-center gap-2">
                            <i class="ti ti-messages text-info fs-5"></i>
                            <span class="font-weight-bold text-sm">{{ __('গ্রুপ ও কমেন্ট ফর্মুলা') }}</span>
                        </div>
                        <span class="badge bg-light-info text-info text-xs">ফ্রি ট্রাফিকের জন্য</span>
                    </a>
                    <a href="{{ route('agent.resources') }}#objection-tab" class="p-2 border rounded-2 d-flex justify-content-between align-items-center text-decoration-none text-dark bg-light hover-shadow">
                        <div class="d-flex align-items-center gap-2">
                            <i class="ti ti-shield-check text-success fs-5"></i>
                            <span class="font-weight-bold text-sm">{{ __('কাস্টমার আপত্তি হ্যান্ডলিং (Objection FAQ)') }}</span>
                        </div>
                        <span class="badge bg-light-success text-success text-xs">সেলস ক্লোজিং</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Commission Earnings Table -->
<div class="row">
    <div class="col-12">
        <div class="card stat-card">
            <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h5 class="mb-0 font-weight-bold">{{ __('সর্বশেষ কমিশন ও বোনাস হিস্ট্রি') }}</h5>
                <a href="{{ route('agent.wallet') }}" class="btn btn-sm btn-outline-secondary">
                    {{ __('পুরো স্টেটমেন্ট') }}
                </a>
            </div>
            <div class="card-body table-border-style p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>{{ __('তারিখ') }}</th>
                                <th>{{ __('মার্চেন্ট / বর্ণনা') }}</th>
                                <th>{{ __('প্ল্যানের নাম ও মূল্য') }}</th>
                                <th>{{ __('কমিশন রেট') }}</th>
                                <th>{{ __('অর্জিত আয়') }}</th>
                                <th>{{ __('স্ট্যাটাস') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentCommissions as $comm)
                            <tr>
                                <td><small class="text-muted">{{ $comm->created_at->format('d M, Y') }}</small></td>
                                <td>
                                    <strong>{{ $comm->user ? $comm->user->name : ($comm->plan_name) }}</strong>
                                    @if($comm->user)
                                        <br><small class="text-muted">{{ $comm->user->email ?? $comm->user->mobile }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-light-dark text-dark">{{ $comm->plan_name }}</span>
                                    @if($comm->plan_price > 0)
                                        <small class="text-muted ms-1">(৳{{ number_format($comm->plan_price, 2) }})</small>
                                    @endif
                                </td>
                                <td>
                                    @if($comm->commission_rate > 0)
                                        {{ $comm->commission_rate }}{{ $agent->commission_type == 'percentage' ? '%' : ' ৳' }}
                                    @else
                                        <span class="badge bg-light-success text-success">বোনাস</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="font-weight-bold text-success fs-6">
                                        +৳{{ number_format($comm->commission_amount + $comm->bonus_amount, 2) }}
                                    </span>
                                </td>
                                <td>
                                    @if($comm->status == 'paid')
                                        <span class="badge bg-success">{{ __('পরিশোধিত') }}</span>
                                    @elseif($comm->status == 'pending')
                                        <span class="badge bg-warning text-dark">{{ __('ওয়ালেটে জমা') }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $comm->status }}</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="ti ti-receipt-off fs-2 d-block mb-1"></i>
                                    {{ __('এখনও কোনো কমিশন রেকর্ড হয়নি। আপনার রেফারেল লিংক শেয়ার করে প্রথম মার্চেন্ট যুক্ত করুন!') }}
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('custom-script')
<script>
function copyReferralLink() {
    var copyText = document.getElementById("agentReferralLinkInput");
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(copyText.value).then(function() {
        var btnText = document.getElementById("copyBtnText");
        btnText.innerText = "কপি হয়েছে!";
        setTimeout(function() {
            btnText.innerText = "লিংক কপি";
        }, 2000);
    });
}
</script>
@endpush

