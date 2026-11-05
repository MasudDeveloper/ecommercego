<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>মার্কেটিং এজেন্ট লগইন - edokanpro</title>

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
            padding: 20px;
        }
        .login-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
            max-width: 460px;
            width: 100%;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .login-header {
            background: linear-gradient(135deg, #4338ca 0%, #6366f1 100%);
            padding: 35px 30px;
            color: #ffffff;
            text-align: center;
            position: relative;
        }
        .login-body {
            padding: 35px 30px;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 14.5px;
            border: 1.5px solid #e2e8f0;
        }
        .form-control:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
        }
        .btn-agent-login {
            background: linear-gradient(135deg, #4338ca 0%, #6366f1 100%);
            border: 0;
            border-radius: 10px;
            padding: 13px;
            font-size: 16px;
            font-weight: 700;
            color: #ffffff;
            width: 100%;
            transition: all 0.2s ease;
        }
        .btn-agent-login:hover {
            opacity: 0.95;
            transform: translateY(-1px);
            color: #ffffff;
        }
        .badge-portal {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(5px);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            display: inline-block;
            margin-top: 8px;
        }
        .info-box {
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            border-radius: 12px;
            padding: 14px;
            font-size: 13px;
            color: #64748b;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="login-header">
        <h2 class="mb-0 font-weight-bold" style="letter-spacing: -0.5px;">edokan<span style="color: #cbd5e1;">pro</span></h2>
        <div class="badge-portal"><i class="ti ti-shield-lock me-1"></i> মার্কেটিং এজেন্ট পোর্টাল</div>
        <p class="mt-2 mb-0 text-white-50 text-sm">আপনার রেফারেল আয়, লিড ও বোনাস ট্র্যাক করুন</p>
    </div>

    <div class="login-body">
        @if(session('info'))
            <div class="alert alert-info py-2 px-3 mb-3 text-sm rounded-3">
                <i class="ti ti-info-circle me-1"></i> {{ session('info') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger py-2 px-3 mb-3 text-sm rounded-3">
                @foreach($errors->all() as $err)
                    <div><i class="ti ti-alert-triangle me-1"></i> {{ $err }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('agent.login.submit') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label font-weight-bold text-dark">{{ __('মোবাইল নম্বর / ইমেইল / রেফারেল কোড') }}</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="ti ti-user text-muted"></i></span>
                    <input type="text" name="login_identifier" class="form-control border-start-0" placeholder="017xxxxxxxx বা RAHIM15" value="{{ old('login_identifier') }}" required autofocus>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label font-weight-bold text-dark">{{ __('পাসওয়ার্ড') }}</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="ti ti-lock text-muted"></i></span>
                    <input type="password" name="password" id="agentPassword" class="form-control border-start-0" placeholder="••••••••" required>
                    <button class="btn btn-outline-light border text-muted" type="button" onclick="togglePasswordVisibility()">
                        <i class="ti ti-eye" id="toggleIcon"></i>
                    </button>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                    <label class="form-check-label text-sm text-muted" for="rememberMe">
                        {{ __('লগইন মনে রাখুন') }}
                    </label>
                </div>
                <a href="https://wa.me/8801700000000?text=মার্কেটিং%20এজেন্ট%20পাসওয়ার্ড%20রিসেট%20সহায়তা" target="_blank" class="text-sm text-primary text-decoration-none font-weight-bold">
                    {{ __('পাসওয়ার্ড ভুলে গেছেন?') }}
                </a>
            </div>

            <button type="submit" class="btn btn-agent-login">
                <i class="ti ti-login me-1"></i> {{ __('এজেন্ট পোর্টালে প্রবেশ করুন') }}
            </button>
        </form>

        <div class="info-box">
            <i class="ti ti-info-circle text-primary me-1"></i> <strong>নতুন এজেন্ট অনবোর্ডিং:</strong> এজেন্ট অ্যাকাউন্ট কেবল এডমিন প্যানেল থেকে তৈরি ও সক্রিয় করা হয়। একাউন্টের জন্য কর্তৃপক্ষের সাথে যোগাযোগ করুন।
        </div>
    </div>
</div>

<script>
function togglePasswordVisibility() {
    var pwd = document.getElementById('agentPassword');
    var icon = document.getElementById('toggleIcon');
    if (pwd.type === 'password') {
        pwd.type = 'text';
        icon.classList.remove('ti-eye');
        icon.classList.add('ti-eye-off');
    } else {
        pwd.type = 'password';
        icon.classList.remove('ti-eye-off');
        icon.classList.add('ti-eye');
    }
}
</script>

</body>
</html>

