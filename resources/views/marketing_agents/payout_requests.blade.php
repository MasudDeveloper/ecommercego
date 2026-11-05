@extends('layouts.app')

@section('page-title')
    {{ __('মার্কেটিং এজেন্ট পেআউট রিকোয়েস্ট') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('marketing-agents.index') }}">{{ __('Marketing Agents') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Payout Requests') }}</li>
@endsection

@section('action-button')
    <div class="text-end d-flex all-button-box justify-content-md-end justify-content-center gap-2">
        <a href="{{ route('marketing-agents.index') }}" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
            <i class="ti ti-arrow-left"></i> {{ __('এজেন্ট তালিকা') }}
        </a>
        <a href="{{ route('marketing-agents.commissions') }}" class="btn btn-sm btn-outline-info d-flex align-items-center gap-1">
            <i class="ti ti-receipt"></i> {{ __('কমিশন হিস্ট্রি') }}
        </a>
    </div>
@endsection

@section('content')
<div class="row">
    <!-- Metric Cards -->
    <div class="col-lg-3 col-6">
        <div class="card">
            <div class="card-body">
                <div class="theme-avtar bg-warning mb-3">
                    <i class="ti ti-clock"></i>
                </div>
                <p class="text-muted text-sm mb-1">{{ __('অপেক্ষমান (Pending) রিকোয়েস্ট') }}</p>
                <h4 class="mb-0 text-warning">{{ $counts['pending'] }} <small class="text-xs">টি</small></h4>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="card">
            <div class="card-body">
                <div class="theme-avtar bg-success mb-3">
                    <i class="ti ti-check"></i>
                </div>
                <p class="text-muted text-sm mb-1">{{ __('পরিশোধিত (Approved)') }}</p>
                <h4 class="mb-0 text-success">{{ $counts['approved'] }} <small class="text-xs">টি</small></h4>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="card">
            <div class="card-body">
                <div class="theme-avtar bg-danger mb-3">
                    <i class="ti ti-x"></i>
                </div>
                <p class="text-muted text-sm mb-1">{{ __('বাতিলকৃত (Rejected)') }}</p>
                <h4 class="mb-0 text-danger">{{ $counts['rejected'] }} <small class="text-xs">টি</small></h4>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="card">
            <div class="card-body">
                <div class="theme-avtar bg-primary mb-3">
                    <i class="ti ti-wallet"></i>
                </div>
                <p class="text-muted text-sm mb-1">{{ __('মোট পেআউট আবেদন') }}</p>
                <h4 class="mb-0">{{ $counts['all'] }} <small class="text-xs">টি</small></h4>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="mb-0">{{ __('এজেন্ট উইথড্রয়াল রিকোয়েস্ট তালিকা (মিনিমাম ৳৫০০)') }}</h5>
                <div class="btn-group btn-group-sm">
                    <a href="{{ route('marketing-agents.payout-requests') }}" class="btn btn-outline-primary {{ !request('status') ? 'active' : '' }}">সকল</a>
                    <a href="{{ route('marketing-agents.payout-requests', ['status' => 'pending']) }}" class="btn btn-outline-warning {{ request('status') == 'pending' ? 'active' : '' }}">পেন্ডিং ({{ $counts['pending'] }})</a>
                    <a href="{{ route('marketing-agents.payout-requests', ['status' => 'approved']) }}" class="btn btn-outline-success {{ request('status') == 'approved' ? 'active' : '' }}">পরিশোধিত</a>
                    <a href="{{ route('marketing-agents.payout-requests', ['status' => 'rejected']) }}" class="btn btn-outline-danger {{ request('status') == 'rejected' ? 'active' : '' }}">বাতিলকৃত</a>
                </div>
            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>{{ __('এজেন্টের নাম ও ফোন') }}</th>
                                <th>{{ __('টাকার পরিমাণ') }}</th>
                                <th>{{ __('পেমেন্ট মেথড') }}</th>
                                <th>{{ __('অ্যাকাউন্ট নম্বর / বিবরণ') }}</th>
                                <th>{{ __('আবেদনের তারিখ') }}</th>
                                <th>{{ __('স্ট্যাটাস') }}</th>
                                <th>{{ __('ট্রানজেকশন আইডি') }}</th>
                                <th class="text-end">{{ __('অ্যাকশন') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($payoutRequests as $req)
                            <tr>
                                <td class="font-monospace">#{{ $req->id }}</td>
                                <td>
                                    <strong>{{ $req->agent->name ?? 'N/A' }}</strong>
                                    <br><small class="text-muted"><i class="ti ti-phone"></i> {{ $req->agent->phone ?? '' }}</small>
                                </td>
                                <td>
                                    <span class="fs-6 font-weight-bold text-dark">৳{{ number_format($req->amount, 2) }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-light-primary text-primary px-2 py-1">{{ $req->payment_method }}</span>
                                </td>
                                <td class="font-monospace">
                                    {{ $req->account_details }}
                                    @if($req->agent_notes)
                                        <br><small class="text-muted"><i class="ti ti-notes"></i> {{ $req->agent_notes }}</small>
                                    @endif
                                </td>
                                <td>
                                    <small>{{ $req->created_at->format('d M, Y h:i A') }}</small>
                                </td>
                                <td>
                                    @if($req->status == 'pending')
                                        <span class="badge bg-warning text-dark">{{ __('পেন্ডিং') }}</span>
                                    @elseif($req->status == 'approved')
                                        <span class="badge bg-success">{{ __('পরিশোধিত') }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ __('বাতিলকৃত') }}</span>
                                    @endif
                                </td>
                                <td class="font-monospace">
                                    {{ $req->transaction_id ?? '-' }}
                                    @if($req->admin_note)
                                        <br><small class="text-muted">{{ $req->admin_note }}</small>
                                    @endif
                                </td>
                                <td class="text-end">
                                    @if($req->status == 'pending')
                                        <div class="d-inline-flex gap-1">
                                            <button type="button" class="btn btn-sm btn-success d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#approveModal{{ $req->id }}">
                                                <i class="ti ti-check"></i> {{ __('পরিশোধ করুন') }}
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $req->id }}" title="{{ __('বাতিল করুন') }}">
                                                <i class="ti ti-x"></i>
                                            </button>
                                        </div>

                                        <!-- Approve Modal -->
                                        <div class="modal fade" id="approveModal{{ $req->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content text-start">
                                                    <form action="{{ route('marketing-agents.payout-requests.approve', $req->id) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">{{ __('পেআউট অনুমোদন ও পরিশোধ - ৳') }}{{ number_format($req->amount, 2) }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="alert alert-light-primary mb-3">
                                                                <div><strong>এজেন্ট:</strong> {{ $req->agent->name }} ({{ $req->agent->phone }})</div>
                                                                <div><strong>মাধ্যম:</strong> {{ $req->payment_method }} - {{ $req->account_details }}</div>
                                                                <div><strong>উত্তোলন অ্যামাউন্ট:</strong> ৳{{ number_format($req->amount, 2) }}</div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ __('ট্রানজেকশন আইডি (TrxID)') }} <span class="text-danger">*</span></label>
                                                                <input type="text" name="transaction_id" class="form-control" placeholder="যেমন: 8N2K91LP3Q" required>
                                                                <small class="text-muted">{{ __('বিকাশ/নগদ/রকেট বা ব্যাংক থেকে টাকা পাঠানোর পর পাওয়া TrxID টি দিন।') }}</small>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ __('অ্যাডমিন নোট (ঐচ্ছিক)') }}</label>
                                                                <input type="text" name="admin_note" class="form-control" placeholder="যেমন: সেন্ট মানি ফি সহ প্রদান করা হয়েছে">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('বাতিল') }}</button>
                                                            <button type="submit" class="btn btn-success">{{ __('পরিশোধ নিশ্চিত করুন') }}</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Reject Modal -->
                                        <div class="modal fade" id="rejectModal{{ $req->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content text-start">
                                                    <form action="{{ route('marketing-agents.payout-requests.reject', $req->id) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">{{ __('পেআউট রিকোয়েস্ট বাতিল') }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="text-muted">{{ __('আপনি কি নিশ্চিত যে এই রিকোয়েস্টটি বাতিল করতে চান? বাতিলকৃত টাকা এজেন্টের ওয়ালেটে ফেরত যুক্ত হবে।') }}</p>
                                                            <div class="mb-3">
                                                                <label class="form-label">{{ __('বাতিল করার কারণ') }} <span class="text-danger">*</span></label>
                                                                <textarea name="admin_note" class="form-control" rows="3" placeholder="যেমন: বিকাশ অ্যাকাউন্ট নম্বরটি ভুল বা বন্ধ ছিল।" required></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('ফিরে যান') }}</button>
                                                            <button type="submit" class="btn btn-danger">{{ __('বাতিল করুন') }}</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted text-xs">{{ __('সম্পন্ন') }}</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="ti ti-wallet-off fs-1 d-block mb-2 text-gray-400"></i>
                                        <p class="mb-0 font-weight-bold">{{ __('কোনো পেআউট রিকোয়েস্ট পাওয়া যায়নি') }}</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $payoutRequests->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
