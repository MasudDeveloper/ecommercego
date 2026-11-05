@extends('agent.layouts.app')

@section('page-title')
    {{ __('এজেন্ট ওয়ালেট ও পেআউট') }}
@endsection

@push('custom-css')
<style>
    .wallet-hero-card {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 60%, #312e81 100%);
        border-radius: 20px;
        padding: 30px;
        color: #ffffff;
        box-shadow: 0 10px 30px rgba(30, 27, 75, 0.25);
        position: relative;
        overflow: hidden;
    }
    .payment-method-radio {
        display: none;
    }
    .payment-method-card {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
        font-weight: 700;
        font-size: 13.5px;
    }
    .payment-method-card:hover {
        border-color: #818cf8;
        background-color: #f8fafc;
    }
    .payment-method-radio:checked + .payment-method-card {
        border-color: #4f46e5;
        background-color: #eef2ff;
        color: #4338ca;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.15);
    }
</style>
@endpush

@section('content')

<!-- Header Section -->
<div class="row align-items-center mb-4 g-3">
    <div class="col-lg-7">
        <h3 class="font-weight-bold text-dark mb-1 d-flex align-items-center gap-2">
            <span class="p-2 rounded-3 bg-warning bg-opacity-10 text-warning d-inline-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                <i class="ti ti-wallet fs-3"></i>
            </span>
            <span>{{ __('আমার ওয়ালেট ও পেআউট ব্যালেন্স') }}</span>
        </h3>
        <p class="text-muted mb-0">আপনার অর্জিত কমিশন ও বোনাস ক্যাশআউট করুন (সর্বনিম্ন উত্তোলন সীমা: ৳৫০০)</p>
    </div>

    <div class="col-lg-5 text-lg-end">
        @if($pendingBalance >= 500)
            <button type="button" class="btn btn-primary px-4 py-2 rounded-3 font-weight-bold d-inline-flex align-items-center gap-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#requestPayoutModal">
                <i class="ti ti-cash fs-5"></i>
                <span>{{ __('টাকা উত্তোলন রিকোয়েস্ট করুন') }}</span>
            </button>
        @else
            <button type="button" class="btn btn-secondary px-4 py-2 rounded-3 font-weight-bold d-inline-flex align-items-center gap-2" disabled title="উত্তোলন করতে সর্বনিম্ন ৳৫০০ ব্যালেন্স প্রয়োজন">
                <i class="ti ti-lock fs-5"></i>
                <span>{{ __('উত্তোলনে ন্যূনতম ৳৫০০ প্রয়োজন') }}</span>
            </button>
        @endif
    </div>
</div>

<!-- ============================================== -->
<!-- 4 FINTECH KPI CARDS                            -->
<!-- ============================================== -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-sm-6">
        <div class="card stat-card h-100 p-3 border-top border-4 border-warning">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-muted text-sm font-weight-bold">{{ __('উত্তোলনযোগ্য ব্যালেন্স') }}</span>
                <div class="icon-badge bg-warning bg-opacity-10 text-warning" style="width: 40px; height: 40px; font-size: 20px;">
                    <i class="ti ti-wallet"></i>
                </div>
            </div>
            <h3 class="mb-1 font-weight-bold text-dark" style="font-size: 26px;">৳{{ number_format($pendingBalance, 2) }}</h3>
            <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top">
                <small class="text-muted text-xs">মিনিমাম উইথড্র সীমা: ৳৫০০</small>
                @if($pendingBalance >= 500)
                    <span class="badge bg-success bg-opacity-10 text-success font-weight-bold text-xs">উত্তোলনযোগ্য</span>
                @else
                    <span class="badge bg-light text-muted text-xs">আর ৳{{ number_format(max(0, 500 - $pendingBalance), 2) }} বাকি</span>
                @endif
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="card stat-card h-100 p-3 border-top border-4 border-info">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-muted text-sm font-weight-bold">{{ __('প্রসেসিংয়ে থাকা পেআউট') }}</span>
                <div class="icon-badge bg-info bg-opacity-10 text-info" style="width: 40px; height: 40px; font-size: 20px;">
                    <i class="ti ti-clock"></i>
                </div>
            </div>
            <h3 class="mb-1 font-weight-bold text-info" style="font-size: 26px;">৳{{ number_format($inProcessing, 2) }}</h3>
            <div class="mt-2 pt-2 border-top">
                <small class="text-muted text-xs">অ্যাডমিন ভেরিফিকেশন চলছে</small>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="card stat-card h-100 p-3 border-top border-4 border-success">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-muted text-sm font-weight-bold">{{ __('পরিশোধিত পেআউট (Paid)') }}</span>
                <div class="icon-badge bg-success bg-opacity-10 text-success" style="width: 40px; height: 40px; font-size: 20px;">
                    <i class="ti ti-check"></i>
                </div>
            </div>
            <h3 class="mb-1 font-weight-bold text-success" style="font-size: 26px;">৳{{ number_format($paidEarnings, 2) }}</h3>
            <div class="mt-2 pt-2 border-top">
                <small class="text-muted text-xs">বিকাশ/নগদে সফলভাবে গৃহিত</small>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="card stat-card h-100 p-3 border-top border-4 border-primary">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-muted text-sm font-weight-bold">{{ __('সর্বমোট অর্জিত আয়') }}</span>
                <div class="icon-badge bg-primary bg-opacity-10 text-primary" style="width: 40px; height: 40px; font-size: 20px;">
                    <i class="ti ti-coins"></i>
                </div>
            </div>
            <h3 class="mb-1 font-weight-bold text-primary" style="font-size: 26px;">৳{{ number_format($totalEarnings, 2) }}</h3>
            <div class="mt-2 pt-2 border-top">
                <small class="text-muted text-xs">কমিশন ও সকল টার্গেট বোনাস</small>
            </div>
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- PAYOUT WITHDRAWAL REQUESTS HISTORY             -->
<!-- ============================================== -->
<div class="card stat-card mb-4">
    <div class="card-header bg-white p-4 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h5 class="mb-0 font-weight-bold text-dark d-flex align-items-center gap-2">
                <i class="ti ti-history text-secondary fs-4"></i> {{ __('উইথড্রয়াল রিকোয়েস্টের ইতিহাস') }}
            </h5>
            <small class="text-muted">আপনার করা উত্তোলন আবেদন ও পেমেন্ট স্ট্যাটাস</small>
        </div>
        @if($pendingBalance >= 500)
            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 font-weight-bold" data-bs-toggle="modal" data-bs-target="#requestPayoutModal">
                <i class="ti ti-plus"></i> {{ __('নতুন রিকোয়েস্ট') }}
            </button>
        @endif
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">#ID</th>
                        <th>{{ __('আবেদনের তারিখ') }}</th>
                        <th>{{ __('উত্তোলন অ্যামাউন্ট') }}</th>
                        <th>{{ __('পেমেন্ট মাধ্যম') }}</th>
                        <th>{{ __('অ্যাকাউন্ট নম্বর') }}</th>
                        <th>{{ __('স্ট্যাটাস') }}</th>
                        <th class="pe-4">{{ __('ট্রানজেকশন আইডি (TrxID) / নোট') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payoutRequests as $req)
                    <tr>
                        <td class="ps-4 font-monospace text-muted font-weight-bold">#{{ $req->id }}</td>
                        <td><small class="text-dark">{{ $req->created_at->format('d M, Y h:i A') }}</small></td>
                        <td>
                            <strong class="fs-6 text-dark font-weight-bold">৳{{ number_format($req->amount, 2) }}</strong>
                        </td>
                        <td>
                            <span class="badge bg-light-primary text-primary font-weight-bold px-2 py-1">
                                {{ $req->payment_method }}
                            </span>
                        </td>
                        <td class="font-monospace text-dark">{{ $req->account_number }}</td>
                        <td>
                            @php
                                $badge = $req->status_badge;
                            @endphp
                            <span class="badge {{ $badge['class'] }} px-2 py-1 font-weight-bold">
                                {{ $badge['label'] }}
                            </span>
                        </td>
                        <td class="pe-4">
                            @if($req->transaction_id)
                                <span class="badge bg-light-success text-success font-monospace font-weight-bold" style="font-size: 12px;">
                                    TrxID: {{ $req->transaction_id }}
                                </span>
                            @endif
                            @if($req->admin_note)
                                <small class="text-muted d-block mt-1">{{ $req->admin_note }}</small>
                            @endif
                            @if(!$req->transaction_id && !$req->admin_note)
                                <span class="text-muted text-xs">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="ti ti-wallet-off fs-1 d-block mb-2 text-gray-400"></i>
                            <h6 class="font-weight-bold text-dark">{{ __('এখনও কোনো উত্তোলন রিকোয়েস্ট করেননি') }}</h6>
                            <small>ব্যালেন্স ৳৫০০ হলেই আপনি বিকাশ বা নগদে টাকা উত্তোলনের আবেদন করতে পারবেন।</small>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3 border-top">
            {{ $payoutRequests->links() }}
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- COMMISSIONS & BONUSES LEDGER                   -->
<!-- ============================================== -->
<div class="card stat-card">
    <div class="card-header bg-white p-4 border-bottom">
        <h5 class="mb-0 font-weight-bold text-dark d-flex align-items-center gap-2">
            <i class="ti ti-receipt text-secondary fs-4"></i> {{ __('পূর্ণাঙ্গ কমিশন ও বোনাস লেনদেন লেজার') }}
        </h5>
        <small class="text-muted">আপনার অ্যাকাউন্টে জমা হওয়া প্রতিটি অর্ডার ও টার্গেট বোনাসের হিসাব</small>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">{{ __('তারিখ') }}</th>
                        <th>{{ __('উৎস / মার্চেন্ট শপ') }}</th>
                        <th>{{ __('প্ল্যানের নাম ও মূল্য') }}</th>
                        <th>{{ __('কমিশন রেট') }}</th>
                        <th>{{ __('অর্জিত আয়') }}</th>
                        <th class="pe-4">{{ __('পেমেন্ট অবস্থা') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($commissions as $comm)
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
                        <td class="pe-4">
                            @if($comm->status == 'paid')
                                <span class="badge bg-success font-weight-bold">{{ __('পরিশোধিত') }}</span>
                            @elseif($comm->status == 'pending')
                                <span class="badge bg-warning text-dark font-weight-bold">{{ __('ওয়ালেটে জমা') }}</span>
                            @else
                                <span class="badge bg-secondary font-weight-bold">{{ $comm->status }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="ti ti-receipt-off fs-1 d-block mb-2 text-gray-400"></i>
                            <h6>{{ __('এখনও কোনো কমিশন লেনদেন পাওয়া যায়নি') }}</h6>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3 border-top">
            {{ $commissions->links() }}
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- REQUEST PAYOUT MODAL (MIN 500 BDT)             -->
<!-- ============================================== -->
<div class="modal fade" id="requestPayoutModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <form action="{{ route('agent.wallet.request') }}" method="POST">
                @csrf
                <div class="modal-header border-bottom p-4">
                    <h5 class="modal-title font-weight-bold text-dark d-flex align-items-center gap-2">
                        <span class="p-2 rounded-3 bg-warning bg-opacity-10 text-warning d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                            <i class="ti ti-cash"></i>
                        </span>
                        <span>{{ __('টাকা উত্তোলন রিকোয়েস্ট') }}</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Balance Summary Badge -->
                    <div class="p-3 rounded-3 mb-4 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%); border: 1px solid #c7d2fe;">
                        <div>
                            <span class="text-xs text-muted font-weight-bold text-uppercase d-block">বর্তমান উত্তোলনযোগ্য ব্যালেন্স</span>
                            <h4 class="mb-0 text-primary font-weight-bold">৳{{ number_format($pendingBalance, 2) }}</h4>
                        </div>
                        <span class="badge bg-success bg-opacity-10 text-success font-weight-bold px-3 py-1 rounded-pill">
                            মিনিমাম সীমা: ৳৫০০
                        </span>
                    </div>

                    <!-- Amount Input -->
                    <div class="mb-3">
                        <label class="form-label font-weight-bold text-dark">{{ __('উত্তোলন করার পরিমাণ (টাকা)') }} <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light font-weight-bold">৳</span>
                            <input type="number" step="10" min="500" max="{{ $pendingBalance }}" name="amount" class="form-control font-weight-bold fs-5" value="{{ max(500, min($pendingBalance, 500)) }}" required>
                        </div>
                        <small class="text-muted">সর্বনিম্ন ৫০০ এবং সর্বোচ্চ ৳{{ number_format($pendingBalance, 2) }}</small>
                    </div>

                    <!-- Payment Method Select Cards -->
                    <div class="mb-3">
                        <label class="form-label font-weight-bold text-dark">{{ __('পেমেন্ট নেওয়ার মাধ্যম') }} <span class="text-danger">*</span></label>
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="radio" name="payment_method" value="bKash" id="pm_bkash" class="payment-method-radio" {{ ($agent->payment_method ?? '') == 'bKash' ? 'checked' : '' }} required>
                                <label for="pm_bkash" class="payment-method-card d-block">
                                    <span style="color: #e2136e;">●</span> bKash (বিকাশ)
                                </label>
                            </div>
                            <div class="col-6">
                                <input type="radio" name="payment_method" value="Nagad" id="pm_nagad" class="payment-method-radio" {{ ($agent->payment_method ?? '') == 'Nagad' ? 'checked' : '' }}>
                                <label for="pm_nagad" class="payment-method-card d-block">
                                    <span style="color: #f7941d;">●</span> Nagad (নগদ)
                                </label>
                            </div>
                            <div class="col-6">
                                <input type="radio" name="payment_method" value="Rocket" id="pm_rocket" class="payment-method-radio" {{ ($agent->payment_method ?? '') == 'Rocket' ? 'checked' : '' }}>
                                <label for="pm_rocket" class="payment-method-card d-block">
                                    <span style="color: #8c1d8c;">●</span> Rocket (রকেট)
                                </label>
                            </div>
                            <div class="col-6">
                                <input type="radio" name="payment_method" value="Bank" id="pm_bank" class="payment-method-radio" {{ ($agent->payment_method ?? '') == 'Bank' ? 'checked' : '' }}>
                                <label for="pm_bank" class="payment-method-card d-block">
                                    <span style="color: #0284c7;">●</span> ব্যাংক ট্রান্সফার
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Account Details -->
                    <div class="mb-3">
                        <label class="form-label font-weight-bold text-dark">{{ __('অ্যাকাউন্ট / মোবাইল নম্বর') }} <span class="text-danger">*</span></label>
                        <input type="text" name="account_details" class="form-control font-monospace" value="{{ $agent->payout_details ?? $agent->phone }}" placeholder="017xxxxxxxx (পার্সোনাল)" required>
                    </div>

                    <!-- Note -->
                    <div class="mb-3">
                        <label class="form-label">{{ __('নোট (ঐচ্ছিক)') }}</label>
                        <input type="text" name="notes" class="form-control" placeholder="যেমন: জরুরি প্রসেস করার অনুরোধ / কোনো বিশেষ তথ্য থাকলে লিখুন">
                    </div>
                </div>
                <div class="modal-footer border-top p-3">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('বাতিল') }}</button>
                    <button type="submit" class="btn btn-primary font-weight-bold px-4">{{ __('রিকোয়েস্ট সাবমিট করুন') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
