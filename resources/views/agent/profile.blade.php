@extends('agent.layouts.app')

@section('page-title')
    {{ __('এজেন্ট প্রোফাইল ও সেটিংস') }}
@endsection

@section('content')

<!-- Header Section -->
<div class="row align-items-center mb-4 g-3">
    <div class="col-12">
        <h3 class="font-weight-bold text-dark mb-1 d-flex align-items-center gap-2">
            <span class="p-2 rounded-3 bg-primary bg-opacity-10 text-primary d-inline-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                <i class="ti ti-user-circle fs-3"></i>
            </span>
            <span>{{ __('আমার প্রোফাইল ও অ্যাকাউন্ট সেটিংস') }}</span>
        </h3>
        <p class="text-muted mb-0">আপনার ব্যক্তিগত তথ্য, পেমেন্ট গ্রহণের ডিটেইলস এবং পাসওয়ার্ড পরিবর্তন করুন</p>
    </div>
</div>

<div class="row g-4">
    <!-- Left Column: Identity & Performance Card -->
    <div class="col-lg-4">
        <div class="card stat-card p-4 text-center">
            <div class="agent-avatar-circle mx-auto mb-3" style="width: 80px; height: 80px; font-size: 32px; border-radius: 20px;">
                {{ strtoupper(substr($agent->name, 0, 1)) }}
            </div>

            <h4 class="font-weight-bold text-dark mb-1">{{ $agent->name }}</h4>
            <p class="text-muted text-sm mb-2"><i class="ti ti-phone text-primary me-1"></i> {{ $agent->phone }}</p>
            @if($agent->email)
                <p class="text-muted text-xs mb-3"><i class="ti ti-mail text-secondary me-1"></i> {{ $agent->email }}</p>
            @endif

            <div class="d-flex justify-content-center gap-2 mb-4 flex-wrap">
                <span class="rank-pill {{ $agent->rank_details['badge_class'] }}">
                    {{ $agent->rank_details['badge'] }} {{ $agent->rank_details['name'] }}
                </span>
                <span class="badge bg-success bg-opacity-10 text-success font-weight-bold py-2 px-3 rounded-pill">
                    {{ $agent->commission_rate }}{{ $agent->commission_type == 'percentage' ? '%' : ' ৳' }} কমিশন
                </span>
            </div>

            <!-- Referral Code Box -->
            <div class="p-3 rounded-3 bg-light border text-start mb-3">
                <small class="text-xs text-muted font-weight-bold text-uppercase d-block mb-1">আপনার ইউনিক রেফারেল কোড</small>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="font-monospace font-weight-bold fs-5 text-dark">{{ $agent->referral_code }}</span>
                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-2" onclick="copyTextToClipboard('{{ $agent->referral_code }}', this)" title="কোড কপি">
                        <i class="ti ti-copy"></i>
                    </button>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="row g-2 text-center pt-2 border-top">
                <div class="col-6">
                    <div class="p-2">
                        <small class="text-muted text-xs d-block">পেইড কনভার্সন</small>
                        <strong class="text-dark fs-5">{{ $agent->totalPaidOrdersCount() }} টি</strong>
                    </div>
                </div>
                <div class="col-6 border-start">
                    <div class="p-2">
                        <small class="text-muted text-xs d-block">লাইফটাইম আয়</small>
                        <strong class="text-success fs-5">৳{{ number_format($agent->totalEarnings(), 2) }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Settings Forms -->
    <div class="col-lg-8">
        <div class="card stat-card p-4">
            <h5 class="font-weight-bold text-dark mb-4 pb-2 border-bottom d-flex align-items-center gap-2">
                <i class="ti ti-settings text-primary"></i>
                <span>{{ __('ব্যক্তিগত ও পেমেন্ট তথ্য আপডেট') }}</span>
            </h5>

            <form action="{{ route('agent.profile.update') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold text-dark">{{ __('পূর্ণ নাম') }} <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $agent->name) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold text-dark">{{ __('মোবাইল নম্বর') }} <span class="text-danger">*</span></label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $agent->phone) }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold text-dark">{{ __('উইথড্রয়াল পেমেন্ট মাধ্যম') }} <span class="text-danger">*</span></label>
                        <select name="payment_method" class="form-select">
                            <option value="bKash" {{ $agent->payment_method == 'bKash' ? 'selected' : '' }}>bKash (বিকাশ পার্সোনাল)</option>
                            <option value="Nagad" {{ $agent->payment_method == 'Nagad' ? 'selected' : '' }}>Nagad (নগদ পার্সোনাল)</option>
                            <option value="Rocket" {{ $agent->payment_method == 'Rocket' ? 'selected' : '' }}>Rocket (রকেট)</option>
                            <option value="Bank" {{ $agent->payment_method == 'Bank' ? 'selected' : '' }}>Bank Transfer (ব্যাংক অ্যাকাউন্ট)</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label font-weight-bold text-dark">{{ __('পেমেন্ট অ্যাকাউন্ট / মোবাইল নম্বর') }} <span class="text-danger">*</span></label>
                        <input type="text" name="payout_details" class="form-control" value="{{ old('payout_details', $agent->payout_details) }}" required>
                    </div>
                </div>

                <hr class="my-4">
                <h6 class="font-weight-bold mb-3 text-dark d-flex align-items-center gap-2">
                    <i class="ti ti-lock text-warning"></i>
                    <span>{{ __('লগইন পাসওয়ার্ড পরিবর্তন (ঐচ্ছিক)') }}</span>
                </h6>

                <div class="mb-3">
                    <label class="form-label text-dark">{{ __('বর্তমান পাসওয়ার্ড') }}</label>
                    <input type="password" name="current_password" class="form-control" placeholder="বর্তমান পাসওয়ার্ড দিন">
                    @error('current_password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-dark">{{ __('নতুন পাসওয়ার্ড') }}</label>
                        <input type="password" name="new_password" class="form-control" placeholder="মিনিমাম ৬ অক্ষর">
                        @error('new_password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-dark">{{ __('নতুন পাসওয়ার্ড নিশ্চিত করুন') }}</label>
                        <input type="password" name="new_password_confirmation" class="form-control" placeholder="পুনরায় নতুন পাসওয়ার্ড দিন">
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary px-4 py-2 font-weight-bold rounded-3 shadow-sm">
                        <i class="ti ti-check me-1"></i> {{ __('পরিবর্তন সংরক্ষণ করুন') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
