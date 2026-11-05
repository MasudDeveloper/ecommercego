@extends('agent.layouts.app')

@section('page-title')
    {{ __('এজেন্ট প্রোফাইল ও সেটিংস') }}
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h3 class="font-weight-bold mb-1 d-flex align-items-center gap-2">
            <i class="ti ti-user-circle text-primary fs-2"></i> {{ __('আমার প্রোফাইল ও অ্যাকাউন্ট সেটিংস') }}
        </h3>
        <p class="text-muted mb-0">আপনার ব্যক্তিগত তথ্য, পেমেন্ট ডিটেইলস এবং পাসওয়ার্ড আপডেট করুন</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card stat-card text-center p-4">
            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3 font-weight-bold" style="width: 80px; height: 80px; font-size: 2rem;">
                {{ strtoupper(substr($agent->name, 0, 1)) }}
            </div>
            <h4 class="font-weight-bold mb-1">{{ $agent->name }}</h4>
            <p class="text-muted text-sm mb-2"><i class="ti ti-phone"></i> {{ $agent->phone }}</p>
            @if($agent->email)
                <p class="text-muted text-sm mb-2"><i class="ti ti-mail"></i> {{ $agent->email }}</p>
            @endif

            <div class="d-flex justify-content-center gap-2 mb-3">
                <span class="rank-pill {{ $agent->rank_details['badge_class'] }}">
                    {{ $agent->rank_details['badge'] }} {{ $agent->rank_details['name'] }}
                </span>
                <span class="badge bg-light-success text-success font-weight-bold py-2 px-3">
                    {{ $agent->commission_rate }}{{ $agent->commission_type == 'percentage' ? '%' : ' ৳' }} কমিশন
                </span>
            </div>

            <div class="copy-box text-start mt-2">
                <label class="text-xs text-muted font-weight-bold text-uppercase d-block mb-1">রেফারেল কোড</label>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="font-monospace font-weight-bold fs-5 text-dark">{{ $agent->referral_code }}</span>
                    <button type="button" class="btn btn-xs btn-outline-secondary" onclick="copyTextToClipboard('{{ $agent->referral_code }}', this)">
                        <i class="ti ti-copy"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card stat-card">
            <div class="card-header bg-transparent">
                <h5 class="mb-0 font-weight-bold">{{ __('প্রোফাইল ও পেমেন্ট তথ্য সম্পাদনা') }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('agent.profile.update') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold">{{ __('পূর্ণ নাম') }} <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $agent->name) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold">{{ __('মোবাইল নম্বর') }} <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $agent->phone) }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold">{{ __('উইথড্রয়াল পেমেন্ট মাধ্যম') }} <span class="text-danger">*</span></label>
                            <select name="payment_method" class="form-select">
                                <option value="bKash" {{ $agent->payment_method == 'bKash' ? 'selected' : '' }}>bKash (বিকাশ পার্সোনাল)</option>
                                <option value="Nagad" {{ $agent->payment_method == 'Nagad' ? 'selected' : '' }}>Nagad (নগদ পার্সোনাল)</option>
                                <option value="Rocket" {{ $agent->payment_method == 'Rocket' ? 'selected' : '' }}>Rocket (রকেট)</option>
                                <option value="Bank" {{ $agent->payment_method == 'Bank' ? 'selected' : '' }}>Bank Transfer (ব্যাংক অ্যাকাউন্ট)</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold">{{ __('পেমেন্ট অ্যাকাউন্ট / মোবাইল নম্বর') }} <span class="text-danger">*</span></label>
                            <input type="text" name="payout_details" class="form-control" value="{{ old('payout_details', $agent->payout_details) }}" required>
                        </div>
                    </div>

                    <hr class="my-4">
                    <h6 class="font-weight-bold mb-3 text-dark"><i class="ti ti-lock me-1"></i> {{ __('লগইন পাসওয়ার্ড পরিবর্তন (ঐচ্ছিক)') }}</h6>

                    <div class="mb-3">
                        <label class="form-label">{{ __('বর্তমান পাসওয়ার্ড') }}</label>
                        <input type="password" name="current_password" class="form-control" placeholder="বর্তমান পাসওয়ার্ড দিন">
                        @error('current_password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('নতুন পাসওয়ার্ড') }}</label>
                            <input type="password" name="new_password" class="form-control" placeholder="মিনিমাম ৬ অক্ষর">
                            @error('new_password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('নতুন পাসওয়ার্ড নিশ্চিত করুন') }}</label>
                            <input type="password" name="new_password_confirmation" class="form-control" placeholder="পুনরায় নতুন পাসওয়ার্ড দিন">
                        </div>
                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary px-4 font-weight-bold">
                            <i class="ti ti-device-floppy me-1"></i> {{ __('পরিবর্তন সংরক্ষণ করুন') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
