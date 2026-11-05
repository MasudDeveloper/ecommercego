@extends('layouts.app')

@section('page-title')
    {{ __('মার্কেটিং এজেন্ট ও এফিলিয়েট কমিশন') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Marketing Agents') }}</li>
@endsection

@section('action-button')
    <div class="text-end d-flex all-button-box justify-content-md-end justify-content-center gap-2">
        <a href="{{ route('marketing-agents.targets') }}" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1">
            <i class="ti ti-target"></i> {{ __('টার্গেট ও বোনাস') }}
        </a>
        <a href="{{ route('marketing-agents.commissions') }}" class="btn btn-sm btn-outline-info d-flex align-items-center gap-1">
            <i class="ti ti-receipt"></i> {{ __('কমিশন হিস্ট্রি') }}
        </a>
        <button type="button" class="btn btn-sm btn-primary d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#createAgentModal">
            <i class="ti ti-plus"></i> {{ __('নতুন এজেন্ট যোগ করুন') }}
        </button>
    </div>
@endsection

@section('content')
<div class="row">
    <!-- Quick Metric Cards -->
    <div class="col-lg-3 col-6">
        <div class="card">
            <div class="card-body">
                <div class="theme-avtar bg-primary mb-3">
                    <i class="ti ti-users"></i>
                </div>
                <p class="text-muted text-sm mb-1">{{ __('মোট এজেন্ট') }}</p>
                <h4 class="mb-0">{{ $totalAgents }} <small class="text-muted text-xs">জন</small></h4>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="card">
            <div class="card-body">
                <div class="theme-avtar bg-info mb-3">
                    <i class="ti ti-building-store"></i>
                </div>
                <p class="text-muted text-sm mb-1">{{ __('রেফারকৃত মার্চেন্ট') }}</p>
                <h4 class="mb-0">{{ $totalReferredUsers }} <small class="text-muted text-xs">টি স্টোর</small></h4>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="card">
            <div class="card-body">
                <div class="theme-avtar bg-warning mb-3">
                    <i class="ti ti-clock"></i>
                </div>
                <p class="text-muted text-sm mb-1">{{ __('বকেয়া কমিশন (Pending)') }}</p>
                <h4 class="mb-0 text-warning">৳{{ number_format($pendingPayout, 2) }}</h4>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="card">
            <div class="card-body">
                <div class="theme-avtar bg-success mb-3">
                    <i class="ti ti-check"></i>
                </div>
                <p class="text-muted text-sm mb-1">{{ __('পরিশোধিত কমিশন (Paid)') }}</p>
                <h4 class="mb-0 text-success">৳{{ number_format($totalPaidOut, 2) }}</h4>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ __('সকল মার্কেটিং এজেন্টের তালিকা') }}</h5>
                <span class="text-muted text-xs">{{ __('কমিশন রেট ১০% থেকে ২০% এবং সাপ্তাহিক/মাসিক টার্গেট বোনাস ট্র্যাক করুন') }}</span>
            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>{{ __('এজেন্টের নাম ও যোগাযোগ') }}</th>
                                <th>{{ __('রেফারেল কোড ও লিংক') }}</th>
                                <th>{{ __('কমিশন রেট') }}</th>
                                <th>{{ __('রেফারকৃত স্টোর') }}</th>
                                <th>{{ __('পেইড সাবস্ক্রিপশন') }}</th>
                                <th>{{ __('মোট আয়') }}</th>
                                <th>{{ __('বকেয়া ব্যালেন্স') }}</th>
                                <th>{{ __('পেমেন্ট ইনফো') }}</th>
                                <th>{{ __('স্ট্যাটাস') }}</th>
                                <th class="text-end">{{ __('অ্যাকশন') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($agents as $agent)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-2 bg-light-primary text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; font-weight: bold;">
                                            {{ strtoupper(substr($agent->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-0 font-weight-bold">{{ $agent->name }}</h6>
                                            <small class="text-muted"><i class="ti ti-phone"></i> {{ $agent->phone }}</small>
                                            @if($agent->email)
                                                <br><small class="text-muted"><i class="ti ti-mail"></i> {{ $agent->email }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light-dark text-dark font-monospace px-2 py-1 mb-1">{{ $agent->referral_code }}</span>
                                    <br>
                                    <button type="button" class="btn btn-xs btn-outline-secondary copy-link-btn" data-url="{{ $agent->referral_url }}" onclick="copyReferralLink(this)">
                                        <i class="ti ti-copy"></i> <span>{{ __('লিংক কপি') }}</span>
                                    </button>
                                </td>
                                <td>
                                    <span class="badge bg-light-success text-success font-weight-bold" style="font-size: 13px;">
                                        {{ $agent->commission_rate }}{{ $agent->commission_type == 'percentage' ? '%' : ' ৳' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-light-info text-info">{{ $agent->totalReferredCount() }} টি</span>
                                </td>
                                <td>
                                    <span class="badge bg-light-primary text-primary">{{ $agent->totalPaidOrdersCount() }} টি</span>
                                </td>
                                <td>
                                    <span class="font-weight-bold text-dark">৳{{ number_format($agent->totalEarnings(), 2) }}</span>
                                </td>
                                <td>
                                    @if($agent->pendingBalance() > 0)
                                        <span class="badge bg-warning text-dark font-weight-bold">৳{{ number_format($agent->pendingBalance(), 2) }}</span>
                                    @else
                                        <span class="text-muted text-xs">৳০.০০</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="d-block font-weight-bold">{{ $agent->payment_method ?? 'bKash' }}</small>
                                    <small class="text-muted font-monospace">{{ $agent->payout_details ?? $agent->phone }}</small>
                                </td>
                                <td>
                                    @if($agent->is_active)
                                        <span class="badge bg-success">{{ __('সক্রিয়') }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ __('নিষ্ক্রিয়') }}</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-1">
                                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editAgentModal{{ $agent->id }}" title="{{ __('এডিট') }}">
                                            <i class="ti ti-pencil"></i>
                                        </button>
                                        <form method="POST" action="{{ route('marketing-agents.destroy', $agent->id) }}" onsubmit="return confirm('আপনি কি এই এজেন্টকে মুছে ফেলতে চান?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="{{ __('মুছুন') }}">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <!-- Edit Modal for Agent -->
                            <div class="modal fade" id="editAgentModal{{ $agent->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <form action="{{ route('marketing-agents.update', $agent->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title">{{ __('এজেন্ট তথ্য সম্পাদনা - ') }} {{ $agent->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">{{ __('এজেন্টের নাম') }} <span class="text-danger">*</span></label>
                                                    <input type="text" name="name" class="form-control" value="{{ $agent->name }}" required>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">{{ __('মোবাইল নম্বর') }} <span class="text-danger">*</span></label>
                                                        <input type="text" name="phone" class="form-control" value="{{ $agent->phone }}" required>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">{{ __('ইমেইল (ঐচ্ছিক)') }}</label>
                                                        <input type="email" name="email" class="form-control" value="{{ $agent->email }}">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">{{ __('রেফারেল কোড') }} <span class="text-danger">*</span></label>
                                                        <input type="text" name="referral_code" class="form-control text-uppercase" value="{{ $agent->referral_code }}" required>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">{{ __('কমিশন রেট') }} <span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <input type="number" step="0.5" name="commission_rate" class="form-control" value="{{ $agent->commission_rate }}" required>
                                                            <select name="commission_type" class="form-select" style="max-width: 90px;">
                                                                <option value="percentage" {{ $agent->commission_type == 'percentage' ? 'selected' : '' }}>%</option>
                                                                <option value="fixed" {{ $agent->commission_type == 'fixed' ? 'selected' : '' }}>৳</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">{{ __('পেমেন্ট মেথড') }}</label>
                                                        <select name="payment_method" class="form-select">
                                                            <option value="bKash" {{ $agent->payment_method == 'bKash' ? 'selected' : '' }}>bKash</option>
                                                            <option value="Nagad" {{ $agent->payment_method == 'Nagad' ? 'selected' : '' }}>Nagad</option>
                                                            <option value="Rocket" {{ $agent->payment_method == 'Rocket' ? 'selected' : '' }}>Rocket</option>
                                                            <option value="Bank" {{ $agent->payment_method == 'Bank' ? 'selected' : '' }}>Bank Transfer</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">{{ __('পেমেন্ট অ্যাকাউন্ট/নম্বর') }}</label>
                                                        <input type="text" name="payout_details" class="form-control" value="{{ $agent->payout_details }}">
                                                    </div>
                                                </div>
                                                <div class="form-check form-switch mb-3">
                                                    <input class="form-check-input" type="checkbox" name="is_active" id="activeSwitch{{ $agent->id }}" {{ $agent->is_active ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="activeSwitch{{ $agent->id }}">{{ __('এজেন্ট অ্যাকাউন্ট সক্রিয় রাখুন') }}</label>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">{{ __('নোট') }}</label>
                                                    <textarea name="notes" class="form-control" rows="2">{{ $agent->notes }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('বাতিল') }}</button>
                                                <button type="submit" class="btn btn-primary">{{ __('আপডেট করুন') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="ti ti-users-off fs-1 d-block mb-2 text-gray-400"></i>
                                        <p class="mb-1 font-weight-bold">{{ __('কোনো মার্কেটিং এজেন্ট পাওয়া যায়নি') }}</p>
                                        <small>{{ __('ওপরের "নতুন এজেন্ট যোগ করুন" বাটনে ক্লিক করে প্রথম মার্কেটিং এজেন্ট তৈরি করুন।') }}</small>
                                    </div>
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

<!-- Create Agent Modal -->
<div class="modal fade" id="createAgentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('marketing-agents.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"><i class="ti ti-user-plus text-primary me-1"></i> {{ __('নতুন মার্কেটিং এজেন্ট যুক্ত করুন') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">{{ __('এজেন্টের নাম') }} <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="যেমন: মোঃ রহিম আলী" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('মোবাইল নম্বর') }} <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control" placeholder="017xxxxxxxx" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('ইমেইল (ঐচ্ছিক)') }}</label>
                            <input type="email" name="email" class="form-control" placeholder="agent@gmail.com">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('রেফারেল কোড (ইউনিক)') }}</label>
                            <input type="text" name="referral_code" class="form-control text-uppercase font-monospace" placeholder="যেমন: RAHIM15 (ফাঁকা রাখলে অটো হবে)">
                            <small class="text-muted text-xs">{{ __('লিংক হবে: edokanpro.com/register?ref=CODE') }}</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('কমিশন রেট') }} <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" step="0.5" name="commission_rate" class="form-control" value="15" min="1" max="100" required>
                                <select name="commission_type" class="form-select" style="max-width: 90px;">
                                    <option value="percentage" selected>%</option>
                                    <option value="fixed">৳</option>
                                </select>
                            </div>
                            <small class="text-muted text-xs">{{ __('সাধারণত ১০% থেকে ২০% কমিশন দেওয়া হয়') }}</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('পেমেন্ট নেওয়ার মাধ্যম') }}</label>
                            <select name="payment_method" class="form-select">
                                <option value="bKash" selected>bKash (বিকাশ)</option>
                                <option value="Nagad">Nagad (নগদ)</option>
                                <option value="Rocket">Rocket (রকেট)</option>
                                <option value="Bank">Bank Transfer (ব্যাংক)</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('পেমেন্ট অ্যাকাউন্ট/মোবাইল নম্বর') }}</label>
                            <input type="text" name="payout_details" class="form-control" placeholder="017xxxxxxxx (পার্সোনাল)">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('অতিরিক্ত নোট বা ঠিকানা') }}</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="এজেন্ট সম্পর্কে কোনো তথ্য..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('বাতিল') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('এজেন্ট সংরক্ষণ করুন') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('custom-script')
<script>
function copyReferralLink(btn) {
    var url = btn.getAttribute('data-url');
    navigator.clipboard.writeText(url).then(function() {
        var span = btn.querySelector('span');
        var originalText = span.innerText;
        span.innerText = 'কপি হয়েছে!';
        btn.classList.remove('btn-outline-secondary');
        btn.classList.add('btn-success');
        setTimeout(function() {
            span.innerText = originalText;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-secondary');
        }, 2000);
    });
}
</script>
@endpush
@endsection

