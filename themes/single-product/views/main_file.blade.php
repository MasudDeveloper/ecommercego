@extends('front_end.layouts.app')

@section('page-title')
    {{ $store->name ?? 'Pure Mustard Oil & Raw Honey Organic Combo' }}
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
    $productTitle = $themeSettings['hero_title'] ?? 'কাঠের ঘানিতে ভাঙানো ১০০% খাঁটি সরিষার তেল ও সুন্দরবনের চাকভাঙা মধু';
    $productDesc = $themeSettings['hero_subtitle'] ?? 'কোনো কেমিক্যাল, প্রিজারভেটিভ বা ভেজাল নেই। তীব্র ঝাঁঝালো খাঁটি সরিষার তেল এবং সুন্দরবনের গভীর অরণ্যের শতভাগ প্রাকৃতিক কাঁচা মধু। পরিবারের সুস্বাস্থ্যে খাঁটি পুষ্টির নিশ্চয়তা।';
    
    $regularPrice = $toNum($themeSettings['hero_regular_price'] ?? 1350, 1350);
    $offerPrice = $toNum($themeSettings['hero_offer_price'] ?? 950, 950);
    
    if ($regularPrice <= 0) $regularPrice = 1350;
    if ($offerPrice <= 0) $offerPrice = 950;
    
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

<main class="space-y-12 sm:space-y-20 bg-emerald-50/40 text-stone-900 font-sans">

    <!-- 1. ORGANIC FOOD EDITORIAL HERO -->
    <section class="relative pt-10 sm:pt-16 pb-16 bg-gradient-to-b from-emerald-100/70 via-amber-50/40 to-white border-b border-emerald-200">
        <div class="max-w-6xl mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                
                <!-- Left Portrait with natural organic frame -->
                <div class="lg:col-span-5 flex justify-center order-2 lg:order-1">
                    <div class="relative p-3 bg-white rounded-3xl shadow-2xl border-4 border-emerald-400 max-w-sm w-full">
                        <div class="absolute -top-3.5 -right-3.5 bg-gradient-to-r from-emerald-600 to-green-700 text-white font-extrabold text-xs uppercase px-3.5 py-1.5 rounded-full shadow-lg tracking-wider animate-pulse">
                            100% PURE & RAW
                        </div>
                        <img src="{{ $productImg1 }}" alt="{{ $productTitle }}" class="w-full h-[380px] object-cover rounded-2xl shadow-inner">
                        <div class="mt-3 text-center text-xs font-serif text-emerald-950 font-bold bg-emerald-50 py-2 px-3 rounded-xl border border-emerald-200">
                            ✦ ১ লিটার ঘানির তেল + ৫০০ গ্রাম সুন্দরবনের মধু ✦
                        </div>
                    </div>
                </div>

                <!-- Right Editorial Text -->
                <div class="lg:col-span-7 space-y-5 text-center lg:text-left order-1 lg:order-2">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-100 text-emerald-950 text-xs sm:text-sm font-black border border-emerald-300 shadow-sm">
                        <i class="fas fa-seedling text-emerald-700"></i>
                        <span>{{ $themeSettings['hero_badge'] ?? '🌿 রাসায়নিক ও ভেজালমুক্ত খাঁটি গ্রামীণ স্বাদ' }}</span>
                    </div>

                    <h1 class="text-3xl sm:text-5xl font-black text-emerald-950 leading-tight">
                        {{ $productTitle }}
                    </h1>

                    <p class="text-stone-700 text-base sm:text-lg leading-relaxed font-medium">
                        {{ $productDesc }}
                    </p>

                    <!-- Urgent Countdown Timer -->
                    <div class="p-3.5 bg-gradient-to-r from-emerald-800 via-green-700 to-emerald-900 text-white rounded-2xl shadow-md flex flex-wrap items-center justify-between gap-3">
                        <div class="flex items-center gap-2 font-bold text-xs sm:text-sm">
                            <span class="inline-block w-2.5 h-2.5 bg-yellow-300 rounded-full animate-ping"></span>
                            <span>🔥 সিজনাল ফ্রেশ স্টক অফার শেষ হতে বাকি:</span>
                        </div>
                        <div class="flex items-center gap-1.5 text-xs sm:text-sm font-black text-stone-900 font-mono">
                            <span class="bg-white px-2 py-1 rounded shadow text-emerald-800 font-bold" id="organic_timer_hours">04</span> :
                            <span class="bg-white px-2 py-1 rounded shadow text-emerald-800 font-bold" id="organic_timer_minutes">38</span> :
                            <span class="bg-white px-2 py-1 rounded shadow text-emerald-800 font-bold" id="organic_timer_seconds">21</span>
                        </div>
                    </div>

                    <!-- Price Badge -->
                    <div class="inline-flex flex-wrap items-center gap-6 p-4 rounded-2xl bg-white border-2 border-emerald-300 shadow-md">
                        <div>
                            <span class="text-xs text-stone-500 block font-bold uppercase">রেগুলার মূল্য</span>
                            <span class="text-xl font-extrabold text-stone-400 line-through">৳{{ number_format($regularPrice) }}</span>
                        </div>
                        <div class="h-8 w-px bg-emerald-200 hidden sm:block"></div>
                        <div>
                            <span class="text-xs text-emerald-900 font-black block uppercase">আজকের অফার মূল্য</span>
                            <span class="text-3xl sm:text-4xl font-black text-emerald-800">৳{{ number_format($offerPrice) }}</span>
                        </div>
                        <span class="bg-gradient-to-r from-emerald-700 to-green-700 text-white text-xs font-black px-3.5 py-1.5 rounded-full shadow-sm">
                            {{ $themeSettings['hero_discount_tag'] ?? '৳৪০০ সরাসরি ছাড়!' }}
                        </span>
                    </div>

                    <!-- Bullet Features Checklist -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 pt-1 text-left text-xs sm:text-sm text-stone-800 font-bold">
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-emerald-700 text-base"></i> কাঠের ঘানিতে কোল্ড-প্রেসড খাঁটি সরিষার তেল</div>
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-emerald-700 text-base"></i> সুন্দরবনের ১০০% প্রাকৃতিক চাকভাঙা কাঁচা মধু</div>
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-emerald-700 text-base"></i> পার্সেল চেক করে ক্যাশ অন ডেলিভারি</div>
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-emerald-700 text-base"></i> কোনো ভেজাল বা কেমিক্যাল নেই (ল্যাব টেস্টেড)</div>
                    </div>

                    <!-- CTA Button -->
                    <div class="pt-2">
                        <a href="#fast-order-form" class="pulse-btn inline-flex items-center justify-center gap-3 bg-gradient-to-r from-emerald-800 to-green-800 hover:from-emerald-900 hover:to-green-900 text-yellow-300 font-black text-lg px-8 py-4 rounded-xl shadow-xl transition transform hover:-translate-y-0.5 w-full sm:w-auto">
                            <i class="fas fa-shopping-basket text-yellow-300"></i>
                            <span>{{ $themeSettings['hero_button_text'] ?? '👉 এখনই অর্ডার করুন (ক্যাশ অন ডেলিভারি)' }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. ORGANIC PURITY GALLERY -->
    <section class="max-w-6xl mx-auto px-4">
        <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
            <span class="text-xs uppercase font-extrabold text-emerald-800 tracking-widest">প্রকৃতির বিশুদ্ধ উপহার</span>
            <h2 class="text-2xl sm:text-4xl font-black text-stone-900">শতভাগ নির্ভেজাল পুষ্টির গ্যারান্টি</h2>
            <p class="text-stone-600 font-medium text-sm">পরিবারের ছোট-বড় সবার সুস্বাস্থ্য রক্ষায় সম্পূর্ণ প্রাকৃতিক ও অপরিশোধিত খাঁটি উপাদান</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl border-2 border-emerald-200 overflow-hidden shadow-md group hover:shadow-xl transition">
                <div class="h-64 overflow-hidden bg-emerald-50 flex items-center justify-center">
                    <img src="{{ $productImg1 }}" alt="খাঁটি সরিষার তেল ও মধু কম্বো" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                </div>
                <div class="p-4 text-center">
                    <h3 class="font-black text-base text-emerald-950 mb-1">অরিজিনাল কম্বো প্যাক</h3>
                    <p class="text-xs text-stone-600 font-medium">১ লিটার ঘানির খাঁটি সরিষার তেল ও ৫০০ গ্রাম সুন্দরবনের প্রাকৃতিক র-হানি</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl border-2 border-emerald-200 overflow-hidden shadow-md group hover:shadow-xl transition">
                <div class="h-64 overflow-hidden bg-emerald-50 flex items-center justify-center">
                    <img src="{{ $productImg2 }}" alt="ঘানিতে ভাঙানো খাঁটি তেল" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                </div>
                <div class="p-4 text-center">
                    <h3 class="font-black text-base text-emerald-950 mb-1">তীব্র ঝাঁঝ ও প্রাকৃতিক রঙ</h3>
                    <p class="text-xs text-stone-600 font-medium">কোনো কৃত্রিম ফ্লেভার বা পাম ওয়েল ছাড়া কোল্ড-প্রেসড আসল ঝাঁঝালো তেল</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl border-2 border-emerald-200 overflow-hidden shadow-md group hover:shadow-xl transition">
                <div class="h-64 overflow-hidden bg-emerald-50 flex items-center justify-center">
                    <img src="{{ $productImg3 }}" alt="সুন্দরবনের প্রাকৃতিক চাকভাঙা মধু" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                </div>
                <div class="p-4 text-center">
                    <h3 class="font-black text-base text-emerald-950 mb-1">চাকভাঙা তাজা কাঁচা মধু</h3>
                    <p class="text-xs text-stone-600 font-medium">কোনো চিনি বা প্রসেসিং ছাড়া প্রাকৃতিক এনজাইম ও রোগ প্রতিরোধ ক্ষমতাসম্পন্ন</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. TECHNICAL SPECIFICATIONS TABLE -->
    <section class="max-w-4xl mx-auto px-4">
        <div class="bg-white rounded-3xl border-2 border-emerald-200 shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-emerald-800 to-green-800 text-white p-5 text-center">
                <h3 class="text-xl sm:text-2xl font-black text-yellow-300">পণ্যের বিশুদ্ধতা ও পুষ্টি বিবরণ</h3>
                <p class="text-emerald-100 text-xs mt-1">অর্ডার করার পূর্বে খাঁটি উপাদানের মানদণ্ড দেখে নিন</p>
            </div>
            <div class="p-6">
                <div class="divide-y divide-emerald-100 text-sm">
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-stone-700">তেলের উৎপাদন প্রক্রিয়া</span>
                        <span class="font-bold text-emerald-900">ঐতিহ্যবাহী কাঠের ঘানিতে কোল্ড-প্রেসড (প্রথম চাপ)</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-stone-700">মধুর উৎস ও ধরণ</span>
                        <span class="font-bold text-emerald-900">সুন্দরবনের গভীর অরণ্যের খলিশা ও গরান ফুলের চাকভাঙা মধু</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-stone-700">ভেজাল ও কেমিক্যাল সুরক্ষা</span>
                        <span class="font-bold text-emerald-900">১০০% চিনিমুক্ত, কোনো প্রিজারভেটিভ বা রঙ নেই (ল্যাব টেস্টেড)</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-stone-700">প্যাকেজিং পরিমাপ</span>
                        <span class="font-bold text-emerald-900">১ লিটার ফুড-গ্রেড বোতল + ৫০০ গ্রাম প্রিমিয়াম জার</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-stone-700">উপকারিতা</span>
                        <span class="font-bold text-emerald-900">হৃদরোগের ঝুঁকি কমায়, হজমে সহায়তা ও ইমিউনিটি বাড়ায়</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-stone-700">বিশুদ্ধতার গ্যারান্টি</span>
                        <span class="font-bold text-emerald-900">ভেজাল প্রমাণে মূল্যের দ্বিগুণ ক্ষতিপূরণ গ্যারান্টি</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. TRUST & GUARANTEE PILLARS -->
    <section class="max-w-6xl mx-auto px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white p-5 rounded-2xl border-2 border-emerald-200 shadow-sm text-center">
                <div class="w-12 h-12 mx-auto rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center text-xl mb-3">
                    <i class="fas fa-hand-holding-dollar"></i>
                </div>
                <h4 class="font-black text-base text-stone-900 mb-1">ক্যাশ অন ডেলিভারি</h4>
                <p class="text-xs text-stone-600 font-medium leading-relaxed">আগে ১ টাকাও দিতে হবে না, পণ্য হাতে পেয়ে দাম দিন।</p>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-emerald-200 shadow-sm text-center">
                <div class="w-12 h-12 mx-auto rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center text-xl mb-3">
                    <i class="fas fa-award"></i>
                </div>
                <h4 class="font-black text-base text-stone-900 mb-1">১০০% খাঁটি ও নির্ভেজাল</h4>
                <p class="text-xs text-stone-600 font-medium leading-relaxed">ল্যাব টেস্টে উত্তীর্ণ, পরিবারের জন্য ১০০% স্বাস্থ্যসম্মত।</p>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-emerald-200 shadow-sm text-center">
                <div class="w-12 h-12 mx-auto rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center text-xl mb-3">
                    <i class="fas fa-truck-fast"></i>
                </div>
                <h4 class="font-black text-base text-stone-900 mb-1">সারা দেশে ডেলিভারি</h4>
                <p class="text-xs text-stone-600 font-medium leading-relaxed">ঢাকায় ২৪-৪৮ ঘণ্টায় এবং ঢাকার বাইরে ২-৩ দিনের মধ্যে ডেলিভারি।</p>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-emerald-200 shadow-sm text-center">
                <div class="w-12 h-12 mx-auto rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center text-xl mb-3">
                    <i class="fas fa-box-open"></i>
                </div>
                <h4 class="font-black text-base text-stone-900 mb-1">দেখে নেওয়ার সুযোগ</h4>
                <p class="text-xs text-stone-600 font-medium leading-relaxed">ডেলিভারিম্যানের সামনে চেক করে নিশ্চিন্তে পার্সেল গ্রহণ করুন।</p>
            </div>
        </div>
    </section>

    <!-- 5. VERIFIED CUSTOMER REVIEWS (SOCIAL PROOF) -->
    <section class="max-w-6xl mx-auto px-4">
        <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
            <span class="text-xs uppercase font-extrabold text-emerald-800 tracking-widest">ভোক্তাদের বাস্তব মতামত</span>
            <h2 class="text-2xl sm:text-4xl font-black text-stone-900">আমাদের সন্তুষ্ট গ্রাহকদের রিভিউ</h2>
            <div class="flex items-center justify-center gap-1 text-amber-500 text-sm">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                <span class="text-stone-700 font-bold ml-2">৪.৯/৫ (৪২০+ গ্রাহক রিভিউ)</span>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-5 rounded-2xl border-2 border-emerald-100 shadow-md flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center gap-1 text-amber-400 text-xs">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-xs sm:text-sm text-stone-700 font-medium leading-relaxed">
                        "তেলের ঝাঁঝটা সত্যি অসাধারণ! আর মধুর স্বাদ একদম খাঁটি সুন্দরবনের কাঁচা মধুর মতো।"
                    </p>
                </div>
                <div class="pt-4 border-t border-emerald-50 flex items-center justify-between mt-4">
                    <div>
                        <h4 class="text-xs font-bold text-emerald-950">প্রফেসর রফিকুল ইসলাম</h4>
                        <span class="text-[11px] text-stone-500 font-medium">ধানমন্ডি, ঢাকা</span>
                    </div>
                    <span class="text-[10px] bg-green-100 text-green-800 font-bold px-2 py-0.5 rounded-full">ভেরিফায়েড</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-emerald-100 shadow-md flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center gap-1 text-amber-400 text-xs">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-xs sm:text-sm text-stone-700 font-medium leading-relaxed">
                        "বাজারে ভেজালের ভিড়ে এমন নির্ভেজাল খাঁটি জিনিস পেয়ে আমি নিয়মিত কাস্টমার হয়ে গেলাম।"
                    </p>
                </div>
                <div class="pt-4 border-t border-emerald-50 flex items-center justify-between mt-4">
                    <div>
                        <h4 class="text-xs font-bold text-emerald-950">সেলিনা পারভীন</h4>
                        <span class="text-[11px] text-stone-500 font-medium">উত্তরা, ঢাকা</span>
                    </div>
                    <span class="text-[10px] bg-green-100 text-green-800 font-bold px-2 py-0.5 rounded-full">ভেরিফায়েড</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-emerald-100 shadow-md flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center gap-1 text-amber-400 text-xs">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-xs sm:text-sm text-stone-700 font-medium leading-relaxed">
                        "ল্যাব টেস্টের মতো কোয়ালিটি। হৃদরোগী ও পরিবারের বাচ্চাদের জন্য এই তেল-মধুর জুড়ি নেই।"
                    </p>
                </div>
                <div class="pt-4 border-t border-emerald-50 flex items-center justify-between mt-4">
                    <div>
                        <h4 class="text-xs font-bold text-emerald-950">ডা. কামরুল হাসান</h4>
                        <span class="text-[11px] text-stone-500 font-medium">চট্টগ্রাম সদর</span>
                    </div>
                    <span class="text-[10px] bg-green-100 text-green-800 font-bold px-2 py-0.5 rounded-full">ভেরিফায়েড</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-emerald-100 shadow-md flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center gap-1 text-amber-400 text-xs">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-xs sm:text-sm text-stone-700 font-medium leading-relaxed">
                        "ক্যাশ অন ডেলিভারিতে চেক করে নিয়েছি। তেলের ঝাঁঝ এবং মধুর ফ্লেভার একদম এক নম্বর।"
                    </p>
                </div>
                <div class="pt-4 border-t border-emerald-50 flex items-center justify-between mt-4">
                    <div>
                        <h4 class="text-xs font-bold text-emerald-950">মোশাররফ হোসেন</h4>
                        <span class="text-[11px] text-stone-500 font-medium">রাজশাহী</span>
                    </div>
                    <span class="text-[10px] bg-green-100 text-green-800 font-bold px-2 py-0.5 rounded-full">ভেরিফায়েড</span>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. HIGH CONVERTING 1-PAGE CASH ON DELIVERY CHECKOUT FORM -->
    <section id="fast-order-form" class="max-w-4xl mx-auto px-4 scroll-mt-20">
        <div class="bg-white rounded-3xl border-4 border-emerald-400 shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-emerald-800 via-green-700 to-emerald-900 text-white p-6 sm:p-8 text-center">
                <span class="inline-block bg-yellow-300 text-emerald-950 text-xs font-black uppercase px-3 py-1 rounded-full mb-2">
                    ⚡ সহজ ১-মিনিট ক্যাশ অন ডেলিভারি ফর্ম
                </span>
                <h3 class="text-2xl sm:text-4xl font-black">অর্ডার করতে নিচের তথ্যগুলো পূরণ করুন</h3>
                <p class="text-emerald-100 text-xs sm:text-sm mt-1">অগ্রিম ১ টাকাও লাগবে না, পার্সেল হাতে পেয়ে দেখে মূল্য পরিশোধ করবেন</p>
            </div>

            <form action="{{ route('single.fast.order', $slug ?? ($store->slug ?? 'shop001')) }}" method="POST" class="p-6 sm:p-10 space-y-6" id="organicOrderForm">
                @csrf
                <input type="hidden" name="product_id" value="{{ $mainProduct->id ?? 1 }}">
                <input type="hidden" name="unit_price" id="organic_unit_price" value="{{ $offerPrice }}">
                <input type="hidden" name="product_variant" id="organic_selected_variant" value="১ লিটার তেল + ৫০০ গ্রাম সুন্দরবনের মধু (৳৯৫০)">
                <input type="hidden" name="selected_package" id="organic_selected_package" value="১ লিটার তেল + ৫০০ গ্রাম মধু">

                <!-- Step 1: Package Selection -->
                <div class="space-y-3">
                    <label class="block text-sm font-black text-emerald-950">
                        ১. প্যাকেজ নির্বাচন করুন <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <label class="relative flex items-center justify-between p-4 rounded-2xl border-2 border-emerald-500 bg-emerald-50/70 cursor-pointer package-card hover:bg-emerald-50 transition" onclick="selectOrganicPackage(1, {{ $offerPrice }}, '১ লিটার তেল + ৫০০ গ্রাম মধু', this)">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="pkg_choice" value="1" checked class="text-emerald-700 focus:ring-emerald-500">
                                <div>
                                    <span class="font-black text-stone-900 text-sm block">১ লিটার তেল + ৫০০ গ্রাম মধু</span>
                                    <span class="text-xs text-stone-600 font-medium">খাঁটি কোল্ড-প্রেসড ও চাকভাঙা মধু</span>
                                </div>
                            </div>
                            <span class="text-lg font-black text-emerald-800">৳{{ number_format($offerPrice) }}</span>
                        </label>

                        <label class="relative flex items-center justify-between p-4 rounded-2xl border-2 border-stone-200 bg-white cursor-pointer package-card hover:bg-emerald-50 transition" onclick="selectOrganicPackage(2, 1790, 'মেগা ফ্যামিলি প্যাক (২ লিটার তেল + ১ কেজি মধু - ফ্রি ডেলিভারি)', this)">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="pkg_choice" value="2" class="text-emerald-700 focus:ring-emerald-500">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-black text-stone-900 text-sm block">মেগা ফ্যামিলি প্যাক</span>
                                        <span class="bg-red-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">ফ্রি ডেলিভারি</span>
                                    </div>
                                    <span class="text-xs text-stone-600 font-medium">২ লিটার তেল + ১ কেজি মধু (ফ্রি ডেলিভারি)</span>
                                </div>
                            </div>
                            <span class="text-lg font-black text-emerald-800">৳১,৭৯০</span>
                        </label>
                    </div>
                </div>

                <!-- Step 2: Customer Details -->
                <div class="space-y-4 pt-2">
                    <label class="block text-sm font-black text-emerald-950">
                        ২. আপনার ডেলিভারি তথ্য দিন <span class="text-red-500">*</span>
                    </label>

                    <div>
                        <label class="block text-xs font-bold text-stone-700 mb-1">আপনার পূর্ণ নাম *</label>
                        <input type="text" name="customer_name" required placeholder="যেমন: প্রফেসর রফিকুল ইসলাম" class="w-full px-4 py-3 rounded-xl border-2 border-stone-300 focus:border-emerald-600 focus:outline-none text-stone-900 font-medium text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-700 mb-1">সচল মোবাইল নম্বর *</label>
                        <input type="tel" name="customer_phone" required placeholder="যেমন: 017xxxxxxxx" class="w-full px-4 py-3 rounded-xl border-2 border-stone-300 focus:border-emerald-600 focus:outline-none text-stone-900 font-medium text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-700 mb-1">সম্পূর্ণ ডেলিভারি ঠিকানা *</label>
                        <textarea name="customer_address" rows="2" required placeholder="যেমন: বাসা নং, রোড নং, থানা ও জেলার নাম" class="w-full px-4 py-3 rounded-xl border-2 border-stone-300 focus:border-emerald-600 focus:outline-none text-stone-900 font-medium text-sm"></textarea>
                    </div>

                    <!-- Delivery Area -->
                    <div>
                        <label class="block text-xs font-bold text-stone-700 mb-2">ডেলিভারি এরিয়া বেছে নিন *</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <label class="flex items-center justify-between p-3.5 rounded-xl border-2 border-emerald-600 bg-emerald-50/60 cursor-pointer delivery-card transition" onclick="setOrganicDelivery({{ $dhakaCharge }}, this)">
                                <div class="flex items-center gap-2">
                                    <input type="radio" name="delivery_location" value="dhaka" checked class="text-emerald-700">
                                    <span class="text-xs sm:text-sm font-bold text-stone-900">ঢাকা সিটির ভিতরে</span>
                                </div>
                                <span class="text-xs sm:text-sm font-bold text-emerald-800">৳{{ $dhakaCharge }}</span>
                            </label>

                            <label class="flex items-center justify-between p-3.5 rounded-xl border-2 border-stone-200 bg-white cursor-pointer delivery-card transition hover:bg-emerald-50" onclick="setOrganicDelivery({{ $outsideCharge }}, this)">
                                <div class="flex items-center gap-2">
                                    <input type="radio" name="delivery_location" value="outside" class="text-emerald-700">
                                    <span class="text-xs sm:text-sm font-bold text-stone-900">ঢাকা সিটির বাইরে</span>
                                </div>
                                <span class="text-xs sm:text-sm font-bold text-emerald-800">৳{{ $outsideCharge }}</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Price Summary Box -->
                <div class="p-5 bg-emerald-50 rounded-2xl border-2 border-emerald-200 space-y-2 text-sm">
                    <div class="flex justify-between text-stone-700 font-medium">
                        <span>পণ্যের মূল্য:</span>
                        <span class="font-bold text-stone-900" id="organic_subtotal_text">৳{{ number_format($offerPrice) }}</span>
                    </div>
                    <div class="flex justify-between text-stone-700 font-medium">
                        <span>ডেলিভারি চার্জ:</span>
                        <span class="font-bold text-stone-900" id="organic_delivery_text">৳{{ $dhakaCharge }}</span>
                    </div>
                    <div class="h-px bg-emerald-200 my-1"></div>
                    <div class="flex justify-between text-base sm:text-lg font-black text-emerald-950">
                        <span>সর্বমোট প্রদেয় বিল:</span>
                        <span class="text-2xl font-black text-emerald-800" id="organic_total_text">৳{{ number_format($offerPrice + $dhakaCharge) }}</span>
                    </div>
                </div>

                <button type="submit" class="pulse-btn w-full bg-gradient-to-r from-emerald-800 via-green-700 to-emerald-900 hover:from-emerald-900 hover:to-green-900 text-yellow-300 font-black text-lg sm:text-xl py-4 rounded-2xl shadow-xl transition transform hover:-translate-y-0.5 flex items-center justify-center gap-3">
                    <i class="fas fa-lock text-yellow-300"></i>
                    <span>অর্ডার কনফার্ম করুন (ক্যাশ অন ডেলিভারি)</span>
                </button>
            </form>
        </div>
    </section>

    <!-- 7. FREQUENTLY ASKED QUESTIONS (FAQ) -->
    <section class="max-w-4xl mx-auto px-4 pb-12">
        <div class="text-center mb-8">
            <span class="text-xs uppercase font-extrabold text-emerald-800 tracking-widest">সাধারণ প্রশ্নোত্তর</span>
            <h2 class="text-2xl sm:text-3xl font-black text-stone-900 mt-1">সচরাচর জানতে চাওয়া প্রশ্ন ও উত্তর</h2>
        </div>

        <div class="space-y-3">
            <div class="bg-white p-5 rounded-2xl border-2 border-emerald-100 shadow-sm">
                <h4 class="font-black text-stone-900 text-sm sm:text-base flex items-center gap-2">
                    <i class="fas fa-question-circle text-emerald-700"></i> তেল ও মধুর খাঁটি হওয়ার নিশ্চয়তা কী?
                </h4>
                <p class="text-xs sm:text-sm text-stone-600 font-medium mt-2 leading-relaxed pl-6">
                    আমাদের তেল নিজস্ব কাঠের ঘানিতে ভাঙানো ও মধু সুন্দরবনের মৌয়ালদের থেকে সংগৃহীত। কোনো ভেজাল পেলে দ্বিগুণ ক্ষতিপূরণ গ্যারান্টি।
                </p>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-emerald-100 shadow-sm">
                <h4 class="font-black text-stone-900 text-sm sm:text-base flex items-center gap-2">
                    <i class="fas fa-question-circle text-emerald-700"></i> ডেলিভারির আগে কি অগ্রিম টাকা দিতে হবে?
                </h4>
                <p class="text-xs sm:text-sm text-stone-600 font-medium mt-2 leading-relaxed pl-6">
                    না, ১ টাকাও অগ্রিম দিতে হবে না। পার্সেল আপনার ঠিকানায় পৌঁছানোর পর সিল খুলে দেখে নিয়ে ক্যাশ অন ডেলিভারিতে পেমেন্ট করবেন।
                </p>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-emerald-100 shadow-sm">
                <h4 class="font-black text-stone-900 text-sm sm:text-base flex items-center gap-2">
                    <i class="fas fa-question-circle text-emerald-700"></i> বোতল বা জার ভেঙে যাওয়ার সম্ভাবনা আছে কি?
                </h4>
                <p class="text-xs sm:text-sm text-stone-600 font-medium mt-2 leading-relaxed pl-6">
                    আমরা ৫ স্তরের থার্মোকল ও বাবল র‍্যাপ দিয়ে শক্ত কার্টনে প্যাকেজিং করি। কোনো ক্ষতি হলে সম্পূর্ণ বিনামূল্যে রিপ্লেসমেন্ট দেওয়া হবে।
                </p>
            </div>
        </div>
    </section>

</main>

<!-- FLOATING WHATSAPP BUTTON -->
<a href="https://wa.me/8801700000000?text=আসসালামু%20আলাইকুম!%20সরিষার%20তেল%20ও%20মধু%20সম্পর্কে%20জানতে%20চাই" target="_blank" class="fixed bottom-20 right-4 z-40 bg-green-500 hover:bg-green-600 text-white p-3.5 rounded-full shadow-2xl flex items-center justify-center transition transform hover:scale-110" title="হোয়াটসঅ্যাপে কথা বলুন">
    <i class="fab fa-whatsapp text-3xl"></i>
</a>

<!-- MOBILE STICKY CTA -->
<div class="fixed bottom-0 left-0 right-0 z-30 sm:hidden bg-white/95 backdrop-blur-md border-t-2 border-emerald-300 p-3 shadow-2xl">
    <div class="flex items-center justify-between gap-3 max-w-md mx-auto">
        <div>
            <span class="text-[11px] text-stone-500 font-bold block">অফার প্রাইস</span>
            <span class="text-xl font-black text-emerald-800">৳{{ number_format($offerPrice) }}</span>
        </div>
        <a href="#fast-order-form" class="bg-emerald-800 hover:bg-emerald-900 text-yellow-300 font-black text-sm px-5 py-2.5 rounded-xl shadow-lg transition flex items-center gap-1.5">
            <i class="fas fa-shopping-basket"></i> এখনই কিনুন
        </a>
    </div>
</div>

<script>
    // Live Countdown Timer
    let organicHours = 4, organicMinutes = 38, organicSeconds = 21;
    setInterval(function() {
        if (organicSeconds > 0) {
            organicSeconds--;
        } else {
            organicSeconds = 59;
            if (organicMinutes > 0) {
                organicMinutes--;
            } else {
                organicMinutes = 59;
                if (organicHours > 0) organicHours--;
            }
        }
        document.getElementById('organic_timer_hours').textContent = String(organicHours).padStart(2, '0');
        document.getElementById('organic_timer_minutes').textContent = String(organicMinutes).padStart(2, '0');
        document.getElementById('organic_timer_seconds').textContent = String(organicSeconds).padStart(2, '0');
    }, 1000);

    let currentOrganicSubtotal = {{ $offerPrice }};
    let currentOrganicDelivery = {{ $dhakaCharge }};
    let isOrganicFreeDelivery = false;

    function selectOrganicPackage(pkgId, price, label, el) {
        currentOrganicSubtotal = price;
        isOrganicFreeDelivery = (pkgId === 2);
        document.getElementById('organic_unit_price').value = price;
        document.getElementById('organic_selected_variant').value = label;
        document.getElementById('organic_selected_package').value = label;

        document.querySelectorAll('.package-card').forEach(c => {
            c.classList.remove('border-emerald-500', 'bg-emerald-50/70');
            c.classList.add('border-stone-200', 'bg-white');
        });
        el.classList.add('border-emerald-500', 'bg-emerald-50/70');
        el.classList.remove('border-stone-200', 'bg-white');
        updateOrganicBill();
    }

    function setOrganicDelivery(charge, el) {
        currentOrganicDelivery = charge;
        document.querySelectorAll('.delivery-card').forEach(d => {
            d.classList.remove('border-emerald-600', 'bg-emerald-50/60');
            d.classList.add('border-stone-200', 'bg-white');
        });
        el.classList.add('border-emerald-600', 'bg-emerald-50/60');
        el.classList.remove('border-stone-200', 'bg-white');
        updateOrganicBill();
    }

    function updateOrganicBill() {
        let deliveryToApply = isOrganicFreeDelivery ? 0 : currentOrganicDelivery;
        let total = currentOrganicSubtotal + deliveryToApply;
        document.getElementById('organic_subtotal_text').textContent = '৳' + currentOrganicSubtotal.toLocaleString();
        document.getElementById('organic_delivery_text').textContent = isOrganicFreeDelivery ? 'ফ্রি (৳০)' : '৳' + deliveryToApply;
        document.getElementById('organic_total_text').textContent = '৳' + total.toLocaleString();
    }
</script>
@endsection
