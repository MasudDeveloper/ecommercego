@extends('layouts.app')

@section('page-title')
    {{ __('ড্রপ-আউট কার্ট ও ১-ক্লিক হোয়াটসঅ্যাপ রিকভারি') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active">{{ __('অ্যাব্যান্ডনড কার্ট (ড্রপ-আউট)') }}</li>
@endsection

@section('content')
<div class="row">
    <!-- Metric Cards -->
    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-0 shadow-sm rounded-4 bg-white p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted text-xs font-weight-bold d-block mb-1">মোট ড্রপ-আউট লিড (অসমাপ্ত অর্ডার)</span>
                    <h3 class="font-weight-bold text-danger mb-0">{{ number_format($totalAbandoned) }} টি</h3>
                    <small class="text-muted text-xs">যারা নাম-নম্বর লিখে অর্ডার সম্পন্ন করেনি</small>
                </div>
                <div class="p-3 rounded-4" style="background: #fee2e2; color: #dc2626;">
                    <i class="ti ti-shopping-cart-x fs-2"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-0 shadow-sm rounded-4 bg-white p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted text-xs font-weight-bold d-block mb-1">সফলভাবে রিকভার্ড অর্ডার</span>
                    <h3 class="font-weight-bold text-success mb-0">{{ number_format($totalRecovered) }} টি</h3>
                    <small class="text-muted text-xs">WhatsApp ফলো-আপের মাধ্যমে সফল সেলস</small>
                </div>
                <div class="p-3 rounded-4" style="background: #dcfce7; color: #16a34a;">
                    <i class="ti ti-circle-check fs-2"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Table -->
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-bottom p-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h5 class="font-weight-bold text-dark mb-1">ড্রপ-আউট কাস্টমার তালিকা (Abandoned Cart Leads)</h5>
                    <p class="text-muted text-xs mb-0">১ ক্লিকে হোয়াটসঅ্যাপে আকর্ষণীয় অফার বা ডিসকাউন্ট দিয়ে সেলস কনভার্ট করুন</p>
                </div>
                <span class="badge bg-light text-dark font-monospace px-3 py-2 border">
                    সর্বমোট {{ $carts->total() }} জন
                </span>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">কাস্টমার নাম</th>
                                <th>মোবাইল নম্বর</th>
                                <th>ঠিকানা</th>
                                <th>পণ্য / পেজ</th>
                                <th>সময়</th>
                                <th>স্ট্যাটাস</th>
                                <th class="text-end pe-4">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($carts as $cart)
                                @php
                                    $rawPhone = preg_replace('/[^0-9]/', '', $cart->customer_phone);
                                    if(strlen($rawPhone) == 11 && str_starts_with($rawPhone, '01')) {
                                        $waPhone = '88' . $rawPhone;
                                    } else {
                                        $waPhone = $rawPhone;
                                    }
                                    $defaultMsg = "আসসালামু আলাইকুম " . ($cart->customer_name ?: 'ভাইয়া/আপু') . "! আমাদের শপে আপনার অর্ডারটি পেন্ডিং রয়েছে। আপনি কি অর্ডারটি কনফার্ম করতে চান? আজই কনফার্ম করলে পাচ্ছেন ফ্রি হোম ডেলিভারি!";
                                    $waUrl = "https://api.whatsapp.com/send?phone=" . $waPhone . "&text=" . urlencode($defaultMsg);
                                @endphp
                                <tr>
                                    <td class="ps-4">
                                        <div class="font-weight-bold text-dark">{{ $cart->customer_name ?: 'নাম নেই' }}</div>
                                        <small class="text-muted text-xs">IP: {{ $cart->ip_address ?: 'Unknown' }}</small>
                                    </td>
                                    <td>
                                        <a href="tel:{{ $cart->customer_phone }}" class="font-monospace text-primary font-weight-bold text-decoration-none">
                                            <i class="ti ti-phone"></i> {{ $cart->customer_phone }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="text-xs text-muted" style="max-width: 200px; display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            {{ $cart->customer_address ?: 'ঠিকানা লিখেনি' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border font-weight-bold">{{ $cart->product_name ?: 'ল্যান্ডিং পণ্য' }}</span>
                                    </td>
                                    <td>
                                        <small class="text-muted text-xs">{{ $cart->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td>
                                        @if($cart->status === 'recovered')
                                            <span class="badge bg-success font-weight-bold">
                                                <i class="ti ti-check"></i> রিকভার্ড
                                            </span>
                                        @else
                                            <span class="badge bg-warning text-dark font-weight-bold">
                                                <i class="ti ti-clock"></i> পেন্ডিং
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex align-items-center justify-content-end gap-2">
                                            <!-- WhatsApp 1-Click CTA -->
                                            <a href="{{ $waUrl }}" target="_blank" class="btn btn-sm text-white font-weight-bold d-inline-flex align-items-center gap-1" style="background: #25D366; border-radius: 8px;">
                                                <i class="ti ti-brand-whatsapp fs-5"></i> WhatsApp
                                            </a>

                                            @if($cart->status !== 'recovered')
                                                <!-- Mark as Recovered -->
                                                <form action="{{ route('abandoned-cart.recover', $cart->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-success" title="রিকভার্ড হিসেবে চিহ্নিত করুন" data-bs-toggle="tooltip">
                                                        <i class="ti ti-circle-check"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            <!-- Delete -->
                                            <form action="{{ route('abandoned-cart.destroy', $cart->id) }}" method="POST" class="d-inline" onsubmit="return confirm('আপনি কি নিশ্চিত এই রেকর্ডটি মুছতে চান?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="মুছে ফেলুন" data-bs-toggle="tooltip">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="ti ti-shopping-cart-off fs-1 d-block mb-2 text-secondary"></i>
                                        <h6 class="font-weight-bold text-dark mb-1">কোনো ড্রপ-আউট কার্ট পাওয়া যায়নি</h6>
                                        <p class="text-xs mb-0">ল্যান্ডিং পেজে কেউ ফোন নম্বর লিখে বের হয়ে গেলে স্বয়ংক্রিয়ভাবে এখানে তালিকা তৈরি হবে।</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($carts->hasPages())
                    <div class="p-3 border-top d-flex justify-content-end">
                        {{ $carts->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

