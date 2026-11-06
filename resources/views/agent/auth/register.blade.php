<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>মার্কেটিং এজেন্ট রেজিস্ট্রেশন - edokanpro</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>
        body {
            font-family: 'Hind Siliguri', 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #312e81 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 15px;
        }
        .register-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.45);
            max-width: 580px;
            width: 100%;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .register-header {
            background: linear-gradient(135deg, #4338ca 0%, #6366f1 100%);
            padding: 32px 30px;
            color: #ffffff;
            text-align: center;
            position: relative;
        }
        .register-body {
            padding: 35px 30px;
        }
        .form-control, .form-select {
            border-radius: 10px;
            padding: 11px 14px;
            font-size: 14.5px;
            border: 1.5px solid #e2e8f0;
            transition: all 0.2s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
        }
        .btn-agent-register {
            background: linear-gradient(135deg, #4338ca 0%, #6366f1 100%);
            border: 0;
            border-radius: 12px;
            padding: 13px;
            font-size: 16px;
            font-weight: 700;
            color: #ffffff;
            width: 100%;
            transition: all 0.2s ease;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.35);
        }
        .btn-agent-register:hover {
            opacity: 0.95;
            transform: translateY(-1px);
            color: #ffffff;
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.45);
        }
        .badge-portal {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(5px);
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            display: inline-block;
            margin-top: 8px;
        }
        .info-notice {
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            border-radius: 12px;
            padding: 14px 16px;
            font-size: 13px;
            color: #475569;
            margin-bottom: 20px;
            line-height: 1.6;
        }
        .perk-pill {
            background: #eef2ff;
            color: #4338ca;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 700;
            border: 1px solid #c7d2fe;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
    </style>
</head>
<body>

<div class="register-card">
    <div class="register-header">
        <h2 class="mb-0 font-weight-bold" style="letter-spacing: -0.5px;">edokan<span style="color: #cbd5e1;">pro</span></h2>
        <div class="badge-portal"><i class="ti ti-user-plus me-1"></i> মার্কেটিং এজেন্ট রেজিস্ট্রেশন</div>
        <p class="mt-2 mb-0 text-white-50 text-sm">এফিলিয়েট পার্টনার হিসেবে যোগ দিয়ে আজই আয় শুরু করুন</p>
    </div>

    <div class="register-body">
        <!-- Highlights -->
        <div class="d-flex flex-wrap gap-2 justify-content-center mb-3">
            <span class="perk-pill"><i class="ti ti-check"></i> ১৫% আজীবন কমিশন</span>
            <span class="perk-pill"><i class="ti ti-gift"></i> সাপ্তাহিক নগদ বোনাস</span>
            <span class="perk-pill"><i class="ti ti-wallet"></i> বিকাশ/নগদে উত্তোলন</span>
        </div>

        <div class="info-notice">
            <i class="ti ti-info-circle text-primary me-1 fs-5 align-middle"></i>
            <strong>অ্যাডমিন অনুমোদন প্রক্রিয়া:</strong> ফর্মটি পূরণ করে সাবমিট করুন। আপনার আবেদনটি সুপার অ্যাডমিন রিভিউ করে সক্রিয় (Approve) করলেই আপনি লগইন করতে পারবেন।
        </div>

        @if($errors->any())
            <div class="alert alert-danger py-2 px-3 mb-3 text-sm rounded-3">
                @foreach($errors->all() as $err)
                    <div><i class="ti ti-alert-triangle me-1"></i> {{ $err }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('agent.register.submit') }}">
            @csrf

            <!-- Name & Phone -->
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label font-weight-bold text-dark">{{ __('আপনার পূর্ণ নাম') }} <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="যেমন: মাসুদ রানা" value="{{ old('name') }}" required autofocus>
                </div>
                <div class="col-md-6">
                    <label class="form-label font-weight-bold text-dark">{{ __('মোবাইল নম্বর') }} <span class="text-danger">*</span></label>
                    <input type="text" name="phone" class="form-control" placeholder="017xxxxxxxx" value="{{ old('phone') }}" required>
                    <small class="text-muted text-xs">এই নম্বরটি আপনার লগইন আইডি হবে</small>
                </div>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label class="form-label font-weight-bold text-dark">{{ __('ইমেইল ঠিকানা (ঐচ্ছিক)') }}</label>
                <input type="email" name="email" class="form-control" placeholder="yourname@gmail.com" value="{{ old('email') }}">
            </div>

            <!-- Password & Confirm -->
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label font-weight-bold text-dark">{{ __('পাসওয়ার্ড') }} <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="password" name="password" id="agentRegPassword" class="form-control border-end-0" placeholder="••••••••" required>
                        <button class="btn btn-outline-light border text-muted" type="button" onclick="toggleRegPassword('agentRegPassword', 'toggleIcon1')">
                            <i class="ti ti-eye" id="toggleIcon1"></i>
                        </button>
                    </div>
                    <small class="text-muted text-xs">মিনিমাম ৬ অক্ষর</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label font-weight-bold text-dark">{{ __('পাসওয়ার্ড নিশ্চিত করুন') }} <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="password" name="password_confirmation" id="agentRegPasswordConfirm" class="form-control border-end-0" placeholder="••••••••" required>
                        <button class="btn btn-outline-light border text-muted" type="button" onclick="toggleRegPassword('agentRegPasswordConfirm', 'toggleIcon2')">
                            <i class="ti ti-eye" id="toggleIcon2"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Payout Method & Details -->
            <div class="row g-3 mb-3">
                <div class="col-md-5">
                    <label class="form-label font-weight-bold text-dark">{{ __('উইথড্রয়াল মাধ্যম') }} <span class="text-danger">*</span></label>
                    <select name="payment_method" class="form-select" required>
                        <option value="bKash" {{ old('payment_method') == 'bKash' ? 'selected' : '' }}>bKash (বিকাশ)</option>
                        <option value="Nagad" {{ old('payment_method') == 'Nagad' ? 'selected' : '' }}>Nagad (নগদ)</option>
                        <option value="Rocket" {{ old('payment_method') == 'Rocket' ? 'selected' : '' }}>Rocket (রকেট)</option>
                        <option value="Bank" {{ old('payment_method') == 'Bank' ? 'selected' : '' }}>Bank Transfer (ব্যাংক)</option>
                    </select>
                </div>
                <div class="col-md-7">
                    <label class="form-label font-weight-bold text-dark">{{ __('পেমেন্ট অ্যাকাউন্ট / মোবাইল নম্বর') }} <span class="text-danger">*</span></label>
                    <input type="text" name="payout_details" class="form-control" placeholder="017xxxxxxxx (পার্সোনাল)" value="{{ old('payout_details') }}" required>
                </div>
            </div>

            <!-- Marketing Experience / Plan (Optional) -->
            <div class="mb-4">
                <label class="form-label font-weight-bold text-dark">{{ __('কীভাবে মার্কেটিং করবেন বা কাজের অভিজ্ঞতা (ঐচ্ছিক)') }}</label>
                <textarea name="marketing_experience" class="form-control" rows="2" placeholder="যেমন: ফেসবুক গ্রুপে পোস্ট ও শপ ওনারদের ইনবক্সে যোগাযোগ করব">{{ old('marketing_experience') }}</textarea>
            </div>

            <button type="submit" class="btn btn-agent-register">
                <i class="ti ti-user-plus me-1"></i> {{ __('রেজিস্ট্রেশন আবেদন সাবমিট করুন') }}
            </button>
        </form>

        <div class="text-center mt-4 pt-3 border-top">
            <span class="text-muted text-sm">{{ __('ইতিমধ্যে আপনার অ্যাকাউন্ট রয়েছে?') }}</span>
            <a href="{{ route('agent.login') }}" class="text-primary text-sm font-weight-bold text-decoration-none ms-1">
                {{ __('লগইন করুন') }}
            </a>
        </div>
    </div>
</div>

<script>
function toggleRegPassword(fieldId, iconId) {
    var field = document.getElementById(fieldId);
    var icon = document.getElementById(iconId);
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('ti-eye');
        icon.classList.add('ti-eye-off');
    } else {
        field.type = 'password';
        icon.classList.remove('ti-eye-off');
        icon.classList.add('ti-eye');
    }
}
</script>

</body>
</html>

