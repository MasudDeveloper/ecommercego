@extends('front_end.layouts.app')

@section('page-title')
    {{ $store->name ?? 'T9 Ultra Smartwatch & Wireless Earbuds Combo' }}
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
    $productTitle = $themeSettings['hero_title'] ?? 'T9 আল্ট্রা AMOLED ডিসপ্লে স্মার্টওয়াচ ও ANC নয়েজ ক্যানসেলিং ইয়ারবাডস কম্বো';
    $productDesc = $themeSettings['hero_subtitle'] ?? '২.০২ ইঞ্চি সুপার ব্রাইট কার্ভড ডিসপ্লে, ব্লুটুথ এইচডি কলিং, হার্ট রেট ও স্লিপ ট্র্যাকিং এবং ৭২ ঘণ্টার ব্যাটারি ব্যাকআপ। সাথে পাচ্ছেন সুপার বেস ওয়্যারলেস ইয়ারবাডস সম্পূর্ণ ফ্রি!';
    
    $regularPrice = $toNum($themeSettings['hero_regular_price'] ?? 2750, 2750);
    $offerPrice = $toNum($themeSettings['hero_offer_price'] ?? 1750, 1750);
    
    if ($regularPrice <= 0) $regularPrice = 2750;
    if ($offerPrice <= 0) $offerPrice = 1750;
    
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

<main class="space-y-12 sm:space-y-20 bg-slate-950 text-slate-100 font-sans">

    <!-- 1. CYBER TECH EDITORIAL HERO -->
    <section class="relative pt-10 sm:pt-16 pb-16 bg-gradient-to-b from-slate-900 via-slate-950 to-slate-900 border-b border-cyan-900/50">
        <div class="max-w-6xl mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                
                <!-- Left Portrait with neon cyber frame -->
                <div class="lg:col-span-5 flex justify-center order-2 lg:order-1">
                    <div class="relative p-3 bg-slate-900 rounded-3xl shadow-2xl border-4 border-cyan-500/60 max-w-sm w-full">
                        <div class="absolute -top-3.5 -right-3.5 bg-cyan-500 text-slate-950 font-extrabold text-xs uppercase px-3.5 py-1.5 rounded-full shadow-lg tracking-wider animate-pulse">
                            PREMIUM EDITION 2026
                        </div>
                        <img src="{{ $productImg1 }}" alt="{{ $productTitle }}" class="w-full h-[380px] object-cover rounded-2xl shadow-inner">
                        <div class="mt-3 text-center text-xs font-mono text-cyan-300 font-bold bg-slate-800/80 py-2 px-3 rounded-xl border border-cyan-500/30">
                            ✦ ১টি স্মার্টওয়াচ + ১টি ANC ইয়ারবাডস কম্বো অফার ✦
                        </div>
                    </div>
                </div>

                <!-- Right Editorial Text -->
                <div class="lg:col-span-7 space-y-5 text-center lg:text-left order-1 lg:order-2">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-cyan-950/80 text-cyan-300 text-xs sm:text-sm font-black border border-cyan-500/40 shadow-sm">
                        <i class="fas fa-bolt text-yellow-400"></i>
                        <span>{{ $themeSettings['hero_badge'] ?? '⚡ স্মার্ট লাইফস্টাইল কম্বো গ্যাজেট ধামাকা' }}</span>
                    </div>

                    <h1 class="text-3xl sm:text-5xl font-black text-white leading-tight">
                        {{ $productTitle }}
                    </h1>

                    <p class="text-slate-200 text-base sm:text-lg leading-relaxed font-medium">
                        {{ $productDesc }}
                    </p>

                    <!-- Urgent Countdown Timer -->
                    <div class="p-3.5 bg-gradient-to-r from-cyan-600 via-blue-600 to-indigo-700 text-white rounded-2xl shadow-lg flex flex-wrap items-center justify-between gap-3 border border-cyan-400/40">
                        <div class="flex items-center gap-2 font-bold text-xs sm:text-sm">
                            <span class="inline-block w-2.5 h-2.5 bg-yellow-300 rounded-full animate-ping"></span>
                            <span>🔥 স্টক শেষ হওয়ার পূর্বে সীমিত সময়ের অফার:</span>
                        </div>
                        <div class="flex items-center gap-1.5 text-xs sm:text-sm font-black text-slate-950 font-mono">
                            <span class="bg-white px-2 py-1 rounded shadow text-cyan-700 font-bold" id="gadget_timer_hours">03</span> :
                            <span class="bg-white px-2 py-1 rounded shadow text-cyan-700 font-bold" id="gadget_timer_minutes">49</span> :
                            <span class="bg-white px-2 py-1 rounded shadow text-cyan-700 font-bold" id="gadget_timer_seconds">15</span>
                        </div>
                    </div>

                    <!-- Price Badge -->
                    <div class="inline-flex flex-wrap items-center gap-6 p-4 rounded-2xl bg-slate-900 border-2 border-cyan-500/50 shadow-md">
                        <div>
                            <span class="text-xs text-slate-400 block font-bold uppercase">রেগুলার প্রাইস</span>
                            <span class="text-xl font-extrabold text-slate-400 line-through">৳{{ number_format($regularPrice) }}</span>
                        </div>
                        <div class="h-8 w-px bg-slate-700 hidden sm:block"></div>
                        <div>
                            <span class="text-xs text-cyan-400 font-black block uppercase">আজকের অফার প্রাইস</span>
                            <span class="text-3xl sm:text-4xl font-black text-cyan-300">৳{{ number_format($offerPrice) }}</span>
                        </div>
                        <span class="bg-gradient-to-r from-red-600 to-rose-600 text-white text-xs font-black px-3.5 py-1.5 rounded-full shadow-sm">
                            {{ $themeSettings['hero_discount_tag'] ?? '৳১,০০০ সরাসরি ছাড়!' }}
                        </span>
                    </div>

                    <!-- Bullet Features Checklist -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 pt-1 text-left text-xs sm:text-sm text-slate-100 font-bold">
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-cyan-400 text-base"></i> ২.০২" কার্ভড ফুল এইচডি ডিসপ্লে</div>
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-cyan-400 text-base"></i> সরাসরি কথা বলার ব্লুটুথ কলিং</div>
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-cyan-400 text-base"></i> পার্সেল চেক করে পেমেন্টের সুযোগ</div>
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-cyan-400 text-base"></i> ১ বছরের ব্র্যান্ড রিপ্লেসমেন্ট ওয়ারেন্টি</div>
                    </div>

                    <!-- CTA Button -->
                    <div class="pt-2">
                        <a href="#fast-order-form" class="pulse-btn inline-flex items-center justify-center gap-3 bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 text-slate-950 font-black text-lg px-8 py-4 rounded-xl shadow-xl transition transform hover:-translate-y-0.5 w-full sm:w-auto">
                            <i class="fas fa-shopping-cart"></i>
                            <span>{{ $themeSettings['hero_button_text'] ?? '👉 এখনই অর্ডার করুন (ক্যাশ অন ডেলিভারি)' }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. HIGH TECH FEATURES GALLERY -->
    <section class="max-w-6xl mx-auto px-4">
        <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
            <span class="text-xs uppercase font-extrabold text-cyan-400 tracking-widest">ফ্লাগশিপ পারফরম্যান্স ও বিল্ড</span>
            <h2 class="text-2xl sm:text-4xl font-black text-white">এক নজরে আধুনিক গ্যাজেট ফিচারসমূহ</h2>
            <p class="text-slate-300 font-medium text-sm">দৈনন্দিন অফিস, জিম, স্পোর্টস ও আউটডোর ব্যবহারের জন্য সেরা কম্বো</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="bg-slate-900 rounded-2xl border-2 border-slate-800 overflow-hidden shadow-lg group hover:border-cyan-500/50 transition">
                <div class="h-64 overflow-hidden bg-slate-950 flex items-center justify-center p-4">
                    <img src="{{ $productImg1 }}" alt="স্মার্টওয়াচ ডিসপ্লে" class="max-h-full object-contain group-hover:scale-105 transition duration-500">
                </div>
                <div class="p-5 text-center">
                    <h3 class="font-black text-base text-white mb-1">সুপার ব্রাইট AMOLED ডিসপ্লে</h3>
                    <p class="text-xs text-slate-300 font-medium">দিনের প্রখর রোদেও পরিষ্কার দেখা যায় এবং ৬০Hz রিফ্রেশ রেটে স্মুথ স্ক্রলিং</p>
                </div>
            </div>

            <div class="bg-slate-900 rounded-2xl border-2 border-slate-800 overflow-hidden shadow-lg group hover:border-cyan-500/50 transition">
                <div class="h-64 overflow-hidden bg-slate-950 flex items-center justify-center p-4">
                    <img src="{{ $productImg2 }}" alt="ব্লুটুথ কলিং ও সেন্সর" class="max-h-full object-contain group-hover:scale-105 transition duration-500">
                </div>
                <div class="p-5 text-center">
                    <h3 class="font-black text-base text-white mb-1">এইচডি মাইক্রোফোন ও কলিং</h3>
                    <p class="text-xs text-slate-300 font-medium">মোবাইল পকেটে রেখেই সরাসরি ঘড়ি দিয়ে কল রিসিভ ও কথা বলার সুবিধা</p>
                </div>
            </div>

            <div class="bg-slate-900 rounded-2xl border-2 border-slate-800 overflow-hidden shadow-lg group hover:border-cyan-500/50 transition">
                <div class="h-64 overflow-hidden bg-slate-950 flex items-center justify-center p-4">
                    <img src="{{ $productImg3 }}" alt="ANC ইয়ারবাডস" class="max-h-full object-contain group-hover:scale-105 transition duration-500">
                </div>
                <div class="p-5 text-center">
                    <h3 class="font-black text-base text-white mb-1">ANC সুপার বেস ইয়ারবাডস</h3>
                    <p class="text-xs text-slate-300 font-medium">নয়েজ ক্যানসেলিং, টাচ কন্ট্রোল এবং ৩৬ ঘণ্টার টোটাল প্লেটাইম ব্যাকআপ</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. TECHNICAL SPECIFICATIONS TABLE -->
    <section class="max-w-4xl mx-auto px-4">
        <div class="bg-slate-900 rounded-3xl border-2 border-cyan-500/40 shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-slate-900 via-cyan-950 to-slate-900 text-white p-5 text-center border-b border-cyan-500/30">
                <h3 class="text-xl sm:text-2xl font-black text-cyan-300">স্মার্টওয়াচ ও ইয়ারবাডস টেকনিক্যাল স্পেসিফিকেশন</h3>
                <p class="text-slate-300 text-xs mt-1">অর্ডার করার পূর্বে ডিভাইসের সকল স্পেক্স দেখে নিন</p>
            </div>
            <div class="p-6">
                <div class="divide-y divide-slate-800 text-sm">
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-slate-300">ডিসপ্লে সাইজ ও টাইপ</span>
                        <span class="font-bold text-cyan-400">২.০২ ইঞ্চি এইচডি কার্ভড স্ক্রিন (60Hz)</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-slate-300">ব্যাটারি লাইফ</span>
                        <span class="font-bold text-cyan-400">৫-৭ দিন একটানা ব্যাকআপ (ম্যাগনেটিক ফাস্ট চার্জ)</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-slate-300">কানেক্টিভিটি</span>
                        <span class="font-bold text-cyan-400">ব্লুটুথ ৫.৩ (Android ও iOS উভয়ের সাথে উপযোগী)</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-slate-300">হেলথ সেন্সর</span>
                        <span class="font-bold text-cyan-400">হার্ট রেট, ব্লাড প্রেশার, SpO2 ও স্লিপ ট্র্যাকিং</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-slate-300">ওয়াটারপ্রুফ রেটিং</span>
                        <span class="font-bold text-cyan-400">IP68 ডাস্ট ও সোয়েট রেজিস্ট্যান্ট</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-slate-300">অফিশিয়াল ওয়ারেন্টি</span>
                        <span class="font-bold text-cyan-400">১ বছরের ব্র্যান্ড রিপ্লেসমেন্ট ওয়ারেন্টি</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. TRUST & GUARANTEE PILLARS -->
    <section class="max-w-6xl mx-auto px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-slate-900 p-5 rounded-2xl border border-slate-800 shadow-sm text-center">
                <div class="w-12 h-12 mx-auto rounded-xl bg-cyan-950 text-cyan-400 flex items-center justify-center text-xl mb-3 border border-cyan-800">
                    <i class="fas fa-hand-holding-dollar"></i>
                </div>
                <h4 class="font-black text-base text-white mb-1">ক্যাশ অন ডেলিভারি</h4>
                <p class="text-xs text-slate-300 font-medium leading-relaxed">আগে কোনো টাকা অগ্রিম নয়, হাতে পণ্য পেয়ে পরীক্ষা করে পরিশোধ করুন।</p>
            </div>

            <div class="bg-slate-900 p-5 rounded-2xl border border-slate-800 shadow-sm text-center">
                <div class="w-12 h-12 mx-auto rounded-xl bg-cyan-950 text-cyan-400 flex items-center justify-center text-xl mb-3 border border-cyan-800">
                    <i class="fas fa-shield-halved"></i>
                </div>
                <h4 class="font-black text-base text-white mb-1">১ বছরের ওয়ারেন্টি</h4>
                <p class="text-xs text-slate-300 font-medium leading-relaxed">যেকোনো টেকনিক্যাল সমস্যায় ১ বছরের সহজ রিপ্লেসমেন্ট সুবিধা।</p>
            </div>

            <div class="bg-slate-900 p-5 rounded-2xl border border-slate-800 shadow-sm text-center">
                <div class="w-12 h-12 mx-auto rounded-xl bg-cyan-950 text-cyan-400 flex items-center justify-center text-xl mb-3 border border-cyan-800">
                    <i class="fas fa-truck-fast"></i>
                </div>
                <h4 class="font-black text-base text-white mb-1">দ্রুততম হোম ডেলিভারি</h4>
                <p class="text-xs text-slate-300 font-medium leading-relaxed">ঢাকায় ২৪ ঘণ্টায় এবং ঢাকার বাইরে ৪৮-৭২ ঘণ্টার ভেতর ডেলিভারি।</p>
            </div>

            <div class="bg-slate-900 p-5 rounded-2xl border border-slate-800 shadow-sm text-center">
                <div class="w-12 h-12 mx-auto rounded-xl bg-cyan-950 text-cyan-400 flex items-center justify-center text-xl mb-3 border border-cyan-800">
                    <i class="fas fa-box-open"></i>
                </div>
                <h4 class="font-black text-base text-white mb-1">প্যাকেট খুলে চেক</h4>
                <p class="text-xs text-slate-300 font-medium leading-relaxed">ডেলিভারিম্যানের সামনে প্যাকেট খুলে গ্যাজেট চেক করে নেয়ার পূর্ণ সুযোগ।</p>
            </div>
        </div>
    </section>

    <!-- 5. VERIFIED CUSTOMER REVIEWS (SOCIAL PROOF) -->
    <section class="max-w-6xl mx-auto px-4">
        <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
            <span class="text-xs uppercase font-extrabold text-cyan-400 tracking-widest">ভেরিফায়েড ক্রেতাদের অভিজ্ঞতা</span>
            <h2 class="text-2xl sm:text-4xl font-black text-white">সন্তুষ্ট গ্রাহকদের ফিডব্যাক ও রিভিউ</h2>
            <div class="flex items-center justify-center gap-1 text-amber-400 text-sm">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                <span class="text-slate-300 font-bold ml-2">৪.৯/৫ (৩২০+ কাস্টমার রিভিউ)</span>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-slate-900 p-5 rounded-2xl border border-slate-800 shadow-md flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center gap-1 text-amber-400 text-xs">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-200 font-medium leading-relaxed">
                        "ডিসপ্লে কোয়ালিটি জাস্ট আগুন! ব্যাটারি ব্যাকআপ প্রায় ৬ দিন পেয়েছি। ব্লুটুথ কলিং এর সাউন্ড খুব ক্লিয়ার।"
                    </p>
                </div>
                <div class="pt-4 border-t border-slate-800 flex items-center justify-between mt-4">
                    <div>
                        <h4 class="text-xs font-bold text-white">আরিফুল ইসলাম</h4>
                        <span class="text-[11px] text-slate-400 font-medium">মিরপুর ১০, ঢাকা</span>
                    </div>
                    <span class="text-[10px] bg-cyan-950 text-cyan-300 font-bold px-2 py-0.5 rounded-full border border-cyan-800">ভেরিফায়েড</span>
                </div>
            </div>

            <div class="bg-slate-900 p-5 rounded-2xl border border-slate-800 shadow-md flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center gap-1 text-amber-400 text-xs">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-200 font-medium leading-relaxed">
                        "ফ্রি যে ইয়ারবাডসটা দিয়েছে সেটার বেস দারুণ। ২ দিনের মধ্যে খুলনাতে ডেলিভারি হাতে পেয়েছি।"
                    </p>
                </div>
                <div class="pt-4 border-t border-slate-800 flex items-center justify-between mt-4">
                    <div>
                        <h4 class="text-xs font-bold text-white">তানভীর হাসান</h4>
                        <span class="text-[11px] text-slate-400 font-medium">খুলনা সদর</span>
                    </div>
                    <span class="text-[10px] bg-cyan-950 text-cyan-300 font-bold px-2 py-0.5 rounded-full border border-cyan-800">ভেরিফায়েড</span>
                </div>
            </div>

            <div class="bg-slate-900 p-5 rounded-2xl border border-slate-800 shadow-md flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center gap-1 text-amber-400 text-xs">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-200 font-medium leading-relaxed">
                        "ঘড়িটার মেটাল বিল্ড কোয়ালিটি অনেক সলিড। অ্যাপ কানেক্ট করা খুব সহজ। ফুল ভ্যালু ফর মানি গ্যাজেট!"
                    </p>
                </div>
                <div class="pt-4 border-t border-slate-800 flex items-center justify-between mt-4">
                    <div>
                        <h4 class="text-xs font-bold text-white">সাজ্জাদ হোসাইন</h4>
                        <span class="text-[11px] text-slate-400 font-medium">কুমিল্লা ক্যান্টনমেন্ট</span>
                    </div>
                    <span class="text-[10px] bg-cyan-950 text-cyan-300 font-bold px-2 py-0.5 rounded-full border border-cyan-800">ভেরিফায়েড</span>
                </div>
            </div>

            <div class="bg-slate-900 p-5 rounded-2xl border border-slate-800 shadow-md flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center gap-1 text-amber-400 text-xs">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-200 font-medium leading-relaxed">
                        "ক্যাশ অন ডেলিভারিতে প্যাকেট খুলে চেক করে তারপর টাকা দিয়েছি। ১০০% জেনুইন অরিজিনাল গ্যাজেট।"
                    </p>
                </div>
                <div class="pt-4 border-t border-slate-800 flex items-center justify-between mt-4">
                    <div>
                        <h4 class="text-xs font-bold text-white">রাশেদ করিম</h4>
                        <span class="text-[11px] text-slate-400 font-medium">বগুড়া সদর</span>
                    </div>
                    <span class="text-[10px] bg-cyan-950 text-cyan-300 font-bold px-2 py-0.5 rounded-full border border-cyan-800">ভেরিফায়েড</span>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. HIGH CONVERTING 1-PAGE CASH ON DELIVERY CHECKOUT FORM -->
    <section id="fast-order-form" class="max-w-4xl mx-auto px-4 scroll-mt-20">
        <div class="bg-slate-900 rounded-3xl border-4 border-cyan-500 shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-cyan-600 via-blue-600 to-indigo-700 text-white p-6 sm:p-8 text-center">
                <span class="inline-block bg-yellow-300 text-slate-950 text-xs font-black uppercase px-3 py-1 rounded-full mb-2">
                    ⚡ সহজ ১-মিনিট ক্যাশ অন ডেলিভারি ফর্ম
                </span>
                <h3 class="text-2xl sm:text-4xl font-black">অর্ডার করতে নিচের তথ্যগুলো পূরণ করুন</h3>
                <p class="text-cyan-100 text-xs sm:text-sm mt-1">অগ্রিম ১ টাকাও লাগবে না, ডেলিভারি হাতে পেয়ে চেক করে টাকা দিন</p>
            </div>

            <form action="{{ route('single.fast.order', $slug ?? ($store->slug ?? 'shop001')) }}" method="POST" class="p-6 sm:p-10 space-y-6" id="gadgetOrderForm">
                @csrf
                <input type="hidden" name="product_id" value="{{ $mainProduct->id ?? 1 }}">
                <input type="hidden" name="unit_price" id="gadget_unit_price" value="{{ $offerPrice }}">
                <input type="hidden" name="product_variant" id="gadget_selected_variant" value="মিডনাইট ব্ল্যাক (১টি স্মার্টওয়াচ + ১টি ইয়ারবাডস)">
                <input type="hidden" name="selected_color" id="gadget_selected_color" value="মিডনাইট ব্ল্যাক">
                <input type="hidden" name="selected_package" id="gadget_selected_package" value="১টি স্মার্টওয়াচ + ১টি ইয়ারবাডস">

                <!-- Step 1: Package Selection -->
                <div class="space-y-3">
                    <label class="block text-sm font-black text-cyan-300">
                        ১. প্যাকেজ নির্বাচন করুন <span class="text-red-400">*</span>
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <label class="relative flex items-center justify-between p-4 rounded-2xl border-2 border-cyan-400 bg-cyan-950/40 cursor-pointer package-card hover:bg-cyan-950/60 transition" onclick="selectGadgetPackage(1, {{ $offerPrice }}, '১টি স্মার্টওয়াচ + ১টি ইয়ারবাডস', this)">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="pkg_choice" value="1" checked class="text-cyan-400 focus:ring-cyan-500">
                                <div>
                                    <span class="font-black text-white text-sm block">১টি স্মার্টওয়াচ + ১টি ফ্রি ইয়ারবাডস</span>
                                    <span class="text-xs text-slate-300 font-medium">ধামাকা কম্বো অফার</span>
                                </div>
                            </div>
                            <span class="text-lg font-black text-cyan-300">৳{{ number_format($offerPrice) }}</span>
                        </label>

                        <label class="relative flex items-center justify-between p-4 rounded-2xl border-2 border-slate-700 bg-slate-900 cursor-pointer package-card hover:bg-cyan-950/40 transition" onclick="selectGadgetPackage(2, 3290, '২টি স্মার্টওয়াচ + ২টি ইয়ারবাডস (ফ্রি ডেলিভারি)', this)">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="pkg_choice" value="2" class="text-cyan-400 focus:ring-cyan-500">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-black text-white text-sm block">২টি স্মার্টওয়াচ + ২টি ইয়ারবাডস</span>
                                        <span class="bg-red-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">ফ্রি ডেলিভারি</span>
                                    </div>
                                    <span class="text-xs text-slate-300 font-medium">৳২১০ সেভ + ফ্রি হোম ডেলিভারি</span>
                                </div>
                            </div>
                            <span class="text-lg font-black text-cyan-300">৳৩,২৯০</span>
                        </label>
                    </div>
                </div>

                <!-- Step 2: Color Selection -->
                <div class="space-y-3">
                    <label class="block text-sm font-black text-cyan-300">
                        ২. ঘড়ির কালার বেছে নিন <span class="text-red-400">*</span>
                    </label>
                    <div class="grid grid-cols-3 gap-3">
                        <button type="button" class="gadget-color-btn py-3 px-3 rounded-xl border-2 border-cyan-400 bg-cyan-950/60 text-cyan-200 font-bold text-xs sm:text-sm flex items-center justify-center gap-2 shadow-sm transition" onclick="setGadgetColor('মিডনাইট ব্ল্যাক', this)">
                            <span class="w-3.5 h-3.5 rounded-full bg-black border border-slate-500"></span>
                            <span>মিডনাইট ব্ল্যাক</span>
                        </button>
                        <button type="button" class="gadget-color-btn py-3 px-3 rounded-xl border-2 border-slate-700 bg-slate-800 text-slate-200 font-bold text-xs sm:text-sm flex items-center justify-center gap-2 transition hover:border-cyan-500/50" onclick="setGadgetColor('টাইটানিয়াম গ্রে', this)">
                            <span class="w-3.5 h-3.5 rounded-full bg-slate-400 border border-slate-300"></span>
                            <span>টাইটানিয়াম গ্রে</span>
                        </button>
                        <button type="button" class="gadget-color-btn py-3 px-3 rounded-xl border-2 border-slate-700 bg-slate-800 text-slate-200 font-bold text-xs sm:text-sm flex items-center justify-center gap-2 transition hover:border-cyan-500/50" onclick="setGadgetColor('ওশান অরেঞ্জ', this)">
                            <span class="w-3.5 h-3.5 rounded-full bg-orange-500 border border-white"></span>
                            <span>ওশান অরেঞ্জ</span>
                        </button>
                    </div>
                </div>

                <!-- Step 3: Customer Details (Inputs on crisp white background for readability) -->
                <div class="space-y-4 pt-2">
                    <label class="block text-sm font-black text-cyan-300">
                        ৩. আপনার ডেলিভারি ঠিকানা দিন <span class="text-red-400">*</span>
                    </label>

                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1">আপনার পূর্ণ নাম *</label>
                        <input type="text" name="customer_name" required placeholder="যেমন: তানভীর আহমেদ" class="w-full px-4 py-3 rounded-xl bg-white text-slate-900 border-2 border-slate-300 focus:border-cyan-500 focus:outline-none font-medium text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1">সচল মোবাইল নম্বর *</label>
                        <input type="tel" name="customer_phone" required placeholder="যেমন: 017xxxxxxxx" class="w-full px-4 py-3 rounded-xl bg-white text-slate-900 border-2 border-slate-300 focus:border-cyan-500 focus:outline-none font-medium text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1">সম্পূর্ণ ডেলিভারি ঠিকানা *</label>
                        <textarea name="customer_address" rows="2" required placeholder="যেমন: বাসা নং, রোড নং, থানা ও জেলার নাম" class="w-full px-4 py-3 rounded-xl bg-white text-slate-900 border-2 border-slate-300 focus:border-cyan-500 focus:outline-none font-medium text-sm"></textarea>
                    </div>

                    <!-- Delivery Area -->
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-2">ডেলিভারি এরিয়া বেছে নিন *</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <label class="flex items-center justify-between p-3.5 rounded-xl border-2 border-cyan-400 bg-cyan-950/40 cursor-pointer delivery-card transition" onclick="setGadgetDelivery({{ $dhakaCharge }}, this)">
                                <div class="flex items-center gap-2">
                                    <input type="radio" name="delivery_location" value="dhaka" checked class="text-cyan-400">
                                    <span class="text-xs sm:text-sm font-bold text-white">ঢাকা সিটির ভিতরে</span>
                                </div>
                                <span class="text-xs sm:text-sm font-bold text-cyan-300">৳{{ $dhakaCharge }}</span>
                            </label>

                            <label class="flex items-center justify-between p-3.5 rounded-xl border-2 border-slate-700 bg-slate-900 cursor-pointer delivery-card transition hover:bg-cyan-950/30" onclick="setGadgetDelivery({{ $outsideCharge }}, this)">
                                <div class="flex items-center gap-2">
                                    <input type="radio" name="delivery_location" value="outside" class="text-cyan-400">
                                    <span class="text-xs sm:text-sm font-bold text-white">ঢাকা সিটির বাইরে</span>
                                </div>
                                <span class="text-xs sm:text-sm font-bold text-cyan-300">৳{{ $outsideCharge }}</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Price Summary Box -->
                <div class="p-5 bg-slate-950 rounded-2xl border-2 border-cyan-500/40 space-y-2 text-sm">
                    <div class="flex justify-between text-slate-300 font-medium">
                        <span>কম্বো মূল্য:</span>
                        <span class="font-bold text-white" id="gadget_subtotal_text">৳{{ number_format($offerPrice) }}</span>
                    </div>
                    <div class="flex justify-between text-slate-300 font-medium">
                        <span>ডেলিভারি চার্জ:</span>
                        <span class="font-bold text-cyan-400" id="gadget_delivery_text">৳{{ $dhakaCharge }}</span>
                    </div>
                    <div class="h-px bg-slate-800 my-1"></div>
                    <div class="flex justify-between text-base sm:text-lg font-black text-white">
                        <span>সর্বমোট প্রদেয় বিল:</span>
                        <span class="text-2xl font-black text-cyan-300" id="gadget_total_text">৳{{ number_format($offerPrice + $dhakaCharge) }}</span>
                    </div>
                </div>

                <button type="submit" class="pulse-btn w-full bg-gradient-to-r from-cyan-500 via-blue-600 to-indigo-600 hover:from-cyan-400 hover:to-indigo-500 text-slate-950 font-black text-lg sm:text-xl py-4 rounded-2xl shadow-xl transition transform hover:-translate-y-0.5 flex items-center justify-center gap-3">
                    <i class="fas fa-lock text-slate-950"></i>
                    <span>অর্ডার কনফার্ম করুন (ক্যাশ অন ডেলিভারি)</span>
                </button>
            </form>
        </div>
    </section>

    <!-- 7. FREQUENTLY ASKED QUESTIONS (FAQ) -->
    <section class="max-w-4xl mx-auto px-4 pb-12">
        <div class="text-center mb-8">
            <span class="text-xs uppercase font-extrabold text-cyan-400 tracking-widest">সাধারণ প্রশ্নোত্তর</span>
            <h2 class="text-2xl sm:text-3xl font-black text-white mt-1">সচরাচর জানতে চাওয়া প্রশ্ন ও উত্তর</h2>
        </div>

        <div class="space-y-3">
            <div class="bg-slate-900 p-5 rounded-2xl border border-slate-800 shadow-sm">
                <h4 class="font-black text-white text-sm sm:text-base flex items-center gap-2">
                    <i class="fas fa-question-circle text-cyan-400"></i> ঘড়িটি কি সব ধরণের ফোনে কানেক্ট হবে?
                </h4>
                <p class="text-xs sm:text-sm text-slate-300 font-medium mt-2 leading-relaxed pl-6">
                    জী, এটি যেকোনো অ্যান্ড্রয়েড (Android) অথবা অ্যাপল আইফোন (iOS)-এর সাথে ব্লুটুথ ৫.৩ দিয়ে দ্রুত কানেক্ট করা যায়।
                </p>
            </div>

            <div class="bg-slate-900 p-5 rounded-2xl border border-slate-800 shadow-sm">
                <h4 class="font-black text-white text-sm sm:text-base flex items-center gap-2">
                    <i class="fas fa-question-circle text-cyan-400"></i> ডেলিভারিম্যানের সামনে কি চেক করার সুযোগ আছে?
                </h4>
                <p class="text-xs sm:text-sm text-slate-300 font-medium mt-2 leading-relaxed pl-6">
                    হ্যাঁ, ডেলিভারিম্যান পার্সেল নিয়ে আসার পর প্যাকেট খুলে স্মার্টওয়াচ ও ইয়ারবাডস চেক করে তারপর ক্যাশ অন ডেলিভারিতে পেমেন্ট করবেন।
                </p>
            </div>

            <div class="bg-slate-900 p-5 rounded-2xl border border-slate-800 shadow-sm">
                <h4 class="font-black text-white text-sm sm:text-base flex items-center gap-2">
                    <i class="fas fa-question-circle text-cyan-400"></i> কোনো ত্রুটি থাকলে কি ওয়ারেন্টি পাব?
                </h4>
                <p class="text-xs sm:text-sm text-slate-300 font-medium mt-2 leading-relaxed pl-6">
                    অবশ্যই! আমাদের প্রতিটি কম্বোর সাথে রয়েছে ১ বছরের অফিসিয়াল ব্র্যান্ড রিপ্লেসমেন্ট ওয়ারেন্টি ও সার্বক্ষণিক হেল্পলাইন সাপোর্ট।
                </p>
            </div>
        </div>
    </section>

</main>

<!-- FLOATING WHATSAPP BUTTON -->
<a href="https://wa.me/8801700000000?text=আসসালামু%20আলাইকুম!%20স্মার্টওয়াচ%20কম্বো%20সম্পর্কে%20জানতে%20চাই" target="_blank" class="fixed bottom-20 right-4 z-40 bg-green-500 hover:bg-green-600 text-white p-3.5 rounded-full shadow-2xl flex items-center justify-center transition transform hover:scale-110" title="হোয়াটসঅ্যাপে কথা বলুন">
    <i class="fab fa-whatsapp text-3xl"></i>
</a>

<!-- MOBILE STICKY CTA -->
<div class="fixed bottom-0 left-0 right-0 z-30 sm:hidden bg-slate-900/95 backdrop-blur-md border-t-2 border-cyan-500/50 p-3 shadow-2xl">
    <div class="flex items-center justify-between gap-3 max-w-md mx-auto">
        <div>
            <span class="text-[11px] text-slate-400 font-bold block">অফার প্রাইস (কম্বো)</span>
            <span class="text-xl font-black text-cyan-300">৳{{ number_format($offerPrice) }}</span>
        </div>
        <a href="#fast-order-form" class="bg-gradient-to-r from-cyan-500 to-blue-600 text-slate-950 font-black text-sm px-5 py-2.5 rounded-xl shadow-lg transition flex items-center gap-1.5">
            <i class="fas fa-shopping-cart"></i> এখনই কিনুন
        </a>
    </div>
</div>

<script>
    // Live Countdown Timer
    let gadgetHours = 3, gadgetMinutes = 49, gadgetSeconds = 15;
    setInterval(function() {
        if (gadgetSeconds > 0) {
            gadgetSeconds--;
        } else {
            gadgetSeconds = 59;
            if (gadgetMinutes > 0) {
                gadgetMinutes--;
            } else {
                gadgetMinutes = 59;
                if (gadgetHours > 0) gadgetHours--;
            }
        }
        document.getElementById('gadget_timer_hours').textContent = String(gadgetHours).padStart(2, '0');
        document.getElementById('gadget_timer_minutes').textContent = String(gadgetMinutes).padStart(2, '0');
        document.getElementById('gadget_timer_seconds').textContent = String(gadgetSeconds).padStart(2, '0');
    }, 1000);

    let currentGadgetSubtotal = {{ $offerPrice }};
    let currentGadgetDelivery = {{ $dhakaCharge }};
    let isGadgetFreeDelivery = false;
    let currentGadgetColor = 'মিডনাইট ব্ল্যাক';
    let currentGadgetPkg = '১টি স্মার্টওয়াচ + ১টি ইয়ারবাডস';

    function syncGadgetVariant() {
        document.getElementById('gadget_selected_variant').value = currentGadgetColor + ' (' + currentGadgetPkg + ')';
    }

    function selectGadgetPackage(pkgId, price, label, el) {
        currentGadgetSubtotal = price;
        isGadgetFreeDelivery = (pkgId === 2);
        currentGadgetPkg = label;
        syncGadgetVariant();
        document.getElementById('gadget_unit_price').value = price;
        document.getElementById('gadget_selected_package').value = label + ' (৳' + price + ')';

        document.querySelectorAll('.package-card').forEach(c => {
            c.classList.remove('border-cyan-400', 'bg-cyan-950/40');
            c.classList.add('border-slate-700', 'bg-slate-900');
        });
        el.classList.add('border-cyan-400', 'bg-cyan-950/40');
        el.classList.remove('border-slate-700', 'bg-slate-900');
        updateGadgetBill();
    }

    function setGadgetColor(color, el) {
        currentGadgetColor = color;
        syncGadgetVariant();
        document.getElementById('gadget_selected_color').value = color;
        document.querySelectorAll('.gadget-color-btn').forEach(b => {
            b.classList.remove('border-cyan-400', 'bg-cyan-950/60', 'text-cyan-200');
            b.classList.add('border-slate-700', 'bg-slate-800', 'text-slate-200');
        });
        el.classList.add('border-cyan-400', 'bg-cyan-950/60', 'text-cyan-200');
        el.classList.remove('border-slate-700', 'bg-slate-800', 'text-slate-200');
    }

    function setGadgetDelivery(charge, el) {
        currentGadgetDelivery = charge;
        document.querySelectorAll('.delivery-card').forEach(d => {
            d.classList.remove('border-cyan-400', 'bg-cyan-950/40');
            d.classList.add('border-slate-700', 'bg-slate-900');
        });
        el.classList.add('border-cyan-400', 'bg-cyan-950/40');
        el.classList.remove('border-slate-700', 'bg-slate-900');
        updateGadgetBill();
    }

    function updateGadgetBill() {
        let deliveryToApply = isGadgetFreeDelivery ? 0 : currentGadgetDelivery;
        let total = currentGadgetSubtotal + deliveryToApply;
        document.getElementById('gadget_subtotal_text').textContent = '৳' + currentGadgetSubtotal.toLocaleString();
        document.getElementById('gadget_delivery_text').textContent = isGadgetFreeDelivery ? 'ফ্রি (৳০)' : '৳' + deliveryToApply;
        document.getElementById('gadget_total_text').textContent = '৳' + total.toLocaleString();
    }
</script>
@endsection
