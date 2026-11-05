@extends('agent.layouts.app')

@section('page-title')
    {{ __('মার্কেটিং এজেন্ট ড্যাশবোর্ড') }}
@endsection

@section('content')

<!-- ============================================== -->
<!-- HERO CARD: Referral Link & Rank Milestone      -->
<!-- ============================================== -->
<div class="card border-0 mb-4 shadow-sm" style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 60%, #312e81 100%); border-radius: 20px; overflow: hidden; position: relative;">
    <!-- Background glowing decorative circle -->
    <div style="position: absolute; right: -50px; top: -50px; width: 250px; height: 250px; background: radial-gradient(circle, rgba(99, 102, 241, 0.25) 0%, rgba(99, 102, 241, 0) 70%); pointer-events: none;"></div>

    <div class="card-body p-4 p-lg-5 text-white position-relative">
        <div class="row align-items-center g-4">
            <div class="col-xl-7 col-lg-7">
                <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                    <span class="rank-pill {{ $rank['badge_class'] }} shadow-sm">
                        {{ $rank['badge'] }} {{ $rank['name'] }}
                    </span>
                    <span class="badge bg-white text-dark font-monospace px-3 py-1 shadow-sm" style="font-size: 12px; border-radius: 20px;">
                        রেফারেল কোড: <strong>{{ $agent->referral_code }}</strong>
                    </span>
                    <span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-25 px-2 py-1">
                        {{ $agent->commission_rate }}{{ $agent->commission_type == 'percentage' ? '%' : ' ৳' }} কমিশন রেট
                    </span>
                </div>

                <h2 class="text-white font-weight-bold mb-2" style="font-size: 26px;">
                    স্বাগতম, {{ $agent->name }}! 👋
                </h2>
                <p class="text-white-50 text-sm mb-4" style="max-width: 580px; line-height: 1.6;">
                    আপনার ইউনিক এফিলিয়েট লিংক মার্চেন্টদের শেয়ার করুন। প্রতি সফল পেইড সাবস্ক্রিপশনে কমিশন এবং সাপ্তাহিক ও মাসিক টার্গেট পূরণ করে আকর্ষণীয় ক্যাশ বোনাস উপভোগ করুন।
                </p>

                <!-- Modern High-Contrast Referral Box -->
                <div class="p-2 bg-white rounded-3 shadow-lg d-flex align-items-center gap-2 text-dark" style="max-width: 620px;">
                    <div class="p-2 bg-light-primary text-primary rounded-2 d-none d-sm-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="ti ti-link fs-5"></i>
                    </div>
                    <input type="text" id="agentReferralLinkHero" class="form-control border-0 font-monospace text-dark font-weight-bold px-2" value="{{ $agent->referral_url }}" readonly style="font-size: 13.5px; background: transparent;">
                    
                    <button type="button" class="btn btn-primary d-flex align-items-center gap-1 text-nowrap px-3 font-weight-bold shadow-sm" onclick="copyHeroReferralLink(this)">
                        <i class="ti ti-copy"></i> <span>{{ __('লিংক কপি') }}</span>
                    </button>

                    <a href="https://api.whatsapp.com/send?text={{ urlencode("আসসালামু আলাইকুম! দেশীয় সেরা ই-কমার্স প্ল্যাটফর্ম edokanpro-তে মাত্র ৫ মিনিটে আপনার অনলাইন শপ তৈরি করুন: " . $agent->referral_url) }}" target="_blank" class="btn btn-success d-flex align-items-center gap-1 text-nowrap px-3 shadow-sm" title="হোয়াটসঅ্যাপে শেয়ার করুন">
                        <i class="ti ti-brand-whatsapp"></i> <span class="d-none d-md-inline">WhatsApp</span>
                    </a>
                </div>
            </div>

            <!-- Rank Level Milestone Widget -->
            <div class="col-xl-5 col-lg-5">
                <div class="p-4 rounded-4" style="background: rgba(255, 255, 255, 0.08); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.15);">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-xs text-uppercase font-weight-bold text-white-50 letter-spacing-1">পার্টনার লেভেল অগ্রগতি</span>
                        <span class="badge bg-warning text-dark font-weight-bold px-2 py-1" style="font-size: 11px;">
                            {{ $rank['progress_percent'] }}% সম্পন্ন
                        </span>
                    </div>

                    <div class="d-flex align-items-center gap-3 my-2">
                        <div class="fs-1">{{ $rank['badge'] }}</div>
                        <div>
                            <h5 class="mb-0 text-white font-weight-bold">{{ $rank['name'] }}</h5>
                            <small class="text-white-50">মোট সফল কনভার্সন: <strong>{{ $totalPaidOrders }}টি</strong></small>
                        </div>
                    </div>

                    <div class="progress my-3" style="height: 9px; background: rgba(255,255,255,0.15); border-radius: 20px;">
                        <div class="progress-bar bg-warning progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ $rank['progress_percent'] }}%; border-radius: 20px;"></div>
                    </div>

                    @if($rank['next_target'])
                        <div class="d-flex align-items-center gap-2 text-xs text-white-50">
                            <i class="ti ti-info-circle text-warning fs-6"></i>
                            <span>পরবর্তী পদবীতে উন্নীত হতে আর মাত্র <strong>{{ $rank['target_remaining'] }}টি</strong> পেইড মার্চেন্ট প্রয়োজন।</span>
                        </div>
                    @else
                        <div class="text-xs text-warning font-weight-bold">
                            🎉 অসাধারণ! আপনি সর্বোচ্চ 'লিজেন্ড এলিট' র‍্যাংক অর্জন করেছেন।
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- 4 MODERN KPI METRIC CARDS                      -->
<!-- ============================================== -->
<div class="row g-3 mb-4">
    <!-- 1. Available Pending Balance -->
    <div class="col-xl-3 col-sm-6">
        <div class="card stat-card h-100 p-3">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="text-muted text-sm font-weight-bold">{{ __('উত্তোলনযোগ্য ব্যালেন্স') }}</span>
                <div class="icon-badge bg-warning bg-opacity-10 text-warning">
                    <i class="ti ti-wallet"></i>
                </div>
            </div>
            <h3 class="mb-1 font-weight-bold text-dark" style="font-size: 26px;">৳{{ number_format($pendingBalance, 2) }}</h3>
            <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                <small class="text-muted text-xs">মিনিমাম পেআউট: ৳৫০০</small>
                @if($pendingBalance >= 500)
                    <a href="{{ route('agent.wallet') }}" class="btn btn-xs btn-stat-withdraw">
                        <i class="ti ti-cash me-1"></i> {{ __('উত্তোলন করুন') }}
                    </a>
                @else
                    <span class="badge bg-light text-muted text-xs">আর ৳{{ number_format(max(0, 500 - $pendingBalance), 2) }} বাকি</span>
                @endif
            </div>
        </div>
    </div>

    <!-- 2. Paid Conversions -->
    <div class="col-xl-3 col-sm-6">
        <div class="card stat-card h-100 p-3">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="text-muted text-sm font-weight-bold">{{ __('পেইড সাবস্ক্রিপশন') }}</span>
                <div class="icon-badge bg-success bg-opacity-10 text-success">
                    <i class="ti ti-circle-check"></i>
                </div>
            </div>
            <h3 class="mb-1 font-weight-bold text-success" style="font-size: 26px;">{{ $totalPaidOrders }} <small class="text-sm font-weight-normal text-muted">টি শপ</small></h3>
            <div class="mt-3 pt-2 border-top">
                <small class="text-muted text-xs">সফল পেইড মার্চেন্টদের থেকে প্রাপ্ত</small>
            </div>
        </div>
    </div>

    <!-- 3. Total Lifetime Earnings -->
    <div class="col-xl-3 col-sm-6">
        <div class="card stat-card h-100 p-3">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="text-muted text-sm font-weight-bold">{{ __('মোট অর্জিত আয়') }}</span>
                <div class="icon-badge bg-primary bg-opacity-10 text-primary">
                    <i class="ti ti-coins"></i>
                </div>
            </div>
            <h3 class="mb-1 font-weight-bold text-primary" style="font-size: 26px;">৳{{ number_format($totalEarnings, 2) }}</h3>
            <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                <small class="text-muted text-xs">পরিশোধিত: <strong>৳{{ number_format($paidEarnings, 2) }}</strong></small>
                @if($inProcessing > 0)
                    <span class="badge bg-info text-white text-xs">প্রসেসিং: ৳{{ number_format($inProcessing, 2) }}</span>
                @endif
            </div>
        </div>
    </div>

    <!-- 4. Total Referred Stores -->
    <div class="col-xl-3 col-sm-6">
        <div class="card stat-card h-100 p-3">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="text-muted text-sm font-weight-bold">{{ __('মোট রেফারেল স্টোর') }}</span>
                <div class="icon-badge bg-info bg-opacity-10 text-info">
                    <i class="ti ti-building-store"></i>
                </div>
            </div>
            <h3 class="mb-1 font-weight-bold text-dark" style="font-size: 26px;">{{ $totalMerchants }} <small class="text-sm font-weight-normal text-muted">টি দোকান</small></h3>
            <div class="mt-3 pt-2 border-top">
                <small class="text-muted text-xs">আপনার লিংকে রেজিস্ট্রেশন করেছে</small>
            </div>
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- ACTIVE TARGETS & BONUS CHALLENGES              -->
<!-- ============================================== -->
@if($targets->count() > 0)
<div class="row mb-4">
    <div class="col-12">
        <div class="card stat-card p-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="icon-badge bg-danger bg-opacity-10 text-danger" style="width: 38px; height: 38px; font-size: 18px;">
                        <i class="ti ti-target"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold text-dark">{{ __('সচল টার্গেট ও এককালীন নগদ ক্যাশ বোনাস') }}</h5>
                        <small class="text-muted">নির্দিষ্ট সময়ের মধ্যে লক্ষ্য পূরণ করলেই কমিশন ছাড়াও নগদ বোনাস জমা হবে</small>
                    </div>
                </div>
                <span class="badge bg-danger bg-opacity-10 text-danger font-weight-bold px-3 py-1" style="font-size: 12px; border-radius: 20px;">
                    সীমিত সময়ের চ্যালেঞ্জ
                </span>
            </div>

            <div class="row g-3">
                @foreach($targets as $target)
                    @php
                        $prog = $target->progress;
                    @endphp
                    <div class="col-md-6 col-lg-4">
                        <div class="p-3 rounded-3 border {{ $prog['completed'] ? 'border-success bg-light-success bg-opacity-25' : '' }}" style="background: #ffffff; border-color: #e2e8f0 !important; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="mb-0 font-weight-bold text-dark">{{ $target->title }}</h6>
                                <span class="badge font-weight-bold" style="font-size: 11px; background: #dcfce7 !important; color: #166534 !important; border: 1px solid #86efac;">
                                    +৳{{ number_format($target->bonus_amount, 2) }} বোনাস
                                </span>
                            </div>
                            <p class="text-muted text-xs mb-2">
                                লক্ষ্যমাত্রা: <strong>{{ $target->target_count }}টি</strong> পেইড মার্চেন্ট ({{ $target->period_type == 'weekly' ? 'সাপ্তাহিক' : ($target->period_type == 'monthly' ? 'মাসিক' : 'ক্যাম্পেইন') }})
                            </p>
                            <div class="progress mb-2" style="height: 8px; border-radius: 10px;">
                                <div class="progress-bar {{ $prog['completed'] ? 'bg-success' : 'bg-primary' }}" style="width: {{ $prog['percent'] }}%; border-radius: 10px;"></div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center text-xs">
                                <span class="text-muted">অগ্রগতি: <strong>{{ $prog['achieved'] }}</strong> / {{ $prog['target'] }}</span>
                                @if($prog['completed'])
                                    <span class="text-success font-weight-bold"><i class="ti ti-check"></i> টার্গেট সম্পন্ন!</span>
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
@endif

<!-- ============================================== -->
<!-- MINI CRM SNAPSHOT & MARKETING TOOLKIT SHORTCUTS-->
<!-- ============================================== -->
<div class="row g-3 mb-4">
    <!-- Mini CRM Quick Pipeline -->
    <div class="col-lg-7">
        <div class="card stat-card h-100 p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="icon-badge bg-info bg-opacity-10 text-info" style="width: 38px; height: 38px; font-size: 18px;">
                        <i class="ti ti-users"></i>
                    </div>
                    <h5 class="mb-0 font-weight-bold text-dark">{{ __('আপনার লিড পাইপলাইন (Mini CRM)') }}</h5>
                </div>
                <a href="{{ route('agent.leads') }}" class="btn btn-sm btn-outline-info rounded-2 font-weight-bold">
                    {{ __('সকল লিড') }} <i class="ti ti-arrow-right"></i>
                </a>
            </div>

            <!-- Pipeline Counters Grid -->
            <div class="row g-2 mb-3 text-center">
                <div class="col-3">
                    <div class="p-2 border rounded-3 bg-light">
                        <small class="text-muted d-block text-xs">নতুন লিড</small>
                        <h4 class="mb-0 font-weight-bold text-dark mt-1">{{ $leadCounts['new'] }}</h4>
                    </div>
                </div>
                <div class="col-3">
                    <div class="p-2 border rounded-3 bg-light">
                        <small class="text-muted d-block text-xs">যোগাযোগকৃত</small>
                        <h4 class="mb-0 font-weight-bold text-primary mt-1">{{ $leadCounts['contacted'] }}</h4>
                    </div>
                </div>
                <div class="col-3">
                    <div class="p-2 border rounded-3 bg-light">
                        <small class="text-muted d-block text-xs">ট্রায়াল শুরু</small>
                        <h4 class="mb-0 font-weight-bold text-warning mt-1">{{ $leadCounts['trial_started'] }}</h4>
                    </div>
                </div>
                <div class="col-3">
                    <div class="p-2 border rounded-3 bg-light">
                        <small class="text-muted d-block text-xs">কনভার্টেড 🎉</small>
                        <h4 class="mb-0 font-weight-bold text-success mt-1">{{ $leadCounts['converted'] }}</h4>
                    </div>
                </div>
            </div>

            <div class="p-3 rounded-3 bg-light border d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1 font-weight-bold text-dark">{{ __('নতুন মার্চেন্টের খোঁজ পেয়েছেন?') }}</h6>
                    <small class="text-muted">{{ __('লিড হিসেবে সংরক্ষণ করুন এবং ১-ক্লিকে হোয়াটসঅ্যাপে পিচ পাঠিয়ে কনভার্ট করুন।') }}</small>
                </div>
                <a href="{{ route('agent.leads') }}" class="btn btn-primary btn-sm font-weight-bold px-3 text-nowrap rounded-2 shadow-sm">
                    <i class="ti ti-plus"></i> {{ __('লিড যোগ করুন') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Ready Marketing Scripts -->
    <div class="col-lg-5">
        <div class="card stat-card h-100 p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="icon-badge bg-warning bg-opacity-10 text-warning" style="width: 38px; height: 38px; font-size: 18px;">
                        <i class="ti ti-bolt"></i>
                    </div>
                    <h5 class="mb-0 font-weight-bold text-dark">{{ __('রেডিমেড স্ক্রিপ্ট প্লেবুক') }}</h5>
                </div>
                <a href="{{ route('agent.resources') }}" class="btn btn-sm btn-outline-primary rounded-2 font-weight-bold">
                    {{ __('টুলকিট দেখুন') }}
                </a>
            </div>

            <p class="text-muted text-xs mb-3">
                মার্চেন্টদের পাঠানো এবং সোশ্যাল মিডিয়ায় শেয়ারের জন্য প্রমাণিত কনভার্টিং বাংলা স্ক্রিপ্ট:
            </p>

            <div class="d-flex flex-column gap-2">
                <a href="{{ route('agent.resources') }}#inbox-pane" class="p-2 border rounded-2 d-flex justify-content-between align-items-center text-decoration-none text-dark bg-light hover-shadow">
                    <div class="d-flex align-items-center gap-2">
                        <i class="ti ti-message-circle text-primary fs-5"></i>
                        <span class="font-weight-bold text-sm">ইনবক্স পিচ স্ক্রিপ্ট</span>
                    </div>
                    <span class="badge bg-primary bg-opacity-10 text-primary text-xs">৮৫% রিপ্লাই রেট</span>
                </a>

                <a href="{{ route('agent.resources') }}#comment-pane" class="p-2 border rounded-2 d-flex justify-content-between align-items-center text-decoration-none text-dark bg-light hover-shadow">
                    <div class="d-flex align-items-center gap-2">
                        <i class="ti ti-messages text-info fs-5"></i>
                        <span class="font-weight-bold text-sm">গ্রুপ ও কমেন্ট ফর্মুলা</span>
                    </div>
                    <span class="badge bg-info bg-opacity-10 text-info text-xs">অর্গানিক ট্রাফিক</span>
                </a>

                <a href="{{ route('agent.resources') }}#objection-pane" class="p-2 border rounded-2 d-flex justify-content-between align-items-center text-decoration-none text-dark bg-light hover-shadow">
                    <div class="d-flex align-items-center gap-2">
                        <i class="ti ti-shield-check text-success fs-5"></i>
                        <span class="font-weight-bold text-sm">আপত্তি হ্যান্ডলিং (FAQ)</span>
                    </div>
                    <span class="badge bg-success bg-opacity-10 text-success text-xs">সেলস ক্লোজিং</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- RECENT COMMISSIONS & PAYOUT HISTORY TABLE      -->
<!-- ============================================== -->
<div class="row">
    <div class="col-12">
        <div class="card stat-card">
            <div class="card-header bg-transparent d-flex justify-content-between align-items-center p-4 border-bottom">
                <h5 class="mb-0 font-weight-bold text-dark d-flex align-items-center gap-2">
                    <i class="ti ti-receipt text-secondary fs-4"></i> {{ __('সর্বশেষ অর্জিত কমিশন ও বোনাস') }}
                </h5>
                <a href="{{ route('agent.wallet') }}" class="btn btn-sm btn-outline-secondary rounded-2">
                    {{ __('পুরো লেনদেন লেজার') }}
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">{{ __('তারিখ') }}</th>
                                <th>{{ __('উৎস / মার্চেন্ট') }}</th>
                                <th>{{ __('প্ল্যানের বিবরণ') }}</th>
                                <th>{{ __('কমিশন রেট') }}</th>
                                <th>{{ __('অর্জিত আয়') }}</th>
                                <th class="text-end pe-4">{{ __('স্ট্যাটাস') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentCommissions as $comm)
                            <tr>
                                <td class="ps-4"><small class="text-muted">{{ $comm->created_at->format('d M, Y') }}</small></td>
                                <td>
                                    <strong class="text-dark">{{ $comm->user ? $comm->user->name : ($comm->plan_name) }}</strong>
                                    @if($comm->user)
                                        <br><small class="text-muted">{{ $comm->user->email ?? $comm->user->mobile }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $comm->plan_name }}</span>
                                    @if($comm->plan_price > 0)
                                        <small class="text-muted ms-1">(৳{{ number_format($comm->plan_price, 2) }})</small>
                                    @endif
                                </td>
                                <td>
                                    @if($comm->commission_rate > 0)
                                        <span class="badge bg-primary bg-opacity-10 text-primary font-weight-bold">
                                            {{ $comm->commission_rate }}{{ $agent->commission_type == 'percentage' ? '%' : ' ৳' }}
                                        </span>
                                    @else
                                        <span class="badge bg-success bg-opacity-10 text-success font-weight-bold">বোনাস</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="font-weight-bold text-success fs-6">
                                        +৳{{ number_format($comm->commission_amount + $comm->bonus_amount, 2) }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
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
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="ti ti-receipt-off fs-1 d-block mb-2 text-gray-400"></i>
                                    <h6>{{ __('এখনও কোনো কমিশন রেকর্ড তৈরি হয়নি') }}</h6>
                                    <small>{{ __('আপনার রেফারেল লিংক শেয়ার করে মার্চেন্টদের যুক্ত করুন!') }}</small>
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
function copyHeroReferralLink(btn) {
    var copyText = document.getElementById("agentReferralLinkHero");
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(copyText.value).then(function() {
        var span = btn.querySelector('span');
        var originalText = span.innerText;
        span.innerText = "কপি হয়েছে!";
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
@endpush
