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
    {{ __('লগইন') }}
@endsection

@if (isset($adminSetting['cust_darklayout']) && $adminSetting['cust_darklayout'] == 'on')
    <style>
        .g-recaptcha {
            filter: invert(1) hue-rotate(180deg) !important;
        }
    </style>
@endif

@section('content')
    <div style="margin-bottom: 24px;">
        <div style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; border-radius: 20px; background: rgba(99, 102, 241, 0.15); border: 1px solid rgba(99, 102, 241, 0.3); color: #a5b4fc; font-size: 12px; font-weight: 600; margin-bottom: 12px;">
            <span>🔐 মার্চেন্ট ও অ্যাডমিন পোর্টাল</span>
        </div>
        <h2 style="font-size: 26px; font-weight: 800; color: #ffffff; margin-bottom: 8px;">
            অ্যাকাউন্টে <span class="gradient-text">লগইন করুন</span>
        </h2>
        <p style="font-size: 14px; color: #94a3b8; line-height: 1.5;">
            আপনার অনলাইন শপ ম্যানেজ করতে ইমেইল ও পাসওয়ার্ড দিয়ে প্রবেশ করুন।
        </p>
    </div>

    <!-- Session Status Alert -->
    @if (session('status'))
        <div style="background: rgba(16, 185, 129, 0.12); border: 1px solid rgba(16, 185, 129, 0.35); border-radius: 12px; padding: 12px 16px; margin-bottom: 20px; color: #34d399; font-size: 14px; display: flex; align-items: center; gap: 10px;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            <div>{{ session('status') }}</div>
        </div>
    @endif

    <!-- Validation Errors Alert -->
    @if ($errors->any())
        <div style="background: rgba(239, 68, 68, 0.12); border: 1px solid rgba(239, 68, 68, 0.35); border-radius: 12px; padding: 12px 16px; margin-bottom: 20px; color: #f87171; font-size: 14px;">
            <div style="display: flex; align-items: center; gap: 8px; font-weight: 700; margin-bottom: 6px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                <span>লগইনে সমস্যা হয়েছে:</span>
            </div>
            <ul style="margin: 0; padding-left: 24px; font-size: 13px; color: #fca5a5;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" id="form_data">
        @csrf
        
        <!-- Email Input -->
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
                    placeholder="যেমন: admin@example.com" required autofocus autocomplete="username" />
            </div>
        </div>

        <!-- Password Input -->
        <div class="form-group">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                <label class="form-label" for="password" style="margin-bottom: 0;">পাসওয়ার্ড</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="font-size: 13px; color: #818cf8; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#a5b4fc'" onmouseout="this.style.color='#818cf8'">
                        পাসওয়ার্ড ভুলে গেছেন?
                    </a>
                @endif
            </div>
            <div class="input-group-custom">
                <span class="input-icon-prefix">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                </span>
                <input id="password" class="form-control" type="password" name="password" required
                    autocomplete="current-password" placeholder="••••••••" style="padding-right: 44px;" />
                <span class="input-icon-suffix" id="togglePasswordBtn" title="পাসওয়ার্ড দেখুন">
                    <svg id="eyeIcon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                </span>
            </div>
        </div>

        <!-- Remember Me Checkbox -->
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 22px;">
            <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: #94a3b8; cursor: pointer; user-select: none;">
                <input type="checkbox" name="remember" id="remember_me" style="accent-color: #6366f1; width: 16px; height: 16px; cursor: pointer; border-radius: 4px;">
                <span>আমাকে মনে রাখুন</span>
            </label>
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
        <button class="btn-submit login_button" type="submit" id="loginBtn">
            <span>অ্যাকাউন্টে প্রবেশ করুন</span>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
            </svg>
        </button>

        <!-- Quick Demo Login Fast-Fill -->
        <div class="demo-chips-box">
            <div class="demo-chips-title">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#fbbf24" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                <span>এক ক্লিকে ডেমো টেস্ট করুন:</span>
            </div>
            <div class="chips-list">
                <button type="button" class="demo-chip" onclick="fillDemo('superadmin@example.com', '1234', this)">
                    👑 <strong>Super Admin</strong>
                </button>
                <button type="button" class="demo-chip" onclick="fillDemo('admin@example.com', '1234', this)">
                    🏪 <strong>Store Owner</strong>
                </button>
            </div>
        </div>

        <!-- Register Link -->
        @if (isset($adminSetting['SIGNUP']) && $adminSetting['SIGNUP'] == 'on')
            <div style="margin-top: 24px; text-align: center; font-size: 14px; color: #94a3b8;">
                কোনো অ্যাকাউন্ট নেই? 
                <a href="{{ route('register') }}" style="color: #818cf8; font-weight: 700; text-decoration: none; margin-left: 4px; transition: color 0.2s;" onmouseover="this.style.color='#a5b4fc'" onmouseout="this.style.color='#818cf8'">
                    নতুন স্টোর খুলুন →
                </a>
            </div>
        @endif
    </form>
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
                        grecaptcha.execute("{{ $adminSetting['NOCAPTCHA_SITEKEY'] }}", {
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
        // Password Visibility Toggle
        document.getElementById('togglePasswordBtn').addEventListener('click', function() {
            var pwd = document.getElementById('password');
            var icon = document.getElementById('eyeIcon');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
            } else {
                pwd.type = 'password';
                icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
            }
        });

        // Demo Credentials Auto Fill
        function fillDemo(email, pass, btn) {
            var emailInput = document.getElementById('email');
            var passInput = document.getElementById('password');
            
            emailInput.value = email;
            passInput.value = pass;

            // Visual highlight
            emailInput.style.borderColor = '#10b981';
            passInput.style.borderColor = '#10b981';
            setTimeout(function() {
                emailInput.style.borderColor = '';
                passInput.style.borderColor = '';
            }, 1200);

            var originalText = btn.innerHTML;
            btn.innerHTML = '✓ ফিল করা হয়েছে!';
            btn.style.background = 'rgba(16, 185, 129, 0.2)';
            btn.style.borderColor = '#10b981';
            setTimeout(function() {
                btn.innerHTML = originalText;
                btn.style.background = '';
                btn.style.borderColor = '';
            }, 1200);
        }

        // Form Submit Loading Feedback
        $(document).ready(function() {
            $("#form_data").submit(function(e) {
                var btn = $("#loginBtn");
                btn.attr("disabled", true);
                btn.css("opacity", "0.75");
                btn.html('<span>লগইন প্রসেস হচ্ছে...</span> <div style="display:inline-block; width:16px; height:16px; border:2px solid #fff; border-top-color:transparent; border-radius:50%; animation:spin 0.8s linear infinite;"></div>');
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
