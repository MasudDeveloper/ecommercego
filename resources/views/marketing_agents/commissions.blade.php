@extends('layouts.app')

@section('page-title')
    {{ __('কমিশন ও পেআউট লেজার') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('marketing-agents.index') }}">{{ __('Marketing Agents') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Commissions & Payouts') }}</li>
@endsection

@section('action-button')
    <div class="text-end d-flex all-button-box justify-content-md-end justify-content-center gap-2">
        <a href="{{ route('marketing-agents.index') }}" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
            <i class="ti ti-arrow-left"></i> {{ __('এজেন্ট তালিকা') }}
        </a>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                <h5 class="mb-0">{{ __('সকল কমিশন ও টার্গেট বোনাস ট্রানজ্যাকশন') }}</h5>
                
                <!-- Filter Form -->
                <form action="{{ route('marketing-agents.commissions') }}" method="GET" class="d-flex align-items-center gap-2">
                    <select name="agent_id" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">{{ __('সকল এজেন্ট') }}</option>
                        @foreach($agents as $ag)
                            <option value="{{ $ag->id }}" {{ request('agent_id') == $ag->id ? 'selected' : '' }}>{{ $ag->name }} ({{ $ag->referral_code }})</option>
                        @endforeach
                    </select>
                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">{{ __('সকল স্ট্যাটাস') }}</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>বকেয়া (Pending)</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>পরিশোধিত (Paid)</option>
                    </select>
                </form>
            </div>
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>{{ __('তারিখ ও সময়') }}</th>
                                <th>{{ __('এজেন্টের নাম ও কোড') }}</th>
                                <th>{{ __('বিবরণ / প্ল্যান') }}</th>
                                <th>{{ __('প্ল্যানের মূল্য') }}</th>
                                <th>{{ __('কমিশন রেট') }}</th>
                                <th>{{ __('অর্জিত টাকা') }}</th>
                                <th>{{ __('স্ট্যাটাস') }}</th>
                                <th>{{ __('পেমেন্ট বিবরণ') }}</th>
                                <th class="text-end">{{ __('অ্যাকশন') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($commissions as $comm)
                            <tr>
                                <td>
                                    <span class="d-block font-weight-bold">{{ $comm->created_at->format('d M, Y') }}</span>
                                    <small class="text-muted">{{ $comm->created_at->format('h:i A') }}</small>
                                </td>
                                <td>
                                    <span class="font-weight-bold d-block">{{ $comm->agent->name ?? 'N/A' }}</span>
                                    <span class="badge bg-light-dark font-monospace">{{ $comm->agent->referral_code ?? '' }}</span>
                                </td>
                                <td>
                                    @if($comm->bonus_target_id)
                                        <span class="badge bg-light-warning text-dark font-weight-bold"><i class="ti ti-trophy"></i> {{ $comm->plan_name }}</span>
                                    @else
                                        <span class="font-weight-bold d-block">{{ $comm->plan_name ?? 'Subscription' }}</span>
                                        @if($comm->user)
                                            <small class="text-muted">মার্চেন্ট: {{ $comm->user->name }}</small>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if($comm->plan_price > 0)
                                        ৳{{ number_format($comm->plan_price, 2) }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($comm->commission_rate > 0)
                                        <span class="badge bg-light-info text-info">{{ $comm->commission_rate }}%</span>
                                    @else
                                        <span class="badge bg-light-success text-success">{{ __('বোনাস') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="font-weight-bold text-success fs-6">৳{{ number_format($comm->total_amount, 2) }}</span>
                                </td>
                                <td>
                                    @if($comm->status == 'paid')
                                        <span class="badge bg-success"><i class="ti ti-check"></i> {{ __('পরিশোধিত (Paid)') }}</span>
                                    @else
                                        <span class="badge bg-warning text-dark"><i class="ti ti-clock"></i> {{ __('বকেয়া (Pending)') }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($comm->status == 'paid')
                                        <small class="d-block font-weight-bold text-dark">{{ $comm->payout_method }}</small>
                                        <small class="text-muted font-monospace">Trx: {{ $comm->payout_trx_id ?? 'N/A' }}</small>
                                    @else
                                        <small class="text-muted">এজেন্টের {{ $comm->agent->payment_method ?? 'bKash' }}:</small>
                                        <small class="d-block font-weight-bold">{{ $comm->agent->payout_details ?? $comm->agent->phone ?? '-' }}</small>
                                    @endif
                                </td>
                                <td class="text-end">
                                    @if($comm->status == 'pending')
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#payoutModal{{ $comm->id }}">
                                            <i class="ti ti-wallet"></i> {{ __('পে করুন') }}
                                        </button>
                                    @else
                                        <span class="text-success text-xs font-weight-bold"><i class="ti ti-circle-check"></i> সম্পন্ন</span>
                                    @endif
                                </td>
                            </tr>

                            <!-- Payout Modal -->
                            @if($comm->status == 'pending')
                            <div class="modal fade" id="payoutModal{{ $comm->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <form action="{{ route('marketing-agents.payout', $comm->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title"><i class="ti ti-cash text-success me-1"></i> {{ __('কমিশন পরিশোধ করুন (Payout)') }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="bg-light p-3 rounded mb-3">
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span class="text-muted">{{ __('এজেন্ট:') }}</span>
                                                        <span class="font-weight-bold">{{ $comm->agent->name }}</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span class="text-muted">{{ __('প্রদেয় অ্যামাউন্ট:') }}</span>
                                                        <span class="font-weight-bold text-success fs-5">৳{{ number_format($comm->total_amount, 2) }}</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <span class="text-muted">{{ __('পেমেন্ট একাউন্ট:') }}</span>
                                                        <span class="font-weight-bold font-monospace">{{ $comm->agent->payment_method }} - {{ $comm->agent->payout_details ?? $comm->agent->phone }}</span>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">{{ __('পেমেন্ট মেথড') }} <span class="text-danger">*</span></label>
                                                    <select name="payout_method" class="form-select">
                                                        <option value="bKash" {{ ($comm->agent->payment_method ?? '') == 'bKash' ? 'selected' : '' }}>bKash</option>
                                                        <option value="Nagad" {{ ($comm->agent->payment_method ?? '') == 'Nagad' ? 'selected' : '' }}>Nagad</option>
                                                        <option value="Rocket" {{ ($comm->agent->payment_method ?? '') == 'Rocket' ? 'selected' : '' }}>Rocket</option>
                                                        <option value="Bank">Bank Transfer</option>
                                                        <option value="Cash">Cash Hand to Hand</option>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">{{ __('ট্রানজ্যাকশন আইডি (TrxID)') }} <span class="text-danger">*</span></label>
                                                    <input type="text" name="payout_trx_id" class="form-control font-monospace" placeholder="যেমন: BL90X982KS" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">{{ __('নোট (ঐচ্ছিক)') }}</label>
                                                    <textarea name="payout_notes" class="form-control" rows="2" placeholder="পেমেন্ট সংক্রান্ত কোনো বিবরণ..."></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('বাতিল') }}</button>
                                                <button type="submit" class="btn btn-success">{{ __('পেমেন্ট সম্পন্ন হিসেবে চিহ্নিত করুন') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">
                                    <i class="ti ti-receipt-off fs-1 d-block mb-2"></i>
                                    {{ __('এখনও কোনো কমিশন রেকর্ড তৈরি হয়নি।') }}
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($commissions->hasPages())
                <div class="mt-3 px-3">
                    {{ $commissions->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

