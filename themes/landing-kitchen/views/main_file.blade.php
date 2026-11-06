@extends('front_end.layouts.app')

@section('page-title')
    {{ $store->name ?? 'Germany 4-in-1 Electric Food Chopper & Meat Grinder' }}
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
    $productTitle = $themeSettings['hero_title'] ?? 'জার্মানি টেকনোলজি ৪-ইন-১ ইলেকট্রিক ফুড চপার, মিট কিমা ও জুসার';
    $productDesc = $themeSettings['hero_subtitle'] ?? '৩০০ ওয়াট ১০০% খাঁটি কপার মোটর, ৪-ব্লেড টাইটানিয়াম স্টিল কাটার ও ২ লিটার স্টেইনলেস স্টিল বাটি। পেঁয়াজ, রসুন, আদা, মাংসের কিমা ও মসলা ব্লেন্ড করুন মাত্র ৫ সেকেন্ডে!';
    
    $regularPrice = $toNum($themeSettings['hero_regular_price'] ?? 1950, 1950);
    $offerPrice = $toNum($themeSettings['hero_offer_price'] ?? 1350, 1350);
    
    if ($regularPrice <= 0) $regularPrice = 1950;
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

<main class="space-y-12 sm:space-y-20 bg-orange-50/40 text-stone-900 font-sans">

    <!-- 1. KITCHEN APPLIANCE HERO -->
    <section class="relative pt-10 sm:pt-16 pb-16 bg-gradient-to-b from-orange-100/70 via-amber-50/40 to-white border-b border-orange-200">
        <div class="max-w-6xl mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                
                <!-- Left Portrait with gold frame -->
                <div class="lg:col-span-5 flex justify-center order-2 lg:order-1">
                    <div class="relative p-3 bg-white rounded-3xl shadow-2xl border-4 border-orange-300 max-w-sm w-full">
                        <div class="absolute -top-3.5 -right-3.5 bg-gradient-to-r from-orange-600 to-red-600 text-white font-extrabold text-xs uppercase px-3.5 py-1.5 rounded-full shadow-lg tracking-wider animate-pulse">
                            GERMAN TECH
                        </div>
                        <img src="{{ $productImg1 }}" alt="{{ $productTitle }}" class="w-full h-[380px] object-cover rounded-2xl shadow-inner">
                        <div class="mt-3 text-center text-xs font-serif text-orange-950 font-bold bg-orange-50 py-2 px-3 rounded-xl border border-orange-200">
                            ✦ ২ বছরের অফিসিয়াল মোটর রিপ্লেসমেন্ট গ্যারান্টি ✦
                        </div>
                    </div>
                </div>

                <!-- Right Editorial Text -->
                <div class="lg:col-span-7 space-y-5 text-center lg:text-left order-1 lg:order-2">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-orange-100 text-orange-950 text-xs sm:text-sm font-black border border-orange-300 shadow-sm">
                        <i class="fas fa-kitchen-set text-orange-600"></i>
                        <span>{{ $themeSettings['hero_badge'] ?? '🍳 আধুনিক গৃহিণীদের স্মার্ট কিচেন হেল্পার' }}</span>
                    </div>

                    <h1 class="text-3xl sm:text-5xl font-black text-orange-950 leading-tight">
                        {{ $productTitle }}
                    </h1>

                    <p class="text-stone-700 text-base sm:text-lg leading-relaxed font-medium">
                        {{ $productDesc }}
                    </p>

                    <!-- Urgent Countdown Timer -->
                    <div class="p-3.5 bg-gradient-to-r from-orange-600 via-red-600 to-amber-600 text-white rounded-2xl shadow-md flex flex-wrap items-center justify-between gap-3">
                        <div class="flex items-center gap-2 font-bold text-xs sm:text-sm">
                            <span class="inline-block w-2.5 h-2.5 bg-yellow-300 rounded-full animate-ping"></span>
                            <span>🔥 স্টক ক্লিয়ারেন্স ধামাকা অফার শেষ হতে বাকি:</span>
                        </div>
                        <div class="flex items-center gap-1.5 text-xs sm:text-sm font-black text-stone-900 font-mono">
                            <span class="bg-white px-2 py-1 rounded shadow text-orange-700 font-bold" id="kitchen_timer_hours">04</span> :
                            <span class="bg-white px-2 py-1 rounded shadow text-orange-700 font-bold" id="kitchen_timer_minutes">25</span> :
                            <span class="bg-white px-2 py-1 rounded shadow text-orange-700 font-bold" id="kitchen_timer_seconds">38</span>
                        </div>
                    </div>

                    <!-- Price Badge -->
                    <div class="inline-flex flex-wrap items-center gap-6 p-4 rounded-2xl bg-white border-2 border-orange-300 shadow-md">
                        <div>
                            <span class="text-xs text-stone-500 block font-bold uppercase">রেগুলার মূল্য</span>
                            <span class="text-xl font-extrabold text-stone-400 line-through">৳{{ number_format($regularPrice) }}</span>
                        </div>
                        <div class="h-8 w-px bg-orange-200 hidden sm:block"></div>
                        <div>
                            <span class="text-xs text-orange-900 font-black block uppercase">উৎসব অফার মূল্য</span>
                            <span class="text-3xl sm:text-4xl font-black text-orange-700">৳{{ number_format($offerPrice) }}</span>
                        </div>
                        <span class="bg-gradient-to-r from-orange-600 to-red-600 text-white text-xs font-black px-3.5 py-1.5 rounded-full shadow-sm">
                            {{ $themeSettings['hero_discount_tag'] ?? '৩১% বিশেষ ছাড়!' }}
                        </span>
                    </div>

                    <!-- Bullet Features Checklist -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 pt-1 text-left text-xs sm:text-sm text-stone-800 font-bold">
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-orange-600 text-base"></i> ৩০০ ওয়াট ১০০% পিউর কপার মোটর</div>
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-orange-600 text-base"></i> ৪-ব্লেড টাইটানিয়াম স্টিল কাটার</div>
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-orange-600 text-base"></i> পার্সেল চেক করে ক্যাশ অন ডেলিভারি</div>
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-orange-600 text-base"></i> ২ বছরের অফিসিয়াল ব্র্যান্ড ওয়ারেন্টি</div>
                    </div>

                    <!-- CTA Button -->
                    <div class="pt-2">
                        <a href="#fast-order-form" class="pulse-btn inline-flex items-center justify-center gap-3 bg-gradient-to-r from-orange-700 to-amber-600 hover:from-orange-800 hover:to-amber-700 text-white font-black text-lg px-8 py-4 rounded-xl shadow-xl transition transform hover:-translate-y-0.5 w-full sm:w-auto">
                            <i class="fas fa-shopping-basket text-yellow-300"></i>
                            <span>{{ $themeSettings['hero_button_text'] ?? '👉 এখনই অর্ডার করুন (ক্যাশ অন ডেলিভারি)' }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. HIGH SPEED FEATURES GALLERY -->
    <section class="max-w-6xl mx-auto px-4">
        <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
            <span class="text-xs uppercase font-extrabold text-orange-800 tracking-widest">জার্মান ইঞ্জিনিয়ারিং ও বিল্ড</span>
            <h2 class="text-2xl sm:text-4xl font-black text-stone-900">রান্নাঘরের সকল কাজ হবে মাত্র নিমিষে</h2>
            <p class="text-stone-600 font-medium text-sm">ঘণ্টার পর ঘণ্টা পেঁয়াজ কাটা বা বাটার দিন শেষ, এখন সব হবে মাত্র ৫ সেকেন্ডে</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl border-2 border-orange-200 overflow-hidden shadow-md group hover:shadow-xl transition">
                <div class="h-64 overflow-hidden bg-orange-50 flex items-center justify-center">
                    <img src="{{ $productImg1 }}" alt="ইলেকট্রিক ফুড চপার" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                </div>
                <div class="p-4 text-center">
                    <h3 class="font-black text-base text-orange-950 mb-1">৩০০ ওয়াট কপার মোটর</h3>
                    <p class="text-xs text-stone-600 font-medium">শক্তিশালী বিশুদ্ধ তামার মোটর যা গরম হয় না ও দীর্ঘ বছর স্থায়ী হয়</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl border-2 border-orange-200 overflow-hidden shadow-md group hover:shadow-xl transition">
                <div class="h-64 overflow-hidden bg-orange-50 flex items-center justify-center">
                    <img src="{{ $productImg2 }}" alt="মাংসের কিমা ও মসলা ব্লেন্ড" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                </div>
                <div class="p-4 text-center">
                    <h3 class="font-black text-base text-orange-950 mb-1">পারফেক্ট মিট কিমা ও মসলা</h3>
                    <p class="text-xs text-stone-600 font-medium">গরু বা মুরগির মাংস, আদা, রসুন, বাদাম ও শুকনো মসলা সেকেন্ডেই কিমা</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl border-2 border-orange-200 overflow-hidden shadow-md group hover:shadow-xl transition">
                <div class="h-64 overflow-hidden bg-orange-50 flex items-center justify-center">
                    <img src="{{ $productImg3 }}" alt="২ লিটার স্টেইনলেস স্টিল বাটি" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                </div>
                <div class="p-4 text-center">
                    <h3 class="font-black text-base text-orange-950 mb-1">২ লিটার স্টেইনলেস স্টিল বাটি</h3>
                    <p class="text-xs text-stone-600 font-medium">আনব্রেকেবল ফুড-গ্রেড স্টিল বাটি যা মাটিতে পড়ে গেলেও ভাঙবে না</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. MACHINE SPECIFICATIONS TABLE -->
    <section class="max-w-4xl mx-auto px-4">
        <div class="bg-white rounded-3xl border-2 border-orange-200 shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-orange-700 via-red-600 to-amber-600 text-white p-5 text-center">
                <h3 class="text-xl sm:text-2xl font-black">ফুড চপারের বিস্তারিত টেকনিক্যাল স্পেক্স</h3>
                <p class="text-orange-100 text-xs mt-1">অর্ডার করার পূর্বে ডিভাইসের সকল স্পেসিফিকেশন জেনে নিন</p>
            </div>
            <div class="p-6">
                <div class="divide-y divide-orange-100 text-sm">
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-stone-700">মোটর পাওয়ার</span>
                        <span class="font-bold text-orange-900">৩০০ ওয়াট ১০০% পিউর কপার মোটর</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-stone-700">ব্লেড টাইপ</span>
                        <span class="font-bold text-orange-900">৪-ব্লেড ডাবল লেয়ার ফুড-গ্রেড টাইটানিয়াম স্টিল</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-stone-700">বাটির ধারণক্ষমতা</span>
                        <span class="font-bold text-orange-900">২ লিটার হেভি ডিউটি স্টেইনলেস স্টিল (আনব্রেকেবল)</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-stone-700">স্পিড কন্ট্রোল</span>
                        <span class="font-bold text-orange-900">২-স্পিড ডুয়েল গিয়ার পুশ বাটন</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-stone-700">সুরক্ষা ফিচার</span>
                        <span class="font-bold text-orange-900">থার্মাল ওভারহিট প্রোটেকশন ও নন-স্লিপ সিলিকন বেস</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-stone-700">অফিশিয়াল ওয়ারেন্টি</span>
                        <span class="font-bold text-orange-900">২ বছরের মোটর রিপ্লেসমেন্ট ওয়ারেন্টি</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. TRUST & GUARANTEE PILLARS -->
    <section class="max-w-6xl mx-auto px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white p-5 rounded-2xl border-2 border-orange-200 shadow-sm text-center">
                <div class="w-12 h-12 mx-auto rounded-xl bg-orange-100 text-orange-800 flex items-center justify-center text-xl mb-3">
                    <i class="fas fa-hand-holding-dollar"></i>
                </div>
                <h4 class="font-black text-base text-stone-900 mb-1">ক্যাশ অন ডেলিভারি</h4>
                <p class="text-xs text-stone-600 font-medium leading-relaxed">আগে ১ টাকাও অগ্রিম দিতে হবে না, পণ্য হাতে পেয়ে মূল্য পরিশোধ করুন।</p>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-orange-200 shadow-sm text-center">
                <div class="w-12 h-12 mx-auto rounded-xl bg-orange-100 text-orange-800 flex items-center justify-center text-xl mb-3">
                    <i class="fas fa-shield-halved"></i>
                </div>
                <h4 class="font-black text-base text-stone-900 mb-1">২ বছরের গ্যারান্টি</h4>
                <p class="text-xs text-stone-600 font-medium leading-relaxed">মোটরে কোনো সমস্যা হলে ২ বছরের ভেতরে সরাসরি নতুন মোটর পরিবর্তন।</p>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-orange-200 shadow-sm text-center">
                <div class="w-12 h-12 mx-auto rounded-xl bg-orange-100 text-orange-800 flex items-center justify-center text-xl mb-3">
                    <i class="fas fa-truck-fast"></i>
                </div>
                <h4 class="font-black text-base text-stone-900 mb-1">দ্রুততম ডেলিভারি</h4>
                <p class="text-xs text-stone-600 font-medium leading-relaxed">ঢাকায় ২৪-৪৮ ঘণ্টায় এবং ঢাকার বাইরে ২-৩ দিনের মধ্যে ডেলিভারি।</p>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-orange-200 shadow-sm text-center">
                <div class="w-12 h-12 mx-auto rounded-xl bg-orange-100 text-orange-800 flex items-center justify-center text-xl mb-3">
                    <i class="fas fa-box-open"></i>
                </div>
                <h4 class="font-black text-base text-stone-900 mb-1">দেখে নেওয়ার সুযোগ</h4>
                <p class="text-xs text-stone-600 font-medium leading-relaxed">ডেলিভারিম্যানের সামনে প্যাকেট খুলে চপার দেখে নিশ্চিন্তে রিসিভ করুন।</p>
            </div>
        </div>
    </section>

    <!-- 5. VERIFIED CUSTOMER REVIEWS (SOCIAL PROOF) -->
    <section class="max-w-6xl mx-auto px-4">
        <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
            <span class="text-xs uppercase font-extrabold text-orange-800 tracking-widest">প্রকৃত ক্রেতাদের রিভিউ</span>
            <h2 class="text-2xl sm:text-4xl font-black text-stone-900">আমাদের সন্তুষ্ট গৃহিণীদের অভিজ্ঞতা</h2>
            <div class="flex items-center justify-center gap-1 text-amber-500 text-sm">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                <span class="text-stone-700 font-bold ml-2">৪.৯/৫ (৪৫০+ কাস্টমার রিভিউ)</span>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-5 rounded-2xl border-2 border-orange-100 shadow-md flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center gap-1 text-amber-400 text-xs">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-xs sm:text-sm text-stone-700 font-medium leading-relaxed">
                        "মাত্র ৫ সেকেন্ডে পেঁয়াজ ও আদা একদম মিহি কিমা হয়ে যায়! রান্নার সময় এখন অর্ধেক বেঁচে যায়।"
                    </p>
                </div>
                <div class="pt-4 border-t border-orange-50 flex items-center justify-between mt-4">
                    <div>
                        <h4 class="text-xs font-bold text-orange-950">ফরিদা ইয়াসমিন</h4>
                        <span class="text-[11px] text-stone-500 font-medium">মিরপুর ২, ঢাকা</span>
                    </div>
                    <span class="text-[10px] bg-green-100 text-green-800 font-bold px-2 py-0.5 rounded-full">ভেরিফায়েড</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-orange-100 shadow-md flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center gap-1 text-amber-400 text-xs">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-xs sm:text-sm text-stone-700 font-medium leading-relaxed">
                        "স্টেইনলেস স্টিলের বাটি হওয়ায় ভাঙার কোনো ভয় নেই। মাংসের কিমা খুব নিখুঁতভাবে হয়।"
                    </p>
                </div>
                <div class="pt-4 border-t border-orange-50 flex items-center justify-between mt-4">
                    <div>
                        <h4 class="text-xs font-bold text-orange-950">মাহবুবা হক</h4>
                        <span class="text-[11px] text-stone-500 font-medium">উত্তরা, ঢাকা</span>
                    </div>
                    <span class="text-[10px] bg-green-100 text-green-800 font-bold px-2 py-0.5 rounded-full">ভেরিফায়েড</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-orange-100 shadow-md flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center gap-1 text-amber-400 text-xs">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-xs sm:text-sm text-stone-700 font-medium leading-relaxed">
                        "মোটরের শক্তি অনেক বেশি, আর শব্দও অন্যান্য ব্লেন্ডারের চেয়ে কম। অক্ষত অবস্থায় পার্সেল পেয়েছি।"
                    </p>
                </div>
                <div class="pt-4 border-t border-orange-50 flex items-center justify-between mt-4">
                    <div>
                        <h4 class="text-xs font-bold text-orange-950">সালমা চৌধুরী</h4>
                        <span class="text-[11px] text-stone-500 font-medium">চট্টগ্রাম সদর</span>
                    </div>
                    <span class="text-[10px] bg-green-100 text-green-800 font-bold px-2 py-0.5 rounded-full">ভেরিফায়েড</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-orange-100 shadow-md flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center gap-1 text-amber-400 text-xs">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-xs sm:text-sm text-stone-700 font-medium leading-relaxed">
                        "ক্যাশ অন ডেলিভারিতে চেক করে নিয়েছি। ২ বছরের ওয়ারেন্টি কার্ড সাথে ছিল। খুব সন্তুষ্ট!"
                    </p>
                </div>
                <div class="pt-4 border-t border-orange-50 flex items-center justify-between mt-4">
                    <div>
                        <h4 class="text-xs font-bold text-orange-950">নাজনীন নাহার</h4>
                        <span class="text-[11px] text-stone-500 font-medium">খুলনা সদর</span>
                    </div>
                    <span class="text-[10px] bg-green-100 text-green-800 font-bold px-2 py-0.5 rounded-full">ভেরিফায়েড</span>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. HIGH CONVERTING 1-PAGE CASH ON DELIVERY CHECKOUT FORM -->
    <section id="fast-order-form" class="max-w-4xl mx-auto px-4 scroll-mt-20">
        <div class="bg-white rounded-3xl border-4 border-orange-400 shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-orange-700 via-red-600 to-amber-600 text-white p-6 sm:p-8 text-center">
                <span class="inline-block bg-yellow-300 text-stone-950 text-xs font-black uppercase px-3 py-1 rounded-full mb-2">
                    ⚡ সহজ ১-মিনিট ক্যাশ অন ডেলিভারি ফর্ম
                </span>
                <h3 class="text-2xl sm:text-4xl font-black">অর্ডার করতে নিচের তথ্যগুলো দিন</h3>
                <p class="text-orange-100 text-xs sm:text-sm mt-1">অগ্রিম ১ টাকাও লাগবে না, পণ্য হাতে পেয়ে মূল্য পরিশোধ করবেন</p>
            </div>

            <form action="{{ route('single.fast.order', $slug ?? ($store->slug ?? 'shop001')) }}" method="POST" class="p-6 sm:p-10 space-y-6" id="kitchenOrderForm">
                @csrf
                <input type="hidden" name="product_id" value="{{ $mainProduct->id ?? 1 }}">
                <input type="hidden" name="unit_price" id="kitchen_unit_price" value="{{ $offerPrice }}">
                <input type="hidden" name="product_variant" id="kitchen_selected_variant" value="১টি ৪-ইন-১ ফুড চপার (৳১,৩৫০)">
                <input type="hidden" name="selected_package" id="kitchen_selected_package" value="১টি ৪-ইন-১ ফুড চপার">

                <!-- Step 1: Package Selection -->
                <div class="space-y-3">
                    <label class="block text-sm font-black text-orange-950">
                        ১. প্যাকেজ নির্বাচন করুন <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <label class="relative flex items-center justify-between p-4 rounded-2xl border-2 border-orange-500 bg-orange-50/70 cursor-pointer package-card hover:bg-orange-50 transition" onclick="selectKitchenPackage(1, {{ $offerPrice }}, '১টি ৪-ইন-১ ফুড চপার', this)">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="pkg_choice" value="1" checked class="text-orange-600 focus:ring-orange-500">
                                <div>
                                    <span class="font-black text-stone-900 text-sm block">১টি ৪-ইন-১ ফুড চপার</span>
                                    <span class="text-xs text-stone-600 font-medium">২ লিটার স্টিল বাটি সহ</span>
                                </div>
                            </div>
                            <span class="text-lg font-black text-orange-800">৳{{ number_format($offerPrice) }}</span>
                        </label>

                        <label class="relative flex items-center justify-between p-4 rounded-2xl border-2 border-stone-200 bg-white cursor-pointer package-card hover:bg-orange-50 transition" onclick="selectKitchenPackage(2, 2500, '২টি ফুড চপার ফ্যামিলি কম্বো (ফ্রি ডেলিভারি)', this)">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="pkg_choice" value="2" class="text-orange-600 focus:ring-orange-500">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-black text-stone-900 text-sm block">২টি চপার মেগা কম্বো</span>
                                        <span class="bg-red-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">ফ্রি ডেলিভারি</span>
                                    </div>
                                    <span class="text-xs text-stone-600 font-medium">৳২০০ ছাড় + ফ্রি হোম ডেলিভারি</span>
                                </div>
                            </div>
                            <span class="text-lg font-black text-orange-800">৳২,৫০০</span>
                        </label>
                    </div>
                </div>

                <!-- Step 2: Customer Details -->
                <div class="space-y-4 pt-2">
                    <label class="block text-sm font-black text-orange-950">
                        ২. আপনার ডেলিভারি তথ্য দিন <span class="text-red-500">*</span>
                    </label>

                    <div>
                        <label class="block text-xs font-bold text-stone-700 mb-1">আপনার পূর্ণ নাম *</label>
                        <input type="text" name="customer_name" required placeholder="যেমন: মোসাঃ ফরিদা বেগম" class="w-full px-4 py-3 rounded-xl border-2 border-stone-300 focus:border-orange-600 focus:outline-none text-stone-900 font-medium text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-700 mb-1">সচল মোবাইল নম্বর *</label>
                        <input type="tel" name="customer_phone" required placeholder="যেমন: 017xxxxxxxx" class="w-full px-4 py-3 rounded-xl border-2 border-stone-300 focus:border-orange-600 focus:outline-none text-stone-900 font-medium text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-700 mb-1">সম্পূর্ণ ডেলিভারি ঠিকানা *</label>
                        <textarea name="customer_address" rows="2" required placeholder="যেমন: বাসা নং, রোড নং, থানা ও জেলার নাম" class="w-full px-4 py-3 rounded-xl border-2 border-stone-300 focus:border-orange-600 focus:outline-none text-stone-900 font-medium text-sm"></textarea>
                    </div>

                    <!-- Delivery Area -->
                    <div>
                        <label class="block text-xs font-bold text-stone-700 mb-2">ডেলিভারি এরিয়া বেছে নিন *</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <label class="flex items-center justify-between p-3.5 rounded-xl border-2 border-orange-600 bg-orange-50/60 cursor-pointer delivery-card transition" onclick="setKitchenDelivery({{ $dhakaCharge }}, this)">
                                <div class="flex items-center gap-2">
                                    <input type="radio" name="delivery_location" value="dhaka" checked class="text-orange-600">
                                    <span class="text-xs sm:text-sm font-bold text-stone-900">ঢাকা সিটির ভিতরে</span>
                                </div>
                                <span class="text-xs sm:text-sm font-bold text-orange-800">৳{{ $dhakaCharge }}</span>
                            </label>

                            <label class="flex items-center justify-between p-3.5 rounded-xl border-2 border-stone-200 bg-white cursor-pointer delivery-card transition hover:bg-orange-50" onclick="setKitchenDelivery({{ $outsideCharge }}, this)">
                                <div class="flex items-center gap-2">
                                    <input type="radio" name="delivery_location" value="outside" class="text-orange-600">
                                    <span class="text-xs sm:text-sm font-bold text-stone-900">ঢাকা সিটির বাইরে</span>
                                </div>
                                <span class="text-xs sm:text-sm font-bold text-orange-800">৳{{ $outsideCharge }}</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Price Summary Box -->
                <div class="p-5 bg-orange-50 rounded-2xl border-2 border-orange-200 space-y-2 text-sm">
                    <div class="flex justify-between text-stone-700 font-medium">
                        <span>পণ্যের মূল্য:</span>
                        <span class="font-bold text-stone-900" id="kitchen_subtotal_text">৳{{ number_format($offerPrice) }}</span>
                    </div>
                    <div class="flex justify-between text-stone-700 font-medium">
                        <span>ডেলিভারি চার্জ:</span>
                        <span class="font-bold text-stone-900" id="kitchen_delivery_text">৳{{ $dhakaCharge }}</span>
                    </div>
                    <div class="h-px bg-orange-200 my-1"></div>
                    <div class="flex justify-between text-base sm:text-lg font-black text-orange-950">
                        <span>সর্বমোট প্রদেয় বিল:</span>
                        <span class="text-2xl font-black text-orange-800" id="kitchen_total_text">৳{{ number_format($offerPrice + $dhakaCharge) }}</span>
                    </div>
                </div>

                <button type="submit" class="pulse-btn w-full bg-gradient-to-r from-orange-700 via-red-600 to-amber-600 hover:from-orange-800 hover:to-amber-700 text-white font-black text-lg sm:text-xl py-4 rounded-2xl shadow-xl transition transform hover:-translate-y-0.5 flex items-center justify-center gap-3">
                    <i class="fas fa-lock text-yellow-300"></i>
                    <span>অর্ডার কনফার্ম করুন (ক্যাশ অন ডেলিভারি)</span>
                </button>
            </form>
        </div>
    </section>

    <!-- 7. FREQUENTLY ASKED QUESTIONS (FAQ) -->
    <section class="max-w-4xl mx-auto px-4 pb-12">
        <div class="text-center mb-8">
            <span class="text-xs uppercase font-extrabold text-orange-800 tracking-widest">সাধারণ প্রশ্নোত্তর</span>
            <h2 class="text-2xl sm:text-3xl font-black text-stone-900 mt-1">সচরাচর জানতে চাওয়া প্রশ্ন ও উত্তর</h2>
        </div>

        <div class="space-y-3">
            <div class="bg-white p-5 rounded-2xl border-2 border-orange-100 shadow-sm">
                <h4 class="font-black text-stone-900 text-sm sm:text-base flex items-center gap-2">
                    <i class="fas fa-question-circle text-orange-600"></i> এটি দিয়ে কি মাংসের কিমা করা যাবে?
                </h4>
                <p class="text-xs sm:text-sm text-stone-600 font-medium mt-2 leading-relaxed pl-6">
                    জী, হাঁড় ছাড়া যেকোনো গরু, খাসি বা মুরগির মাংস মাত্র ৫-১০ সেকেন্ডের মধ্যে নিখুঁত মিহি কিমা করা যায়।
                </p>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-orange-100 shadow-sm">
                <h4 class="font-black text-stone-900 text-sm sm:text-base flex items-center gap-2">
                    <i class="fas fa-question-circle text-orange-600"></i> বাটি কি কাঁচের নাকি স্টিলের?
                </h4>
                <p class="text-xs sm:text-sm text-stone-600 font-medium mt-2 leading-relaxed pl-6">
                    এটি হেভি ডিউটি আনব্রেকেবল স্টেইনলেস স্টিলের বাটি, যা হাত থেকে পড়ে গেলেও ভাঙার বা ফাটল ধরার কোনো ভয় নেই।
                </p>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-orange-100 shadow-sm">
                <h4 class="font-black text-stone-900 text-sm sm:text-base flex items-center gap-2">
                    <i class="fas fa-question-circle text-orange-600"></i> মোটরের ওয়ারেন্টি কীভাবে ক্লেইম করব?
                </h4>
                <p class="text-xs sm:text-sm text-stone-600 font-medium mt-2 leading-relaxed pl-6">
                    পার্সেলের সাথে ২ বছরের অফিশিয়াল ওয়ারেন্টি কার্ড পাবেন। যেকোনো সমস্যায় আমাদের কাস্টমার সার্ভিসে কল দিলেই সহায়তা পাবেন।
                </p>
            </div>
        </div>
    </section>

</main>

<!-- FLOATING WHATSAPP BUTTON -->
<a href="https://wa.me/8801700000000?text=আসসালামু%20আলাইকুম!%20ইলেকট্রিক%20ফুড%20চপার%20সম্পর্কে%20জানতে%20চাই" target="_blank" class="fixed bottom-20 right-4 z-40 bg-green-500 hover:bg-green-600 text-white p-3.5 rounded-full shadow-2xl flex items-center justify-center transition transform hover:scale-110" title="হোয়াটসঅ্যাপে কথা বলুন">
    <i class="fab fa-whatsapp text-3xl"></i>
</a>

<!-- MOBILE STICKY CTA -->
<div class="fixed bottom-0 left-0 right-0 z-30 sm:hidden bg-white/95 backdrop-blur-md border-t-2 border-orange-300 p-3 shadow-2xl">
    <div class="flex items-center justify-between gap-3 max-w-md mx-auto">
        <div>
            <span class="text-[11px] text-stone-500 font-bold block">অফার প্রাইস</span>
            <span class="text-xl font-black text-orange-700">৳{{ number_format($offerPrice) }}</span>
        </div>
        <a href="#fast-order-form" class="bg-orange-700 hover:bg-orange-800 text-white font-black text-sm px-5 py-2.5 rounded-xl shadow-lg transition flex items-center gap-1.5">
            <i class="fas fa-shopping-basket"></i> এখনই কিনুন
        </a>
    </div>
</div>

<script>
    // Live Countdown Timer
    let kitchenHours = 4, kitchenMinutes = 25, kitchenSeconds = 38;
    setInterval(function() {
        if (kitchenSeconds > 0) {
            kitchenSeconds--;
        } else {
            kitchenSeconds = 59;
            if (kitchenMinutes > 0) {
                kitchenMinutes--;
            } else {
                kitchenMinutes = 59;
                if (kitchenHours > 0) kitchenHours--;
            }
        }
        document.getElementById('kitchen_timer_hours').textContent = String(kitchenHours).padStart(2, '0');
        document.getElementById('kitchen_timer_minutes').textContent = String(kitchenMinutes).padStart(2, '0');
        document.getElementById('kitchen_timer_seconds').textContent = String(kitchenSeconds).padStart(2, '0');
    }, 1000);

    let currentKitchenSubtotal = {{ $offerPrice }};
    let currentKitchenDelivery = {{ $dhakaCharge }};
    let isKitchenFreeDelivery = false;

    function selectKitchenPackage(pkgId, price, label, el) {
        currentKitchenSubtotal = price;
        isKitchenFreeDelivery = (pkgId === 2);
        document.getElementById('kitchen_unit_price').value = price;
        document.getElementById('kitchen_selected_variant').value = label;
        document.getElementById('kitchen_selected_package').value = label;

        document.querySelectorAll('.package-card').forEach(c => {
            c.classList.remove('border-orange-500', 'bg-orange-50/70');
            c.classList.add('border-stone-200', 'bg-white');
        });
        el.classList.add('border-orange-500', 'bg-orange-50/70');
        el.classList.remove('border-stone-200', 'bg-white');
        updateKitchenBill();
    }

    function setKitchenDelivery(charge, el) {
        currentKitchenDelivery = charge;
        document.querySelectorAll('.delivery-card').forEach(d => {
            d.classList.remove('border-orange-600', 'bg-orange-50/60');
            d.classList.add('border-stone-200', 'bg-white');
        });
        el.classList.add('border-orange-600', 'bg-orange-50/60');
        el.classList.remove('border-stone-200', 'bg-white');
        updateKitchenBill();
    }

    function updateKitchenBill() {
        let deliveryToApply = isKitchenFreeDelivery ? 0 : currentKitchenDelivery;
        let total = currentKitchenSubtotal + deliveryToApply;
        document.getElementById('kitchen_subtotal_text').textContent = '৳' + currentKitchenSubtotal.toLocaleString();
        document.getElementById('kitchen_delivery_text').textContent = isKitchenFreeDelivery ? 'ফ্রি (৳০)' : '৳' + deliveryToApply;
        document.getElementById('kitchen_total_text').textContent = '৳' + total.toLocaleString();
    }
</script>
@endsection
