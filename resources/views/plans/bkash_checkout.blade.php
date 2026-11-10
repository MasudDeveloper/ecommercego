@extends('layouts.app')

@section('page-title', __('প্ল্যান সাবস্ক্রিপশন পেমেন্ট (bKash / Nagad / Rocket)'))

@push('custom-style')
<style>
    .payment-checkout-card {
        border: 0;
        border-radius: 20px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        background: #ffffff;
    }
    .payment-header-banner {
        background: linear-gradient(135deg, #e2136e 0%, #be125a 100%);
        color: #ffffff;
        padding: 26px 30px;
        position: relative;
        overflow: hidden;
        transition: background 0.3s ease;
    }
    .gateway-tab-btn {
        border-radius: 12px;
        padding: 10px 18px;
        font-weight: 700;
        font-size: 14px;
        border: 2px solid transparent;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .gateway-tab-btn.active-bkash {
        background: #fff0f5;
        border-color: #e2136e;
        color: #be125a;
    }
    .gateway-tab-btn.active-nagad {
        background: #fff7ed;
        border-color: #ea580c;
        color: #c2410c;
    }
    .gateway-tab-btn.active-rocket {
        background: #faf5ff;
        border-color: #9333ea;
        color: #7e22ce;
    }
    .payment-number-box {
        background: #fff5f8;
        border: 2px dashed #f472b6;
        border-radius: 14px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        transition: all 0.3s ease;
    }
    .step-item {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        margin-bottom: 14px;
    }
    .step-badge {
        width: 28px;
        height: 28px;
        background: #e2136e;
        color: #ffffff;
        font-weight: 700;
        font-size: 13px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-top: 2px;
        transition: background 0.3s ease;
    }
    .form-control-payment {
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 15px;
        border: 1.5px solid #cbd5e1;
        transition: all 0.2s ease;
    }
    .form-control-payment:focus {
        border-color: #e2136e;
        box-shadow: 0 0 0 3px rgba(226, 19, 110, 0.15);
    }
    .btn-payment-confirm {
        background: linear-gradient(135deg, #e2136e 0%, #be125a 100%);
        color: #ffffff;
        border: 0;
        border-radius: 12px;
        padding: 14px 24px;
        font-size: 16px;
        font-weight: 700;
        width: 100%;
        transition: all 0.2s ease;
        box-shadow: 0 4px 15px rgba(226, 19, 110, 0.3);
    }
    .btn-payment-confirm:hover {
        opacity: 0.95;
        transform: translateY(-1px);
        color: #ffffff;
    }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-8 col-lg-10">
        
        @if(session('error'))
            <div class="alert alert-danger rounded-3 mb-4 d-flex align-items-center gap-2">
                <i class="ti ti-alert-triangle fs-4"></i>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        <!-- Gateway Selector Bar -->
        <div class="card border-0 shadow-sm rounded-4 mb-3 p-2">
            <div class="d-flex justify-content-center flex-wrap gap-2">
                <button type="button" class="btn gateway-tab-btn active-bkash" id="tabBkash" onclick="selectGateway('bkash')">
                    🌸 বিকাশ (bKash)
                </button>
                <button type="button" class="btn gateway-tab-btn" id="tabNagad" onclick="selectGateway('nagad')">
                    🟠 নগদ (Nagad)
                </button>
                <button type="button" class="btn gateway-tab-btn" id="tabRocket" onclick="selectGateway('rocket')">
                    🟣 রকেট (Rocket)
                </button>
            </div>
        </div>

        <div class="payment-checkout-card">
            
            <!-- Banner Header -->
            <div class="payment-header-banner d-flex justify-content-between align-items-center flex-wrap gap-3" id="paymentHeader">
                <div>
                    <span class="badge bg-white text-dark font-weight-bold px-3 py-1 mb-2" id="headerBadge" style="border-radius: 20px; font-size: 11px;">
                        বিকাশ পার্সোনাল সেন্ড মানি (Send Money)
                    </span>
                    <h3 class="text-white font-weight-bold mb-1">{{ $plan->name }}</h3>
                    <p class="text-white-50 text-sm mb-0" id="headerSubtext">প্ল্যান মেয়াদের জন্য মাত্র এক ক্লিকে সেন্ড মানি করে সক্রিয় করুন</p>
                </div>
                <div class="text-end">
                    <span class="text-white-50 text-xs d-block">প্রদেয় সর্বমোট ফি</span>
                    <h2 class="text-white font-weight-bold mb-0">৳{{ number_format($plan->price) }}</h2>
                    <span class="badge {{ $plan->duration == 'Year' ? 'bg-success text-white' : 'bg-warning text-dark' }} text-xs font-weight-bold">
                        {{ $plan->duration == 'Year' ? 'বাৎসরিক সাবস্ক্রিপশন (১২ মাস)' : ($plan->duration == 'Month' ? 'মাসিক সাবস্ক্রিপশন' : 'সাবস্ক্রিপশন') }}
                    </span>
                </div>
            </div>

            <!-- Body -->
            <div class="p-4 p-md-5">
                <div class="row g-4">
                    
                    <!-- Left: Instructions -->
                    <div class="col-lg-6 border-end-lg pe-lg-4">
                        <h5 class="font-weight-bold text-dark mb-3 d-flex align-items-center gap-2">
                            <i class="ti ti-info-circle text-primary"></i> <span id="instructionTitle">বিকাশ সেন্ড মানি করার নিয়ম:</span>
                        </h5>

                        <!-- Number Box -->
                        <div class="payment-number-box mb-4" id="numberBox">
                            <div>
                                <small class="text-muted d-block text-xs font-weight-bold" id="numberBoxLabel">পার্সোনাল নম্বর (Send Money):</small>
                                <span class="fs-4 font-monospace font-weight-bold" style="color: #be125a;" id="activeNumberText">{{ $bkashNumber }}</span>
                                <small class="text-muted d-block text-xs">অ্যাকাউন্ট টাইপ: পার্সোনাল (Personal)</small>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-danger font-weight-bold px-3 rounded-pill" id="copyNumberBtn" onclick="copyActiveNumber()">
                                <i class="ti ti-copy"></i> কপি করুন
                            </button>
                        </div>

                        <!-- Step by Step -->
                        <div class="step-item">
                            <div class="step-badge" id="step1Badge">১</div>
                            <div class="text-sm text-dark" id="step1Text">
                                আপনার মোবাইলের <strong>bKash App</strong> ওপেন করে অথবা <strong>*247#</strong> ডায়াল করে <strong>Send Money</strong> অপশনে যান।
                            </div>
                        </div>

                        <div class="step-item">
                            <div class="step-badge" id="step2Badge">২</div>
                            <div class="text-sm text-dark">
                                প্রাপক নম্বরে উপরের <strong id="stepNumberSpan">{{ $bkashNumber }}</strong> নম্বরটি দিন।
                            </div>
                        </div>

                        <div class="step-item">
                            <div class="step-badge" id="step3Badge">৩</div>
                            <div class="text-sm text-dark">
                                টাকার পরিমাণে ঠিক <strong>৳{{ number_format($plan->price) }}</strong> দিন এবং রেফারেন্সে আপনার শপের নাম লিখুন।
                            </div>
                        </div>

                        <div class="step-item">
                            <div class="step-badge" id="step4Badge">৪</div>
                            <div class="text-sm text-dark" id="step4Text">
                                পেমেন্ট সম্পন্ন হলে ফিরতি SMS বা অ্যাপের স্টেটমেন্ট থেকে <strong>Transaction ID (TrxID)</strong> কপি করে পাশের ফর্মে বসিয়ে দিন।
                            </div>
                        </div>

                        <div class="p-3 bg-light rounded-3 text-xs text-muted border mt-3">
                            <i class="ti ti-bolt text-warning me-1"></i> <strong>অটো ভেরিফিকেশন:</strong> আপনার পেমেন্ট এসএমএস পৌঁছামাত্রই আমাদের অ্যান্ড্রয়েড ভেরিফায়ার ইঞ্জিন তাৎক্ষণিকভাবে ভেরিফাই করে মাত্র ১০ সেকেন্ডে আপনার প্ল্যান চালু করে দেবে!
                        </div>
                    </div>

                    <!-- Right: Form -->
                    <div class="col-lg-6 ps-lg-4">
                        <h5 class="font-weight-bold text-dark mb-3 d-flex align-items-center gap-2">
                            <i class="ti ti-shield-check" style="color: #be125a;" id="formTitleIcon"></i> ট্রানজেকশন তথ্য সাবমিট করুন:
                        </h5>

                        <form action="{{ route('plan.bkash.submit') }}" method="POST" id="paymentSubmitForm">
                            @csrf
                            <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                            <input type="hidden" name="gateway" id="selectedGateway" value="bkash">

                            <!-- Sender Phone -->
                            <div class="mb-3">
                                <label class="form-label font-weight-bold text-dark" id="senderPhoneLabel">
                                    যে বিকাশ নম্বর থেকে টাকা পাঠিয়েছেন <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="ti ti-phone"></i></span>
                                    <input type="text" name="sender_number" class="form-control form-control-payment" placeholder="017xxxxxxxx" value="{{ old('sender_number', $user->phone ?? '') }}" required>
                                </div>
                                <small class="text-muted text-xs">আপনার ব্যক্তিগত নম্বরটি লিখুন।</small>
                            </div>

                            <!-- TrxID -->
                            <div class="mb-4">
                                <label class="form-label font-weight-bold text-dark" id="trxIdLabel">
                                    ট্রানজেকশন আইডি (Transaction ID / TrxID) <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="ti ti-receipt"></i></span>
                                    <input type="text" name="trx_id" id="trxIdInput" class="form-control form-control-payment font-monospace text-uppercase" placeholder="যেমন: BLA7X8Y9Z" value="{{ old('trx_id') }}" style="letter-spacing: 1px; font-weight: 700;" required>
                                </div>
                                <small class="text-muted text-xs" id="trxHelpText">বিকাশ থেকে প্রাপ্ত ৮-১০ অক্ষরের TrxID কোডটি লিখুন।</small>
                            </div>

                            <button type="submit" class="btn btn-payment-confirm d-flex align-items-center justify-content-center gap-2" id="submitBtn">
                                <i class="ti ti-check"></i>
                                <span>পেমেন্ট নিশ্চিত করুন ও প্ল্যান সক্রিয় করুন</span>
                            </button>

                            <div class="text-center mt-3">
                                <a href="{{ route('plan.index') }}" class="text-muted text-sm text-decoration-none">
                                    <i class="ti ti-arrow-left"></i> অন্য প্ল্যান বেছে নিতে ফিরে যান
                                </a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

        </div>

    </div>
</div>
@endsection

@push('custom-script')
<script>
    const gatewayData = {
        bkash: {
            name: 'বিকাশ (bKash)',
            number: '{{ $bkashNumber }}',
            color: '#be125a',
            gradient: 'linear-gradient(135deg, #e2136e 0%, #be125a 100%)',
            border: '#f472b6',
            bg: '#fff5f8',
            btnClass: 'btn-outline-danger',
            appStep: 'আপনার মোবাইলের <strong>bKash App</strong> ওপেন করে অথবা <strong>*247#</strong> ডায়াল করে <strong>Send Money</strong> অপশনে যান।',
            trxHelp: 'বিকাশ SMS থেকে প্রাপ্ত ৮-১০ অক্ষরের TrxID কোডটি লিখুন।'
        },
        nagad: {
            name: 'নগদ (Nagad)',
            number: '{{ $nagadNumber }}',
            color: '#ea580c',
            gradient: 'linear-gradient(135deg, #f97316 0%, #c2410c 100%)',
            border: '#fdba74',
            bg: '#fff7ed',
            btnClass: 'btn-outline-warning',
            appStep: 'আপনার মোবাইলের <strong>Nagad App</strong> ওপেন করে অথবা <strong>*167#</strong> ডায়াল করে <strong>Send Money</strong> অপশনে যান।',
            trxHelp: 'নগদ SMS থেকে প্রাপ্ত ৮ অক্ষরের TxnID কোডটি লিখুন।'
        },
        rocket: {
            name: 'রকেট (Rocket)',
            number: '{{ $rocketNumber }}',
            color: '#7e22ce',
            gradient: 'linear-gradient(135deg, #a855f7 0%, #6b21a8 100%)',
            border: '#d8b4fe',
            bg: '#faf5ff',
            btnClass: 'btn-outline-primary',
            appStep: 'আপনার মোবাইলের <strong>Rocket App</strong> ওপেন করে অথবা <strong>*322#</strong> ডায়াল করে <strong>Send Money</strong> অপশনে যান।',
            trxHelp: 'রকেট SMS থেকে প্রাপ্ত Transaction ID কোডটি লিখুন।'
        }
    };

    function selectGateway(gw) {
        document.getElementById('selectedGateway').value = gw;
        const data = gatewayData[gw];

        // Update tabs active state
        document.getElementById('tabBkash').className = 'btn gateway-tab-btn' + (gw === 'bkash' ? ' active-bkash' : '');
        document.getElementById('tabNagad').className = 'btn gateway-tab-btn' + (gw === 'nagad' ? ' active-nagad' : '');
        document.getElementById('tabRocket').className = 'btn gateway-tab-btn' + (gw === 'rocket' ? ' active-rocket' : '');

        // Update header banner
        document.getElementById('paymentHeader').style.background = data.gradient;
        document.getElementById('headerBadge').innerText = data.name + ' পার্সোনাল সেন্ড মানি (Send Money)';
        document.getElementById('instructionTitle').innerText = data.name + ' সেন্ড মানি করার নিয়ম:';

        // Update number box
        const numBox = document.getElementById('numberBox');
        numBox.style.background = data.bg;
        numBox.style.borderColor = data.border;
        document.getElementById('activeNumberText').innerText = data.number;
        document.getElementById('activeNumberText').style.color = data.color;
        document.getElementById('stepNumberSpan').innerText = data.number;

        // Update step badges & texts
        ['step1Badge', 'step2Badge', 'step3Badge', 'step4Badge'].forEach(id => {
            document.getElementById(id).style.background = data.color;
        });
        document.getElementById('step1Text').innerHTML = data.appStep;
        document.getElementById('trxHelpText').innerText = data.trxHelp;
        document.getElementById('senderPhoneLabel').innerHTML = 'যে ' + data.name + ' নম্বর থেকে টাকা পাঠিয়েছেন <span class="text-danger">*</span>';
        document.getElementById('submitBtn').style.background = data.gradient;
        document.getElementById('formTitleIcon').style.color = data.color;
    }

    function copyActiveNumber() {
        const num = document.getElementById('activeNumberText').innerText;
        navigator.clipboard.writeText(num).then(() => {
            alert('নম্বরটি কপি করা হয়েছে: ' + num);
        });
    }

    // Auto uppercase TrxID
    document.getElementById('trxIdInput').addEventListener('input', function(e) {
        this.value = this.value.toUpperCase().replace(/\s/g, '');
    });
</script>
@endpush
