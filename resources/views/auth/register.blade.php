@php
    $adminSetting = getSuperAdminAllSetting();
    config([
        'captcha.secret' => $adminSetting['NOCAPTCHA_SECRET'] ?? '',
        'captcha.sitekey' => $adminSetting['NOCAPTCHA_SITEKEY'] ?? '',
        'options' => [
            'timeout' => 30,
        ],
    ]);
@endphp

@extends('layouts.guest')

@section('page-title')
    {{ __('নতুন স্টোর রেজিস্ট্রেশন') }}
@endsection

@if (isset($adminSetting['cust_darklayout']) && $adminSetting['cust_darklayout'] == 'on')
    <style>
        .g-recaptcha {
            filter: invert(1) hue-rotate(180deg) !important;
        }
    </style>
@endif

@section('content')
    <div style="margin-bottom: 22px;">
        <div style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; border-radius: 20px; background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); color: #34d399; font-size: 12px; font-weight: 600; margin-bottom: 12px;">
            <span>🚀 ১৪ দিনের আনলিমিটেড ফ্রি ট্রায়াল</span>
        </div>
        <h2 style="font-size: 26px; font-weight: 800; color: #ffffff; margin-bottom: 8px;">
            নতুন স্টোর <span class="gradient-text">রেজিস্ট্রেশন করুন</span>
        </h2>
        <p style="font-size: 14px; color: #94a3b8; line-height: 1.5;">
            কোনো ক্রেডিট কার্ড লাগবে না। ২ মিনিটে তৈরি করুন আপনার অনলাইন বিজনেস।
        </p>

        @if(request()->query('plan_id'))
            <div style="margin-top: 10px; display: inline-flex; align-items: center; gap: 6px; background: rgba(99, 102, 241, 0.15); border: 1px solid rgba(99, 102, 241, 0.3); border-radius: 8px; padding: 6px 12px; font-size: 12px; color: #c7d2fe;">
                <span>🎯 নির্বাচিত প্যাকেজ আইডি: <strong>#{{ request()->query('plan_id') }}</strong></span>
            </div>
        @endif
    </div>

    <!-- Status Alert -->
    @if (session('status'))
        <div style="background: rgba(16, 185, 129, 0.12); border: 1px solid rgba(16, 185, 129, 0.35); border-radius: 12px; padding: 12px 16px; margin-bottom: 20px; color: #34d399; font-size: 14px; display: flex; align-items: center; gap: 10px;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            <div>{{ session('status') ?? __('Email SMTP settings does not configured so please contact to your site admin.') }}</div>
        </div>
    @endif

    <!-- Validation Errors Alert -->
    @if ($errors->any())
        <div style="background: rgba(239, 68, 68, 0.12); border: 1px solid rgba(239, 68, 68, 0.35); border-radius: 12px; padding: 12px 16px; margin-bottom: 20px; color: #f87171; font-size: 14px;">
            <div style="display: flex; align-items: center; gap: 8px; font-weight: 700; margin-bottom: 6px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                <span>রেজিস্ট্রেশনে ত্রুটি রয়েছে:</span>
            </div>
            <ul style="margin: 0; padding-left: 24px; font-size: 13px; color: #fca5a5;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" id="registerForm">
        @csrf
        <input name="plan_id" type="hidden" value="{{ request()->query('plan_id') }}">

        <!-- Full Name -->
        <div class="form-group">
            <label class="form-label" for="name">আপনার পূর্ণ নাম</label>
            <div class="input-group-custom">
                <span class="input-icon-prefix">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </span>
                <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" required
                    placeholder="যেমন: তানভীর আহমেদ" autofocus />
            </div>
        </div>

        <!-- Store Name -->
        <div class="form-group">
            <label class="form-label" for="store_name">আপনার স্টোরের নাম (দোকানের নাম)</label>
            <div class="input-group-custom">
                <span class="input-icon-prefix">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                </span>
                <input id="store_name" class="form-control" type="text" name="store_name" value="{{ old('store_name') }}"
                    placeholder="যেমন: ফ্যাশন ক্যাফে বা গ্যাজেট হাব" required />
            </div>
        </div>

        <!-- Email Address -->
        <div class="form-group">
            <label class="form-label" for="email">ইমেইল ঠিকানা</label>
            <div class="input-group-custom">
                <span class="input-icon-prefix">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                </span>
                <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" 
                    placeholder="যেমন: you@gmail.com" required autocomplete="username" />
            </div>
        </div>

        <!-- Password -->
        <div class="form-group">
            <label class="form-label" for="password">পাসওয়ার্ড (কমপক্ষে ৪ বা ৮ ক্যারেক্টার)</label>
            <div class="input-group-custom">
                <span class="input-icon-prefix">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                </span>
                <input id="password" class="form-control" type="password" name="password" required
                    autocomplete="new-password" placeholder="••••••••" style="padding-right: 44px;" />
                <span class="input-icon-suffix" id="toggleRegPwd" title="পাসওয়ার্ড দেখুন">
                    <svg id="regEyeIcon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                </span>
            </div>
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label class="form-label" for="password_confirmation">কনফার্ম পাসওয়ার্ড</label>
            <div class="input-group-custom">
                <span class="input-icon-prefix">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    </svg>
                </span>
                <input id="password_confirmation" class="form-control" type="password" name="password_confirmation"
                    placeholder="পাসওয়ার্ডটি পুনরায় লিখুন" required autocomplete="new-password" style="padding-right: 44px;" />
                <span class="input-icon-suffix" id="toggleRegConfPwd" title="পাসওয়ার্ড দেখুন">
                    <svg id="regConfEyeIcon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                </span>
            </div>
        </div>

        <!-- reCAPTCHA -->
        @if (isset($adminSetting['RECAPTCHA_MODULE']) && $adminSetting['RECAPTCHA_MODULE'] == 'yes')
            @if (isset($adminSetting['NOCAPTCHA_VERSON']) && $adminSetting['NOCAPTCHA_VERSON'] == 'v2')
                <div class="form-group col-lg-12 col-md-12 mt-3">
                    {!! NoCaptcha::display((isset($adminSetting['cust_darklayout']) && $adminSetting['cust_darklayout'] == 'on') ? ['data-theme' => 'dark'] : []) !!}
                    @error('g-recaptcha-response')
                        <span class="small text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            @else
                <div class="form-group col-lg-12 col-md-12 mt-3">
                    <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response" class="form-control">
                    @error('g-recaptcha-response')
                        <span class="error small text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            @endif
        @endif

        <!-- Submit Button -->
        <button class="btn-submit" type="submit" id="submitRegBtn">
            <span>ফ্রি ট্রায়ালে স্টোর খুলুন 🚀</span>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
            </svg>
        </button>

        <!-- Terms note -->
        <div style="margin-top: 14px; font-size: 12px; color: #64748b; text-align: center; line-height: 1.4;">
            রেজিস্ট্রেশন করার মাধ্যমে আপনি আমাদের শর্তাবলী ও প্রাইভেসির সাথে সম্মতি দিচ্ছেন।
        </div>
    </form>

    <div style="margin-top: 24px; text-align: center; font-size: 14px; color: #94a3b8; border-top: 1px solid rgba(255, 255, 255, 0.08); padding-top: 18px;">
        ইতিমধ্যে অ্যাকাউন্ট আছে? 
        <a href="{{ route('login') }}" style="color: #818cf8; font-weight: 700; text-decoration: none; margin-left: 4px; transition: color 0.2s;" onmouseover="this.style.color='#a5b4fc'" onmouseout="this.style.color='#818cf8'">
            লগইন করুন →
        </a>
    </div>
@endsection

@push('scripts')
@if (isset($adminSetting['RECAPTCHA_MODULE']) && $adminSetting['RECAPTCHA_MODULE'] == 'yes')
    @if (isset($adminSetting['NOCAPTCHA_VERSON']) && $adminSetting['NOCAPTCHA_VERSON'] == 'v2')
        {!! NoCaptcha::renderJs() !!}
    @else
        <script src="https://www.google.com/recaptcha/api.js?render={{ $adminSetting['NOCAPTCHA_SITEKEY'] }}"></script>
        <script>
            $(document).ready(function() {
                grecaptcha.ready(function() {
                    grecaptcha.execute('{{ $adminSetting['NOCAPTCHA_SITEKEY'] }}', {
                        action: 'submit'
                    }).then(function(token) {
                        $('#g-recaptcha-response').val(token);
                    });
                });
            });
        </script>
    @endif
@endif

<script>
    // Password toggle
    function setupPasswordToggle(toggleId, inputId, iconId) {
        var toggleBtn = document.getElementById(toggleId);
        if (!toggleBtn) return;
        toggleBtn.addEventListener('click', function() {
            var pwd = document.getElementById(inputId);
            var icon = document.getElementById(iconId);
            if (pwd.type === 'password') {
                pwd.type = 'text';
                icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
            } else {
                pwd.type = 'password';
                icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
            }
        });
    }

    setupPasswordToggle('toggleRegPwd', 'password', 'regEyeIcon');
    setupPasswordToggle('toggleRegConfPwd', 'password_confirmation', 'regConfEyeIcon');

    $(document).ready(function() {
        $("#registerForm").submit(function(e) {
            var btn = $("#submitRegBtn");
            btn.attr("disabled", true);
            btn.css("opacity", "0.75");
            btn.html('<span>স্টোর তৈরি হচ্ছে...</span> <div style="display:inline-block; width:16px; height:16px; border:2px solid #fff; border-top-color:transparent; border-radius:50%; animation:spin 0.8s linear infinite;"></div>');
            return true;
        });
    });
</script>
<style>
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>
@endpush
