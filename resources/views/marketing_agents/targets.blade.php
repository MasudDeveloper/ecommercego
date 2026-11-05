@extends('layouts.app')

@section('page-title')
    {{ __('টার্গেট ও বোনাস ক্যাম্পেইন') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('marketing-agents.index') }}">{{ __('Marketing Agents') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Targets & Bonuses') }}</li>
@endsection

@section('action-button')
    <div class="text-end d-flex all-button-box justify-content-md-end justify-content-center gap-2">
        <a href="{{ route('marketing-agents.index') }}" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
            <i class="ti ti-arrow-left"></i> {{ __('এজেন্ট তালিকা') }}
        </a>
        <button type="button" class="btn btn-sm btn-primary d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#createTargetModal">
            <i class="ti ti-plus"></i> {{ __('নতুন টার্গেট বোনাস তৈরি করুন') }}
        </button>
    </div>
@endsection

@section('content')
<!-- Active Target Campaigns Cards -->
<div class="row">
    <div class="col-12 mb-3">
        <h5 class="mb-1">{{ __('চলমান টার্গেট ও ইনসেন্টিভ বোনাসসমূহ') }}</h5>
        <p class="text-muted text-sm">{{ __('এজেন্টরা নির্ধারিত সময়ে লক্ষ্য পূরণ করলে স্বয়ংক্রিয়ভাবে অতিরিক্ত ক্যাশ বোনাস পাবেন।') }}</p>
    </div>

    @forelse($targets as $target)
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100 border-top border-4 border-primary shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span class="badge bg-light-primary text-primary font-weight-bold px-2 py-1">
                        {{ $target->period_label }}
                    </span>
                    <form action="{{ route('marketing-agents.targets.destroy', $target->id) }}" method="POST" onsubmit="return confirm('আপনি কি এই টার্গেটটি মুছে ফেলতে চান?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-xs btn-outline-danger" title="{{ __('মুছুন') }}">
                            <i class="ti ti-trash"></i>
                        </button>
                    </form>
                </div>
                <h5 class="card-title font-weight-bold mb-2">{{ $target->title }}</h5>
                
                <div class="bg-light p-3 rounded mb-3">
                    <div class="row text-center">
                        <div class="col-6 border-end">
                            <span class="text-muted text-xs d-block">{{ __('টার্গেট সাবস্ক্রিপশন') }}</span>
                            <span class="fs-4 font-weight-bold text-dark">{{ $target->target_count }}</span> <small>টি</small>
                        </div>
                        <div class="col-6">
                            <span class="text-muted text-xs d-block">{{ __('ইনসেন্টিভ বোনাস') }}</span>
                            <span class="fs-4 font-weight-bold text-success">৳{{ number_format($target->bonus_amount, 0) }}</span>
                        </div>
                    </div>
                </div>

                <div class="text-muted text-xs d-flex justify-content-between align-items-center">
                    <span><i class="ti ti-calendar"></i> শুরু: {{ $target->start_date ? $target->start_date->format('d M, Y') : 'আজ' }}</span>
                    <span>শেষ: {{ $target->end_date ? $target->end_date->format('d M, Y') : 'চলমান' }}</span>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="ti ti-target-arrow fs-1 text-muted d-block mb-2"></i>
                <h6 class="font-weight-bold">{{ __('বর্তমানে কোনো সক্রিয় টার্গেট ক্যাম্পেইন নেই') }}</h6>
                <p class="text-muted text-sm">{{ __('যেমন: "এক সপ্তাহে ১৫টি সাবস্ক্রিপশন পূরণ করলে অতিরিক্ত ৳২,০০০ বোনাস"') }}</p>
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createTargetModal">
                    <i class="ti ti-plus"></i> {{ __('প্রথম টার্গেট তৈরি করুন') }}
                </button>
            </div>
        </div>
    </div>
    @endforelse
</div>

<!-- Agents Target Progress Leaderboard -->
<div class="row mt-2">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ __('এজেন্টদের টার্গেট অর্জন ও প্রগ্রেস ট্র্যাকার (Leaderboard)') }}</h5>
            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>{{ __('এজেন্টের নাম') }}</th>
                                <th>{{ __('রেফারেল কোড') }}</th>
                                <th>{{ __('সক্রিয় টার্গেট') }}</th>
                                <th style="min-width: 250px;">{{ __('টার্গেট প্রগ্রেস') }}</th>
                                <th>{{ __('অর্জন') }}</th>
                                <th>{{ __('স্ট্যাটাস') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($agents as $agent)
                                @if($targets->isNotEmpty())
                                    @foreach($targets as $target)
                                    @php
                                        $progress = $agent->getTargetProgress($target);
                                    @endphp
                                    <tr>
                                        <td class="font-weight-bold">{{ $agent->name }}</td>
                                        <td><span class="badge bg-light-dark font-monospace">{{ $agent->referral_code }}</span></td>
                                        <td>
                                            <span class="font-weight-bold d-block">{{ $target->title }}</span>
                                            <small class="text-success">বোনাস: ৳{{ number_format($target->bonus_amount, 0) }}</small>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="progress flex-grow-1" style="height: 10px;">
                                                    <div class="progress-bar {{ $progress['completed'] ? 'bg-success' : 'bg-primary' }} progress-bar-striped progress-bar-animated" 
                                                         role="progressbar" 
                                                         style="width: {{ $progress['percent'] }}%;" 
                                                         aria-valuenow="{{ $progress['percent'] }}" 
                                                         aria-valuemin="0" 
                                                         aria-valuemax="100"></div>
                                                </div>
                                                <span class="text-xs font-weight-bold">{{ $progress['percent'] }}%</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="font-weight-bold">{{ $progress['achieved'] }}</span> / {{ $progress['target'] }}
                                        </td>
                                        <td>
                                            @if($progress['completed'])
                                                <span class="badge bg-success"><i class="ti ti-trophy"></i> {{ __('টার্গেট অর্জিত!') }}</span>
                                            @else
                                                <span class="badge bg-light-warning text-dark"><i class="ti ti-clock"></i> {{ __('চলমান') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="font-weight-bold">{{ $agent->name }}</td>
                                        <td><span class="badge bg-light-dark font-monospace">{{ $agent->referral_code }}</span></td>
                                        <td colspan="4" class="text-muted text-sm">{{ __('কোনো সক্রিয় টার্গেট ক্যাম্পেইন নেই।') }}</td>
                                    </tr>
                                @endif
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">{{ __('কোনো এজেন্ট পাওয়া যায়নি।') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Target Modal -->
<div class="modal fade" id="createTargetModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('marketing-agents.targets.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"><i class="ti ti-trophy text-warning me-1"></i> {{ __('নতুন টার্গেট ও বোনাস তৈরি করুন') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">{{ __('টার্গেটের নাম / শিরোনাম') }} <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" placeholder="যেমন: সাপ্তাহিক ব্লাস্ট - ১৫ সাবস্ক্রিপশন" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('টার্গেট সাবস্ক্রিপশন সংখ্যা') }} <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" name="target_count" class="form-control" value="15" min="1" required>
                                <span class="input-group-text">টি</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('ইনসেন্টিভ বোনাস মানি') }} <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">৳</span>
                                <input type="number" name="bonus_amount" class="form-control" value="2000" min="1" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('টার্গেটের সময়কাল (Period)') }} <span class="text-danger">*</span></label>
                        <select name="period_type" class="form-select" id="periodSelect">
                            <option value="weekly" selected>সাপ্তাহিক (প্রতি সোমবার - রবিবার)</option>
                            <option value="monthly">মাসিক (চলতি মাস)</option>
                            <option value="custom">কাস্টম তারিখ অনুযায়ী</option>
                        </select>
                    </div>
                    <div class="row" id="customDateRow" style="display: none;">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('শুরুর তারিখ') }}</label>
                            <input type="date" name="start_date" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('শেষের তারিখ') }}</label>
                            <input type="date" name="end_date" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('বাতিল') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('টার্গেট চালু করুন') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('custom-script')
<script>
document.getElementById('periodSelect').addEventListener('change', function() {
    var dateRow = document.getElementById('customDateRow');
    if (this.value === 'custom') {
        dateRow.style.display = 'flex';
    } else {
        dateRow.style.display = 'none';
    }
});
</script>
@endpush
@endsection

