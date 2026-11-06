@extends('front_end.layouts.app')

@section('page-title')
    {{ $store->name ?? 'Men\'s Royal Fashion Panjabi' }}
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
    $productTitle = $themeSettings['hero_title'] ?? 'ঈদ ও উৎসব কালেকশন প্রিমিয়াম সুতি কারচুপি এমব্রয়ডারি পাঞ্জাবি';
    $productDesc = $themeSettings['hero_subtitle'] ?? '১০০% পিউর আরামদায়ক সুতি কাপড়, কলার ও প্ল্যাকেটে নিখুঁত হ্যান্ডমেড কারচুপির সূক্ষ্ম কাজ এবং আকর্ষণীয় ড্রপ ফিটিং। আপনার আভিজাত্যের আসল প্রতীক।';
    
    $regularPrice = $toNum($themeSettings['hero_regular_price'] ?? 1850, 1850);
    $offerPrice = $toNum($themeSettings['hero_offer_price'] ?? 1290, 1290);
    
    if ($regularPrice <= 0) $regularPrice = 1850;
    if ($offerPrice <= 0) $offerPrice = 1290;
    
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

<main class="space-y-12 sm:space-y-20 bg-stone-50 text-stone-900">

    <!-- 1. ROYAL FASHION MAGAZINE EDITORIAL HERO -->
    <section class="relative pt-10 sm:pt-16 pb-16 bg-gradient-to-b from-amber-50/70 via-stone-50 to-white border-b border-amber-200">
        <div class="max-w-6xl mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                
                <!-- Left Portrait with gold frame -->
                <div class="lg:col-span-5 flex justify-center order-2 lg:order-1">
                    <div class="relative p-3 bg-white rounded-3xl shadow-2xl border-4 border-amber-300 max-w-sm w-full">
                        <div class="absolute -top-3.5 -right-3.5 bg-red-600 text-white font-extrabold text-xs uppercase px-3.5 py-1.5 rounded-full shadow-lg tracking-wider animate-pulse">
                            EXCLUSIVE 2026
                        </div>
                        <img src="{{ $productImg1 }}" alt="{{ $productTitle }}" class="w-full h-[420px] object-cover rounded-2xl shadow-inner">
                        <div class="mt-3 text-center text-xs font-serif text-amber-900 font-bold bg-amber-50 py-2 px-3 rounded-xl border border-amber-200">
                            ✦ ১০০% পিউর সুতি হ্যান্ডমেড এমব্রয়ডারি কালেকশন ✦
                        </div>
                    </div>
                </div>

                <!-- Right Editorial Text -->
                <div class="lg:col-span-7 space-y-5 text-center lg:text-left order-1 lg:order-2">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-100 text-amber-900 text-xs sm:text-sm font-black border border-amber-300 shadow-sm">
                        <i class="fas fa-crown text-amber-600"></i>
                        <span>{{ $themeSettings['hero_badge'] ?? '👑 ROYAL HERITAGE 2026 EDITION' }}</span>
                    </div>

                    <h1 class="text-3xl sm:text-5xl font-black text-stone-900 leading-tight">
                        {{ $productTitle }}
                    </h1>

                    <p class="text-stone-700 text-base sm:text-lg leading-relaxed font-sans font-medium">
                        {{ $productDesc }}
                    </p>

                    <!-- Urgent Countdown Timer -->
                    <div class="p-3.5 bg-gradient-to-r from-red-600 via-rose-600 to-red-700 text-white rounded-2xl shadow-md flex flex-wrap items-center justify-between gap-3">
                        <div class="flex items-center gap-2 font-bold text-xs sm:text-sm">
                            <span class="inline-block w-2.5 h-2.5 bg-yellow-300 rounded-full animate-ping"></span>
                            <span>🔥 সীমিত সময়ের ধামাকা অফার শেষ হতে বাকি:</span>
                        </div>
                        <div class="flex items-center gap-1.5 text-xs sm:text-sm font-black text-stone-900 font-mono">
                            <span class="bg-white px-2 py-1 rounded shadow text-red-600" id="timer_hours">04</span> :
                            <span class="bg-white px-2 py-1 rounded shadow text-red-600" id="timer_minutes">32</span> :
                            <span class="bg-white px-2 py-1 rounded shadow text-red-600" id="timer_seconds">18</span>
                        </div>
                    </div>

                    <!-- Price Badge -->
                    <div class="inline-flex flex-wrap items-center gap-6 p-4 rounded-2xl bg-white border-2 border-amber-300 shadow-md">
                        <div>
                            <span class="text-xs text-stone-500 block font-bold uppercase">রেগুলার মূল্য</span>
                            <span class="text-xl font-extrabold text-stone-400 line-through">৳{{ number_format($regularPrice) }}</span>
                        </div>
                        <div class="h-8 w-px bg-amber-300 hidden sm:block"></div>
                        <div>
                            <span class="text-xs text-blue-900 font-black block uppercase">উৎসব অফার মূল্য</span>
                            <span class="text-3xl sm:text-4xl font-black text-blue-900">৳{{ number_format($offerPrice) }}</span>
                        </div>
                        <span class="bg-red-600 text-white text-xs font-black px-3.5 py-1.5 rounded-full shadow-sm">
                            {{ $themeSettings['hero_discount_tag'] ?? '৩০% প্রিমিয়াম ছাড়!' }}
                        </span>
                    </div>

                    <!-- Bullet Features Checklist -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 pt-1 text-left text-xs sm:text-sm text-stone-800 font-bold">
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-green-600 text-base"></i> ১০০% পিউর আরামদায়ক সুতি কাপড়</div>
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-green-600 text-base"></i> কলার ও প্ল্যাকেটে নিখুঁত কারচুপি কাজ</div>
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-green-600 text-base"></i> পার্সেল খুলে চেক করে পেমেন্টের সুবিধা</div>
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-green-600 text-base"></i> সারা দেশে দ্রুততম ক্যাশ অন ডেলিভারি</div>
                    </div>

                    <div class="pt-2">
                        <a href="#fast-order-form" class="pulse-btn inline-flex items-center justify-center gap-3 bg-blue-950 hover:bg-blue-900 text-amber-300 font-black text-lg px-8 py-4 rounded-2xl shadow-xl transition w-full sm:w-auto">
                            <i class="fas fa-shopping-bag text-amber-400 text-xl"></i>
                            <span>{{ $themeSettings['hero_button_text'] ?? '👉 এখনই অর্ডার করুন (ক্যাশ অন ডেলিভারি)' }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. PRODUCT CLOSE-UP & FINISHING DETAILS GALLERY -->
    <section class="max-w-6xl mx-auto px-4">
        <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
            <span class="text-xs uppercase font-extrabold text-blue-900 tracking-widest bg-amber-100 px-3 py-1 rounded-full border border-amber-300">নিখুঁত কারুকাজ ও কোয়ালিটি</span>
            <h2 class="text-2xl sm:text-4xl font-black text-stone-900">পাঞ্জাবির ফিনিশিং ও কাজের বিবরণ সরাসরি দেখুন</h2>
            <p class="text-stone-600 text-sm font-medium">প্রতিটি সেলাই ও কারচুপির কাজে নিশ্চিত করা হয়েছে নিখুঁত আভিজাত্য</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white rounded-3xl p-4 border-2 border-amber-200 shadow-md hover:shadow-xl transition">
                <img src="{{ $productImg1 }}" alt="সামগ্রিক লুক" class="w-full h-72 object-cover rounded-2xl mb-4">
                <h3 class="font-black text-stone-900 text-base mb-1">👑 ক্লাসিক রয়্যাল ড্রপ ফিটিং</h3>
                <p class="text-xs text-stone-600 leading-relaxed font-medium">শরীরের সাথে মানানসই আধুনিক ও রাজকীয় ফিটিং, যা পরলে আপনার ব্যক্তিত্বে এনে দেবে নতুন মাত্রা।</p>
            </div>

            <div class="bg-white rounded-3xl p-4 border-2 border-amber-200 shadow-md hover:shadow-xl transition">
                <img src="{{ $productImg2 }}" alt="কলার কারচুপি" class="w-full h-72 object-cover rounded-2xl mb-4">
                <h3 class="font-black text-stone-900 text-base mb-1">✨ নিখুঁত কলার ও প্ল্যাকেট কাজ</h3>
                <p class="text-xs text-stone-600 leading-relaxed font-medium">দক্ষ কারিগরদের হাতে তৈরি সূক্ষ্ম এমব্রয়ডারি ও কারচুপির কাজ যা অনেক ধোয়ার পরেও নতুনের মতো থাকে।</p>
            </div>

            <div class="bg-white rounded-3xl p-4 border-2 border-amber-200 shadow-md hover:shadow-xl transition sm:col-span-2 lg:col-span-1">
                <img src="{{ $productImg3 }}" alt="কাপড় ও বাটন" class="w-full h-72 object-cover rounded-2xl mb-4">
                <h3 class="font-black text-stone-900 text-base mb-1">🌿 ১০০% ব্রিদেবল পিউর কটন</h3>
                <p class="text-xs text-stone-600 leading-relaxed font-medium">অত্যন্ত মোলায়েম এবং আরামদায়ক সুতি কাপড়, যা আমাদের দেশের গরম আবহাওয়ায় দীর্ঘক্ষণ স্বাচ্ছন্দ্য দেয়।</p>
            </div>
        </div>
    </section>

    <!-- 3. SIZE MEASUREMENT CHART -->
    <section class="max-w-5xl mx-auto px-4">
        <div class="bg-white rounded-3xl p-6 sm:p-10 border-2 border-amber-200 shadow-xl space-y-6">
            <div class="text-center space-y-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-100 text-blue-900 text-xs font-black uppercase">
                    <i class="fas fa-ruler-combined"></i> সাইজ চার্ট ও মাপের নির্দেশিকা
                </span>
                <h2 class="text-2xl sm:text-3xl font-black text-stone-900">আপনার সঠিক পাঞ্জাবির সাইজ নির্বাচন করুন</h2>
                <p class="text-xs sm:text-sm text-stone-600 font-medium">সঠিক সাইজ পেতে নিচের চার্টটি অনুসরণ করুন। আপনি রেগুলার যে শার্ট বা পাঞ্জাবি পরেন সেই সাইজটি বেছে নিন।</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-center border-collapse">
                    <thead>
                        <tr class="bg-blue-950 text-white text-xs sm:text-sm font-black">
                            <th class="p-3.5 rounded-l-xl">সাইজ (Size)</th>
                            <th class="p-3.5">পাঞ্জাবির ঝুল (Length)</th>
                            <th class="p-3.5">বুকের মাপ (Chest)</th>
                            <th class="p-3.5 rounded-r-xl">কলার (Collar)</th>
                        </tr>
                    </thead>
                    <tbody class="text-xs sm:text-sm font-bold text-stone-800 divide-y divide-amber-100">
                        <tr class="hover:bg-amber-50/50">
                            <td class="p-3.5 font-black text-blue-900">M (৪০)</td>
                            <td class="p-3.5">৪০ ইঞ্চি</td>
                            <td class="p-3.5">৪২ ইঞ্চি</td>
                            <td class="p-3.5">১৫.৫ ইঞ্চি</td>
                        </tr>
                        <tr class="hover:bg-amber-50/50">
                            <td class="p-3.5 font-black text-blue-900">L (৪২)</td>
                            <td class="p-3.5">৪২ ইঞ্চি</td>
                            <td class="p-3.5">৪৪ ইঞ্চি</td>
                            <td class="p-3.5">১৬ ইঞ্চি</td>
                        </tr>
                        <tr class="hover:bg-amber-50/50">
                            <td class="p-3.5 font-black text-blue-900">XL (৪৪)</td>
                            <td class="p-3.5">৪৪ ইঞ্চি</td>
                            <td class="p-3.5">৪৬ ইঞ্চি</td>
                            <td class="p-3.5">১৬.৫ ইঞ্চি</td>
                        </tr>
                        <tr class="hover:bg-amber-50/50">
                            <td class="p-3.5 font-black text-blue-900">XXL (৪৬)</td>
                            <td class="p-3.5">৪৬ ইঞ্চি</td>
                            <td class="p-3.5">৪৮ ইঞ্চি</td>
                            <td class="p-3.5">১৭ ইঞ্চি</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="p-3 bg-amber-50 rounded-2xl border border-amber-200 text-center text-xs font-bold text-amber-900">
                💡 <span class="underline">বিশেষ সুবিধা:</span> সাইজে কোনো অমিল বা সমস্যা হলে ডেলিভারির পর বিনামূল্যে এক্সচেঞ্জ করার শতভাগ সুবিধা রয়েছে।
            </div>
        </div>
    </section>

    <!-- 4. DISTINCT CATEGORY FEATURES SECTION -->
    <section class="max-w-6xl mx-auto px-4">
        <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
            <span class="text-xs uppercase font-extrabold text-blue-900 tracking-widest">মেনজ ফ্যাশন ও পাঞ্জাবি</span>
            <h2 class="text-2xl sm:text-4xl font-black text-gray-900">আমাদের সেরা বিশেষত্ব ও সুযোগ-সুবিধা</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-2xl border-2 border-amber-200 shadow-sm hover:shadow-lg transition">
                <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-900 flex items-center justify-center text-xl mb-4 font-black">
                    <i class="fas fa-certificate"></i>
                </div>
                <h3 class="font-black text-lg mb-2 text-stone-900">১০০% অরিজিনাল ও অথেনটিক</h3>
                <p class="text-xs sm:text-sm text-stone-600 leading-relaxed font-medium">সর্বোচ্চ গুণমান নিশ্চিত করে সরাসরি দক্ষ তাঁতি ও কারিগরদের থেকে প্রস্তুতকৃত।</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border-2 border-amber-200 shadow-sm hover:shadow-lg transition">
                <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-900 flex items-center justify-center text-xl mb-4 font-black">
                    <i class="fas fa-truck-ramp-box"></i>
                </div>
                <h3 class="font-black text-lg mb-2 text-stone-900">ক্যাশ অন ডেলিভারি</h3>
                <p class="text-xs sm:text-sm text-stone-600 leading-relaxed font-medium">আগে কোনো টাকা দিতে হবে না, পণ্য হাতে পেয়ে দেখে তবেই মূল্য পরিশোধ করুন।</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border-2 border-amber-200 shadow-sm hover:shadow-lg transition">
                <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-900 flex items-center justify-center text-xl mb-4 font-black">
                    <i class="fas fa-arrows-rotate"></i>
                </div>
                <h3 class="font-black text-lg mb-2 text-stone-900">সহজ রিটার্ন ও রিপ্লেসমেন্ট</h3>
                <p class="text-xs sm:text-sm text-stone-600 leading-relaxed font-medium">কোনো ত্রুটি বা অমিল পেলে দ্রুত পরিবর্তন বা রিটার্ন করার শতভাগ সুযোগ।</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border-2 border-amber-200 shadow-sm hover:shadow-lg transition">
                <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-900 flex items-center justify-center text-xl mb-4 font-black">
                    <i class="fas fa-headset"></i>
                </div>
                <h3 class="font-black text-lg mb-2 text-stone-900">২৪/৭ কাস্টমার সাপোর্ট</h3>
                <p class="text-xs sm:text-sm text-stone-600 leading-relaxed font-medium">যেকোনো তথ্য বা সহায়তার জন্য আমাদের হটলাইনে সরাসরি কথা বলুন।</p>
            </div>
        </div>
    </section>

    <!-- 5. VERIFIED CUSTOMER REVIEWS (SOCIAL PROOF) -->
    <section class="max-w-6xl mx-auto px-4">
        <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
            <span class="text-xs uppercase font-extrabold text-blue-900 tracking-widest bg-amber-100 px-3 py-1 rounded-full border border-amber-300">কাস্টমার ফিডব্যাক</span>
            <h2 class="text-2xl sm:text-4xl font-black text-stone-900">সন্তুষ্ট গ্রাহকদের বাস্তব মতামত</h2>
            <div class="flex items-center justify-center gap-1 text-amber-500 text-lg">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                <span class="text-xs font-black text-stone-700 ml-2">৪.৯/৫ (৮৫০+ ভেরিফাইড রিভিউ)</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-3xl border-2 border-amber-200 shadow-md space-y-3">
                <div class="flex items-center justify-between">
                    <div class="flex text-amber-400 text-sm">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <span class="bg-green-100 text-green-700 text-[10px] font-black px-2 py-0.5 rounded-full">✓ ভেরিফাইড ক্রেতা</span>
                </div>
                <p class="text-xs sm:text-sm text-stone-700 leading-relaxed font-medium">
                    "পাঞ্জাবিটি হাতে পেয়ে সত্যি মুগ্ধ হয়েছি! সুতি কাপড়ের কোয়ালিটি অত্যন্ত আরামদায়ক এবং কলারের কারচুপি কাজ খুব নিখুঁত। L সাইজ একদম পারফেক্ট হয়েছে।"
                </p>
                <div class="pt-2 border-t border-amber-100 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-blue-900 text-amber-300 font-black flex items-center justify-center text-sm">ত</div>
                    <div>
                        <h4 class="font-extrabold text-xs sm:text-sm text-stone-900">তানভীর আহমেদ</h4>
                        <span class="text-[11px] text-stone-500">উত্তরা, ঢাকা</span>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border-2 border-amber-200 shadow-md space-y-3">
                <div class="flex items-center justify-between">
                    <div class="flex text-amber-400 text-sm">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <span class="bg-green-100 text-green-700 text-[10px] font-black px-2 py-0.5 rounded-full">✓ ভেরিফাইড ক্রেতা</span>
                </div>
                <p class="text-xs sm:text-sm text-stone-700 leading-relaxed font-medium">
                    "অনলাইনে কাপড় কিনতে ভয় পেতাম, কিন্তু পার্সেল খুলে দেখে পেমেন্ট করার সুযোগ থাকায় অর্ডার করেছিলাম। যেমন দেখেছি হুবহু তেমন পেয়েছি। ধন্যবাদ!"
                </p>
                <div class="pt-2 border-t border-amber-100 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-blue-900 text-amber-300 font-black flex items-center justify-center text-sm">ম</div>
                    <div>
                        <h4 class="font-extrabold text-xs sm:text-stone-900 text-stone-900">মাহমুদুল হাসান</h4>
                        <span class="text-[11px] text-stone-500">পাঁচলাইশ, চট্টগ্রাম</span>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border-2 border-amber-200 shadow-md space-y-3">
                <div class="flex items-center justify-between">
                    <div class="flex text-amber-400 text-sm">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <span class="bg-green-100 text-green-700 text-[10px] font-black px-2 py-0.5 rounded-full">✓ ভেরিফাইড ক্রেতা</span>
                </div>
                <p class="text-xs sm:text-sm text-stone-700 leading-relaxed font-medium">
                    "ঈদের জন্য ২টা কম্বো নিয়েছিলাম। প্রিমিয়াম প্যাকিং এবং মাত্র ২ দিনে ডেলিভারি পেয়েছি। কাপড়ের রঙ ও ড্রপ ফিটিং এক কথায় অসাধারণ।"
                </p>
                <div class="pt-2 border-t border-amber-100 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-blue-900 text-amber-300 font-black flex items-center justify-center text-sm">স</div>
                    <div>
                        <h4 class="font-extrabold text-xs sm:text-sm text-stone-900">সাব্বির হোসেন</h4>
                        <span class="text-[11px] text-stone-500">উপশহর, সিলেট</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. YOUTUBE VIDEO SECTION (SHOWN ONLY IF URL IS SET) -->
    @if(!empty($embedUrl))
    <section class="max-w-5xl mx-auto px-4">
        <div class="bg-white p-6 sm:p-10 rounded-3xl border-2 border-amber-200 shadow-2xl text-center space-y-6">
            <div class="space-y-2">
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-100 text-red-600 text-xs font-bold uppercase">
                    <i class="fab fa-youtube text-base"></i> ভিডিও রিভিউ
                </span>
                <h2 class="text-2xl sm:text-3xl font-black text-gray-900">
                    {{ $themeSettings['video_title'] ?? 'পণ্যটির আসল ব্যবহার ও কার্যকারিতা সরাসরি ভিডিওতে দেখুন' }}
                </h2>
                <p class="text-xs sm:text-sm text-stone-600 max-w-xl mx-auto font-medium">
                    {{ $themeSettings['video_subtitle'] ?? 'অর্ডার করার আগে ভিডিওটি দেখে পণ্যের কোয়ালিটি যাচাই করে নিন' }}
                </p>
            </div>

            <!-- Responsive 16:9 Video Frame -->
            <div class="relative w-full rounded-2xl overflow-hidden shadow-2xl border-2 border-amber-200 aspect-video max-w-4xl mx-auto bg-black">
                <iframe 
                    class="absolute inset-0 w-full h-full"
                    src="{{ $embedUrl }}" 
                    title="YouTube video player" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                    allowfullscreen>
                </iframe>
            </div>

            <div class="pt-2">
                <a href="#fast-order-form" class="inline-flex items-center gap-2 bg-blue-950 hover:bg-blue-900 text-amber-300 font-extrabold text-base px-8 py-3.5 rounded-xl shadow-lg transition">
                    <i class="fas fa-hand-point-right"></i> ভিডিও দেখা শেষ হলে অর্ডার করতে এখানে ক্লিক করুন
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- 7. 1-CLICK CASH ON DELIVERY CHECKOUT FORM -->
    <section id="fast-order-form" class="max-w-4xl mx-auto px-4 scroll-mt-24">
        <div class="bg-white rounded-3xl shadow-2xl border-4 border-amber-300 overflow-hidden">
            
            <div class="bg-blue-950 text-white p-6 sm:p-8 text-center space-y-2">
                <span class="inline-block bg-amber-400 text-blue-950 text-xs font-black uppercase px-4 py-1 rounded-full shadow-sm">ক্যাশ অন ডেলিভারি</span>
                <h2 class="text-2xl sm:text-3xl font-black">অর্ডার ফর্মটি সঠিকভাবে পূরণ করুন</h2>
                <p class="text-xs sm:text-sm text-amber-100 font-medium">পণ্য হাতে পেয়ে দেখে টাকা পরিশোধ করুন। কোনো প্রকার অগ্রিম পেমেন্টের প্রয়োজন নেই।</p>
            </div>

            <form id="singleProductFastForm" class="p-6 sm:p-10 space-y-7" method="POST" action="{{ route('single.fast.order', $slug) }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $mainProduct->id ?? 1 }}">
                <input type="hidden" id="base_price" value="{{ $offerPrice }}">
                <input type="hidden" name="product_variant" id="selectedVariantInput" value="L (৪২) - স্নো হোয়াইট">

                <!-- STEP 1: PACKAGE SELECTOR -->
                <div>
                    <label class="block text-sm font-black text-stone-900 uppercase tracking-wider mb-3">
                        ১. আপনার প্যাকেজ নির্বাচন করুন:
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <label class="relative flex items-center justify-between p-4 rounded-2xl border-2 border-blue-900 bg-blue-50 cursor-pointer package-card hover:shadow-md transition">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="order_package" value="1" class="w-5 h-5 text-blue-900 accent-blue-900" checked onchange="updateTotalCalculation()">
                                <div>
                                    <span class="font-extrabold text-stone-900 text-sm sm:text-base block">১টি প্রিমিয়াম পাঞ্জাবি</span>
                                    <span class="text-xs text-stone-600 font-medium">স্ট্যান্ডার্ড প্যাকেজ</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="font-black text-blue-950 text-lg">৳{{ number_format($offerPrice) }}</span>
                            </div>
                        </label>

                        <label class="relative flex items-center justify-between p-4 rounded-2xl border-2 border-stone-200 bg-white cursor-pointer package-card hover:border-blue-900/50 transition">
                            <span class="absolute -top-2.5 right-4 bg-red-600 text-white text-[10px] font-black uppercase px-2.5 py-0.5 rounded-full shadow-sm">
                                মেগা অফার
                            </span>
                            <div class="flex items-center gap-3">
                                <input type="radio" name="order_package" value="2" data-special-price="2390" class="w-5 h-5 text-blue-900 accent-blue-900" onchange="updateTotalCalculation()">
                                <div>
                                    <span class="font-extrabold text-stone-900 text-sm sm:text-base block">২টি পাঞ্জাবি ডুয়েল কম্বো</span>
                                    <span class="text-xs text-stone-600 font-medium">ফ্যামিলি মেগা সেভিংস (৳১৯০ ছাড়)</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="font-black text-blue-950 text-lg">৳2,390</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- STEP 2: SIZE & COLOR SELECTOR -->
                <div class="p-5 bg-amber-50/70 rounded-2xl border border-amber-200 space-y-4">
                    <div>
                        <label class="block text-xs font-black text-stone-900 uppercase tracking-wider mb-2">
                            ২. আপনার পাঞ্জাবির সাইজ নির্বাচন করুন:
                        </label>
                        <div class="grid grid-cols-4 gap-2 text-center" id="sizeSelectorGroup">
                            <button type="button" class="size-pill border-2 border-stone-300 bg-white py-2 px-1 rounded-xl text-xs sm:text-sm font-black text-stone-800 hover:border-blue-900 transition" onclick="selectPanjabiSize(this, 'M (৪০)')">M (৪০)</button>
                            <button type="button" class="size-pill border-2 border-blue-900 bg-blue-900 text-white py-2 px-1 rounded-xl text-xs sm:text-sm font-black shadow transition active" onclick="selectPanjabiSize(this, 'L (৪২)')">L (৪২)</button>
                            <button type="button" class="size-pill border-2 border-stone-300 bg-white py-2 px-1 rounded-xl text-xs sm:text-sm font-black text-stone-800 hover:border-blue-900 transition" onclick="selectPanjabiSize(this, 'XL (৪৪)')">XL (৪৪)</button>
                            <button type="button" class="size-pill border-2 border-stone-300 bg-white py-2 px-1 rounded-xl text-xs sm:text-sm font-black text-stone-800 hover:border-blue-900 transition" onclick="selectPanjabiSize(this, 'XXL (৪৬)')">XXL (৪৬)</button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-stone-900 uppercase tracking-wider mb-2">
                            ৩. পছন্দের কালার নির্বাচন করুন:
                        </label>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-center" id="colorSelectorGroup">
                            <button type="button" class="color-pill border-2 border-blue-900 bg-white py-2 px-2 rounded-xl text-xs font-bold text-stone-800 shadow-sm transition active" onclick="selectPanjabiColor(this, 'স্নো হোয়াইট')">⚪ স্নো হোয়াইট</button>
                            <button type="button" class="color-pill border-2 border-stone-300 bg-white py-2 px-2 rounded-xl text-xs font-bold text-stone-800 transition" onclick="selectPanjabiColor(this, 'রয়েল ব্লু')">🔵 রয়েল ব্লু</button>
                            <button type="button" class="color-pill border-2 border-stone-300 bg-white py-2 px-2 rounded-xl text-xs font-bold text-stone-800 transition" onclick="selectPanjabiColor(this, 'ডিপ মেরুন')">🔴 ডিপ মেরুন</button>
                            <button type="button" class="color-pill border-2 border-stone-300 bg-white py-2 px-2 rounded-xl text-xs font-bold text-stone-800 transition" onclick="selectPanjabiColor(this, 'জেট ব্ল্যাক')">⚫ জেট ব্ল্যাক</button>
                        </div>
                    </div>
                </div>

                <!-- STEP 3: CUSTOMER DETAILS -->
                <div class="space-y-4">
                    <label class="block text-sm font-black text-stone-900 uppercase tracking-wider">
                        ৪. আপনার নাম, মোবাইল নম্বর ও ঠিকানা লিখুন:
                    </label>

                    <div>
                        <label class="block text-xs font-black text-stone-800 mb-1">আপনার পূর্ণ নাম <span class="text-red-600">*</span></label>
                        <input type="text" name="customer_name" required placeholder="যেমন: মোঃ সাকিব হোসেন" class="w-full px-4 py-3 rounded-xl border-2 border-stone-300 bg-stone-50 text-stone-900 focus:border-blue-900 focus:bg-white text-sm outline-none transition font-medium">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-stone-800 mb-1">মোবাইল নম্বর (১১ ডিজিট) <span class="text-red-600">*</span></label>
                        <input type="tel" name="customer_phone" required placeholder="যেমন: 01712345678" pattern="[0-9]{11}" class="w-full px-4 py-3 rounded-xl border-2 border-stone-300 bg-stone-50 text-stone-900 focus:border-blue-900 focus:bg-white text-sm outline-none transition font-medium">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-stone-800 mb-1">সম্পূর্ণ ডেলিভারি ঠিকানা <span class="text-red-600">*</span></label>
                        <textarea name="delivery_address" rows="3" required placeholder="বাড়ি নম্বর, রোড নম্বর/গ্রাম, থানা এবং জেলার নাম বিস্তারিত লিখুন..." class="w-full px-4 py-3 rounded-xl border-2 border-stone-300 bg-stone-50 text-stone-900 focus:border-blue-900 focus:bg-white text-sm outline-none transition font-medium"></textarea>
                    </div>
                </div>

                <!-- STEP 4: SHIPPING AREA -->
                <div>
                    <label class="block text-sm font-black text-stone-900 uppercase tracking-wider mb-3">
                        ৫. ডেলিভারি এলাকা নির্বাচন করুন:
                    </label>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <label class="flex items-center justify-between p-3.5 rounded-xl border-2 border-blue-900 bg-blue-50 cursor-pointer shipping-option">
                            <div class="flex items-center gap-2.5">
                                <input type="radio" name="shipping_area" value="dhaka" data-charge="{{ $dhakaCharge }}" class="w-4 h-4 text-blue-900 accent-blue-900" checked onchange="updateTotalCalculation()">
                                <span class="text-xs sm:text-sm font-bold text-stone-900">ঢাকার ভেতরে ডেলিভারি</span>
                            </div>
                            <span class="text-xs sm:text-sm font-black text-blue-950">৳{{ $dhakaCharge }}</span>
                        </label>

                        <label class="flex items-center justify-between p-3.5 rounded-xl border-2 border-stone-200 bg-white cursor-pointer shipping-option">
                            <div class="flex items-center gap-2.5">
                                <input type="radio" name="shipping_area" value="outside" data-charge="{{ $outsideCharge }}" class="w-4 h-4 text-blue-900 accent-blue-900" onchange="updateTotalCalculation()">
                                <span class="text-xs sm:text-sm font-bold text-stone-900">ঢাকার বাইরে (সারা দেশ)</span>
                            </div>
                            <span class="text-xs sm:text-sm font-black text-blue-950">৳{{ $outsideCharge }}</span>
                        </label>
                    </div>
                </div>

                <!-- STEP 5: ORDER SUMMARY & SUBMIT -->
                <div class="bg-stone-50 border-stone-200 p-5 rounded-2xl border space-y-3">
                    <div class="flex justify-between text-xs sm:text-sm text-stone-700 font-bold">
                        <span>পণ্যের মূল্য:</span>
                        <span id="summary_subtotal" class="font-black text-stone-900">৳{{ number_format($offerPrice) }}</span>
                    </div>
                    <div class="flex justify-between text-xs sm:text-sm text-stone-700 font-bold">
                        <span>ডেলিভারি চার্জ:</span>
                        <span id="summary_shipping" class="font-black text-stone-900">৳{{ $dhakaCharge }}</span>
                    </div>
                    <div class="border-t border-stone-200 pt-3 flex justify-between items-center text-base sm:text-lg font-black">
                        <span class="text-stone-900">সর্বমোট প্রদেয় মূল্য:</span>
                        <span id="summary_total" class="text-2xl text-blue-950 font-black">৳{{ number_format($offerPrice + $dhakaCharge) }}</span>
                    </div>
                </div>

                <button type="submit" id="submitOrderBtn" class="pulse-btn w-full bg-blue-950 hover:bg-blue-900 text-amber-300 font-black text-lg sm:text-xl py-4 sm:py-5 rounded-2xl shadow-xl flex items-center justify-center gap-3 transition">
                    <i class="fas fa-check-circle text-2xl text-amber-400"></i>
                    <span>অর্ডার কনফার্ম করুন (ক্যাশ অন ডেলিভারি)</span>
                </button>

                <p class="text-center text-xs text-stone-600 font-bold">
                    🔒 আপনার তথ্য সম্পূর্ণ নিরাপদ। কোনো প্রশ্ন থাকলে সরাসরি কল করুন: 
                    <a href="tel:{{ $themeSettings['header_call'] ?? '01700-000000' }}" class="text-blue-900 underline">{{ $themeSettings['header_call'] ?? '01700-000000' }}</a>
                </p>
            </form>
        </div>
    </section>

    <!-- 8. FAQS ACCORDION -->
    <section class="max-w-4xl mx-auto px-4 pb-16">
        <div class="text-center mb-8 space-y-2">
            <span class="text-xs uppercase font-extrabold text-blue-900 tracking-widest bg-amber-100 px-3 py-1 rounded-full border border-amber-300">প্রশ্নোত্তর</span>
            <h2 class="text-2xl sm:text-3xl font-black text-stone-900">সাধারণ জিজ্ঞাসা ও উত্তর (FAQ)</h2>
        </div>

        <div class="space-y-4">
            <div class="bg-white p-5 rounded-2xl border-2 border-amber-200 shadow-sm space-y-2">
                <h3 class="font-black text-base text-stone-900 flex items-center gap-2">
                    <i class="fas fa-circle-question text-blue-900"></i> পণ্য হাতে পাওয়ার পর কি চেক করতে পারব?
                </h3>
                <p class="text-xs sm:text-sm text-stone-700 pl-6 leading-relaxed font-medium">
                    হ্যাঁ, অবশ্যই! ডেলিভারিম্যানের সামনে পার্সেল খুলে পণ্য দেখে সন্তুষ্ট হয়ে তবেই মূল্য পরিশোধ করবেন। কোনো অগ্রিম পেমেন্টের প্রয়োজন নেই।
                </p>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-amber-200 shadow-sm space-y-2">
                <h3 class="font-black text-base text-stone-900 flex items-center gap-2">
                    <i class="fas fa-circle-question text-blue-900"></i> ডেলিভারি পেতে কতদিন সময় লাগবে?
                </h3>
                <p class="text-xs sm:text-sm text-stone-700 pl-6 leading-relaxed font-medium">
                    ঢাকার ভেতরে ২৪ থেকে ৪৮ ঘণ্টার মধ্যে এবং ঢাকার বাইরে সারা বাংলাদেশে ২ থেকে ৩ কার্যদিবসের মধ্যে হোম ডেলিভারি পাবেন।
                </p>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-amber-200 shadow-sm space-y-2">
                <h3 class="font-black text-base text-stone-900 flex items-center gap-2">
                    <i class="fas fa-circle-question text-blue-900"></i> সাইজে কোনো সমস্যা হলে কি পরিবর্তন করা যাবে?
                </h3>
                <p class="text-xs sm:text-sm text-stone-700 pl-6 leading-relaxed font-medium">
                    অবশ্যই! সাইজে ছোট বা বড় হলে ডেলিভারির ৩ দিনের মধ্যে আমাদের হটলাইনে কল দিলে সম্পূর্ণ ফ্রিতে সঠিক সাইজ এক্সচেঞ্জ করে দেওয়া হবে।
                </p>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-amber-200 shadow-sm space-y-2">
                <h3 class="font-black text-base text-stone-900 flex items-center gap-2">
                    <i class="fas fa-circle-question text-blue-900"></i> পাঞ্জাবিটি ধোয়ার সঠিক নিয়ম কী?
                </h3>
                <p class="text-xs sm:text-sm text-stone-700 pl-6 leading-relaxed font-medium">
                    যেহেতু এটি পিউর সুতি ও কারচুপি কাজের পাঞ্জাবি, নরমাল পানিতে মাইল্ড ডিটারজেন্ট দিয়ে আলতো করে ধোয়া বা শ্যাম্পু ওয়াশ করা সবচেয়ে ভালো। কলারের ওপর সরাসরি ভারী ঘষা না দেওয়ার পরামর্শ দেওয়া হচ্ছে।
                </p>
            </div>
        </div>
    </section>

</main>

<!-- FLOATING MOBILE BOTTOM CTA -->
<div class="sm:hidden fixed bottom-0 left-0 right-0 bg-white/95 border-amber-200 backdrop-blur-md p-3 border-t shadow-2xl z-40 flex items-center justify-between gap-3">
    <div>
        <span class="text-[10px] text-stone-500 uppercase font-bold block">অফার মূল্য</span>
        <span class="text-lg font-black text-blue-950">৳{{ number_format($offerPrice) }}</span>
    </div>
    <a href="#fast-order-form" class="pulse-btn flex-1 bg-blue-950 text-amber-300 text-center font-black py-2.5 px-4 rounded-xl text-sm shadow-md flex items-center justify-center gap-2">
        <i class="fas fa-shopping-cart text-amber-400"></i>
        <span>অর্ডার করুন</span>
    </a>
</div>

<!-- FLOATING WHATSAPP BUTTON -->
@php
    $rawPhone = $themeSettings['header_call'] ?? '01700000000';
    $wpNum = preg_replace('/[^0-9]/', '', $rawPhone);
    if (strlen($wpNum) == 11 && str_starts_with($wpNum, '01')) {
        $wpNum = '88' . $wpNum;
    }
@endphp
<a href="https://wa.me/{{ $wpNum }}?text={{ urlencode('আসসালামু আলাইকুম! আমি ' . $productTitle . ' সম্পর্কে বিস্তারিত জানতে চাই।') }}" target="_blank" class="fixed bottom-16 sm:bottom-6 right-4 sm:right-6 z-40 bg-[#25d366] hover:bg-[#20ba5a] text-white p-3.5 sm:p-4 rounded-full shadow-2xl flex items-center justify-center hover:scale-110 transition-all" title="WhatsApp-এ যোগাযোগ করুন">
    <i class="fab fa-whatsapp text-2xl sm:text-3xl"></i>
</a>

@endsection

@push('custom-scripts')
<script>
    var currentSelectedSize = 'L (৪২)';
    var currentSelectedColor = 'স্নো হোয়াইট';

    function selectPanjabiSize(btn, size) {
        $(".size-pill").removeClass("border-blue-900 bg-blue-900 text-white shadow").addClass("border-stone-300 bg-white text-stone-800");
        $(btn).removeClass("border-stone-300 bg-white text-stone-800").addClass("border-blue-900 bg-blue-900 text-white shadow");
        currentSelectedSize = size;
        syncVariantInput();
    }

    function selectPanjabiColor(btn, color) {
        $(".color-pill").removeClass("border-blue-900 bg-blue-50 text-blue-900 shadow-sm font-black").addClass("border-stone-300 bg-white text-stone-800 font-bold");
        $(btn).removeClass("border-stone-300 bg-white text-stone-800 font-bold").addClass("border-blue-900 bg-blue-50 text-blue-900 shadow-sm font-black");
        currentSelectedColor = color;
        syncVariantInput();
    }

    function syncVariantInput() {
        $("#selectedVariantInput").val("সাইজ: " + currentSelectedSize + " | কালার: " + currentSelectedColor);
    }

    function updateTotalCalculation() {
        var basePrice = parseFloat($("#base_price").val()) || 1290;
        var selectedPkg = $('input[name="order_package"]:checked');
        var pkgVal = parseInt(selectedPkg.val()) || 1;
        var subtotal = basePrice;
        
        if (pkgVal === 2) {
            var specialPrice = parseFloat(selectedPkg.data('special-price'));
            subtotal = specialPrice ? specialPrice : 2390;
        } else {
            subtotal = basePrice * pkgVal;
        }

        var shippingCharge = parseFloat($('input[name="shipping_area"]:checked').data('charge')) || 70;
        var total = subtotal + shippingCharge;

        $("#summary_subtotal").text("৳" + Math.round(subtotal).toLocaleString());
        $("#summary_shipping").text("৳" + Math.round(shippingCharge).toLocaleString());
        $("#summary_total").text("৳" + Math.round(total).toLocaleString());
    }

    // Countdown Timer logic
    function startUrgencyCountdown() {
        var hours = 4, minutes = 32, seconds = 18;
        setInterval(function() {
            if (seconds > 0) {
                seconds--;
            } else {
                seconds = 59;
                if (minutes > 0) {
                    minutes--;
                } else {
                    minutes = 59;
                    if (hours > 0) hours--;
                }
            }
            $("#timer_hours").text(hours < 10 ? '0' + hours : hours);
            $("#timer_minutes").text(minutes < 10 ? '0' + minutes : minutes);
            $("#timer_seconds").text(seconds < 10 ? '0' + seconds : seconds);
        }, 1000);
    }

    $(document).ready(function() {
        updateTotalCalculation();
        syncVariantInput();
        startUrgencyCountdown();

        $(".package-card").click(function() {
            $(".package-card").removeClass("border-blue-900 bg-blue-50 shadow-md").addClass("border-stone-200 bg-white");
            $(this).removeClass("border-stone-200 bg-white").addClass("border-blue-900 bg-blue-50 shadow-md");
        });

        $(".shipping-option").click(function() {
            $(".shipping-option").removeClass("border-blue-900 bg-blue-50 shadow-sm").addClass("border-stone-200 bg-white");
            $(this).removeClass("border-stone-200 bg-white").addClass("border-blue-900 bg-blue-50 shadow-sm");
        });
    });
</script>
@endpush
