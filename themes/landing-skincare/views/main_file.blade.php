@extends('front_end.layouts.app')

@section('page-title')
    {{ $store->name ?? 'Kashmiri Saffron Skin Brightening Serum' }}
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
    $productTitle = $themeSettings['hero_title'] ?? 'প্রাকৃতিক কাশ্মীরি জাফরান ও কুমকুমাডি স্কিন ব্রাইটনিং সিরাম';
    $productDesc = $themeSettings['hero_subtitle'] ?? '১০০% খাঁটি কাশ্মীরি জাফরান, চন্দন ও ১৬টি ভেষজ উপাদানের জাদুকরী মিশ্রণ। ত্বকের মেছতা, ব্রণের দাগ ও ডার্ক সার্কেল দূর করে মাত্র ১৪ দিনে নিয়ে আসুন প্রাকৃতিক উজ্জ্বলতা।';
    
    $regularPrice = $toNum($themeSettings['hero_regular_price'] ?? 1450, 1450);
    $offerPrice = $toNum($themeSettings['hero_offer_price'] ?? 890, 890);
    
    if ($regularPrice <= 0) $regularPrice = 1450;
    if ($offerPrice <= 0) $offerPrice = 890;
    
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

<main class="space-y-12 sm:space-y-20 bg-rose-50/40 text-stone-900 font-sans">

    <!-- 1. SKINCARE EDITORIAL HERO -->
    <section class="relative pt-10 sm:pt-16 pb-16 bg-gradient-to-b from-rose-100/60 via-pink-50/40 to-white border-b border-rose-200">
        <div class="max-w-6xl mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                
                <!-- Left Portrait with gold frame -->
                <div class="lg:col-span-5 flex justify-center order-2 lg:order-1">
                    <div class="relative p-3 bg-white rounded-3xl shadow-2xl border-4 border-rose-300 max-w-sm w-full">
                        <div class="absolute -top-3.5 -right-3.5 bg-gradient-to-r from-rose-600 to-pink-600 text-white font-extrabold text-xs uppercase px-3.5 py-1.5 rounded-full shadow-lg tracking-wider animate-pulse">
                            100% ORGANIC
                        </div>
                        <img src="{{ $productImg1 }}" alt="{{ $productTitle }}" class="w-full h-[400px] object-cover rounded-2xl shadow-inner">
                        <div class="mt-3 text-center text-xs font-serif text-rose-950 font-bold bg-rose-50 py-2 px-3 rounded-xl border border-rose-200">
                            ✦ কোনো সাইড ইফেক্ট নেই • সকল ত্বকে উপযোগী ✦
                        </div>
                    </div>
                </div>

                <!-- Right Editorial Text -->
                <div class="lg:col-span-7 space-y-5 text-center lg:text-left order-1 lg:order-2">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-rose-100 text-rose-900 text-xs sm:text-sm font-black border border-rose-300 shadow-sm">
                        <i class="fas fa-spa text-rose-600"></i>
                        <span>{{ $themeSettings['hero_badge'] ?? '🌿 খাঁটি কাশ্মীরি জাফরান ও কুমকুমাডি থেরাপি' }}</span>
                    </div>

                    <h1 class="text-3xl sm:text-5xl font-black text-rose-950 leading-tight">
                        {{ $productTitle }}
                    </h1>

                    <p class="text-stone-700 text-base sm:text-lg leading-relaxed font-medium">
                        {{ $productDesc }}
                    </p>

                    <!-- Urgent Countdown Timer -->
                    <div class="p-3.5 bg-gradient-to-r from-rose-600 via-pink-600 to-rose-700 text-white rounded-2xl shadow-md flex flex-wrap items-center justify-between gap-3">
                        <div class="flex items-center gap-2 font-bold text-xs sm:text-sm">
                            <span class="inline-block w-2.5 h-2.5 bg-yellow-300 rounded-full animate-ping"></span>
                            <span>🔥 স্কিনকেয়ার স্পেশাল ডিসকাউন্ট শেষ হতে বাকি:</span>
                        </div>
                        <div class="flex items-center gap-1.5 text-xs sm:text-sm font-black text-stone-900 font-mono">
                            <span class="bg-white px-2 py-1 rounded shadow text-rose-700 font-bold" id="skincare_timer_hours">06</span> :
                            <span class="bg-white px-2 py-1 rounded shadow text-rose-700 font-bold" id="skincare_timer_minutes">18</span> :
                            <span class="bg-white px-2 py-1 rounded shadow text-rose-700 font-bold" id="skincare_timer_seconds">42</span>
                        </div>
                    </div>

                    <!-- Price Badge -->
                    <div class="inline-flex flex-wrap items-center gap-6 p-4 rounded-2xl bg-white border-2 border-rose-300 shadow-md">
                        <div>
                            <span class="text-xs text-stone-500 block font-bold uppercase">রেগুলার মূল্য</span>
                            <span class="text-xl font-extrabold text-stone-400 line-through">৳{{ number_format($regularPrice) }}</span>
                        </div>
                        <div class="h-8 w-px bg-rose-200 hidden sm:block"></div>
                        <div>
                            <span class="text-xs text-rose-900 font-black block uppercase">অফার মূল্য</span>
                            <span class="text-3xl sm:text-4xl font-black text-rose-700">৳{{ number_format($offerPrice) }}</span>
                        </div>
                        <span class="bg-gradient-to-r from-rose-600 to-pink-600 text-white text-xs font-black px-3.5 py-1.5 rounded-full shadow-sm">
                            {{ $themeSettings['hero_discount_tag'] ?? '৳৫৬০ ছাড়!' }}
                        </span>
                    </div>

                    <!-- Bullet Features Checklist -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 pt-1 text-left text-xs sm:text-sm text-stone-800 font-bold">
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-rose-600 text-base"></i> মেছতা ও ব্রণের দাগ হালকা করে</div>
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-rose-600 text-base"></i> কোনো ক্ষতিকারক কেমিক্যাল বা মার্কারি নেই</div>
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-rose-600 text-base"></i> পার্সেল দেখে পেমেন্ট করার সুযোগ</div>
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-rose-600 text-base"></i> সারা দেশে দ্রুত ক্যাশ অন ডেলিভারি</div>
                    </div>

                    <!-- CTA Button -->
                    <div class="pt-2">
                        <a href="#fast-order-form" class="pulse-btn inline-flex items-center justify-center gap-3 bg-gradient-to-r from-rose-700 to-pink-600 hover:from-rose-800 hover:to-pink-700 text-white font-black text-lg px-8 py-4 rounded-xl shadow-xl transition transform hover:-translate-y-0.5 w-full sm:w-auto">
                            <i class="fas fa-sparkles text-yellow-300"></i>
                            <span>{{ $themeSettings['hero_button_text'] ?? '👉 এখনই অর্ডার করুন (ক্যাশ অন ডেলিভারি)' }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. INGREDIENTS & TRANSFORMATION GALLERY -->
    <section class="max-w-6xl mx-auto px-4">
        <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
            <span class="text-xs uppercase font-extrabold text-rose-800 tracking-widest">খাঁটি ভেষজ উপাদানের শক্তি</span>
            <h2 class="text-2xl sm:text-4xl font-black text-stone-900">কেন এটি আপনার ত্বকের জন্য সেরা?</h2>
            <p class="text-stone-600 font-medium text-sm">প্রাচীন আয়ুর্বেদিক ফর্মুলায় তৈরি যা ভেতর থেকে ত্বককে মেরামত করে</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl border-2 border-rose-200 overflow-hidden shadow-md group hover:shadow-xl transition">
                <div class="h-64 overflow-hidden bg-rose-50 flex items-center justify-center">
                    <img src="{{ $productImg1 }}" alt="কাশ্মীরি জাফরান সিরাম" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                </div>
                <div class="p-4 text-center">
                    <h3 class="font-black text-base text-rose-950 mb-1">খাঁটি কাশ্মীরি জাফরান</h3>
                    <p class="text-xs text-stone-600 font-medium">অ্যান্টিঅক্সিডেন্টে ভরপুর যা ত্বকের পিগমেন্টেশন ও বয়সের ছাপ দূর করে</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl border-2 border-rose-200 overflow-hidden shadow-md group hover:shadow-xl transition">
                <div class="h-64 overflow-hidden bg-rose-50 flex items-center justify-center">
                    <img src="{{ $productImg2 }}" alt="লাল চন্দন ও কুমকুমাডি তৈল" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                </div>
                <div class="p-4 text-center">
                    <h3 class="font-black text-base text-rose-950 mb-1">লাল চন্দন ও কুমকুমাডি</h3>
                    <p class="text-xs text-stone-600 font-medium">ত্বকের পোরস টাইট করে এবং অতিরিক্ত তেল নিয়ন্ত্রণে এনে ন্যাচারাল গ্লো আনে</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl border-2 border-rose-200 overflow-hidden shadow-md group hover:shadow-xl transition">
                <div class="h-64 overflow-hidden bg-rose-50 flex items-center justify-center">
                    <img src="{{ $productImg3 }}" alt="প্রাকৃতিক স্কিন গ্লো" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                </div>
                <div class="p-4 text-center">
                    <h3 class="font-black text-base text-rose-950 mb-1">১৪ দিনে দৃশ্যমান পরিবর্তন</h3>
                    <p class="text-xs text-stone-600 font-medium">নিয়মিত ব্যবহারে কোনো পার্শ্বপ্রতিক্রিয়া ছাড়াই ত্বক হয় মসৃণ ও উজ্জ্বল</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. SKINCARE INGREDIENTS & APPLICATION TABLE -->
    <section class="max-w-4xl mx-auto px-4">
        <div class="bg-white rounded-3xl border-2 border-rose-200 shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-rose-700 via-pink-600 to-rose-800 text-white p-5 text-center">
                <h3 class="text-xl sm:text-2xl font-black">উপাদান ও সঠিক ব্যবহারের নিয়ম</h3>
                <p class="text-rose-100 text-xs mt-1">সর্বোচ্চ কার্যকারিতা পেতে নির্দেশিকা অনুসরণ করুন</p>
            </div>
            <div class="p-6">
                <div class="divide-y divide-rose-100 text-sm">
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-stone-700">প্রধান উপাদানসমূহ</span>
                        <span class="font-bold text-rose-900">কাশ্মীরি জাফরান, রক্ত চন্দন, কুমকুমাডি ও পদ্ম নির্যাস</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-stone-700">ত্বকের উপযোগীতা</span>
                        <span class="font-bold text-rose-900">শুষ্ক, তৈলাক্ত, কম্বিনেশন ও সেনসিটিভ সব ত্বকে নিরাপদ</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-stone-700">বোতলের পরিমাপ</span>
                        <span class="font-bold text-rose-900">৩০ মি.লি. প্রিমিয়াম ড্রপার গ্লাস বোতল</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-stone-700">কেমিক্যাল সুরক্ষা</span>
                        <span class="font-bold text-rose-900">১০০% প্যারাবেন, সালফেট ও ক্ষতিকারক মার্কারি মুক্ত</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-stone-700">ব্যবহারের সময়</span>
                        <span class="font-bold text-rose-900">প্রতিদিন রাতে ঘুমানোর পূর্বে ফেসওয়াশ দিয়ে মুখ ধুয়ে</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-stone-700">ব্যবহারের নিয়ম</span>
                        <span class="font-bold text-rose-900">৩-৪ ফোঁটা মুখে আলতোভাবে আঙুল দিয়ে ম্যাসাজ করুন</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. TRUST & GUARANTEE PILLARS -->
    <section class="max-w-6xl mx-auto px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white p-5 rounded-2xl border-2 border-rose-200 shadow-sm text-center">
                <div class="w-12 h-12 mx-auto rounded-xl bg-rose-100 text-rose-800 flex items-center justify-center text-xl mb-3">
                    <i class="fas fa-hand-holding-dollar"></i>
                </div>
                <h4 class="font-black text-base text-stone-900 mb-1">ক্যাশ অন ডেলিভারি</h4>
                <p class="text-xs text-stone-600 font-medium leading-relaxed">আগে ১ টাকাও অগ্রিম দিতে হবে না, পণ্য পেয়ে মূল্য পরিশোধ করুন।</p>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-rose-200 shadow-sm text-center">
                <div class="w-12 h-12 mx-auto rounded-xl bg-rose-100 text-rose-800 flex items-center justify-center text-xl mb-3">
                    <i class="fas fa-leaf"></i>
                </div>
                <h4 class="font-black text-base text-stone-900 mb-1">১০০% প্রাকৃতিক</h4>
                <p class="text-xs text-stone-600 font-medium leading-relaxed">কোনো প্রকার পার্শ্বপ্রতিক্রিয়া ছাড়া স্থায়ীভাবে ত্বকের যত্ন নেয়।</p>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-rose-200 shadow-sm text-center">
                <div class="w-12 h-12 mx-auto rounded-xl bg-rose-100 text-rose-800 flex items-center justify-center text-xl mb-3">
                    <i class="fas fa-truck-fast"></i>
                </div>
                <h4 class="font-black text-base text-stone-900 mb-1">সারা দেশে ডেলিভারি</h4>
                <p class="text-xs text-stone-600 font-medium leading-relaxed">ঢাকায় ২৪-৪৮ ঘণ্টায় এবং ঢাকার বাইরে ২-৩ দিনের মধ্যে ডেলিভারি।</p>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-rose-200 shadow-sm text-center">
                <div class="w-12 h-12 mx-auto rounded-xl bg-rose-100 text-rose-800 flex items-center justify-center text-xl mb-3">
                    <i class="fas fa-box-open"></i>
                </div>
                <h4 class="font-black text-base text-stone-900 mb-1">দেখে নেওয়ার সুবিধা</h4>
                <p class="text-xs text-stone-600 font-medium leading-relaxed">ডেলিভারিম্যানের সামনে প্যাকেট দেখে নিশ্চিন্তে রিসিভ করুন।</p>
            </div>
        </div>
    </section>

    <!-- 5. VERIFIED CUSTOMER REVIEWS (SOCIAL PROOF) -->
    <section class="max-w-6xl mx-auto px-4">
        <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
            <span class="text-xs uppercase font-extrabold text-rose-800 tracking-widest">প্রকৃত ব্যবহারকারীদের অভিজ্ঞতা</span>
            <h2 class="text-2xl sm:text-4xl font-black text-stone-900">সন্তুষ্ট গ্রাহকদের শতভাগ সৎ রিভিউ</h2>
            <div class="flex items-center justify-center gap-1 text-amber-500 text-sm">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                <span class="text-stone-700 font-bold ml-2">৪.৯/৫ (২৪০+ ভেরিফায়েড রিভিউ)</span>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-5 rounded-2xl border-2 border-rose-100 shadow-md flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center gap-1 text-amber-400 text-xs">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-xs sm:text-sm text-stone-700 font-medium leading-relaxed">
                        "মাত্র ১০ দিন ব্যবহারের পর মুখের মেছতার দাগ অনেকটাই হালকা হয়ে গেছে! স্কিন খুব সফট ও গ্লো করছে।"
                    </p>
                </div>
                <div class="pt-4 border-t border-rose-50 flex items-center justify-between mt-4">
                    <div>
                        <h4 class="text-xs font-bold text-rose-950">রাবেয়া বসরী</h4>
                        <span class="text-[11px] text-stone-500 font-medium">উত্তরা, ঢাকা</span>
                    </div>
                    <span class="text-[10px] bg-green-100 text-green-800 font-bold px-2 py-0.5 rounded-full">ভেরিফায়েড</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-rose-100 shadow-md flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center gap-1 text-amber-400 text-xs">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-xs sm:text-sm text-stone-700 font-medium leading-relaxed">
                        "সিরামের সুবাসটা খুব মিষ্টি আর একদম নন-স্টিকি। সাথে যে জেড রোলারটা দিয়েছে সেটাও খুব প্রিমিয়াম।"
                    </p>
                </div>
                <div class="pt-4 border-t border-rose-50 flex items-center justify-between mt-4">
                    <div>
                        <h4 class="text-xs font-bold text-rose-950">সাবরিনা আক্তার</h4>
                        <span class="text-[11px] text-stone-500 font-medium">চট্টগ্রাম সদর</span>
                    </div>
                    <span class="text-[10px] bg-green-100 text-green-800 font-bold px-2 py-0.5 rounded-full">ভেরিফায়েড</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-rose-100 shadow-md flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center gap-1 text-amber-400 text-xs">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-xs sm:text-sm text-stone-700 font-medium leading-relaxed">
                        "আমার খুব সেনসিটিভ স্কিন, ভয় পাচ্ছিলাম। কিন্তু কোনো র‍্যাশ ওঠেনি, উল্টো ত্বক অনেক উজ্জ্বল হয়েছে।"
                    </p>
                </div>
                <div class="pt-4 border-t border-rose-50 flex items-center justify-between mt-4">
                    <div>
                        <h4 class="text-xs font-bold text-rose-950">তানিয়া আফরোজ</h4>
                        <span class="text-[11px] text-stone-500 font-medium">সিলেট সদর</span>
                    </div>
                    <span class="text-[10px] bg-green-100 text-green-800 font-bold px-2 py-0.5 rounded-full">ভেরিফায়েড</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-rose-100 shadow-md flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center gap-1 text-amber-400 text-xs">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-xs sm:text-sm text-stone-700 font-medium leading-relaxed">
                        "ক্যাশ অন ডেলিভারিতে প্যাকেট দেখে নিয়েছি। খাঁটি জাফরানের সুবাস আছে। সবাইকে ব্যবহারের অনুরোধ করব।"
                    </p>
                </div>
                <div class="pt-4 border-t border-rose-50 flex items-center justify-between mt-4">
                    <div>
                        <h4 class="text-xs font-bold text-rose-950">শামীমা নাসরিন</h4>
                        <span class="text-[11px] text-stone-500 font-medium">রাজশাহী</span>
                    </div>
                    <span class="text-[10px] bg-green-100 text-green-800 font-bold px-2 py-0.5 rounded-full">ভেরিফায়েড</span>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. HIGH CONVERTING 1-PAGE CASH ON DELIVERY CHECKOUT FORM -->
    <section id="fast-order-form" class="max-w-4xl mx-auto px-4 scroll-mt-20">
        <div class="bg-white rounded-3xl border-4 border-rose-300 shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-rose-700 via-pink-600 to-rose-800 text-white p-6 sm:p-8 text-center">
                <span class="inline-block bg-yellow-300 text-rose-950 text-xs font-black uppercase px-3 py-1 rounded-full mb-2">
                    ⚡ সহজ ১-মিনিট ক্যাশ অন ডেলিভারি ফর্ম
                </span>
                <h3 class="text-2xl sm:text-4xl font-black">অর্ডার করতে নিচের তথ্যগুলো দিন</h3>
                <p class="text-rose-100 text-xs sm:text-sm mt-1">অগ্রিম কোনো টাকা দিতে হবে না, পণ্য হাতে পেয়ে দাম পরিশোধ করবেন</p>
            </div>

            <form action="{{ route('single.fast.order', $slug ?? ($store->slug ?? 'shop001')) }}" method="POST" class="p-6 sm:p-10 space-y-6" id="skincareOrderForm">
                @csrf
                <input type="hidden" name="product_id" value="{{ $mainProduct->id ?? 1 }}">
                <input type="hidden" name="unit_price" id="skincare_unit_price" value="{{ $offerPrice }}">
                <input type="hidden" name="product_variant" id="skincare_selected_variant" value="১ বোতল সিরাম (৳৮৯০)">
                <input type="hidden" name="selected_package" id="skincare_selected_package" value="১ বোতল (৩০ মি.লি.)">

                <!-- Step 1: Package Selection -->
                <div class="space-y-3">
                    <label class="block text-sm font-black text-rose-950">
                        ১. প্যাকেজ নির্বাচন করুন <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <label class="relative flex items-center justify-between p-4 rounded-2xl border-2 border-rose-500 bg-rose-50/70 cursor-pointer package-card hover:bg-rose-50 transition" onclick="selectSkincarePackage(1, {{ $offerPrice }}, '১ বোতল সিরাম (৩০ মি.লি.)', this)">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="pkg_choice" value="1" checked class="text-rose-600 focus:ring-rose-500">
                                <div>
                                    <span class="font-black text-stone-900 text-sm block">১ বোতল সিরাম (৩০ মি.লি.)</span>
                                    <span class="text-xs text-stone-600 font-medium">১৪ দিনের গ্লো থেরাপি</span>
                                </div>
                            </div>
                            <span class="text-lg font-black text-rose-800">৳{{ number_format($offerPrice) }}</span>
                        </label>

                        <label class="relative flex items-center justify-between p-4 rounded-2xl border-2 border-stone-200 bg-white cursor-pointer package-card hover:bg-rose-50 transition" onclick="selectSkincarePackage(2, 1590, '২ বোতল সিরাম + ফ্রি জেড রোলার (ফ্রি ডেলিভারি)', this)">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="pkg_choice" value="2" class="text-rose-600 focus:ring-rose-500">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-black text-stone-900 text-sm block">২ বোতল মেগা কম্বো</span>
                                        <span class="bg-red-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">ফ্রি রোলার</span>
                                    </div>
                                    <span class="text-xs text-stone-600 font-medium">+ ফ্রি জেড রোলার ও ফ্রি ডেলিভারি</span>
                                </div>
                            </div>
                            <span class="text-lg font-black text-rose-800">৳১,৫৯০</span>
                        </label>
                    </div>
                </div>

                <!-- Step 2: Customer Details -->
                <div class="space-y-4 pt-2">
                    <label class="block text-sm font-black text-rose-950">
                        ২. আপনার ডেলিভারি তথ্য দিন <span class="text-red-500">*</span>
                    </label>

                    <div>
                        <label class="block text-xs font-bold text-stone-700 mb-1">আপনার পূর্ণ নাম *</label>
                        <input type="text" name="customer_name" required placeholder="যেমন: ফারহানা আহমেদ" class="w-full px-4 py-3 rounded-xl border-2 border-stone-300 focus:border-rose-600 focus:outline-none text-stone-900 font-medium text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-700 mb-1">সচল মোবাইল নম্বর *</label>
                        <input type="tel" name="customer_phone" required placeholder="যেমন: 017xxxxxxxx" class="w-full px-4 py-3 rounded-xl border-2 border-stone-300 focus:border-rose-600 focus:outline-none text-stone-900 font-medium text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-700 mb-1">সম্পূর্ণ ডেলিভারি ঠিকানা *</label>
                        <textarea name="customer_address" rows="2" required placeholder="যেমন: বাসা নং, রোড নং, থানা ও জেলার নাম" class="w-full px-4 py-3 rounded-xl border-2 border-stone-300 focus:border-rose-600 focus:outline-none text-stone-900 font-medium text-sm"></textarea>
                    </div>

                    <!-- Delivery Area -->
                    <div>
                        <label class="block text-xs font-bold text-stone-700 mb-2">ডেলিভারি এরিয়া বেছে নিন *</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <label class="flex items-center justify-between p-3.5 rounded-xl border-2 border-rose-600 bg-rose-50/60 cursor-pointer delivery-card transition" onclick="setSkincareDelivery({{ $dhakaCharge }}, this)">
                                <div class="flex items-center gap-2">
                                    <input type="radio" name="delivery_location" value="dhaka" checked class="text-rose-600">
                                    <span class="text-xs sm:text-sm font-bold text-stone-900">ঢাকা সিটির ভিতরে</span>
                                </div>
                                <span class="text-xs sm:text-sm font-bold text-rose-800">৳{{ $dhakaCharge }}</span>
                            </label>

                            <label class="flex items-center justify-between p-3.5 rounded-xl border-2 border-stone-200 bg-white cursor-pointer delivery-card transition hover:bg-rose-50" onclick="setSkincareDelivery({{ $outsideCharge }}, this)">
                                <div class="flex items-center gap-2">
                                    <input type="radio" name="delivery_location" value="outside" class="text-rose-600">
                                    <span class="text-xs sm:text-sm font-bold text-stone-900">ঢাকা সিটির বাইরে</span>
                                </div>
                                <span class="text-xs sm:text-sm font-bold text-rose-800">৳{{ $outsideCharge }}</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Price Summary Box -->
                <div class="p-5 bg-rose-50 rounded-2xl border-2 border-rose-200 space-y-2 text-sm">
                    <div class="flex justify-between text-stone-700 font-medium">
                        <span>পণ্যের মূল্য:</span>
                        <span class="font-bold text-stone-900" id="skincare_subtotal_text">৳{{ number_format($offerPrice) }}</span>
                    </div>
                    <div class="flex justify-between text-stone-700 font-medium">
                        <span>ডেলিভারি চার্জ:</span>
                        <span class="font-bold text-stone-900" id="skincare_delivery_text">৳{{ $dhakaCharge }}</span>
                    </div>
                    <div class="h-px bg-rose-200 my-1"></div>
                    <div class="flex justify-between text-base sm:text-lg font-black text-rose-950">
                        <span>সর্বমোট প্রদেয় বিল:</span>
                        <span class="text-2xl font-black text-rose-800" id="skincare_total_text">৳{{ number_format($offerPrice + $dhakaCharge) }}</span>
                    </div>
                </div>

                <button type="submit" class="pulse-btn w-full bg-gradient-to-r from-rose-700 via-pink-600 to-rose-800 hover:from-rose-800 hover:to-rose-900 text-white font-black text-lg sm:text-xl py-4 rounded-2xl shadow-xl transition transform hover:-translate-y-0.5 flex items-center justify-center gap-3">
                    <i class="fas fa-lock text-yellow-300"></i>
                    <span>অর্ডার কনফার্ম করুন (ক্যাশ অন ডেলিভারি)</span>
                </button>
            </form>
        </div>
    </section>

    <!-- 7. FREQUENTLY ASKED QUESTIONS (FAQ) -->
    <section class="max-w-4xl mx-auto px-4 pb-12">
        <div class="text-center mb-8">
            <span class="text-xs uppercase font-extrabold text-rose-800 tracking-widest">সাধারণ প্রশ্নোত্তর</span>
            <h2 class="text-2xl sm:text-3xl font-black text-stone-900 mt-1">সচরাচর জানতে চাওয়া প্রশ্ন ও উত্তর</h2>
        </div>

        <div class="space-y-3">
            <div class="bg-white p-5 rounded-2xl border-2 border-rose-100 shadow-sm">
                <h4 class="font-black text-stone-900 text-sm sm:text-base flex items-center gap-2">
                    <i class="fas fa-question-circle text-rose-600"></i> সিরামটি ব্যবহার করলে কি কোনো পার্শ্বপ্রতিক্রিয়া হবে?
                </h4>
                <p class="text-xs sm:text-sm text-stone-600 font-medium mt-2 leading-relaxed pl-6">
                    একদমই না! এটি শতভাগ প্রাকৃতিক কাশ্মীরি জাফরান ও আয়ুর্বেদিক ভেষজ নির্যাস থেকে প্রস্তুত। এতে কোনো ব্লিচ বা মার্কারি নেই, তাই সকল ত্বকে নিরাপদ।
                </p>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-rose-100 shadow-sm">
                <h4 class="font-black text-stone-900 text-sm sm:text-base flex items-center gap-2">
                    <i class="fas fa-question-circle text-rose-600"></i> কত দিনে ভালো ফলাফল দেখতে পারব?
                </h4>
                <p class="text-xs sm:text-sm text-stone-600 font-medium mt-2 leading-relaxed pl-6">
                    নিয়মিত প্রতিদিন রাতে ব্যবহারে ৭ থেকে ১৪ দিনের মধ্যেই মুখের মেছতা, ব্রণের দাগ হালকা হয়ে প্রাকৃতিক গ্লো ফুটে ওঠে।
                </p>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-rose-100 shadow-sm">
                <h4 class="font-black text-stone-900 text-sm sm:text-base flex items-center gap-2">
                    <i class="fas fa-question-circle text-rose-600"></i> ডেলিভারিম্যানের সামনে চেক করে কি টাকা দিতে পারব?
                </h4>
                <p class="text-xs sm:text-sm text-stone-600 font-medium mt-2 leading-relaxed pl-6">
                    অবশ্যই! সারা বাংলাদেশে আমরা ফুল ক্যাশ অন ডেলিভারি দিই। ডেলিভারিম্যান আসার পর পার্সেল সিল চেক করে নিশ্চিন্তে টাকা পেমেন্ট করবেন।
                </p>
            </div>
        </div>
    </section>

</main>

<!-- FLOATING WHATSAPP BUTTON -->
<a href="https://wa.me/8801700000000?text=আসসালামু%20আলাইকুম!%20জাফরান%20সিরাম%20সম্পর্কে%20জানতে%20চাই" target="_blank" class="fixed bottom-20 right-4 z-40 bg-green-500 hover:bg-green-600 text-white p-3.5 rounded-full shadow-2xl flex items-center justify-center transition transform hover:scale-110" title="হোয়াটসঅ্যাপে কথা বলুন">
    <i class="fab fa-whatsapp text-3xl"></i>
</a>

<!-- MOBILE STICKY CTA -->
<div class="fixed bottom-0 left-0 right-0 z-30 sm:hidden bg-white/95 backdrop-blur-md border-t-2 border-rose-300 p-3 shadow-2xl">
    <div class="flex items-center justify-between gap-3 max-w-md mx-auto">
        <div>
            <span class="text-[11px] text-stone-500 font-bold block">অফার প্রাইস</span>
            <span class="text-xl font-black text-rose-700">৳{{ number_format($offerPrice) }}</span>
        </div>
        <a href="#fast-order-form" class="bg-rose-700 hover:bg-rose-800 text-white font-black text-sm px-5 py-2.5 rounded-xl shadow-lg transition flex items-center gap-1.5">
            <i class="fas fa-sparkles"></i> এখনই কিনুন
        </a>
    </div>
</div>

<script>
    // Live Countdown Timer
    let skincareHours = 6, skincareMinutes = 18, skincareSeconds = 42;
    setInterval(function() {
        if (skincareSeconds > 0) {
            skincareSeconds--;
        } else {
            skincareSeconds = 59;
            if (skincareMinutes > 0) {
                skincareMinutes--;
            } else {
                skincareMinutes = 59;
                if (skincareHours > 0) skincareHours--;
            }
        }
        document.getElementById('skincare_timer_hours').textContent = String(skincareHours).padStart(2, '0');
        document.getElementById('skincare_timer_minutes').textContent = String(skincareMinutes).padStart(2, '0');
        document.getElementById('skincare_timer_seconds').textContent = String(skincareSeconds).padStart(2, '0');
    }, 1000);

    let currentSkincareSubtotal = {{ $offerPrice }};
    let currentSkincareDelivery = {{ $dhakaCharge }};
    let isSkincareFreeDelivery = false;

    function selectSkincarePackage(pkgId, price, label, el) {
        currentSkincareSubtotal = price;
        isSkincareFreeDelivery = (pkgId === 2);
        document.getElementById('skincare_unit_price').value = price;
        document.getElementById('skincare_selected_variant').value = label;
        document.getElementById('skincare_selected_package').value = label;

        document.querySelectorAll('.package-card').forEach(c => {
            c.classList.remove('border-rose-500', 'bg-rose-50/70');
            c.classList.add('border-stone-200', 'bg-white');
        });
        el.classList.add('border-rose-500', 'bg-rose-50/70');
        el.classList.remove('border-stone-200', 'bg-white');
        updateSkincareBill();
    }

    function setSkincareDelivery(charge, el) {
        currentSkincareDelivery = charge;
        document.querySelectorAll('.delivery-card').forEach(d => {
            d.classList.remove('border-rose-600', 'bg-rose-50/60');
            d.classList.add('border-stone-200', 'bg-white');
        });
        el.classList.add('border-rose-600', 'bg-rose-50/60');
        el.classList.remove('border-stone-200', 'bg-white');
        updateSkincareBill();
    }

    function updateSkincareBill() {
        let deliveryToApply = isSkincareFreeDelivery ? 0 : currentSkincareDelivery;
        let total = currentSkincareSubtotal + deliveryToApply;
        document.getElementById('skincare_subtotal_text').textContent = '৳' + currentSkincareSubtotal.toLocaleString();
        document.getElementById('skincare_delivery_text').textContent = isSkincareFreeDelivery ? 'ফ্রি (৳০)' : '৳' + deliveryToApply;
        document.getElementById('skincare_total_text').textContent = '৳' + total.toLocaleString();
    }
</script>
@endsection
