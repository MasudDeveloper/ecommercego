@extends('layouts.app')

@section('page-title')
    {{ __('পেমেন্ট ভেরিফিকেশন চলছে - ') }} {{ $order->order_id }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('plan.index') }}">{{ __('Plan') }}</a></li>
    <li class="breadcrumb-item active">{{ __('পেমেন্ট ভেরিফিকেশন') }}</li>
@endsection

@push('css')
<style>
    .waiting-card {
        background: #ffffff;
        border-radius: 24px;
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.08);
        border: 1px solid #f1f5f9;
        text-align: center;
        padding: 50px 30px;
        max-width: 600px;
        margin: 0 auto;
    }
    .pulse-ring-container {
        position: relative;
        width: 100px;
        height: 100px;
        margin: 0 auto 30px auto;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .pulse-outer-ring {
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: rgba(226, 19, 110, 0.15);
        animation: pulseRadar 2s infinite cubic-bezier(0.4, 0, 0.6, 1);
    }
    .pulse-inner-circle {
        position: relative;
        width: 68px;
        height: 68px;
        border-radius: 50%;
        background: linear-gradient(135deg, #e2136e 0%, #be125a 100%);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        box-shadow: 0 8px 25px rgba(226, 19, 110, 0.4);
    }
    @keyframes pulseRadar {
        0% { transform: scale(0.9); opacity: 0.8; }
        50% { transform: scale(1.4); opacity: 0; }
        100% { transform: scale(0.9); opacity: 0; }
    }
    .order-info-pill {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 14px 20px;
        margin: 25px 0;
        text-align: left;
    }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        
        <div class="waiting-card">
            
            <div class="pulse-ring-container" id="statusIconBox">
                <div class="pulse-outer-ring"></div>
                <div class="pulse-inner-circle">
                    <i class="ti ti-loader-2 ti-spin"></i>
                </div>
            </div>

            <h3 class="font-weight-bold text-dark mb-2" id="statusHeading">অটো-ভেরিফিকেশন চলছে...</h3>
            <p class="text-muted text-sm mb-4" id="statusMessage">
                আপনার দেওয়া ট্রানজেকশন তথ্য মিলিয়ে দেখা হচ্ছে। বিকাশ থেকে নোটিফিকেশন পৌঁছামাত্রই আপনার প্ল্যানটি স্বয়ংক্রিয়ভাবে সক্রিয় হয়ে যাবে।
            </p>

            <div class="order-info-pill">
                <div class="d-flex justify-content-between py-1 border-bottom">
                    <span class="text-muted text-sm">অর্ডার আইডি:</span>
                    <span class="font-weight-bold font-monospace text-dark">{{ $order->order_id }}</span>
                </div>
                <div class="d-flex justify-content-between py-1 border-bottom">
                    <span class="text-muted text-sm">নির্বাচিত প্ল্যান:</span>
                    <span class="font-weight-bold text-primary">{{ $plan->name }}</span>
                </div>
                <div class="d-flex justify-content-between py-1 border-bottom">
                    <span class="text-muted text-sm">টাকার পরিমাণ:</span>
                    <span class="font-weight-bold text-dark">৳{{ number_format($order->price) }}</span>
                </div>
                <div class="d-flex justify-content-between py-1 border-bottom">
                    <span class="text-muted text-sm">প্রেরকের নম্বর:</span>
                    <span class="font-weight-bold font-monospace text-dark">{{ $order->sender_number }}</span>
                </div>
                <div class="d-flex justify-content-between py-1">
                    <span class="text-muted text-sm">ট্রানজেকশন আইডি (TrxID):</span>
                    <span class="font-weight-bold font-monospace" style="color: #be125a;">{{ $order->txn_id }}</span>
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-center gap-2 text-xs text-muted mb-4">
                <span class="spinner-grow spinner-grow-sm text-danger" role="status"></span>
                <span>সার্ভারে লাইভ চেক করা হচ্ছে (প্রতি ৩ সেকেন্ড অন্তর)...</span>
            </div>

            <div class="d-flex justify-content-center gap-2">
                <a href="{{ route('plan.index') }}" class="btn btn-light px-4">
                    <i class="ti ti-arrow-left"></i> প্ল্যান তালিকায় যান
                </a>
            </div>

        </div>

    </div>
</div>
@endsection

@push('custom-script')
<script>
    let pollInterval = setInterval(checkStatus, 3000);

    function checkStatus() {
        fetch("{{ route('plan.check.status', $order->id) }}")
            .then(res => res.json())
            .then(data => {
                if (data.is_success) {
                    clearInterval(pollInterval);
                    
                    document.getElementById('statusIconBox').innerHTML = `
                        <div class="pulse-inner-circle" style="background: #10b981; box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);">
                            <i class="ti ti-circle-check"></i>
                        </div>
                    `;
                    document.getElementById('statusHeading').innerText = '🎉 অভিনন্দন! প্ল্যান সফলভাবে সক্রিয় হয়েছে!';
                    document.getElementById('statusHeading').className = 'font-weight-bold text-success mb-2';
                    document.getElementById('statusMessage').innerText = 'আপনার পেমেন্ট সফল হয়েছে। ড্যাশবোর্ডে রিডাইরেক্ট করা হচ্ছে...';

                    setTimeout(() => {
                        window.location.href = "{{ route('plan.index') }}";
                    }, 2000);
                } else if (data.status === 'rejected') {
                    clearInterval(pollInterval);
                    document.getElementById('statusHeading').innerText = '❌ পেমেন্ট বাতিল হয়েছে';
                    document.getElementById('statusHeading').className = 'font-weight-bold text-danger mb-2';
                    document.getElementById('statusMessage').innerText = 'দুঃখিত, ট্রানজেকশন তথ্য যাচাই করা সম্ভব হয়নি। সহায়তার জন্য সাপোর্টে যোগাযোগ করুন।';
                }
            })
            .catch(err => console.error("Poll check error:", err));
    }
</script>
@endpush
