@extends('layouts.app')

@section('page-title')
    {{ __('প্ল্যান পেমেন্ট ও বিকাশ ভেরিফিকেশন রিকোয়েস্ট') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('plan.index') }}">{{ __('Plan') }}</a></li>
    <li class="breadcrumb-item active">{{ __('পেমেন্ট রিকোয়েস্ট ও SMS লগ') }}</li>
@endsection

@section('content')
<div class="row">
    
    <!-- Top Configuration Card -->
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-3 rounded-3" style="background: #fff0f5; color: #e2136e;">
                            <i class="ti ti-brand-android fs-2"></i>
                        </div>
                        <div>
                            <h5 class="font-weight-bold mb-1 text-dark">মোবাইল অ্যাপ নোটিফিকেশন ভেরিফায়ার কনফিগারেশন</h5>
                            <p class="text-muted text-xs mb-0">Android অ্যাপের মাধ্যমে বিকাশ SMS/নোটিফিকেশন রিড করে স্বয়ংক্রিয়ভাবে প্ল্যান অ্যাক্টিভ করার সেটিংস</p>
                        </div>
                    </div>
                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill font-weight-bold">
                        <i class="ti ti-circle-check"></i> সিস্টেম সচল
                    </span>
                </div>

                <form action="{{ route('admin.plan.payment.settings') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-5">
                            <label class="form-label font-weight-bold text-dark text-sm">বিকাশ পার্সোনাল নম্বর (Send Money Receiver)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="ti ti-phone"></i></span>
                                <input type="text" name="bkash_personal_number" class="form-control font-monospace font-weight-bold" value="{{ $bkashNumber }}" placeholder="01899112233" required>
                            </div>
                            <small class="text-muted text-xs">এই নম্বরে মার্চেন্টরা সাবস্ক্রিপশন ফি সেন্ড মানি করবেন।</small>
                        </div>

                        <div class="col-md-5">
                            <label class="form-label font-weight-bold text-dark text-sm">Android অ্যাপ সিক্রেট টোকেন (API Secret Key)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="ti ti-key"></i></span>
                                <input type="text" name="sms_verifier_token" class="form-control font-monospace" value="{{ $verifierToken }}" required>
                            </div>
                            <small class="text-muted text-xs">আপনার ফোনে ইনস্টলকৃত Android অ্যাপের সেটিংসে হুবহু এই টোকেনটি দিবেন।</small>
                        </div>

                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100 font-weight-bold py-2">
                                <i class="ti ti-device-floppy"></i> সেভ করুন
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Payment Requests Table -->
    <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-bottom p-4 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="font-weight-bold text-dark mb-1">মার্চেন্টদের পেমেন্ট রিকোয়েস্ট তালিকা</h5>
                    <p class="text-muted text-xs mb-0">অটো-ভেরিফাইড ও অপেক্ষমান সকল বিকাশ সেন্ড মানি রিকোয়েস্ট</p>
                </div>
                <span class="badge bg-light text-dark font-monospace px-3 py-2 border">মোট {{ $orders->total() }} টি অর্ডার</span>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">অর্ডার আইডি</th>
                                <th>মার্চেন্ট</th>
                                <th>প্ল্যানের নাম</th>
                                <th>টাকার পরিমাণ</th>
                                <th>প্রেরকের নম্বর</th>
                                <th>TrxID</th>
                                <th>স্ট্যাটাস</th>
                                <th>ভেরিফিকেশন মাধ্যম</th>
                                <th class="text-end pe-4">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $ord)
                                <tr>
                                    <td class="ps-4 font-monospace font-weight-bold text-dark">{{ $ord->order_id }}</td>
                                    <td>
                                        <div class="font-weight-bold text-dark">{{ $ord->name ?? ($ord->user->name ?? 'N/A') }}</div>
                                        <small class="text-muted text-xs">{{ $ord->email ?? ($ord->user->email ?? '') }}</small>
                                    </td>
                                    <td><span class="badge bg-primary text-white font-weight-bold px-3 py-2 rounded-pill">{{ $ord->plan_name }}</span></td>
                                    <td class="font-weight-bold text-dark">৳{{ number_format($ord->price) }}</td>
                                    <td class="font-monospace text-secondary">{{ $ord->sender_number ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge font-monospace px-2 py-1" style="background: #fff0f5; color: #be125a; border: 1px solid #fbcfe8;">
                                            {{ $ord->txn_id }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($ord->payment_status === 'success')
                                            <span class="badge bg-success font-weight-bold"><i class="ti ti-check"></i> সফল (Active)</span>
                                        @elseif($ord->payment_status === 'pending')
                                            <span class="badge bg-warning text-dark font-weight-bold"><i class="ti ti-clock"></i> অপেক্ষমান (Pending)</span>
                                        @else
                                            <span class="badge bg-danger font-weight-bold"><i class="ti ti-x"></i> বাতিল</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($ord->verified_by === 'android_app')
                                            <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25">
                                                <i class="ti ti-brand-android"></i> Android অটো-ভেরিফাইড
                                            </span>
                                        @elseif($ord->verified_by === 'super_admin_manual')
                                            <span class="badge bg-secondary">
                                                <i class="ti ti-user-check"></i> অ্যাডমিন ম্যানুয়াল
                                            </span>
                                        @else
                                            <span class="text-muted text-xs">যাচাইয়ের অপেক্ষায়</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        @if($ord->payment_status === 'pending')
                                            <div class="d-inline-flex gap-1">
                                                <form action="{{ route('admin.plan.order.approve', $ord->id) }}" method="POST" onsubmit="return confirm('আপনি কি এই পেমেন্ট অনুমোদন করে প্ল্যান সক্রিয় করতে চান?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success font-weight-bold">
                                                        <i class="ti ti-check"></i> অনুমোদন
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.plan.order.reject', $ord->id) }}" method="POST" onsubmit="return confirm('আপনি কি এই পেমেন্ট বাতিল করতে চান?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="ti ti-x"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-muted text-xs">সম্পন্ন</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-5 text-muted">কোনো বিকাশ পেমেন্ট রিকোয়েস্ট পাওয়া যায়নি।</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-3 border-top d-flex justify-content-end">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Live Android Intercepted SMS Logs -->
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-bottom p-4 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="font-weight-bold text-dark mb-1">Android অ্যাপ দ্বারা রিসিভকৃত নোটিফিকেশন লগ (Live SMS Feed)</h5>
                    <p class="text-muted text-xs mb-0">আপনার মোবাইল থেকে ইন্টারসেপ্ট হয়ে আসা সাম্প্রতিক ২০টি বিকাশ নোটিফিকেশন</p>
                </div>
                <span class="badge bg-primary px-3 py-1.5 font-weight-bold">লাইভ সিঙ্ক চালু</span>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-sm">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">সময়</th>
                                <th>গেটওয়ে</th>
                                <th>টাকার পরিমাণ</th>
                                <th>TrxID</th>
                                <th>প্রেরক নম্বর</th>
                                <th>স্ট্যাটাস</th>
                                <th>র নোটিফিকেশন টেক্সট</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($smsLogs as $log)
                                <tr>
                                    <td class="ps-4 font-monospace text-muted text-xs">{{ $log->created_at->format('d M, Y h:i A') }}</td>
                                    <td><span class="badge bg-danger text-uppercase">{{ $log->gateway }}</span></td>
                                    <td class="font-weight-bold text-success">৳{{ number_format($log->amount, 2) }}</td>
                                    <td class="font-monospace font-weight-bold text-dark">{{ $log->trx_id }}</td>
                                    <td class="font-monospace text-secondary">{{ $log->sender_number }}</td>
                                    <td>
                                        @if($log->status === 'matched')
                                            <span class="badge bg-success"><i class="ti ti-check"></i> অর্ডার ম্যাচ হয়েছে</span>
                                        @else
                                            <span class="badge bg-secondary">দাবির অপেক্ষায় (Unmatched)</span>
                                        @endif
                                    </td>
                                    <td><small class="text-muted font-monospace text-xs" style="max-width: 320px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $log->raw_notification }}</small></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">এখনও কোনো মোবাইল নোটিফিকেশন রিসিভ হয়নি। Android অ্যাপ চালু করলে এখানে স্বয়ংক্রিয়ভাবে জমা হবে।</td>
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
