<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>পেজের মেয়াদ শেষ হয়েছে (419) - edokanpro</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>
        body {
            font-family: 'Hind Siliguri', 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #312e81 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            margin: 0;
            color: #1e293b;
        }
        .error-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.5);
            max-width: 500px;
            width: 100%;
            overflow: hidden;
            text-align: center;
            padding: 40px 32px;
            animation: fadeIn 0.3s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .icon-bubble {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #fef3c7;
            color: #d97706;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 38px;
            margin-bottom: 20px;
            box-shadow: 0 8px 24px rgba(217, 119, 6, 0.2);
        }
        .btn-reload {
            background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
            color: #ffffff;
            font-weight: 700;
            padding: 13px 24px;
            border-radius: 12px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 15px;
            border: 0;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);
        }
        .btn-reload:hover {
            opacity: 0.95;
            color: #ffffff;
            transform: translateY(-1px);
        }
        .btn-agent {
            background: #f1f5f9;
            color: #334155;
            font-weight: 600;
            padding: 13px 24px;
            border-radius: 12px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 15px;
            border: 1px solid #cbd5e1;
            transition: all 0.2s ease;
        }
        .btn-agent:hover {
            background: #e2e8f0;
            color: #0f172a;
        }
    </style>
</head>
<body>

<div class="error-card">
    <div class="icon-bubble">
        <i class="ti ti-clock-pause"></i>
    </div>

    <div class="mb-2">
        <span class="badge bg-warning bg-opacity-20 text-warning px-3 py-1 font-monospace" style="font-size: 13px; font-weight: 700; border-radius: 50px;">
            ত্রুটি কোড: ৪১৯ (সেশন মেয়াদোত্তীর্ণ)
        </span>
    </div>

    <h3 class="font-weight-bold text-dark mt-3 mb-2" style="font-size: 22px;">
        আপনার সেশনের সময় শেষ হয়ে গেছে
    </h3>

    <p class="text-secondary mb-4" style="font-size: 14.5px; line-height: 1.6;">
        নিরাপত্তার স্বার্থে বেশি সময় নিষ্ক্রিয় থাকলে ফর্ম বা সেশন বন্ধ হয়ে যায়। অনুগ্রহ করে পেজটি রিফ্রেশ করে আবার চেষ্টা করুন।
    </p>

    <div class="d-grid gap-2 mb-3">
        <button type="button" onclick="window.location.reload();" class="btn-reload">
            <i class="ti ti-refresh fs-5"></i> <span>পেজটি রিফ্রেশ করুন</span>
        </button>

        <a href="{{ url('/agent/login') }}" class="btn-agent">
            <i class="ti ti-login fs-5"></i> <span>এজেন্ট লগইন পেজে যান</span>
        </a>
    </div>

    <div class="text-xs text-muted mt-3">
        <span id="countdown-text"><span id="sec-count" class="font-weight-bold text-primary">৪</span> সেকেন্ডের মধ্যে স্বয়ংক্রিয়ভাবে লগইন পেজে রিডাইরেক্ট হচ্ছে...</span>
    </div>
</div>

<script>
    let remaining = 4;
    const secEl = document.getElementById('sec-count');
    const timer = setInterval(() => {
        remaining--;
        if (secEl) secEl.textContent = remaining;
        if (remaining <= 0) {
            clearInterval(timer);
            if (document.referrer && document.referrer.includes(window.location.host)) {
                window.location.href = document.referrer;
            } else {
                window.location.href = "{{ url('/agent/login') }}";
            }
        }
    }, 1000);
</script>

</body>
</html>
