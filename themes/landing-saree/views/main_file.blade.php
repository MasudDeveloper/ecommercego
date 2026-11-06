@extends('front_end.layouts.app')

@section('page-title')
    {{ $store->name ?? 'ঐতিহ্যবাহী তাঁতের খাঁটি ঢাকাই জামদানি শাড়ি' }}
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
    $productTitle = $themeSettings['hero_title'] ?? 'ঐতিহ্যবাহী তাঁতের খাঁটি ঢাকাই জামদানি ও রেশমি সিল্ক শাড়ি কালেকশন';
    $productDesc = $themeSettings['hero_subtitle'] ?? '১০০ কাউন্টের মোলায়েম সুতা ও চকচকে সোনালী জরির সুনিপুণ কারুকাজ। ১৪ হাত পূর্ণ বহর, নিখুঁত কুঁচি ও সাথে পাচ্ছেন ১ গজ ম্যাচিং রানিং ব্লাউজ পিস।';
    
    $regularPrice = $toNum($themeSettings['hero_regular_price'] ?? 2800, 2800);
    $offerPrice = $toNum($themeSettings['hero_offer_price'] ?? 1950, 1950);
    
    if ($regularPrice <= 0) $regularPrice = 2800;
    if ($offerPrice <= 0) $offerPrice = 1950;
    
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

<main class="space-y-12 sm:space-y-20 bg-rose-50/50 text-stone-900 font-sans">

    <!-- 1. ROYAL HERITAGE SAREE EDITORIAL HERO -->
    <section class="relative pt-10 sm:pt-16 pb-16 bg-gradient-to-b from-rose-100/70 via-rose-50/40 to-white border-b border-rose-200">
        <div class="max-w-6xl mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                
                <!-- Left Portrait with gold frame -->
                <div class="lg:col-span-5 flex justify-center order-2 lg:order-1">
                    <div class="relative p-3 bg-white rounded-3xl shadow-2xl border-4 border-rose-300 max-w-sm w-full">
                        <div class="absolute -top-3.5 -right-3.5 bg-rose-700 text-white font-extrabold text-xs uppercase px-3.5 py-1.5 rounded-full shadow-lg tracking-wider animate-pulse">
                            ORIGINAL HANDLOOM
                        </div>
                        <img src="{{ $productImg1 }}" alt="{{ $productTitle }}" class="w-full h-[420px] object-cover rounded-2xl shadow-inner">
                        <div class="mt-3 text-center text-xs font-serif text-rose-950 font-bold bg-rose-50 py-2 px-3 rounded-xl border border-rose-200">
                            ✦ ১৪ হাত পূর্ণ বহর ও ম্যাচিং রানিং ব্লাউজ পিস সহ ✦
                        </div>
                    </div>
                </div>

                <!-- Right Editorial Text -->
                <div class="lg:col-span-7 space-y-5 text-center lg:text-left order-1 lg:order-2">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-rose-100 text-rose-950 text-xs sm:text-sm font-black border border-rose-300 shadow-sm">
                        <i class="fas fa-gem text-rose-700"></i>
                        <span>{{ $themeSettings['hero_badge'] ?? '🥻 রূপগঞ্জের ঐতিহ্যবাহী তাঁতের খাঁটি ঢাকাই জামদানি' }}</span>
                    </div>

                    <h1 class="text-3xl sm:text-5xl font-black text-rose-950 leading-tight">
                        {{ $productTitle }}
                    </h1>

                    <p class="text-stone-700 text-base sm:text-lg leading-relaxed font-medium">
                        {{ $productDesc }}
                    </p>

                    <!-- Urgent Countdown Timer -->
                    <div class="p-3.5 bg-gradient-to-r from-rose-700 via-red-600 to-rose-800 text-white rounded-2xl shadow-md flex flex-wrap items-center justify-between gap-3">
                        <div class="flex items-center gap-2 font-bold text-xs sm:text-sm">
                            <span class="inline-block w-2.5 h-2.5 bg-yellow-300 rounded-full animate-ping"></span>
                            <span>🔥 উৎসব স্পেশাল ধামাকা অফার শেষ হতে বাকি:</span>
                        </div>
                        <div class="flex items-center gap-1.5 text-xs sm:text-sm font-black text-stone-900 font-mono">
                            <span class="bg-white px-2 py-1 rounded shadow text-rose-700" id="saree_timer_hours">05</span> :
                            <span class="bg-white px-2 py-1 rounded shadow text-rose-700" id="saree_timer_minutes">41</span> :
                            <span class="bg-white px-2 py-1 rounded shadow text-rose-700" id="saree_timer_seconds">29</span>
                        </div>
                    </div>

                    <!-- Price Badge -->
                    <div class="inline-flex flex-wrap items-center gap-6 p-4 rounded-2xl bg-white border-2 border-rose-300 shadow-md">
                        <div>
                            <span class="text-xs text-stone-500 block font-bold uppercase">রেগুলার মূল্য</span>
                            <span class="text-xl font-extrabold text-stone-400 line-through">৳{{ number_format($regularPrice) }}</span>
                        </div>
                        <div class="h-8 w-px bg-rose-300 hidden sm:block"></div>
                        <div>
                            <span class="text-xs text-rose-900 font-black block uppercase">উৎসব অফার মূল্য</span>
                            <span class="text-3xl sm:text-4xl font-black text-rose-800">৳{{ number_format($offerPrice) }}</span>
                        </div>
                        <span class="bg-rose-700 text-white text-xs font-black px-3.5 py-1.5 rounded-full shadow-sm">
                            {{ $themeSettings['hero_discount_tag'] ?? '৩০% বিশেষ মূল্যছাড়!' }}
                        </span>
                    </div>

                    <!-- Bullet Features Checklist -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 pt-1 text-left text-xs sm:text-sm text-stone-800 font-bold">
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-rose-700 text-base"></i> ১০০ কাউন্টের সফট ও মোলায়েম কাপড়</div>
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-rose-700 text-base"></i> চকচকে সোনালী জরির সুনিপুণ কাজ</div>
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-rose-700 text-base"></i> পার্সেল খুলে চেক করে পেমেন্টের সুযোগ</div>
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-rose-700 text-base"></i> সারা দেশে দ্রুত ক্যাশ অন ডেলিভারি</div>
                    </div>

                    <!-- CTA Button -->
                    <div class="pt-2">
                        <a href="#fast-order-form" class="pulse-btn inline-flex items-center justify-center gap-3 bg-rose-800 hover:bg-rose-900 text-amber-300 font-black text-lg px-8 py-4 rounded-xl shadow-xl transition transform hover:-translate-y-0.5 w-full sm:w-auto">
                            <i class="fas fa-shopping-bag"></i>
                            <span>{{ $themeSettings['hero_button_text'] ?? '👉 পছন্দের কালার বেছে অর্ডার করুন (ক্যাশ অন ডেলিভারি)' }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. CRAFTSMANSHIP & TEXTURE GALLERY -->
    <section class="max-w-6xl mx-auto px-4">
        <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
            <span class="text-xs uppercase font-extrabold text-rose-800 tracking-widest">সূক্ষ্ম তাঁতের বুনন ও কারুকাজ</span>
            <h2 class="text-2xl sm:text-4xl font-black text-stone-900">কাছ থেকে দেখুন জামদানির আসল আভিজাত্য</h2>
            <p class="text-stone-600 font-medium text-sm">প্রতিটি শাড়িতে ফুটে ওঠে আবহমান বাংলার ঐতিহ্যবাহী তাঁতিদের নিখুঁত শিল্পকর্ম</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl border-2 border-rose-200 overflow-hidden shadow-md group hover:shadow-xl transition">
                <div class="h-64 overflow-hidden bg-rose-50">
                    <img src="{{ $productImg1 }}" alt="শাড়ির জমিন ও বুনন" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                </div>
                <div class="p-4 text-center">
                    <h3 class="font-black text-base text-rose-950 mb-1">নিখুঁত ফুলকারি জমিন</h3>
                    <p class="text-xs text-stone-600 font-medium">১০০ কাউন্টের মোলায়েম সুতায় বোনা সম্পূর্ণ আরামদায়ক ফিনিশিং</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl border-2 border-rose-200 overflow-hidden shadow-md group hover:shadow-xl transition">
                <div class="h-64 overflow-hidden bg-rose-50">
                    <img src="{{ $productImg2 }}" alt="আঁচল ও পাড়ের কারুকাজ" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                </div>
                <div class="p-4 text-center">
                    <h3 class="font-black text-base text-rose-950 mb-1">আভিজাত্যময় জরি আঁচল</h3>
                    <p class="text-xs text-stone-600 font-medium">চকচকে প্রিমিয়াম জরির কাজ যা সহজে নষ্ট হবে না বা রঙ উঠবে না</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl border-2 border-rose-200 overflow-hidden shadow-md group hover:shadow-xl transition">
                <div class="h-64 overflow-hidden bg-rose-50">
                    <img src="{{ $productImg3 }}" alt="ম্যাচিং ব্লাউজ পিস" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                </div>
                <div class="p-4 text-center">
                    <h3 class="font-black text-base text-rose-950 mb-1">ম্যাচিং ব্লাউজ পিস</h3>
                    <p class="text-xs text-stone-600 font-medium">১ গজ রানিং ব্লাউজ পিস সহ পূর্ণাঙ্গ ও আকর্ষণীয় সাজের নিশ্চয়তা</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. SAREE SPECIFICATIONS TABLE -->
    <section class="max-w-4xl mx-auto px-4">
        <div class="bg-white rounded-3xl border-2 border-rose-200 shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-rose-800 to-rose-900 text-white p-5 text-center">
                <h3 class="text-xl sm:text-2xl font-black">শাড়ির বিস্তারিত বিবরণ ও স্পেসিফিকেশন</h3>
                <p class="text-rose-100 text-xs mt-1">অর্ডার করার পূর্বে পণ্যের যাবতীয় তথ্য জেনে নিন</p>
            </div>
            <div class="p-6">
                <div class="divide-y divide-rose-100 text-sm">
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-stone-700">উপাদান ও সুতা</span>
                        <span class="font-bold text-rose-950">১০০ কাউন্ট মোলায়েম সুতা ও খাঁটি জরি</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-stone-700">শাড়ির পূর্ণ বহর</span>
                        <span class="font-bold text-rose-950">১৪ হাত (কুঁচি ও আঁচল নিখুঁতভাবে বসবে)</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-stone-700">ব্লাউজ পিস</span>
                        <span class="font-bold text-rose-950">১ মিটার ম্যাচিং রানিং ব্লাউজ পিস সহ</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-stone-700">বুনন পদ্ধতি</span>
                        <span class="font-bold text-rose-950">রূপগঞ্জের খাঁটি হ্যান্ডলুম তাঁতে প্রস্তুত</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-stone-700">ব্যবহার উপযোগী</span>
                        <span class="font-bold text-rose-950">ঈদ, বিয়ে, পূজা, জন্মদিন ও যেকোনো পারিবারিক অনুষ্ঠানে</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-stone-700">ধোয়ার নিয়ম</span>
                        <span class="font-bold text-rose-950">ড্রাই ওয়াশ অথবা হালকা ঠাণ্ডা পানিতে শ্যাম্পু ওয়াশ</span>
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
                <p class="text-xs text-stone-600 font-medium leading-relaxed">আগে ১ টাকাও অগ্রিম দিতে হবে না, পণ্য হাতে পেয়ে দাম পরিশোধ করুন।</p>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-rose-200 shadow-sm text-center">
                <div class="w-12 h-12 mx-auto rounded-xl bg-rose-100 text-rose-800 flex items-center justify-center text-xl mb-3">
                    <i class="fas fa-box-open"></i>
                </div>
                <h4 class="font-black text-base text-stone-900 mb-1">দেখে নেওয়ার সুযোগ</h4>
                <p class="text-xs text-stone-600 font-medium leading-relaxed">ডেলিভারিম্যানের সামনে পার্সেল খুলে শাড়ি দেখে নিশ্চিত হয়ে রিসিভ করুন।</p>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-rose-200 shadow-sm text-center">
                <div class="w-12 h-12 mx-auto rounded-xl bg-rose-100 text-rose-800 flex items-center justify-center text-xl mb-3">
                    <i class="fas fa-truck-fast"></i>
                </div>
                <h4 class="font-black text-base text-stone-900 mb-1">সারা দেশে ডেলিভারি</h4>
                <p class="text-xs text-stone-600 font-medium leading-relaxed">ঢাকায় ২৪-৪৮ ঘণ্টায় এবং ঢাকার বাইরে ২-৩ দিনের মধ্যে নিশ্চিত ডেলিভারি।</p>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-rose-200 shadow-sm text-center">
                <div class="w-12 h-12 mx-auto rounded-xl bg-rose-100 text-rose-800 flex items-center justify-center text-xl mb-3">
                    <i class="fas fa-arrows-rotate"></i>
                </div>
                <h4 class="font-black text-base text-stone-900 mb-1">সহজ এক্সচেঞ্জ নীতি</h4>
                <p class="text-xs text-stone-600 font-medium leading-relaxed">কোনো ডিফেক্ট বা রঙের অমিল থাকলে ৭ দিনের ভেতর বিনামূল্যে বদলানোর সুবিধা।</p>
            </div>
        </div>
    </section>

    <!-- 5. VERIFIED CUSTOMER REVIEWS (SOCIAL PROOF) -->
    <section class="max-w-6xl mx-auto px-4">
        <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
            <span class="text-xs uppercase font-extrabold text-rose-800 tracking-widest">প্রকৃত ক্রেতাদের মতামত</span>
            <h2 class="text-2xl sm:text-4xl font-black text-stone-900">আমাদের সন্তুষ্ট গ্রাহকদের রিভিউ</h2>
            <div class="flex items-center justify-center gap-1 text-amber-500 text-sm">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                <span class="text-stone-700 font-bold ml-2">৪.৯/৫ (১৫০+ ভেরিফায়েড রিভিউ)</span>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-5 rounded-2xl border-2 border-rose-100 shadow-md flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center gap-1 text-amber-400 text-xs">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-xs sm:text-sm text-stone-700 font-medium leading-relaxed">
                        "শাড়িটা হাতে পেয়ে সত্যি মুগ্ধ হয়েছি! কাপড়ের সফটনেস আর জরি কাজ অসাধারণ। প্যাকেজিং খুব সুন্দর ছিল।"
                    </p>
                </div>
                <div class="pt-4 border-t border-rose-50 flex items-center justify-between mt-4">
                    <div>
                        <h4 class="text-xs font-bold text-rose-950">সানজিদা সুলতানা</h4>
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
                        "পার্সেল খুলে দেখে পেমেন্ট করতে পেরে খুব ভালো লেগেছে। ছবির চেয়েও বাস্তবে বেশি সুন্দর ও উজ্জ্বল।"
                    </p>
                </div>
                <div class="pt-4 border-t border-rose-50 flex items-center justify-between mt-4">
                    <div>
                        <h4 class="text-xs font-bold text-rose-950">নুসরাত জাহান রিমি</h4>
                        <span class="text-[11px] text-stone-500 font-medium">ধানমন্ডি, ঢাকা</span>
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
                        "কালার কম্বিনেশন জাস্ট ওয়াও! ব্লাউজ পিসটাও বেশ বড় আছে। পরিবারের সবাই শাড়িটির প্রশংসা করেছে।"
                    </p>
                </div>
                <div class="pt-4 border-t border-rose-50 flex items-center justify-between mt-4">
                    <div>
                        <h4 class="text-xs font-bold text-rose-950">ফারহানা ইয়াসমিন</h4>
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
                        "মাত্র ২ দিনে চট্টগ্রামে ডেলিভারি পেয়েছি। এই দামে এমন প্রিমিয়াম কোয়ালিটির জামদানি সত্যি অবিশ্বাস্য!"
                    </p>
                </div>
                <div class="pt-4 border-t border-rose-50 flex items-center justify-between mt-4">
                    <div>
                        <h4 class="text-xs font-bold text-rose-950">মেহজাবিন আহমেদ</h4>
                        <span class="text-[11px] text-stone-500 font-medium">চট্টগ্রাম সদর</span>
                    </div>
                    <span class="text-[10px] bg-green-100 text-green-800 font-bold px-2 py-0.5 rounded-full">ভেরিফায়েড</span>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. HIGH CONVERTING 1-PAGE CASH ON DELIVERY CHECKOUT FORM -->
    <section id="fast-order-form" class="max-w-4xl mx-auto px-4 scroll-mt-20">
        <div class="bg-white rounded-3xl border-4 border-rose-400 shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-rose-800 via-red-700 to-rose-900 text-white p-6 sm:p-8 text-center">
                <span class="inline-block bg-yellow-400 text-rose-950 text-xs font-black uppercase px-3 py-1 rounded-full mb-2">
                    ⚡ সহজ ১-মিনিট ক্যাশ অন ডেলিভারি ফর্ম
                </span>
                <h3 class="text-2xl sm:text-4xl font-black">অর্ডার করতে নিচের তথ্যগুলো পূরণ করুন</h3>
                <p class="text-rose-100 text-xs sm:text-sm mt-1">অগ্রিম ১ টাকাও দিতে হবে না, পার্সেল হাতে পেয়ে মূল্য পরিশোধ করবেন</p>
            </div>

            <form action="{{ route('single.fast.order', $slug ?? ($store->slug ?? 'shop001')) }}" method="POST" class="p-6 sm:p-10 space-y-6" id="sareeOrderForm">
                @csrf
                <input type="hidden" name="product_id" value="{{ $mainProduct->id ?? 1 }}">
                <input type="hidden" name="unit_price" id="saree_unit_price" value="{{ $offerPrice }}">
                <input type="hidden" name="product_variant" id="saree_selected_variant" value="রয়্যাল মেরুন (১টি শাড়ি)">
                <input type="hidden" name="selected_color" id="saree_selected_color" value="রয়্যাল মেরুন">
                <input type="hidden" name="selected_package" id="saree_selected_package" value="১টি শাড়ি (৳১,৯৫০)">

                <!-- Step 1: Package Selection -->
                <div class="space-y-3">
                    <label class="block text-sm font-black text-rose-950">
                        ১. প্যাকেজ পছন্দ করুন <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <label class="relative flex items-center justify-between p-4 rounded-2xl border-2 border-rose-400 bg-rose-50/60 cursor-pointer package-card hover:bg-rose-50 transition" onclick="selectSareePackage(1, {{ $offerPrice }}, '১টি শাড়ি', this)">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="pkg_choice" value="1" checked class="text-rose-700 focus:ring-rose-500">
                                <div>
                                    <span class="font-black text-stone-900 text-sm block">১টি প্রিমিয়াম শাড়ি</span>
                                    <span class="text-xs text-stone-600 font-medium">উৎসব স্পেশাল অফার</span>
                                </div>
                            </div>
                            <span class="text-lg font-black text-rose-800">৳{{ number_format($offerPrice) }}</span>
                        </label>

                        <label class="relative flex items-center justify-between p-4 rounded-2xl border-2 border-stone-200 bg-white cursor-pointer package-card hover:bg-rose-50 transition" onclick="selectSareePackage(2, 3650, '২টি শাড়ি কম্বো (ফ্রি ডেলিভারি)', this)">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="pkg_choice" value="2" class="text-rose-700 focus:ring-rose-500">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-black text-stone-900 text-sm block">২টি শাড়ি মেগা কম্বো</span>
                                        <span class="bg-red-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">ফ্রি ডেলিভারি</span>
                                    </div>
                                    <span class="text-xs text-stone-600 font-medium">৳২৫০ সেভ + ফ্রি হোম ডেলিভারি</span>
                                </div>
                            </div>
                            <span class="text-lg font-black text-rose-800">৳৩,৬৫০</span>
                        </label>
                    </div>
                </div>

                <!-- Step 2: Color Selection -->
                <div class="space-y-3">
                    <label class="block text-sm font-black text-rose-950">
                        ২. আপনার পছন্দের কালার বেছে নিন <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <button type="button" class="saree-color-btn py-3 px-3 rounded-xl border-2 border-rose-600 bg-rose-50 text-rose-950 font-bold text-xs sm:text-sm flex items-center justify-center gap-2 shadow-sm transition" onclick="setSareeColor('রয়্যাল মেরুন', this)">
                            <span class="w-3.5 h-3.5 rounded-full bg-red-900 border border-white"></span>
                            <span>রয়্যাল মেরুন</span>
                        </button>
                        <button type="button" class="saree-color-btn py-3 px-3 rounded-xl border-2 border-stone-200 bg-white text-stone-800 font-bold text-xs sm:text-sm flex items-center justify-center gap-2 transition hover:border-rose-300" onclick="setSareeColor('ময়ূরকণ্ঠী ব্লু', this)">
                            <span class="w-3.5 h-3.5 rounded-full bg-blue-900 border border-white"></span>
                            <span>ময়ূরকণ্ঠী ব্লু</span>
                        </button>
                        <button type="button" class="saree-color-btn py-3 px-3 rounded-xl border-2 border-stone-200 bg-white text-stone-800 font-bold text-xs sm:text-sm flex items-center justify-center gap-2 transition hover:border-rose-300" onclick="setSareeColor('পান্না সবুজ', this)">
                            <span class="w-3.5 h-3.5 rounded-full bg-emerald-800 border border-white"></span>
                            <span>পান্না সবুজ</span>
                        </button>
                        <button type="button" class="saree-color-btn py-3 px-3 rounded-xl border-2 border-stone-200 bg-white text-stone-800 font-bold text-xs sm:text-sm flex items-center justify-center gap-2 transition hover:border-rose-300" onclick="setSareeColor('বাসন্তী হলুদ', this)">
                            <span class="w-3.5 h-3.5 rounded-full bg-amber-500 border border-white"></span>
                            <span>বাসন্তী হলুদ</span>
                        </button>
                    </div>
                </div>

                <!-- Step 3: Customer Details -->
                <div class="space-y-4 pt-2">
                    <label class="block text-sm font-black text-rose-950">
                        ৩. ডেলিভারি তথ্য দিন <span class="text-red-500">*</span>
                    </label>

                    <div>
                        <label class="block text-xs font-bold text-stone-700 mb-1">আপনার পূর্ণ নাম *</label>
                        <input type="text" name="customer_name" required placeholder="যেমন: নুসরাত জাহান" class="w-full px-4 py-3 rounded-xl border-2 border-stone-300 focus:border-rose-600 focus:outline-none text-stone-900 font-medium text-sm">
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
                            <label class="flex items-center justify-between p-3.5 rounded-xl border-2 border-rose-600 bg-rose-50/60 cursor-pointer delivery-card transition" onclick="setSareeDelivery({{ $dhakaCharge }}, this)">
                                <div class="flex items-center gap-2">
                                    <input type="radio" name="delivery_location" value="dhaka" checked class="text-rose-700">
                                    <span class="text-xs sm:text-sm font-bold text-stone-900">ঢাকা সিটির ভিতরে</span>
                                </div>
                                <span class="text-xs sm:text-sm font-bold text-rose-800">৳{{ $dhakaCharge }}</span>
                            </label>

                            <label class="flex items-center justify-between p-3.5 rounded-xl border-2 border-stone-200 bg-white cursor-pointer delivery-card transition hover:bg-rose-50" onclick="setSareeDelivery({{ $outsideCharge }}, this)">
                                <div class="flex items-center gap-2">
                                    <input type="radio" name="delivery_location" value="outside" class="text-rose-700">
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
                        <span class="font-bold text-stone-900" id="saree_subtotal_text">৳{{ number_format($offerPrice) }}</span>
                    </div>
                    <div class="flex justify-between text-stone-700 font-medium">
                        <span>ডেলিভারি চার্জ:</span>
                        <span class="font-bold text-stone-900" id="saree_delivery_text">৳{{ $dhakaCharge }}</span>
                    </div>
                    <div class="h-px bg-rose-200 my-1"></div>
                    <div class="flex justify-between text-base sm:text-lg font-black text-rose-950">
                        <span>সর্বমোট প্রদেয় বিল:</span>
                        <span class="text-2xl font-black text-rose-800" id="saree_total_text">৳{{ number_format($offerPrice + $dhakaCharge) }}</span>
                    </div>
                </div>

                <button type="submit" class="pulse-btn w-full bg-gradient-to-r from-rose-700 via-red-600 to-rose-800 hover:from-rose-800 hover:to-rose-900 text-white font-black text-lg sm:text-xl py-4 rounded-2xl shadow-xl transition transform hover:-translate-y-0.5 flex items-center justify-center gap-3">
                    <i class="fas fa-lock text-yellow-300"></i>
                    <span>অর্ডার কনফার্ম করুন (ক্যাশ অন ডেলিভারি)</span>
                </button>
            </form>
        </div>
    </section>

    <!-- 7. FREQUENTLY ASKED QUESTIONS (FAQ) -->
    <section class="max-w-4xl mx-auto px-4">
        <div class="text-center mb-8">
            <span class="text-xs uppercase font-extrabold text-rose-800 tracking-widest">সাধারণ জিজ্ঞাসা</span>
            <h2 class="text-2xl sm:text-3xl font-black text-stone-900 mt-1">সচরাচর জানতে চাওয়া প্রশ্ন ও উত্তর</h2>
        </div>

        <div class="space-y-3">
            <div class="bg-white p-5 rounded-2xl border-2 border-rose-100 shadow-sm">
                <h4 class="font-black text-stone-900 text-sm sm:text-base flex items-center gap-2">
                    <i class="fas fa-question-circle text-rose-700"></i> শাড়িটি কি আসল ঢাকাই জামদানি?
                </h4>
                <p class="text-xs sm:text-sm text-stone-600 font-medium mt-2 leading-relaxed pl-6">
                    জী, এটি রূপগঞ্জের ঐতিহ্যবাহী তাঁতিদের হাতে বোনা খাঁটি ঢাকাই জামদানি। ১০০ কাউন্টের সফট সুতা ও উন্নত জরির ফিনিশিং নিশ্চিত করা হয়েছে।
                </p>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-rose-100 shadow-sm">
                <h4 class="font-black text-stone-900 text-sm sm:text-base flex items-center gap-2">
                    <i class="fas fa-question-circle text-rose-700"></i> ডেলিভারির আগে কি কোনো অগ্রিম টাকা দিতে হবে?
                </h4>
                <p class="text-xs sm:text-sm text-stone-600 font-medium mt-2 leading-relaxed pl-6">
                    একদমই না! আমরা ১০০% ক্যাশ অন ডেলিভারিতে সারাদেশে ডেলিভারি দিই। ডেলিভারিম্যান আসার পর পার্সেল দেখে তারপর টাকা পরিশোধ করবেন।
                </p>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-rose-100 shadow-sm">
                <h4 class="font-black text-stone-900 text-sm sm:text-base flex items-center gap-2">
                    <i class="fas fa-question-circle text-rose-700"></i> কোনো সমস্যা হলে কি পরিবর্তন করার সুযোগ আছে?
                </h4>
                <p class="text-xs sm:text-sm text-stone-600 font-medium mt-2 leading-relaxed pl-6">
                    অবশ্যই! পার্সেল খোলার সময় কোনো ত্রুটি বা রঙের অমিল দেখা দিলে আমাদের হটলাইনে কল দিন, আমরা বিনা খরচে তাৎক্ষণিক রিপ্লেসমেন্ট করে দেব।
                </p>
            </div>
        </div>
    </section>

</main>

<!-- FLOATING WHATSAPP BUTTON -->
<a href="https://wa.me/8801700000000?text=আসসালামু%20আলাইকুম!%20ঢাকাই%20জামদানি%20শাড়ি%20সম্পর্কে%20জানতে%20চাই" target="_blank" class="fixed bottom-20 right-4 z-40 bg-green-500 hover:bg-green-600 text-white p-3.5 rounded-full shadow-2xl flex items-center justify-center transition transform hover:scale-110" title="হোয়াটসঅ্যাপে কথা বলুন">
    <i class="fab fa-whatsapp text-3xl"></i>
</a>

<!-- MOBILE STICKY CTA -->
<div class="fixed bottom-0 left-0 right-0 z-30 sm:hidden bg-white/95 backdrop-blur-md border-t-2 border-rose-300 p-3 shadow-2xl">
    <div class="flex items-center justify-between gap-3 max-w-md mx-auto">
        <div>
            <span class="text-[11px] text-stone-500 font-bold block">উৎসব স্পেশাল মূল্য</span>
            <span class="text-xl font-black text-rose-800">৳{{ number_format($offerPrice) }}</span>
        </div>
        <a href="#fast-order-form" class="bg-rose-800 hover:bg-rose-900 text-amber-300 font-black text-sm px-5 py-2.5 rounded-xl shadow-lg transition flex items-center gap-1.5">
            <i class="fas fa-shopping-bag"></i> এখনই কিনুন
        </a>
    </div>
</div>

<script>
    // Live Countdown Timer
    let sareeHours = 5, sareeMinutes = 41, sareeSeconds = 29;
    setInterval(function() {
        if (sareeSeconds > 0) {
            sareeSeconds--;
        } else {
            sareeSeconds = 59;
            if (sareeMinutes > 0) {
                sareeMinutes--;
            } else {
                sareeMinutes = 59;
                if (sareeHours > 0) sareeHours--;
            }
        }
        document.getElementById('saree_timer_hours').textContent = String(sareeHours).padStart(2, '0');
        document.getElementById('saree_timer_minutes').textContent = String(sareeMinutes).padStart(2, '0');
        document.getElementById('saree_timer_seconds').textContent = String(sareeSeconds).padStart(2, '0');
    }, 1000);

    let currentSareeSubtotal = {{ $offerPrice }};
    let currentSareeDelivery = {{ $dhakaCharge }};
    let isSareeFreeDelivery = false;
    let currentSareeColor = 'রয়্যাল মেরুন';
    let currentSareePkg = '১টি শাড়ি';

    function syncSareeVariant() {
        document.getElementById('saree_selected_variant').value = currentSareeColor + ' (' + currentSareePkg + ')';
    }

    function selectSareePackage(pkgId, price, label, el) {
        currentSareeSubtotal = price;
        isSareeFreeDelivery = (pkgId === 2);
        currentSareePkg = label;
        syncSareeVariant();
        document.getElementById('saree_unit_price').value = price;
        document.getElementById('saree_selected_package').value = label + ' (৳' + price + ')';

        document.querySelectorAll('.package-card').forEach(c => {
            c.classList.remove('border-rose-400', 'bg-rose-50/60');
            c.classList.add('border-stone-200', 'bg-white');
        });
        el.classList.add('border-rose-400', 'bg-rose-50/60');
        el.classList.remove('border-stone-200', 'bg-white');
        updateSareeBill();
    }

    function setSareeColor(color, el) {
        currentSareeColor = color;
        syncSareeVariant();
        document.getElementById('saree_selected_color').value = color;
        document.querySelectorAll('.saree-color-btn').forEach(b => {
            b.classList.remove('border-rose-600', 'bg-rose-50', 'text-rose-950');
            b.classList.add('border-stone-200', 'bg-white', 'text-stone-800');
        });
        el.classList.add('border-rose-600', 'bg-rose-50', 'text-rose-950');
        el.classList.remove('border-stone-200', 'bg-white', 'text-stone-800');
    }

    function setSareeDelivery(charge, el) {
        currentSareeDelivery = charge;
        document.querySelectorAll('.delivery-card').forEach(d => {
            d.classList.remove('border-rose-600', 'bg-rose-50/60');
            d.classList.add('border-stone-200', 'bg-white');
        });
        el.classList.add('border-rose-600', 'bg-rose-50/60');
        el.classList.remove('border-stone-200', 'bg-white');
        updateSareeBill();
    }

    function updateSareeBill() {
        let deliveryToApply = isSareeFreeDelivery ? 0 : currentSareeDelivery;
        let total = currentSareeSubtotal + deliveryToApply;
        document.getElementById('saree_subtotal_text').textContent = '৳' + currentSareeSubtotal.toLocaleString();
        document.getElementById('saree_delivery_text').textContent = isSareeFreeDelivery ? 'ফ্রি (৳০)' : '৳' + deliveryToApply;
        document.getElementById('saree_total_text').textContent = '৳' + total.toLocaleString();
    }
</script>
@endsection
