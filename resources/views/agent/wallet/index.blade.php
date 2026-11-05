@extends('agent.layouts.app')

@section('page-title')
    {{ __('এজেন্ট ওয়ালেট ও পেআউট') }}
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h3 class="font-weight-bold mb-1 d-flex align-items-center gap-2">
                    <i class="ti ti-wallet text-primary fs-2"></i> {{ __('আমার ওয়ালেট ও পেআউট ব্যালেন্স') }}
                </h3>
                <p class="text-muted mb-0">আপনার কমিশন ও টার্গেট বোনাস ক্যাশআউট করুন (মিনিমাম উত্তোলন: ৳৫০০)</p>
            </div>
            @if($pendingBalance >= 500)
                <button type="button" class="btn btn-primary d-flex align-items-center gap-1 shadow-sm" data-bs-toggle="modal" data-bs-target="#requestPayoutModal">
                    <i class="ti ti-cash"></i> {{ __('টাকা উত্তোলন রিকোয়েস্ট করুন') }}
                </button>
            @else
                <button type="button" class="btn btn-secondary d-flex align-items-center gap-1" disabled title="উত্তোলন করতে সর্বনিম্ন ৳৫০০ ব্যালেন্স প্রয়োজন">
                    <i class="ti ti-lock"></i> {{ __('উত্তোলনে ন্যূনতম ৳৫০০ প্রয়োজন') }}
                </button>
            @endif
        </div>
    </div>
</div>

<!-- Financial Summary Metric Cards -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-sm-6">
        <div class="card stat-card border-top border-4 border-warning h-100">
            <div class="card-body">
                <span class="text-muted text-sm font-weight-bold d-block mb-1">{{ __('উত্তোলনযোগ্য ব্যালেন্স') }}</span>
                <h3 class="mb-1 font-weight-bold text-warning">৳{{ number_format($pendingBalance, 2) }}</h3>
                <small class="text-muted text-xs">মিনিমাম উত্তোলন সীমা: ৳৫০০.০০</small>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="card stat-card border-top border-4 border-info h-100">
            <div class="card-body">
                <span class="text-muted text-sm font-weight-bold d-block mb-1">{{ __('প্রসেসিংয়ে থাকা রিকোয়েস্ট') }}</span>
                <h3 class="mb-1 font-weight-bold text-info">৳{{ number_format($inProcessing, 2) }}</h3>
                <small class="text-muted text-xs">এডমিন পর্যালোচনায় রয়েছে</small>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="card stat-card border-top border-4 border-success h-100">
            <div class="card-body">
                <span class="text-muted text-sm font-weight-bold d-block mb-1">{{ __('পরিশোধিত পেআউট (Paid)') }}</span>
                <h3 class="mb-1 font-weight-bold text-success">৳{{ number_format($paidEarnings, 2) }}</h3>
                <small class="text-muted text-xs">সরাসরি বিকাশ/নগদে গৃহীত</small>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="card stat-card border-top border-4 border-primary h-100">
            <div class="card-body">
                <span class="text-muted text-sm font-weight-bold d-block mb-1">{{ __('লাইফটাইম মোট আয়') }}</span>
                <h3 class="mb-1 font-weight-bold text-primary">৳{{ number_format($totalEarnings, 2) }}</h3>
                <small class="text-muted text-xs">কমিশন + সকল টার্গেট বোনাস</small>
            </div>
        </div>
    </div>
</div>

<!-- Payout Requests Table -->
<div class="card stat-card mb-4">
    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
        <h5 class="mb-0 font-weight-bold d-flex align-items-center gap-2">
            <i class="ti ti-history text-secondary fs-4"></i> {{ __('উইথড্রয়াল রিকোয়েস্টের ইতিহাস') }}
        </h5>
        @if($pendingBalance >= 500)
            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#requestPayoutModal">
                <i class="ti ti-plus"></i> {{ __('নতুন রিকোয়েস্ট') }}
            </button>
        @endif
    </div>
    <div class="card-body table-border-style p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>#ID</th>
                        <th>{{ __('আবেদনের তারিখ') }}</th>
                        <th>{{ __('উত্তোলন অ্যামাউন্ট') }}</th>
                        <th>{{ __('পেমেন্ট মাধ্যম') }}</th>
                        <th>{{ __('অ্যাকাউন্ট নম্বর') }}</th>
                        <th>{{ __('স্ট্যাটাস') }}</th>
                        <th>{{ __('ট্রানজেকশন আইডি (TrxID) / নোট') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payoutRequests as $req)
                    <tr>
                        <td class="font-monospace">#{{ $req->id }}</td>
                        <td><small>{{ $req->created_at->format('d M, Y h:i A') }}</small></td>
                        <td>
                            <strong class="fs-6 text-dark">৳{{ number_format($req->amount, 2) }}</strong>
                        </td>
                        <td>
                            <span class="badge bg-light-primary text-primary">{{ $req->payment_method }}</span>
                        </td>
                        <td class="font-monospace">{{ $req->account_number }}</td>
                        <td>
                            @php
                                $badge = $req->status_badge;
                            @endphp
                            <span class="badge {{ $badge['class'] }} px-2 py-1">
                                {{ $badge['label'] }}
                            </span>
                        </td>
                        <td>
                            @if($req->transaction_id)
                                <span class="font-monospace font-weight-bold text-success">{{ $req->transaction_id }}</span>
                            @endif
                            @if($req->admin_note)
                                <small class="text-muted d-block">{{ $req->admin_note }}</small>
                            @endif
                            @if(!$req->transaction_id && !$req->admin_note)
                                <span class="text-muted text-xs">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            {{ __('এখনও কোনো উইথড্রয়াল রিকোয়েস্ট করা হয়নি।') }}
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">
            {{ $payoutRequests->links() }}
        </div>
    </div>
</div>

<!-- Full Commissions Ledger Table -->
<div class="card stat-card">
    <div class="card-header bg-transparent">
        <h5 class="mb-0 font-weight-bold d-flex align-items-center gap-2">
            <i class="ti ti-receipt text-secondary fs-4"></i> {{ __('কমিশন ও বোনাস ট্রানজেকশন লেজার') }}
        </h5>
    </div>
    <div class="card-body table-border-style p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>{{ __('তারিখ') }}</th>
                        <th>{{ __('উৎস / মার্চেন্ট') }}</th>
                        <th>{{ __('প্ল্যানের নাম ও মূল্য') }}</th>
                        <th>{{ __('কমিশন হার') }}</th>
                        <th>{{ __('অর্জিত আয়') }}</th>
                        <th>{{ __('পেমেন্ট স্ট্যাটাস') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($commissions as $comm)
                    <tr>
                        <td><small>{{ $comm->created_at->format('d M, Y') }}</small></td>
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
                            {{ __('কোনো কমিশন লেনদেন পাওয়া যায়নি।') }}
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">
            {{ $commissions->links() }}
        </div>
    </div>
</div>

<!-- Request Payout Modal (Min 500 BDT) -->
<div class="modal fade" id="requestPayoutModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('agent.wallet.request') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold"><i class="ti ti-wallet text-primary me-1"></i> {{ __('উইথড্রয়াল রিকোয়েস্ট') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-light-primary p-3 mb-3 rounded-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-sm font-weight-bold">উত্তোলনযোগ্য ব্যালেন্স:</span>
                            <span class="fs-5 font-weight-bold text-primary">৳{{ number_format($pendingBalance, 2) }}</span>
                        </div>
                        <small class="text-muted d-block mt-1">সর্বনিম্ন উত্তোলন সীমা <strong>৳৫০০</strong> টাকা। ২৪ ঘণ্টার মধ্যে পেমেন্ট প্রসেস করা হবে।</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold">{{ __('উত্তোলন করার পরিমাণ (টাকা)') }} <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">৳</span>
                            <input type="number" step="10" min="500" max="{{ $pendingBalance }}" name="amount" class="form-control" value="{{ max(500, min($pendingBalance, 500)) }}" required>
                        </div>
                        <small class="text-muted">সর্বনিম্ন ৫০০ এবং সর্বোচ্চ ৳{{ number_format($pendingBalance, 2) }}</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold">{{ __('পেমেন্ট নেওয়ার মাধ্যম') }} <span class="text-danger">*</span></label>
                            <select name="payment_method" class="form-select">
                                <option value="bKash" {{ ($agent->payment_method ?? '') == 'bKash' ? 'selected' : '' }}>bKash (বিকাশ পার্সোনাল)</option>
                                <option value="Nagad" {{ ($agent->payment_method ?? '') == 'Nagad' ? 'selected' : '' }}>Nagad (নগদ পার্সোনাল)</option>
                                <option value="Rocket" {{ ($agent->payment_method ?? '') == 'Rocket' ? 'selected' : '' }}>Rocket (রকেট)</option>
                                <option value="Bank" {{ ($agent->payment_method ?? '') == 'Bank' ? 'selected' : '' }}>Bank Transfer (ব্যাংক)</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold">{{ __('অ্যাকাউন্ট / মোবাইল নম্বর') }} <span class="text-danger">*</span></label>
                            <input type="text" name="account_details" class="form-control" value="{{ $agent->payout_details ?? $agent->phone }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('অতিরিক্ত নোট (ঐচ্ছিক)') }}</label>
                        <input type="text" name="notes" class="form-control" placeholder="যেমন: পার্সোনাল বিকাশ নম্বর">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('বাতিল') }}</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">{{ __('রিকোয়েস্ট সাবমিট করুন') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

