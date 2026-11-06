@extends('front_end.layouts.app')

@section('page-title')
    {{ $store->name ?? 'Professional 11-Piece Home Workout Resistance Bands Kit' }}
@endsection

@section('content')
@php
    $toNum = function($val, $default = 0) {
        if (is_numeric($val)) return (float)$val;
        if (is_string($val)) {
            $bn = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
            $en = ['0','1','2','3','4','5','6','7','8','9'];
            $clean = str_replace($bn, $en, $val);
            $clean = preg_replace('/[^0-9.]/', '', $clean);
            return is_numeric($clean) ? (float)$clean : (float)$default;
        }
        return (float)$default;
    };

    $mainProduct = $all_products->first() ?? $bestseller_products->first() ?? null;
    $productTitle = $themeSettings['hero_title'] ?? 'প্রফেশনাল হোম ওয়ার্কআউট ১১-পিস রেজিস্ট্যান্স ব্যান্ড ও ডাম্বেল ফিটনেস কিট';
    $productDesc = $themeSettings['hero_subtitle'] ?? '১৫০ পাউন্ড পর্যন্ত স্ট্যাকেবল রেজিস্ট্যান্স। ১০০% মালয়েশিয়ান ন্যাচারাল ল্যাটেক্স টিউব ও মেটাল কারাবিনার। জিম ছাড়াই ঘরে বসে বুক, বাইসেপ, ট্রাইসেপ, অ্যাবস ও শোল্ডার তৈরি করুন!';
    
    $regularPrice = $toNum($themeSettings['hero_regular_price'] ?? 1850, 1850);
    $offerPrice = $toNum($themeSettings['hero_offer_price'] ?? 1350, 1350);
    
    if ($regularPrice <= 0) $regularPrice = 1850;
    if ($offerPrice <= 0) $offerPrice = 1350;
    
    $productImg1 = asset('themes/' . $currentTheme . '/assets/images/product-01.png');
    $productImg2 = asset('themes/' . $currentTheme . '/assets/images/product-02.png');
    $productImg3 = asset('themes/' . $currentTheme . '/assets/images/product-03.png');
    $aboutImg = asset('themes/' . $currentTheme . '/assets/images/about-image.png');

    $dhakaCharge = (int)$toNum($themeSettings['delivery_charge_dhaka'] ?? 70, 70);
    $outsideCharge = (int)$toNum($themeSettings['delivery_charge_outside'] ?? 130, 130);

    // YouTube Embed Link Helper
    $rawYoutube = $themeSettings['video_youtube_url'] ?? '';
    $youtubeAutoplay = (!empty($themeSettings['video_autoplay']) && $themeSettings['video_autoplay'] == '1') ? true : false;
    $embedUrl = null;
    if (!empty($rawYoutube)) {
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/|youtube\.com\/shorts\/)([^"&?\/ ]{11})/i';
        if (preg_match($pattern, $rawYoutube, $match)) {
            $embedUrl = 'https://www.youtube-nocookie.com/embed/' . $match[1] . '?rel=0' . ($youtubeAutoplay ? '&autoplay=1&mute=1' : '');
        }
    }
@endphp

<main class="space-y-12 sm:space-y-20 bg-zinc-950 text-slate-100 font-sans">

    <!-- 1. HIGH-ENERGY GYM EDITORIAL HERO -->
    <section class="relative pt-10 sm:pt-16 pb-16 bg-gradient-to-b from-zinc-900 via-zinc-950 to-zinc-900 border-b border-red-900/50">
        <div class="max-w-6xl mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                
                <!-- Left Portrait with aggressive gym frame -->
                <div class="lg:col-span-5 flex justify-center order-2 lg:order-1">
                    <div class="relative p-3 bg-zinc-900 rounded-3xl shadow-2xl border-4 border-red-600/70 max-w-sm w-full">
                        <div class="absolute -top-3.5 -right-3.5 bg-gradient-to-r from-red-600 to-rose-600 text-white font-extrabold text-xs uppercase px-3.5 py-1.5 rounded-full shadow-lg tracking-wider animate-pulse">
                            150 LBS RESISTANCE
                        </div>
                        <img src="{{ $productImg1 }}" alt="{{ $productTitle }}" class="w-full h-[380px] object-cover rounded-2xl shadow-inner">
                        <div class="mt-3 text-center text-xs font-mono text-red-400 font-bold bg-zinc-800/80 py-2 px-3 rounded-xl border border-red-600/40">
                            ✦ ১১-পিস প্রফেশনাল ফুল বডি কিট • ফ্রি ক্যারি ব্যাগ ✦
                        </div>
                    </div>
                </div>

                <!-- Right Editorial Text -->
                <div class="lg:col-span-7 space-y-5 text-center lg:text-left order-1 lg:order-2">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-red-950/80 text-red-300 text-xs sm:text-sm font-black border border-red-600/50 shadow-sm">
                        <i class="fas fa-dumbbell text-red-500"></i>
                        <span>{{ $themeSettings['hero_badge'] ?? '🔥 ঘরে বসেই ফুল বডি জিম ওয়ার্কআউট' }}</span>
                    </div>

                    <h1 class="text-3xl sm:text-5xl font-black text-white leading-tight">
                        {{ $productTitle }}
                    </h1>

                    <p class="text-slate-200 text-base sm:text-lg leading-relaxed font-medium">
                        {{ $productDesc }}
                    </p>

                    <!-- Urgent Countdown Timer -->
                    <div class="p-3.5 bg-gradient-to-r from-red-700 via-rose-700 to-red-800 text-white rounded-2xl shadow-lg flex flex-wrap items-center justify-between gap-3 border border-red-500/40">
                        <div class="flex items-center gap-2 font-bold text-xs sm:text-sm">
                            <span class="inline-block w-2.5 h-2.5 bg-yellow-300 rounded-full animate-ping"></span>
                            <span>⚡ লিমিটেড স্টক ডিসকাউন্ট অফার শেষ হতে বাকি:</span>
                        </div>
                        <div class="flex items-center gap-1.5 text-xs sm:text-sm font-black text-zinc-950 font-mono">
                            <span class="bg-white px-2 py-1 rounded shadow text-red-700 font-bold" id="fitness_timer_hours">04</span> :
                            <span class="bg-white px-2 py-1 rounded shadow text-red-700 font-bold" id="fitness_timer_minutes">15</span> :
                            <span class="bg-white px-2 py-1 rounded shadow text-red-700 font-bold" id="fitness_timer_seconds">28</span>
                        </div>
                    </div>

                    <!-- Price Badge -->
                    <div class="inline-flex flex-wrap items-center gap-6 p-4 rounded-2xl bg-zinc-900 border-2 border-red-600/60 shadow-md">
                        <div>
                            <span class="text-xs text-slate-400 block font-bold uppercase">রেগুলার প্রাইস</span>
                            <span class="text-xl font-extrabold text-slate-400 line-through">৳{{ number_format($regularPrice) }}</span>
                        </div>
                        <div class="h-8 w-px bg-zinc-700 hidden sm:block"></div>
                        <div>
                            <span class="text-xs text-red-400 font-black block uppercase">আজকের অফার প্রাইস</span>
                            <span class="text-3xl sm:text-4xl font-black text-red-500">৳{{ number_format($offerPrice) }}</span>
                        </div>
                        <span class="bg-gradient-to-r from-red-600 to-rose-600 text-white text-xs font-black px-3.5 py-1.5 rounded-full shadow-sm">
                            {{ $themeSettings['hero_discount_tag'] ?? '৳৫০০ সরাসরি ছাড়!' }}
                        </span>
                    </div>

                    <!-- Bullet Features Checklist -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 pt-1 text-left text-xs sm:text-sm text-slate-100 font-bold">
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-red-500 text-base"></i> ১৫০ পাউন্ড পর্যন্ত স্ট্যাকেবল রেজিস্ট্যান্স</div>
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-red-500 text-base"></i> ১০০% ন্যাচারাল অ্যান্টি-স্ন্যাপ ল্যাটেক্স টিউব</div>
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-red-500 text-base"></i> পার্সেল চেক করে ক্যাশ অন ডেলিভারি</div>
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-red-500 text-base"></i> ২ বছরের অফিসিয়াল রিপ্লেসমেন্ট ওয়ারেন্টি</div>
                    </div>

                    <!-- CTA Button -->
                    <div class="pt-2">
                        <a href="#fast-order-form" class="pulse-btn inline-flex items-center justify-center gap-3 bg-gradient-to-r from-red-600 to-rose-700 hover:from-red-700 hover:to-rose-800 text-white font-black text-lg px-8 py-4 rounded-xl shadow-xl transition transform hover:-translate-y-0.5 w-full sm:w-auto">
                            <i class="fas fa-bolt text-yellow-300"></i>
                            <span>{{ $themeSettings['hero_button_text'] ?? '👉 এখনই অর্ডার করুন (ক্যাশ অন ডেলিভারি)' }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. HIGH SPEED EXERCISE GALLERY -->
    <section class="max-w-6xl mx-auto px-4">
        <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
            <span class="text-xs uppercase font-extrabold text-red-500 tracking-widest">১০০+ ফুল বডি ওয়ার্কআউট</span>
            <h2 class="text-2xl sm:text-4xl font-black text-white">জিমের খরচ বাঁচিয়ে ঘরেই গড়ুন সুঠাম দেহ</h2>
            <p class="text-slate-300 font-medium text-sm">চেস্ট, আর্মস, ব্যাক, শোল্ডার ও লেগস — যেকোনো মাসল গ্রুপ টার্গেট করুন সহজে</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="bg-zinc-900 rounded-2xl border border-zinc-800 overflow-hidden shadow-lg group hover:border-red-600/50 transition">
                <div class="h-64 overflow-hidden bg-zinc-950 flex items-center justify-center p-4">
                    <img src="{{ $productImg1 }}" alt="১১-পিস রেজিস্ট্যান্স কিট" class="max-h-full object-contain group-hover:scale-105 transition duration-500">
                </div>
                <div class="p-5 text-center">
                    <h3 class="font-black text-base text-white mb-1">৫টি কালার কোডেড ব্যান্ড</h3>
                    <p class="text-xs text-slate-300 font-medium">১০ পাউন্ড থেকে ৫০ পাউন্ড পর্যন্ত আলাদা ও একসাথে মিলিয়ে ১৫০ পাউন্ড ওজন</p>
                </div>
            </div>

            <div class="bg-zinc-900 rounded-2xl border border-zinc-800 overflow-hidden shadow-lg group hover:border-red-600/50 transition">
                <div class="h-64 overflow-hidden bg-zinc-950 flex items-center justify-center p-4">
                    <img src="{{ $productImg2 }}" alt="কুশন হ্যান্ডেল ও ডোর অ্যাঙ্কর" class="max-h-full object-contain group-hover:scale-105 transition duration-500">
                </div>
                <div class="p-5 text-center">
                    <h3 class="font-black text-base text-white mb-1">হেভি ডিউটি ডোর অ্যাঙ্কর</h3>
                    <p class="text-xs text-slate-300 font-medium">ঘরের যেকোনো দরজায় সহজে লক করে চেস্ট প্রেস ও ল্যাট পুলডাউন করার সুবিধা</p>
                </div>
            </div>

            <div class="bg-zinc-900 rounded-2xl border border-zinc-800 overflow-hidden shadow-lg group hover:border-red-600/50 transition">
                <div class="h-64 overflow-hidden bg-zinc-950 flex items-center justify-center p-4">
                    <img src="{{ $productImg3 }}" alt="ফুল বডি এক্সারসাইজ" class="max-h-full object-contain group-hover:scale-105 transition duration-500">
                </div>
                <div class="p-5 text-center">
                    <h3 class="font-black text-base text-white mb-1">অ্যান্টি-স্ন্যাপ মেটাল হুক</h3>
                    <p class="text-xs text-slate-300 font-medium">মজবুত স্টিল কারাবিনার হুক যা শতভাগ নিরাপদ ও টানলে কখনো ছিঁড়বে না</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. TECHNICAL SPECIFICATIONS TABLE -->
    <section class="max-w-4xl mx-auto px-4">
        <div class="bg-zinc-900 rounded-3xl border-2 border-red-600/40 shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-zinc-900 via-red-950 to-zinc-900 text-white p-5 text-center border-b border-red-600/30">
                <h3 class="text-xl sm:text-2xl font-black text-red-400">ফিটনেস কিটের সম্পূর্ণ স্পেক্স ও প্যাকেজ তালিকা</h3>
                <p class="text-slate-300 text-xs mt-1">অর্ডার করার পূর্বে সেটের সকল আইটেম দেখে নিন</p>
            </div>
            <div class="p-6">
                <div class="divide-y divide-zinc-800 text-sm">
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-slate-300">টিউব উপাদান</span>
                        <span class="font-bold text-red-400">১০০% মালয়েশিয়ান ন্যাচারাল অ্যান্টি-স্ন্যাপ ল্যাটেক্স</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-slate-300">সর্বোচ্চ রেজিস্ট্যান্স শক্তি</span>
                        <span class="font-bold text-red-400">মোট ১৫০ পাউন্ড (১০, ২০, ৩০, ৪০, ৫০ পাউন্ড কম্বিনেশন)</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-slate-300">সেটের সামগ্রী (১১ পিস)</span>
                        <span class="font-bold text-red-400">৫টি ব্যান্ড, ২টি হ্যান্ডেল, ২টি অ্যাঙ্কেল স্ট্র্যাপ, ডোর অ্যাঙ্কর ও ব্যাগ</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-slate-300">কারাবিনার হুক</span>
                        <span class="font-bold text-red-400">হেভি ডিউটি অ্যান্টি-রাস্ট স্টেইনলেস স্টিল</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-slate-300">ফ্রি উপহার সামগ্রী</span>
                        <span class="font-bold text-red-400">ফুল কালার বাংলা এক্সারসাইজ চার্ট ও পোর্টেবল ক্যারি ব্যাগ</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-slate-300">অফিশিয়াল ওয়ারেন্টি</span>
                        <span class="font-bold text-red-400">২ বছরের টিউব রিপ্লেসমেন্ট ওয়ারেন্টি</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. TRUST & GUARANTEE PILLARS -->
    <section class="max-w-6xl mx-auto px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-zinc-900 p-5 rounded-2xl border border-zinc-800 shadow-sm text-center">
                <div class="w-12 h-12 mx-auto rounded-xl bg-red-950 text-red-400 flex items-center justify-center text-xl mb-3 border border-red-800">
                    <i class="fas fa-hand-holding-dollar"></i>
                </div>
                <h4 class="font-black text-base text-white mb-1">ক্যাশ অন ডেলিভারি</h4>
                <p class="text-xs text-slate-300 font-medium leading-relaxed">আগে ১ টাকাও অগ্রিম নয়, পার্সেল দেখে তারপর মূল্য দিন।</p>
            </div>

            <div class="bg-zinc-900 p-5 rounded-2xl border border-zinc-800 shadow-sm text-center">
                <div class="w-12 h-12 mx-auto rounded-xl bg-red-950 text-red-400 flex items-center justify-center text-xl mb-3 border border-red-800">
                    <i class="fas fa-shield-halved"></i>
                </div>
                <h4 class="font-black text-base text-white mb-1">২ বছরের গ্যারান্টি</h4>
                <p class="text-xs text-slate-300 font-medium leading-relaxed">কোনো টিউব বা হুক নষ্ট হলে ২ বছরের ফ্রি রিপ্লেসমেন্ট।</p>
            </div>

            <div class="bg-zinc-900 p-5 rounded-2xl border border-zinc-800 shadow-sm text-center">
                <div class="w-12 h-12 mx-auto rounded-xl bg-red-950 text-red-400 flex items-center justify-center text-xl mb-3 border border-red-800">
                    <i class="fas fa-truck-fast"></i>
                </div>
                <h4 class="font-black text-base text-white mb-1">সারা দেশে ডেলিভারি</h4>
                <p class="text-xs text-slate-300 font-medium leading-relaxed">ঢাকায় ২৪-৪৮ ঘণ্টায় এবং ঢাকার বাইরে ২-৩ দিনের মধ্যে ডেলিভারি।</p>
            </div>

            <div class="bg-zinc-900 p-5 rounded-2xl border border-zinc-800 shadow-sm text-center">
                <div class="w-12 h-12 mx-auto rounded-xl bg-red-950 text-red-400 flex items-center justify-center text-xl mb-3 border border-red-800">
                    <i class="fas fa-box-open"></i>
                </div>
                <h4 class="font-black text-base text-white mb-1">দেখে নেওয়ার সুযোগ</h4>
                <p class="text-xs text-slate-300 font-medium leading-relaxed">ডেলিভারিম্যানের সামনে প্যাকেট খুলে চেক করে নেয়ার সুবিধা।</p>
            </div>
        </div>
    </section>

    <!-- 5. VERIFIED CUSTOMER REVIEWS (SOCIAL PROOF) -->
    <section class="max-w-6xl mx-auto px-4">
        <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
            <span class="text-xs uppercase font-extrabold text-red-500 tracking-widest">ফিটনেস প্রেমীদের রিভিউ</span>
            <h2 class="text-2xl sm:text-4xl font-black text-white">আমাদের সন্তুষ্ট গ্রাহকদের ফিডব্যাক</h2>
            <div class="flex items-center justify-center gap-1 text-amber-400 text-sm">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                <span class="text-slate-300 font-bold ml-2">৪.৯/৫ (২৯০+ কাস্টমার রিভিউ)</span>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-zinc-900 p-5 rounded-2xl border border-zinc-800 shadow-md flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center gap-1 text-amber-400 text-xs">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-200 font-medium leading-relaxed">
                        "জিমে যাওয়ার সময় পেতাম না। এই কিট দিয়ে ঘরে বসেই বুক ও হাতের দারুণ এক্সারসাইজ করতে পারছি।"
                    </p>
                </div>
                <div class="pt-4 border-t border-zinc-800 flex items-center justify-between mt-4">
                    <div>
                        <h4 class="text-xs font-bold text-white">তাসলিম কবির</h4>
                        <span class="text-[11px] text-slate-400 font-medium">উত্তরা, ঢাকা</span>
                    </div>
                    <span class="text-[10px] bg-red-950 text-red-300 font-bold px-2 py-0.5 rounded-full border border-red-800">ভেরিফায়েড</span>
                </div>
            </div>

            <div class="bg-zinc-900 p-5 rounded-2xl border border-zinc-800 shadow-md flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center gap-1 text-amber-400 text-xs">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-200 font-medium leading-relaxed">
                        "ল্যাটেক্স রাবারের কোয়ালিটি অনেক হেভি। দরজায় আটকে সহজে ভারী টান দিয়ে বুক ও বাইসেপ ট্রেনিং করা যায়।"
                    </p>
                </div>
                <div class="pt-4 border-t border-zinc-800 flex items-center justify-between mt-4">
                    <div>
                        <h4 class="text-xs font-bold text-white">সাইদুর রহমান</h4>
                        <span class="text-[11px] text-slate-400 font-medium">ধানমন্ডি, ঢাকা</span>
                    </div>
                    <span class="text-[10px] bg-red-950 text-red-300 font-bold px-2 py-0.5 rounded-full border border-red-800">ভেরিফায়েড</span>
                </div>
            </div>

            <div class="bg-zinc-900 p-5 rounded-2xl border border-zinc-800 shadow-md flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center gap-1 text-amber-400 text-xs">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-200 font-medium leading-relaxed">
                        "প্যাকেটে ৫টি ব্যান্ডের টান আলাদা হওয়ায় প্রয়োজনমতো ওজন বাড়ানো যায়। ডাম্বেলের চেয়েও কার্যকর।"
                    </p>
                </div>
                <div class="pt-4 border-t border-zinc-800 flex items-center justify-between mt-4">
                    <div>
                        <h4 class="text-xs font-bold text-white">জুবায়ের হোসেন</h4>
                        <span class="text-[11px] text-slate-400 font-medium">চট্টগ্রাম সদর</span>
                    </div>
                    <span class="text-[10px] bg-red-950 text-red-300 font-bold px-2 py-0.5 rounded-full border border-red-800">ভেরিফায়েড</span>
                </div>
            </div>

            <div class="bg-zinc-900 p-5 rounded-2xl border border-zinc-800 shadow-md flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center gap-1 text-amber-400 text-xs">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-200 font-medium leading-relaxed">
                        "ক্যাশ অন ডেলিভারিতে চেক করে নিয়েছি। ক্যারি ব্যাগ ও গাইড চার্ট দুটোই সাথে ছিল। ১০০% রেকমেন্ডেড।"
                    </p>
                </div>
                <div class="pt-4 border-t border-zinc-800 flex items-center justify-between mt-4">
                    <div>
                        <h4 class="text-xs font-bold text-white">মেহেদী হাসান</h4>
                        <span class="text-[11px] text-slate-400 font-medium">সিলেট সদর</span>
                    </div>
                    <span class="text-[10px] bg-red-950 text-red-300 font-bold px-2 py-0.5 rounded-full border border-red-800">ভেরিফায়েড</span>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. HIGH CONVERTING 1-PAGE CASH ON DELIVERY CHECKOUT FORM -->
    <section id="fast-order-form" class="max-w-4xl mx-auto px-4 scroll-mt-20">
        <div class="bg-zinc-900 rounded-3xl border-4 border-red-600 shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-red-700 via-rose-700 to-red-800 text-white p-6 sm:p-8 text-center">
                <span class="inline-block bg-yellow-300 text-zinc-950 text-xs font-black uppercase px-3 py-1 rounded-full mb-2">
                    ⚡ সহজ ১-মিনিট ক্যাশ অন ডেলিভারি ফর্ম
                </span>
                <h3 class="text-2xl sm:text-4xl font-black">অর্ডার করতে নিচের তথ্যগুলো দিন</h3>
                <p class="text-red-100 text-xs sm:text-sm mt-1">অগ্রিম ১ টাকাও লাগবে না, পার্সেল হাতে পেয়ে দেখে মূল্য পরিশোধ করবেন</p>
            </div>

            <form action="{{ route('single.fast.order', $slug ?? ($store->slug ?? 'shop001')) }}" method="POST" class="p-6 sm:p-10 space-y-6" id="fitnessOrderForm">
                @csrf
                <input type="hidden" name="product_id" value="{{ $mainProduct->id ?? 1 }}">
                <input type="hidden" name="unit_price" id="fitness_unit_price" value="{{ $offerPrice }}">
                <input type="hidden" name="product_variant" id="fitness_selected_variant" value="১টি ১১-পিস কমপ্লিট কিট (৳১,৩৫০)">
                <input type="hidden" name="selected_package" id="fitness_selected_package" value="১টি ১১-পিস কিট">

                <!-- Step 1: Package Selection -->
                <div class="space-y-3">
                    <label class="block text-sm font-black text-red-400">
                        ১. প্যাকেজ নির্বাচন করুন <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <label class="relative flex items-center justify-between p-4 rounded-2xl border-2 border-red-500 bg-red-950/40 cursor-pointer package-card hover:bg-red-950/60 transition" onclick="selectFitnessPackage(1, {{ $offerPrice }}, '১টি ১১-পিস কমপ্লিট কিট', this)">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="pkg_choice" value="1" checked class="text-red-500 focus:ring-red-500">
                                <div>
                                    <span class="font-black text-white text-sm block">১টি ১১-পিস কমপ্লিট কিট</span>
                                    <span class="text-xs text-slate-300 font-medium">১৫০ পাউন্ড স্ট্যাকেবল রেজিস্ট্যান্স</span>
                                </div>
                            </div>
                            <span class="text-lg font-black text-red-400">৳{{ number_format($offerPrice) }}</span>
                        </label>

                        <label class="relative flex items-center justify-between p-4 rounded-2xl border-2 border-zinc-700 bg-zinc-900 cursor-pointer package-card hover:bg-red-950/40 transition" onclick="selectFitnessPackage(2, 2500, '২টি ফিটনেস কিট পার্টনার কম্বো (ফ্রি ডেলিভারি)', this)">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="pkg_choice" value="2" class="text-red-500 focus:ring-red-500">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-black text-white text-sm block">২টি কিট মেগা কম্বো</span>
                                        <span class="bg-red-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">ফ্রি ডেলিভারি</span>
                                    </div>
                                    <span class="text-xs text-slate-300 font-medium">৳২০০ ছাড় + ফ্রি হোম ডেলিভারি</span>
                                </div>
                            </div>
                            <span class="text-lg font-black text-red-400">৳২,৫০০</span>
                        </label>
                    </div>
                </div>

                <!-- Step 2: Customer Details (Inputs on crisp white background for readability) -->
                <div class="space-y-4 pt-2">
                    <label class="block text-sm font-black text-red-400">
                        ২. আপনার ডেলিভারি তথ্য দিন <span class="text-red-500">*</span>
                    </label>

                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1">আপনার পূর্ণ নাম *</label>
                        <input type="text" name="customer_name" required placeholder="যেমন: তাসলিম আহমেদ" class="w-full px-4 py-3 rounded-xl bg-white text-zinc-900 border-2 border-zinc-300 focus:border-red-500 focus:outline-none font-medium text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1">সচল মোবাইল নম্বর *</label>
                        <input type="tel" name="customer_phone" required placeholder="যেমন: 017xxxxxxxx" class="w-full px-4 py-3 rounded-xl bg-white text-zinc-900 border-2 border-zinc-300 focus:border-red-500 focus:outline-none font-medium text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1">সম্পূর্ণ ডেলিভারি ঠিকানা *</label>
                        <textarea name="customer_address" rows="2" required placeholder="যেমন: বাসা নং, রোড নং, থানা ও জেলার নাম" class="w-full px-4 py-3 rounded-xl bg-white text-zinc-900 border-2 border-zinc-300 focus:border-red-500 focus:outline-none font-medium text-sm"></textarea>
                    </div>

                    <!-- Delivery Area -->
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-2">ডেলিভারি এরিয়া বেছে নিন *</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <label class="flex items-center justify-between p-3.5 rounded-xl border-2 border-red-500 bg-red-950/40 cursor-pointer delivery-card transition" onclick="setFitnessDelivery({{ $dhakaCharge }}, this)">
                                <div class="flex items-center gap-2">
                                    <input type="radio" name="delivery_location" value="dhaka" checked class="text-red-500">
                                    <span class="text-xs sm:text-sm font-bold text-white">ঢাকা সিটির ভিতরে</span>
                                </div>
                                <span class="text-xs sm:text-sm font-bold text-red-400">৳{{ $dhakaCharge }}</span>
                            </label>

                            <label class="flex items-center justify-between p-3.5 rounded-xl border-2 border-zinc-700 bg-zinc-900 cursor-pointer delivery-card transition hover:bg-red-950/30" onclick="setFitnessDelivery({{ $outsideCharge }}, this)">
                                <div class="flex items-center gap-2">
                                    <input type="radio" name="delivery_location" value="outside" class="text-red-500">
                                    <span class="text-xs sm:text-sm font-bold text-white">ঢাকা সিটির বাইরে</span>
                                </div>
                                <span class="text-xs sm:text-sm font-bold text-red-400">৳{{ $outsideCharge }}</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Price Summary Box -->
                <div class="p-5 bg-zinc-950 rounded-2xl border-2 border-red-600/40 space-y-2 text-sm">
                    <div class="flex justify-between text-slate-300 font-medium">
                        <span>পণ্যের মূল্য:</span>
                        <span class="font-bold text-white" id="fitness_subtotal_text">৳{{ number_format($offerPrice) }}</span>
                    </div>
                    <div class="flex justify-between text-slate-300 font-medium">
                        <span>ডেলিভারি চার্জ:</span>
                        <span class="font-bold text-red-400" id="fitness_delivery_text">৳{{ $dhakaCharge }}</span>
                    </div>
                    <div class="h-px bg-zinc-800 my-1"></div>
                    <div class="flex justify-between text-base sm:text-lg font-black text-white">
                        <span>সর্বমোট প্রদেয় বিল:</span>
                        <span class="text-2xl font-black text-red-500" id="fitness_total_text">৳{{ number_format($offerPrice + $dhakaCharge) }}</span>
                    </div>
                </div>

                <button type="submit" class="pulse-btn w-full bg-gradient-to-r from-red-600 via-rose-600 to-red-700 hover:from-red-700 hover:to-rose-800 text-white font-black text-lg sm:text-xl py-4 rounded-2xl shadow-xl transition transform hover:-translate-y-0.5 flex items-center justify-center gap-3">
                    <i class="fas fa-lock text-yellow-300"></i>
                    <span>অর্ডার কনফার্ম করুন (ক্যাশ অন ডেলিভারি)</span>
                </button>
            </form>
        </div>
    </section>

    <!-- 7. FREQUENTLY ASKED QUESTIONS (FAQ) -->
    <section class="max-w-4xl mx-auto px-4 pb-12">
        <div class="text-center mb-8">
            <span class="text-xs uppercase font-extrabold text-red-500 tracking-widest">সাধারণ প্রশ্নোত্তর</span>
            <h2 class="text-2xl sm:text-3xl font-black text-white mt-1">সচরাচর জানতে চাওয়া প্রশ্ন ও উত্তর</h2>
        </div>

        <div class="space-y-3">
            <div class="bg-zinc-900 p-5 rounded-2xl border border-zinc-800 shadow-sm">
                <h4 class="font-black text-white text-sm sm:text-base flex items-center gap-2">
                    <i class="fas fa-question-circle text-red-500"></i> টানলে কি ব্যান্ড ছিঁড়ে যাওয়ার ভয় আছে?
                </h4>
                <p class="text-xs sm:text-sm text-slate-300 font-medium mt-2 leading-relaxed pl-6">
                    একদমই না! এটি ১০০% মালয়েশিয়ান ন্যাচারাল ল্যাটেক্স ও অ্যান্টি-স্ন্যাপ টেকনোলজিতে তৈরি। এতে ২ বছরের ফ্রি রিপ্লেসমেন্ট ওয়ারেন্টি রয়েছে।
                </p>
            </div>

            <div class="bg-zinc-900 p-5 rounded-2xl border border-zinc-800 shadow-sm">
                <h4 class="font-black text-white text-sm sm:text-base flex items-center gap-2">
                    <i class="fas fa-question-circle text-red-500"></i> আমি কি দরজায় আটকে ব্যায়াম করতে পারব?
                </h4>
                <p class="text-xs sm:text-sm text-slate-300 font-medium mt-2 leading-relaxed pl-6">
                    জী, সেটের সাথে প্রিমিয়াম ডোর অ্যাঙ্কর পাবেন যা ঘরের যেকোনো দরজায় আটকে অনায়াসে চেস্ট প্রেস, ব্যাক রো এবং শোল্ডার প্রেস করতে পারবেন।
                </p>
            </div>

            <div class="bg-zinc-900 p-5 rounded-2xl border border-zinc-800 shadow-sm">
                <h4 class="font-black text-white text-sm sm:text-base flex items-center gap-2">
                    <i class="fas fa-question-circle text-red-500"></i> ক্যাশ অন ডেলিভারিতে চেক করে নেওয়ার সুযোগ আছে?
                </h4>
                <p class="text-xs sm:text-sm text-slate-300 font-medium mt-2 leading-relaxed pl-6">
                    অবশ্যই! ডেলিভারিম্যান আসার পর প্যাকেট খুলে ১১টি পার্টস ও বাংলা গাইড চার্ট চেক করে নিশ্চিত হয়ে টাকা পরিশোধ করবেন।
                </p>
            </div>
        </div>
    </section>

</main>

<!-- FLOATING WHATSAPP BUTTON -->
<a href="https://wa.me/8801700000000?text=আসসালামু%20আলাইকুম!%20রেজিস্ট্যান্স%20ব্যান্ড%20কিট%20সম্পর্কে%20জানতে%20চাই" target="_blank" class="fixed bottom-20 right-4 z-40 bg-green-500 hover:bg-green-600 text-white p-3.5 rounded-full shadow-2xl flex items-center justify-center transition transform hover:scale-110" title="হোয়াটসঅ্যাপে কথা বলুন">
    <i class="fab fa-whatsapp text-3xl"></i>
</a>

<!-- MOBILE STICKY CTA -->
<div class="fixed bottom-0 left-0 right-0 z-30 sm:hidden bg-zinc-900/95 backdrop-blur-md border-t-2 border-red-600/50 p-3 shadow-2xl">
    <div class="flex items-center justify-between gap-3 max-w-md mx-auto">
        <div>
            <span class="text-[11px] text-slate-400 font-bold block">অফার প্রাইস</span>
            <span class="text-xl font-black text-red-500">৳{{ number_format($offerPrice) }}</span>
        </div>
        <a href="#fast-order-form" class="bg-red-600 hover:bg-red-700 text-white font-black text-sm px-5 py-2.5 rounded-xl shadow-lg transition flex items-center gap-1.5">
            <i class="fas fa-dumbbell"></i> এখনই কিনুন
        </a>
    </div>
</div>

<script>
    // Live Countdown Timer
    let fitnessHours = 4, fitnessMinutes = 15, fitnessSeconds = 28;
    setInterval(function() {
        if (fitnessSeconds > 0) {
            fitnessSeconds--;
        } else {
            fitnessSeconds = 59;
            if (fitnessMinutes > 0) {
                fitnessMinutes--;
            } else {
                fitnessMinutes = 59;
                if (fitnessHours > 0) fitnessHours--;
            }
        }
        document.getElementById('fitness_timer_hours').textContent = String(fitnessHours).padStart(2, '0');
        document.getElementById('fitness_timer_minutes').textContent = String(fitnessMinutes).padStart(2, '0');
        document.getElementById('fitness_timer_seconds').textContent = String(fitnessSeconds).padStart(2, '0');
    }, 1000);

    let currentFitnessSubtotal = {{ $offerPrice }};
    let currentFitnessDelivery = {{ $dhakaCharge }};
    let isFitnessFreeDelivery = false;

    function selectFitnessPackage(pkgId, price, label, el) {
        currentFitnessSubtotal = price;
        isFitnessFreeDelivery = (pkgId === 2);
        document.getElementById('fitness_unit_price').value = price;
        document.getElementById('fitness_selected_variant').value = label;
        document.getElementById('fitness_selected_package').value = label;

        document.querySelectorAll('.package-card').forEach(c => {
            c.classList.remove('border-red-500', 'bg-red-950/40');
            c.classList.add('border-zinc-700', 'bg-zinc-900');
        });
        el.classList.add('border-red-500', 'bg-red-950/40');
        el.classList.remove('border-zinc-700', 'bg-zinc-900');
        updateFitnessBill();
    }

    function setFitnessDelivery(charge, el) {
        currentFitnessDelivery = charge;
        document.querySelectorAll('.delivery-card').forEach(d => {
            d.classList.remove('border-red-500', 'bg-red-950/40');
            d.classList.add('border-zinc-700', 'bg-zinc-900');
        });
        el.classList.add('border-red-500', 'bg-red-950/40');
        el.classList.remove('border-zinc-700', 'bg-zinc-900');
        updateFitnessBill();
    }

    function updateFitnessBill() {
        let deliveryToApply = isFitnessFreeDelivery ? 0 : currentFitnessDelivery;
        let total = currentFitnessSubtotal + deliveryToApply;
        document.getElementById('fitness_subtotal_text').textContent = '৳' + currentFitnessSubtotal.toLocaleString();
        document.getElementById('fitness_delivery_text').textContent = isFitnessFreeDelivery ? 'ফ্রি (৳০)' : '৳' + deliveryToApply;
        document.getElementById('fitness_total_text').textContent = '৳' + total.toLocaleString();
    }
</script>
@endsection
