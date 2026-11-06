@extends('front_end.layouts.app')

@section('page-title')
    {{ $store->name ?? 'Genuine Leather Wallet & Belt Luxury Combo' }}
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
    $productTitle = $themeSettings['hero_title'] ?? 'এক্সক্লুসিভ কাউ লেদার ওয়ালেট, অটো-লক বেল্ট ও কি-রিং লাক্সারি গিফট বক্স';
    $productDesc = $themeSettings['hero_subtitle'] ?? '১০০% খাঁটি প্রিমিয়াম টপ-গ্রেইন কাউ লেদার। আরএফআইডি প্রটেক্টেড ওয়ালেট, স্টাইলিশ অটো-লক বাকেল বেল্ট ও কি-রিং। অফিস, উপহার কিংবা নিজের আভিজাত্যের সেরা প্রকাশ।';
    
    $regularPrice = $toNum($themeSettings['hero_regular_price'] ?? 2250, 2250);
    $offerPrice = $toNum($themeSettings['hero_offer_price'] ?? 1490, 1490);
    
    if ($regularPrice <= 0) $regularPrice = 2250;
    if ($offerPrice <= 0) $offerPrice = 1490;
    
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

<main class="space-y-12 sm:space-y-20 bg-amber-50/50 text-stone-900 font-sans">

    <!-- 1. LUXURY LEATHER EDITORIAL HERO -->
    <section class="relative pt-10 sm:pt-16 pb-16 bg-gradient-to-b from-amber-100/70 via-stone-50 to-white border-b border-amber-200">
        <div class="max-w-6xl mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                
                <!-- Left Portrait with gold frame -->
                <div class="lg:col-span-5 flex justify-center order-2 lg:order-1">
                    <div class="relative p-3 bg-white rounded-3xl shadow-2xl border-4 border-amber-400 max-w-sm w-full">
                        <div class="absolute -top-3.5 -right-3.5 bg-gradient-to-r from-amber-700 to-amber-900 text-white font-extrabold text-xs uppercase px-3.5 py-1.5 rounded-full shadow-lg tracking-wider animate-pulse">
                            100% GENUINE LEATHER
                        </div>
                        <img src="{{ $productImg1 }}" alt="{{ $productTitle }}" class="w-full h-[380px] object-cover rounded-2xl shadow-inner">
                        <div class="mt-3 text-center text-xs font-serif text-amber-950 font-bold bg-amber-50 py-2 px-3 rounded-xl border border-amber-200">
                            ✦ ৩-ইন-১ লাক্সারি গিফট বক্স • ৫ বছরের লেদার গ্যারান্টি ✦
                        </div>
                    </div>
                </div>

                <!-- Right Editorial Text -->
                <div class="lg:col-span-7 space-y-5 text-center lg:text-left order-1 lg:order-2">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-100 text-amber-950 text-xs sm:text-sm font-black border border-amber-300 shadow-sm">
                        <i class="fas fa-crown text-amber-700"></i>
                        <span>{{ $themeSettings['hero_badge'] ?? '💼 প্রিমিয়াম এক্সিকিউটিভ লেদার কম্বো' }}</span>
                    </div>

                    <h1 class="text-3xl sm:text-5xl font-black text-amber-950 leading-tight">
                        {{ $productTitle }}
                    </h1>

                    <p class="text-stone-700 text-base sm:text-lg leading-relaxed font-medium">
                        {{ $productDesc }}
                    </p>

                    <!-- Urgent Countdown Timer -->
                    <div class="p-3.5 bg-gradient-to-r from-amber-800 via-stone-800 to-amber-900 text-white rounded-2xl shadow-md flex flex-wrap items-center justify-between gap-3">
                        <div class="flex items-center gap-2 font-bold text-xs sm:text-sm">
                            <span class="inline-block w-2.5 h-2.5 bg-yellow-400 rounded-full animate-ping"></span>
                            <span>🔥 স্টক ক্লিয়ারেন্স স্পেশাল অফার শেষ হতে বাকি:</span>
                        </div>
                        <div class="flex items-center gap-1.5 text-xs sm:text-sm font-black text-stone-900 font-mono">
                            <span class="bg-white px-2 py-1 rounded shadow text-amber-800 font-bold" id="leather_timer_hours">05</span> :
                            <span class="bg-white px-2 py-1 rounded shadow text-amber-800 font-bold" id="leather_timer_minutes">12</span> :
                            <span class="bg-white px-2 py-1 rounded shadow text-amber-800 font-bold" id="leather_timer_seconds">47</span>
                        </div>
                    </div>

                    <!-- Price Badge -->
                    <div class="inline-flex flex-wrap items-center gap-6 p-4 rounded-2xl bg-white border-2 border-amber-300 shadow-md">
                        <div>
                            <span class="text-xs text-stone-500 block font-bold uppercase">রেগুলার মূল্য</span>
                            <span class="text-xl font-extrabold text-stone-400 line-through">৳{{ number_format($regularPrice) }}</span>
                        </div>
                        <div class="h-8 w-px bg-amber-200 hidden sm:block"></div>
                        <div>
                            <span class="text-xs text-amber-900 font-black block uppercase">আজকের অফার মূল্য</span>
                            <span class="text-3xl sm:text-4xl font-black text-amber-800">৳{{ number_format($offerPrice) }}</span>
                        </div>
                        <span class="bg-gradient-to-r from-red-600 to-rose-600 text-white text-xs font-black px-3.5 py-1.5 rounded-full shadow-sm">
                            {{ $themeSettings['hero_discount_tag'] ?? '৳৭৬০ ছাড়!' }}
                        </span>
                    </div>

                    <!-- Bullet Features Checklist -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 pt-1 text-left text-xs sm:text-sm text-stone-800 font-bold">
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-amber-700 text-base"></i> ১০০% অরিজিনাল টপ-গ্রেইন কাউ লেদার</div>
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-amber-700 text-base"></i> আরএফআইডি প্রটেক্টেড ওয়ালেট (কার্ড সেফ)</div>
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-amber-700 text-base"></i> পার্সেল চেক করে ক্যাশ অন ডেলিভারি</div>
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-amber-700 text-base"></i> ৫ বছরের লেদার ক্র্যাকিং গ্যারান্টি</div>
                    </div>

                    <!-- CTA Button -->
                    <div class="pt-2">
                        <a href="#fast-order-form" class="pulse-btn inline-flex items-center justify-center gap-3 bg-gradient-to-r from-amber-800 to-stone-900 hover:from-amber-900 hover:to-black text-amber-300 font-black text-lg px-8 py-4 rounded-xl shadow-xl transition transform hover:-translate-y-0.5 w-full sm:w-auto">
                            <i class="fas fa-gift text-yellow-300"></i>
                            <span>{{ $themeSettings['hero_button_text'] ?? '👉 পছন্দের কালার বেছে অর্ডার করুন (ক্যাশ অন ডেলিভারি)' }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. LEATHER CRAFTSMANSHIP GALLERY -->
    <section class="max-w-6xl mx-auto px-4">
        <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
            <span class="text-xs uppercase font-extrabold text-amber-800 tracking-widest">আসল চামড়ার আভিজাত্য</span>
            <h2 class="text-2xl sm:text-4xl font-black text-stone-900">কাছ থেকে দেখুন প্রিমিয়াম ফিনিশিং</h2>
            <p class="text-stone-600 font-medium text-sm">হাতে তৈরি নিখুঁত সেলাই ও টেকসই মেটাল বাকেল যা বছরের পর বছর থাকবে অমলিন</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl border-2 border-amber-200 overflow-hidden shadow-md group hover:shadow-xl transition">
                <div class="h-64 overflow-hidden bg-amber-50 flex items-center justify-center">
                    <img src="{{ $productImg1 }}" alt="কাউ লেদার ওয়ালেট" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                </div>
                <div class="p-4 text-center">
                    <h3 class="font-black text-base text-amber-950 mb-1">আরএফআইডি সেফ ওয়ালেট</h3>
                    <p class="text-xs text-stone-600 font-medium">১২টি কার্ড স্লট, কয়েন পকেট ও ডিজিটাল কার্ড হ্যাকিং প্রটেকশন</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl border-2 border-amber-200 overflow-hidden shadow-md group hover:shadow-xl transition">
                <div class="h-64 overflow-hidden bg-amber-50 flex items-center justify-center">
                    <img src="{{ $productImg2 }}" alt="অটো-লক বেল্ট" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                </div>
                <div class="p-4 text-center">
                    <h3 class="font-black text-base text-amber-950 mb-1">স্মার্ট অটো-লক বেল্ট</h3>
                    <p class="text-xs text-stone-600 font-medium">ছিদ্র ছাড়া স্মুথ স্লাইড অটো-লক মেকানিজম ও প্রিমিয়াম অ্যালয় বাকেল</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl border-2 border-amber-200 overflow-hidden shadow-md group hover:shadow-xl transition">
                <div class="h-64 overflow-hidden bg-amber-50 flex items-center justify-center">
                    <img src="{{ $productImg3 }}" alt="লাক্সারি গিফট বক্স" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                </div>
                <div class="p-4 text-center">
                    <h3 class="font-black text-base text-amber-950 mb-1">এক্সক্লুসিভ গিফট বক্স</h3>
                    <p class="text-xs text-stone-600 font-medium">উপহার দেওয়ার জন্য আকর্ষণীয় বক্স প্যাকেজিং ও ম্যাচিং লেদার কি-রিং</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. TECHNICAL SPECIFICATIONS TABLE -->
    <section class="max-w-4xl mx-auto px-4">
        <div class="bg-white rounded-3xl border-2 border-amber-200 shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-amber-800 to-stone-900 text-white p-5 text-center">
                <h3 class="text-xl sm:text-2xl font-black text-amber-200">লেদার গিফট সেটের বিস্তারিত স্পেক্স</h3>
                <p class="text-amber-100 text-xs mt-1">অর্ডার করার পূর্বে পণ্যের যাবতীয় উপাদান দেখে নিন</p>
            </div>
            <div class="p-6">
                <div class="divide-y divide-amber-100 text-sm">
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-stone-700">উপাদান ও মেটেরিয়াল</span>
                        <span class="font-bold text-amber-950">১০০% টপ-গ্রেইন প্রিমিয়াম কাউ লেদার</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-stone-700">ওয়ালেটের বিশেষত্ব</span>
                        <span class="font-bold text-amber-950">আরএফআইডি প্রটেকশন (RFID Blocking) ও ১২টি স্লট</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-stone-700">বেল্টের দৈর্ঘ্য ও বাকেল</span>
                        <span class="font-bold text-amber-950">২৮-৪৬ ইঞ্চি যেকোনো কোমরে ফিট, মেটালিক অটো-লক</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-stone-700">কি-রিং ও প্যাকেজিং</span>
                        <span class="font-bold text-amber-950">খাঁটি লেদার কি-রিং ও ম্যাগনেটিক লাক্সারি গিফট বক্স</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-stone-700">লেদার ফিনিশিং</span>
                        <span class="font-bold text-amber-950">স্ক্র্যাচ রেজিস্ট্যান্ট ও ওয়াটার রিপেলেন্ট টেক্সচার</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-stone-700">কোয়ালিটি গ্যারান্টি</span>
                        <span class="font-bold text-amber-950">৫ বছরের লেদার ক্র্যাকিং ও পিলিং গ্যারান্টি</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. TRUST & GUARANTEE PILLARS -->
    <section class="max-w-6xl mx-auto px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white p-5 rounded-2xl border-2 border-amber-200 shadow-sm text-center">
                <div class="w-12 h-12 mx-auto rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center text-xl mb-3">
                    <i class="fas fa-hand-holding-dollar"></i>
                </div>
                <h4 class="font-black text-base text-stone-900 mb-1">ক্যাশ অন ডেলিভারি</h4>
                <p class="text-xs text-stone-600 font-medium leading-relaxed">আগে ১ টাকাও অগ্রিম নয়, পার্সেল দেখে তারপর টাকা দিন।</p>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-amber-200 shadow-sm text-center">
                <div class="w-12 h-12 mx-auto rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center text-xl mb-3">
                    <i class="fas fa-certificate"></i>
                </div>
                <h4 class="font-black text-base text-stone-900 mb-1">৫ বছরের গ্যারান্টি</h4>
                <p class="text-xs text-stone-600 font-medium leading-relaxed">চামড়া ফেটে গেলে বা রঙ নষ্ট হলে সরাসরি নতুন রিপ্লেসমেন্ট।</p>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-amber-200 shadow-sm text-center">
                <div class="w-12 h-12 mx-auto rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center text-xl mb-3">
                    <i class="fas fa-truck-fast"></i>
                </div>
                <h4 class="font-black text-base text-stone-900 mb-1">সারা দেশে ডেলিভারি</h4>
                <p class="text-xs text-stone-600 font-medium leading-relaxed">ঢাকায় ২৪-৪৮ ঘণ্টায় এবং ঢাকার বাইরে ২-৩ দিনের মধ্যে ডেলিভারি।</p>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-amber-200 shadow-sm text-center">
                <div class="w-12 h-12 mx-auto rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center text-xl mb-3">
                    <i class="fas fa-box-open"></i>
                </div>
                <h4 class="font-black text-base text-stone-900 mb-1">দেখে নেওয়ার সুবিধা</h4>
                <p class="text-xs text-stone-600 font-medium leading-relaxed">ডেলিভারিম্যানের সামনে বক্স খুলে চেক করে নেওয়ার সুবিধা।</p>
            </div>
        </div>
    </section>

    <!-- 5. VERIFIED CUSTOMER REVIEWS (SOCIAL PROOF) -->
    <section class="max-w-6xl mx-auto px-4">
        <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
            <span class="text-xs uppercase font-extrabold text-amber-800 tracking-widest">প্রকৃত ক্রেতাদের মতামত</span>
            <h2 class="text-2xl sm:text-4xl font-black text-stone-900">আমাদের সন্তুষ্ট গ্রাহকদের রিভিউ</h2>
            <div class="flex items-center justify-center gap-1 text-amber-500 text-sm">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                <span class="text-stone-700 font-bold ml-2">৪.৯/৫ (৩৮০+ ভেরিফায়েড রিভিউ)</span>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-5 rounded-2xl border-2 border-amber-100 shadow-md flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center gap-1 text-amber-400 text-xs">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-xs sm:text-sm text-stone-700 font-medium leading-relaxed">
                        "চামড়ার কোয়ালিটি সত্যিই অসাধারণ! অটো-লক বাকেলটা দেখতে খুবই গর্জিয়াস। গিফট বক্সটাও প্রিমিয়াম।"
                    </p>
                </div>
                <div class="pt-4 border-t border-amber-50 flex items-center justify-between mt-4">
                    <div>
                        <h4 class="text-xs font-bold text-amber-950">শাহরিয়ার নাফিস</h4>
                        <span class="text-[11px] text-stone-500 font-medium">গুলশান, ঢাকা</span>
                    </div>
                    <span class="text-[10px] bg-green-100 text-green-800 font-bold px-2 py-0.5 rounded-full">ভেরিফায়েড</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-amber-100 shadow-md flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center gap-1 text-amber-400 text-xs">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-xs sm:text-sm text-stone-700 font-medium leading-relaxed">
                        "ক্যাশ অন ডেলিভারিতে চেক করে দেখেছি, ১০০% আসল চামড়া। কোনো কৃত্রিম গন্ধ বা রেক্সিন না।"
                    </p>
                </div>
                <div class="pt-4 border-t border-amber-50 flex items-center justify-between mt-4">
                    <div>
                        <h4 class="text-xs font-bold text-amber-950">মাহিন আহমেদ</h4>
                        <span class="text-[11px] text-stone-500 font-medium">ধানমন্ডি, ঢাকা</span>
                    </div>
                    <span class="text-[10px] bg-green-100 text-green-800 font-bold px-2 py-0.5 rounded-full">ভেরিফায়েড</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-amber-100 shadow-md flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center gap-1 text-amber-400 text-xs">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-xs sm:text-sm text-stone-700 font-medium leading-relaxed">
                        "আমার বাবার জন্মদিনে উপহার দিয়েছিলাম, উনি খুব খুশি হয়েছেন। বেল্ট ও ওয়ালেটের ফিনিশিং খুব নিখুঁত।"
                    </p>
                </div>
                <div class="pt-4 border-t border-amber-50 flex items-center justify-between mt-4">
                    <div>
                        <h4 class="text-xs font-bold text-amber-950">তানজিমুল ইসলাম</h4>
                        <span class="text-[11px] text-stone-500 font-medium">চট্টগ্রাম সদর</span>
                    </div>
                    <span class="text-[10px] bg-green-100 text-green-800 font-bold px-2 py-0.5 rounded-full">ভেরিফায়েড</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-amber-100 shadow-md flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center gap-1 text-amber-400 text-xs">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-xs sm:text-sm text-stone-700 font-medium leading-relaxed">
                        "২ দিনের মধ্যে রাজশাহী ডেলিভারি পেয়েছি। এই দামে এমন প্রিমিয়াম লেদার সেট বাজারে পাওয়া কঠিন।"
                    </p>
                </div>
                <div class="pt-4 border-t border-amber-50 flex items-center justify-between mt-4">
                    <div>
                        <h4 class="text-xs font-bold text-amber-950">কামরুল হাসান</h4>
                        <span class="text-[11px] text-stone-500 font-medium">রাজশাহী</span>
                    </div>
                    <span class="text-[10px] bg-green-100 text-green-800 font-bold px-2 py-0.5 rounded-full">ভেরিফায়েড</span>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. HIGH CONVERTING 1-PAGE CASH ON DELIVERY CHECKOUT FORM -->
    <section id="fast-order-form" class="max-w-4xl mx-auto px-4 scroll-mt-20">
        <div class="bg-white rounded-3xl border-4 border-amber-400 shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-amber-800 via-stone-800 to-amber-900 text-white p-6 sm:p-8 text-center">
                <span class="inline-block bg-yellow-400 text-stone-950 text-xs font-black uppercase px-3 py-1 rounded-full mb-2">
                    ⚡ সহজ ১-মিনিট ক্যাশ অন ডেলিভারি ফর্ম
                </span>
                <h3 class="text-2xl sm:text-4xl font-black">অর্ডার করতে নিচের তথ্যগুলো দিন</h3>
                <p class="text-amber-100 text-xs sm:text-sm mt-1">অগ্রিম ১ টাকাও লাগবে না, পার্সেল হাতে পেয়ে দেখে মূল্য পরিশোধ করবেন</p>
            </div>

            <form action="{{ route('single.fast.order', $slug ?? ($store->slug ?? 'shop001')) }}" method="POST" class="p-6 sm:p-10 space-y-6" id="leatherOrderForm">
                @csrf
                <input type="hidden" name="product_id" value="{{ $mainProduct->id ?? 1 }}">
                <input type="hidden" name="unit_price" id="leather_unit_price" value="{{ $offerPrice }}">
                <input type="hidden" name="product_variant" id="leather_selected_variant" value="চকলেট ব্রাউন (১টি লাক্সারি গিফট সেট)">
                <input type="hidden" name="selected_color" id="leather_selected_color" value="চকলেট ব্রাউন">
                <input type="hidden" name="selected_package" id="leather_selected_package" value="১টি লাক্সারি গিফট সেট">

                <!-- Step 1: Package Selection -->
                <div class="space-y-3">
                    <label class="block text-sm font-black text-amber-950">
                        ১. প্যাকেজ নির্বাচন করুন <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <label class="relative flex items-center justify-between p-4 rounded-2xl border-2 border-amber-500 bg-amber-50/70 cursor-pointer package-card hover:bg-amber-50 transition" onclick="selectLeatherPackage(1, {{ $offerPrice }}, '১টি লাক্সারি গিফট সেট', this)">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="pkg_choice" value="1" checked class="text-amber-700 focus:ring-amber-500">
                                <div>
                                    <span class="font-black text-stone-900 text-sm block">১টি ৩-ইন-১ লাক্সারি গিফট সেট</span>
                                    <span class="text-xs text-stone-600 font-medium">ওয়ালেট + অটো-লক বেল্ট + কি-রিং</span>
                                </div>
                            </div>
                            <span class="text-lg font-black text-amber-800">৳{{ number_format($offerPrice) }}</span>
                        </label>

                        <label class="relative flex items-center justify-between p-4 rounded-2xl border-2 border-stone-200 bg-white cursor-pointer package-card hover:bg-amber-50 transition" onclick="selectLeatherPackage(2, 2790, '২টি লেদার কম্বো সেট (ফ্রি ডেলিভারি)', this)">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="pkg_choice" value="2" class="text-amber-700 focus:ring-amber-500">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-black text-stone-900 text-sm block">২টি মেগা কম্বো সেট</span>
                                        <span class="bg-red-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">ফ্রি ডেলিভারি</span>
                                    </div>
                                    <span class="text-xs text-stone-600 font-medium">৳১৯০ ছাড় + ফ্রি হোম ডেলিভারি</span>
                                </div>
                            </div>
                            <span class="text-lg font-black text-amber-800">৳২,৭৯০</span>
                        </label>
                    </div>
                </div>

                <!-- Step 2: Color Selection -->
                <div class="space-y-3">
                    <label class="block text-sm font-black text-amber-950">
                        ২. লেদারের কালার বেছে নিন <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 gap-3">
                        <button type="button" class="leather-color-btn py-3 px-3 rounded-xl border-2 border-amber-700 bg-amber-50 text-amber-950 font-bold text-xs sm:text-sm flex items-center justify-center gap-2 shadow-sm transition" onclick="setLeatherColor('চকলেট ব্রাউন', this)">
                            <span class="w-3.5 h-3.5 rounded-full bg-amber-900 border border-white"></span>
                            <span>চকলেট ব্রাউন</span>
                        </button>
                        <button type="button" class="leather-color-btn py-3 px-3 rounded-xl border-2 border-stone-200 bg-white text-stone-800 font-bold text-xs sm:text-sm flex items-center justify-center gap-2 transition hover:border-amber-400" onclick="setLeatherColor('জেট ব্ল্যাক', this)">
                            <span class="w-3.5 h-3.5 rounded-full bg-black border border-white"></span>
                            <span>জেট ব্ল্যাক</span>
                        </button>
                    </div>
                </div>

                <!-- Step 3: Customer Details -->
                <div class="space-y-4 pt-2">
                    <label class="block text-sm font-black text-amber-950">
                        ৩. আপনার ডেলিভারি তথ্য দিন <span class="text-red-500">*</span>
                    </label>

                    <div>
                        <label class="block text-xs font-bold text-stone-700 mb-1">আপনার পূর্ণ নাম *</label>
                        <input type="text" name="customer_name" required placeholder="যেমন: শাহরিয়ার আহমেদ" class="w-full px-4 py-3 rounded-xl border-2 border-stone-300 focus:border-amber-700 focus:outline-none text-stone-900 font-medium text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-700 mb-1">সচল মোবাইল নম্বর *</label>
                        <input type="tel" name="customer_phone" required placeholder="যেমন: 017xxxxxxxx" class="w-full px-4 py-3 rounded-xl border-2 border-stone-300 focus:border-amber-700 focus:outline-none text-stone-900 font-medium text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-700 mb-1">সম্পূর্ণ ডেলিভারি ঠিকানা *</label>
                        <textarea name="customer_address" rows="2" required placeholder="যেমন: বাসা নং, রোড নং, থানা ও জেলার নাম" class="w-full px-4 py-3 rounded-xl border-2 border-stone-300 focus:border-amber-700 focus:outline-none text-stone-900 font-medium text-sm"></textarea>
                    </div>

                    <!-- Delivery Area -->
                    <div>
                        <label class="block text-xs font-bold text-stone-700 mb-2">ডেলিভারি এরিয়া বেছে নিন *</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <label class="flex items-center justify-between p-3.5 rounded-xl border-2 border-amber-700 bg-amber-50/60 cursor-pointer delivery-card transition" onclick="setLeatherDelivery({{ $dhakaCharge }}, this)">
                                <div class="flex items-center gap-2">
                                    <input type="radio" name="delivery_location" value="dhaka" checked class="text-amber-700">
                                    <span class="text-xs sm:text-sm font-bold text-stone-900">ঢাকা সিটির ভিতরে</span>
                                </div>
                                <span class="text-xs sm:text-sm font-bold text-amber-800">৳{{ $dhakaCharge }}</span>
                            </label>

                            <label class="flex items-center justify-between p-3.5 rounded-xl border-2 border-stone-200 bg-white cursor-pointer delivery-card transition hover:bg-amber-50" onclick="setLeatherDelivery({{ $outsideCharge }}, this)">
                                <div class="flex items-center gap-2">
                                    <input type="radio" name="delivery_location" value="outside" class="text-amber-700">
                                    <span class="text-xs sm:text-sm font-bold text-stone-900">ঢাকা সিটির বাইরে</span>
                                </div>
                                <span class="text-xs sm:text-sm font-bold text-amber-800">৳{{ $outsideCharge }}</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Price Summary Box -->
                <div class="p-5 bg-amber-50 rounded-2xl border-2 border-amber-200 space-y-2 text-sm">
                    <div class="flex justify-between text-stone-700 font-medium">
                        <span>পণ্যের মূল্য:</span>
                        <span class="font-bold text-stone-900" id="leather_subtotal_text">৳{{ number_format($offerPrice) }}</span>
                    </div>
                    <div class="flex justify-between text-stone-700 font-medium">
                        <span>ডেলিভারি চার্জ:</span>
                        <span class="font-bold text-stone-900" id="leather_delivery_text">৳{{ $dhakaCharge }}</span>
                    </div>
                    <div class="h-px bg-amber-200 my-1"></div>
                    <div class="flex justify-between text-base sm:text-lg font-black text-amber-950">
                        <span>সর্বমোট প্রদেয় বিল:</span>
                        <span class="text-2xl font-black text-amber-800" id="leather_total_text">৳{{ number_format($offerPrice + $dhakaCharge) }}</span>
                    </div>
                </div>

                <button type="submit" class="pulse-btn w-full bg-gradient-to-r from-amber-800 via-stone-800 to-amber-900 hover:from-amber-900 hover:to-black text-amber-300 font-black text-lg sm:text-xl py-4 rounded-2xl shadow-xl transition transform hover:-translate-y-0.5 flex items-center justify-center gap-3">
                    <i class="fas fa-lock text-yellow-300"></i>
                    <span>অর্ডার কনফার্ম করুন (ক্যাশ অন ডেলিভারি)</span>
                </button>
            </form>
        </div>
    </section>

    <!-- 7. FREQUENTLY ASKED QUESTIONS (FAQ) -->
    <section class="max-w-4xl mx-auto px-4 pb-12">
        <div class="text-center mb-8">
            <span class="text-xs uppercase font-extrabold text-amber-800 tracking-widest">সাধারণ প্রশ্নোত্তর</span>
            <h2 class="text-2xl sm:text-3xl font-black text-stone-900 mt-1">সচরাচর জানতে চাওয়া প্রশ্ন ও উত্তর</h2>
        </div>

        <div class="space-y-3">
            <div class="bg-white p-5 rounded-2xl border-2 border-amber-100 shadow-sm">
                <h4 class="font-black text-stone-900 text-sm sm:text-base flex items-center gap-2">
                    <i class="fas fa-question-circle text-amber-700"></i> এটি কি শতভাগ খাঁটি চামড়ার পণ্য?
                </h4>
                <p class="text-xs sm:text-sm text-stone-600 font-medium mt-2 leading-relaxed pl-6">
                    জী, এটি ১০০% অরিজিনাল টপ-গ্রেইন কাউহাইড লেদার (খাঁটি গরুর চামড়া) দিয়ে তৈরি। কোনো প্রকার কৃত্রিম রেক্সিন ব্যবহার করা হয়নি।
                </p>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-amber-100 shadow-sm">
                <h4 class="font-black text-stone-900 text-sm sm:text-base flex items-center gap-2">
                    <i class="fas fa-question-circle text-amber-700"></i> বেল্টটি কি আমার কোমরে ফিট হবে?
                </h4>
                <p class="text-xs sm:text-sm text-stone-600 font-medium mt-2 leading-relaxed pl-6">
                    অবশ্যই! আমাদের বেল্টে রয়েছে আধুনিক অটো-লক বাকেল যা ২৮ ইঞ্চি থেকে ৪৬ ইঞ্চি পর্যন্ত যেকোনো সাইজের কোমরে অনায়াসে এডজাস্ট করা যায়।
                </p>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-amber-100 shadow-sm">
                <h4 class="font-black text-stone-900 text-sm sm:text-base flex items-center gap-2">
                    <i class="fas fa-question-circle text-amber-700"></i> চামড়া ফেটে গেলে কী সুবিধা পাব?
                </h4>
                <p class="text-xs sm:text-sm text-stone-600 font-medium mt-2 leading-relaxed pl-6">
                    আমাদের রয়েছে ৫ বছরের অফিসিয়াল লেদার রিপ্লেসমেন্ট গ্যারান্টি। কোনো ক্র্যাকিং বা পিলিং হলে আমরা সম্পূর্ণ বিনামূল্যে পরিবর্তন করে দেব।
                </p>
            </div>
        </div>
    </section>

</main>

<!-- FLOATING WHATSAPP BUTTON -->
<a href="https://wa.me/8801700000000?text=আসসালামু%20আলাইকুম!%20লেদার%20গিফট%20সেট%20সম্পর্কে%20জানতে%20চাই" target="_blank" class="fixed bottom-20 right-4 z-40 bg-green-500 hover:bg-green-600 text-white p-3.5 rounded-full shadow-2xl flex items-center justify-center transition transform hover:scale-110" title="হোয়াটসঅ্যাপে কথা বলুন">
    <i class="fab fa-whatsapp text-3xl"></i>
</a>

<!-- MOBILE STICKY CTA -->
<div class="fixed bottom-0 left-0 right-0 z-30 sm:hidden bg-white/95 backdrop-blur-md border-t-2 border-amber-300 p-3 shadow-2xl">
    <div class="flex items-center justify-between gap-3 max-w-md mx-auto">
        <div>
            <span class="text-[11px] text-stone-500 font-bold block">অফার প্রাইস</span>
            <span class="text-xl font-black text-amber-800">৳{{ number_format($offerPrice) }}</span>
        </div>
        <a href="#fast-order-form" class="bg-amber-800 hover:bg-amber-900 text-amber-300 font-black text-sm px-5 py-2.5 rounded-xl shadow-lg transition flex items-center gap-1.5">
            <i class="fas fa-gift"></i> এখনই কিনুন
        </a>
    </div>
</div>

<script>
    // Live Countdown Timer
    let leatherHours = 5, leatherMinutes = 12, leatherSeconds = 47;
    setInterval(function() {
        if (leatherSeconds > 0) {
            leatherSeconds--;
        } else {
            leatherSeconds = 59;
            if (leatherMinutes > 0) {
                leatherMinutes--;
            } else {
                leatherMinutes = 59;
                if (leatherHours > 0) leatherHours--;
            }
        }
        document.getElementById('leather_timer_hours').textContent = String(leatherHours).padStart(2, '0');
        document.getElementById('leather_timer_minutes').textContent = String(leatherMinutes).padStart(2, '0');
        document.getElementById('leather_timer_seconds').textContent = String(leatherSeconds).padStart(2, '0');
    }, 1000);

    let currentLeatherSubtotal = {{ $offerPrice }};
    let currentLeatherDelivery = {{ $dhakaCharge }};
    let isLeatherFreeDelivery = false;
    let currentLeatherColor = 'চকলেট ব্রাউন';
    let currentLeatherPkg = '১টি লাক্সারি গিফট সেট';

    function syncLeatherVariant() {
        document.getElementById('leather_selected_variant').value = currentLeatherColor + ' (' + currentLeatherPkg + ')';
    }

    function selectLeatherPackage(pkgId, price, label, el) {
        currentLeatherSubtotal = price;
        isLeatherFreeDelivery = (pkgId === 2);
        currentLeatherPkg = label;
        syncLeatherVariant();
        document.getElementById('leather_unit_price').value = price;
        document.getElementById('leather_selected_package').value = label + ' (৳' + price + ')';

        document.querySelectorAll('.package-card').forEach(c => {
            c.classList.remove('border-amber-500', 'bg-amber-50/70');
            c.classList.add('border-stone-200', 'bg-white');
        });
        el.classList.add('border-amber-500', 'bg-amber-50/70');
        el.classList.remove('border-stone-200', 'bg-white');
        updateLeatherBill();
    }

    function setLeatherColor(color, el) {
        currentLeatherColor = color;
        syncLeatherVariant();
        document.getElementById('leather_selected_color').value = color;
        document.querySelectorAll('.leather-color-btn').forEach(b => {
            b.classList.remove('border-amber-700', 'bg-amber-50', 'text-amber-950');
            b.classList.add('border-stone-200', 'bg-white', 'text-stone-800');
        });
        el.classList.add('border-amber-700', 'bg-amber-50', 'text-amber-950');
        el.classList.remove('border-stone-200', 'bg-white', 'text-stone-800');
    }

    function setLeatherDelivery(charge, el) {
        currentLeatherDelivery = charge;
        document.querySelectorAll('.delivery-card').forEach(d => {
            d.classList.remove('border-amber-700', 'bg-amber-50/60');
            d.classList.add('border-stone-200', 'bg-white');
        });
        el.classList.add('border-amber-700', 'bg-amber-50/60');
        el.classList.remove('border-stone-200', 'bg-white');
        updateLeatherBill();
    }

    function updateLeatherBill() {
        let deliveryToApply = isLeatherFreeDelivery ? 0 : currentLeatherDelivery;
        let total = currentLeatherSubtotal + deliveryToApply;
        document.getElementById('leather_subtotal_text').textContent = '৳' + currentLeatherSubtotal.toLocaleString();
        document.getElementById('leather_delivery_text').textContent = isLeatherFreeDelivery ? 'ফ্রি (৳০)' : '৳' + deliveryToApply;
        document.getElementById('leather_total_text').textContent = '৳' + total.toLocaleString();
    }
</script>
@endsection
