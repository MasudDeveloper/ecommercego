@extends('front_end.layouts.app')

@section('page-title')
    {{ $store->name ?? 'Kids Talking Magic Book & 8.5 Inch LCD Writing Tablet' }}
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
    $productTitle = $themeSettings['hero_title'] ?? 'শিশুদের কথা বলা ডিজিটাল ম্যাজিক বুক ও ৮.৫ ইঞ্চি এলসিডি রাইটিং ট্যাব';
    $productDesc = $themeSettings['hero_subtitle'] ?? 'মোবাইল আসক্তি ছাড়িয়ে সন্তানকে করে তুলুন প্রখর মেধাবী। বাংলা ও ইংরেজি অডিও উচ্চারণ, রিইউজেবল ট্রেসিং খাতা ও ৮.৫ ইঞ্চি চোখের সুরক্ষাযুক্ত ডিজিটাল রাইটিং ট্যাব কম্বো!';
    
    $regularPrice = $toNum($themeSettings['hero_regular_price'] ?? 1450, 1450);
    $offerPrice = $toNum($themeSettings['hero_offer_price'] ?? 990, 990);
    
    if ($regularPrice <= 0) $regularPrice = 1450;
    if ($offerPrice <= 0) $offerPrice = 990;
    
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

<main class="space-y-12 sm:space-y-20 bg-sky-50/50 text-stone-900 font-sans">

    <!-- 1. PLAYFUL KIDS EDUCATIONAL HERO -->
    <section class="relative pt-10 sm:pt-16 pb-16 bg-gradient-to-b from-sky-100/70 via-blue-50/40 to-white border-b border-sky-200">
        <div class="max-w-6xl mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                
                <!-- Left Portrait with playful frame -->
                <div class="lg:col-span-5 flex justify-center order-2 lg:order-1">
                    <div class="relative p-3 bg-white rounded-3xl shadow-2xl border-4 border-sky-400 max-w-sm w-full">
                        <div class="absolute -top-3.5 -right-3.5 bg-gradient-to-r from-pink-500 to-rose-500 text-white font-extrabold text-xs uppercase px-3.5 py-1.5 rounded-full shadow-lg tracking-wider animate-pulse">
                            KIDS SPECIAL COMBO
                        </div>
                        <img src="{{ $productImg1 }}" alt="{{ $productTitle }}" class="w-full h-[380px] object-cover rounded-2xl shadow-inner">
                        <div class="mt-3 text-center text-xs font-serif text-sky-950 font-bold bg-sky-50 py-2 px-3 rounded-xl border border-sky-200">
                            ✦ কথা বলা সাউন্ড বুক + ৮.৫" এলসিডি ড্রয়িং ট্যাব ✦
                        </div>
                    </div>
                </div>

                <!-- Right Editorial Text -->
                <div class="lg:col-span-7 space-y-5 text-center lg:text-left order-1 lg:order-2">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-sky-100 text-sky-950 text-xs sm:text-sm font-black border border-sky-300 shadow-sm">
                        <i class="fas fa-graduation-cap text-blue-600"></i>
                        <span>{{ $themeSettings['hero_badge'] ?? '👶 সন্তানের মোবাইল আসক্তি দূর করার সেরা উপহার' }}</span>
                    </div>

                    <h1 class="text-3xl sm:text-5xl font-black text-sky-950 leading-tight">
                        {{ $productTitle }}
                    </h1>

                    <p class="text-stone-700 text-base sm:text-lg leading-relaxed font-medium">
                        {{ $productDesc }}
                    </p>

                    <!-- Urgent Countdown Timer -->
                    <div class="p-3.5 bg-gradient-to-r from-blue-600 via-indigo-600 to-sky-600 text-white rounded-2xl shadow-md flex flex-wrap items-center justify-between gap-3">
                        <div class="flex items-center gap-2 font-bold text-xs sm:text-sm">
                            <span class="inline-block w-2.5 h-2.5 bg-yellow-300 rounded-full animate-ping"></span>
                            <span>🔥 কিডস লার্নিং স্পেশাল অফার শেষ হতে বাকি:</span>
                        </div>
                        <div class="flex items-center gap-1.5 text-xs sm:text-sm font-black text-stone-900 font-mono">
                            <span class="bg-white px-2 py-1 rounded shadow text-blue-700 font-bold" id="kids_timer_hours">05</span> :
                            <span class="bg-white px-2 py-1 rounded shadow text-blue-700 font-bold" id="kids_timer_minutes">22</span> :
                            <span class="bg-white px-2 py-1 rounded shadow text-blue-700 font-bold" id="kids_timer_seconds">35</span>
                        </div>
                    </div>

                    <!-- Price Badge -->
                    <div class="inline-flex flex-wrap items-center gap-6 p-4 rounded-2xl bg-white border-2 border-sky-300 shadow-md">
                        <div>
                            <span class="text-xs text-stone-500 block font-bold uppercase">রেগুলার মূল্য</span>
                            <span class="text-xl font-extrabold text-stone-400 line-through">৳{{ number_format($regularPrice) }}</span>
                        </div>
                        <div class="h-8 w-px bg-sky-200 hidden sm:block"></div>
                        <div>
                            <span class="text-xs text-blue-900 font-black block uppercase">অফার মূল্য</span>
                            <span class="text-3xl sm:text-4xl font-black text-blue-700">৳{{ number_format($offerPrice) }}</span>
                        </div>
                        <span class="bg-gradient-to-r from-pink-500 to-rose-600 text-white text-xs font-black px-3.5 py-1.5 rounded-full shadow-sm">
                            {{ $themeSettings['hero_discount_tag'] ?? '৳৪৬০ ছাড়!' }}
                        </span>
                    </div>

                    <!-- Bullet Features Checklist -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 pt-1 text-left text-xs sm:text-sm text-stone-800 font-bold">
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-blue-600 text-base"></i> বাংলা ও ইংরেজি সাউন্ড উচ্চারণ বুক</div>
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-blue-600 text-base"></i> চোখের ক্ষতিহীন ৮.৫" এলসিডি ট্যাব</div>
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-blue-600 text-base"></i> পার্সেল দেখে ক্যাশ অন ডেলিভারি</div>
                        <div class="flex items-center gap-2"><i class="fas fa-check-circle text-blue-600 text-base"></i> সাথে ৪টি ম্যাজিক প্র্যাকটিস খাতা ফ্রি</div>
                    </div>

                    <!-- CTA Button -->
                    <div class="pt-2">
                        <a href="#fast-order-form" class="pulse-btn inline-flex items-center justify-center gap-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-black text-lg px-8 py-4 rounded-xl shadow-xl transition transform hover:-translate-y-0.5 w-full sm:w-auto">
                            <i class="fas fa-pencil-alt text-yellow-300"></i>
                            <span>{{ $themeSettings['hero_button_text'] ?? '👉 পছন্দের কালার বেছে অর্ডার করুন (ক্যাশ অন ডেলিভারি)' }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. KIDS LEARNING FEATURES GALLERY -->
    <section class="max-w-6xl mx-auto px-4">
        <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
            <span class="text-xs uppercase font-extrabold text-blue-700 tracking-widest">স্মার্ট শিক্ষা ও সৃজনশীলতা</span>
            <h2 class="text-2xl sm:text-4xl font-black text-stone-900">খেলাধুলায় সোনামণি শিখবে নিজে নিজেই</h2>
            <p class="text-stone-600 font-medium text-sm">বর্ণমালা, ছড়া, সংখ্যা ও ছবি আঁকার জাদুকরী আনন্দের মাধ্যমে মেধার বিকাশ</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl border-2 border-sky-200 overflow-hidden shadow-md group hover:shadow-xl transition">
                <div class="h-64 overflow-hidden bg-sky-50 flex items-center justify-center">
                    <img src="{{ $productImg1 }}" alt="ডিজিটাল কথা বলা বই" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                </div>
                <div class="p-4 text-center">
                    <h3 class="font-black text-base text-sky-950 mb-1">কথা বলা সাউন্ড বুক</h3>
                    <p class="text-xs text-stone-600 font-medium">আঙুলের স্পর্শে বাংলা বর্ণমালা, প্রাণী, ছড়া ও আরবি হরফের স্পষ্ট উচ্চারণ</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl border-2 border-sky-200 overflow-hidden shadow-md group hover:shadow-xl transition">
                <div class="h-64 overflow-hidden bg-sky-50 flex items-center justify-center">
                    <img src="{{ $productImg2 }}" alt="৮.৫ ইঞ্চি রাইটিং ট্যাব" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                </div>
                <div class="p-4 text-center">
                    <h3 class="font-black text-base text-sky-950 mb-1">৮.৫" এলসিডি রাইটিং ট্যাব</h3>
                    <p class="text-xs text-stone-600 font-medium">কাগজ নষ্ট ছাড়া ছবি আঁকা ও লেখার প্র্যাকটিস, ওয়ান-টাচ ডিলিট বাটন সহ</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl border-2 border-sky-200 overflow-hidden shadow-md group hover:shadow-xl transition">
                <div class="h-64 overflow-hidden bg-sky-50 flex items-center justify-center">
                    <img src="{{ $productImg3 }}" alt="ম্যাজিক ক্যালিগ্রাফি খাতা" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                </div>
                <div class="p-4 text-center">
                    <h3 class="font-black text-base text-sky-950 mb-1">রিইউজেবল ম্যাজিক বুক</h3>
                    <p class="text-xs text-stone-600 font-medium">লিখলে ১০ মিনিটের মধ্যে কালি মুছে যায়, ফলে বার বার লেখার অনুশীলন</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. TECHNICAL SPECIFICATIONS TABLE -->
    <section class="max-w-4xl mx-auto px-4">
        <div class="bg-white rounded-3xl border-2 border-sky-200 shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-sky-600 text-white p-5 text-center">
                <h3 class="text-xl sm:text-2xl font-black text-yellow-300">কিডস লার্নিং কিটের বিস্তারিত স্পেক্স</h3>
                <p class="text-sky-100 text-xs mt-1">অর্ডার করার পূর্বে সেটের সকল আইটেম দেখে নিন</p>
            </div>
            <div class="p-6">
                <div class="divide-y divide-sky-100 text-sm">
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-stone-700">সাউন্ড বুকের বিষয়বস্তু</span>
                        <span class="font-bold text-blue-900">বাংলা বর্ণমালা, ইংরেজি, আরবি, গণনা ও সাধারণ জ্ঞান</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-stone-700">ট্যাবের ডিসপ্লে সাইজ</span>
                        <span class="font-bold text-blue-900">৮.৫ ইঞ্চি অ্যান্টি-ব্লু রে আই-প্রটেক্টেড এলসিডি</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-stone-700">লেখার প্রযুক্তি ও বাটন</span>
                        <span class="font-bold text-blue-900">স্টাইলাস পেন ও ওয়ান-টাচ লক/ইরেজ ফিচার</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-stone-700">উপহার সামগ্রী</span>
                        <span class="font-bold text-blue-900">৪টি ম্যাজিক প্র্যাকটিস খাতা ও রিফিল পেন সেট সম্পূর্ণ ফ্রি</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-stone-700">শিশু সুরক্ষা</span>
                        <span class="font-bold text-blue-900">বিপিএ-মুক্ত রাউন্ড কর্নার পরিবেশবান্ধব আনব্রেকেবল বডি</span>
                    </div>
                    <div class="py-3.5 flex justify-between items-center">
                        <span class="font-bold text-stone-700">উপযোগী বয়স</span>
                        <span class="font-bold text-blue-900">২ বছর থেকে ৯ বছর বয়সী সকল শিশুর জন্য উপযোগী</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. TRUST & GUARANTEE PILLARS -->
    <section class="max-w-6xl mx-auto px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white p-5 rounded-2xl border-2 border-sky-200 shadow-sm text-center">
                <div class="w-12 h-12 mx-auto rounded-xl bg-sky-100 text-blue-700 flex items-center justify-center text-xl mb-3">
                    <i class="fas fa-hand-holding-dollar"></i>
                </div>
                <h4 class="font-black text-base text-stone-900 mb-1">ক্যাশ অন ডেলিভারি</h4>
                <p class="text-xs text-stone-600 font-medium leading-relaxed">আগে ১ টাকাও দিতে হবে না, পণ্য হাতে পেয়ে মূল্য পরিশোধ করুন।</p>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-sky-200 shadow-sm text-center">
                <div class="w-12 h-12 mx-auto rounded-xl bg-sky-100 text-blue-700 flex items-center justify-center text-xl mb-3">
                    <i class="fas fa-child"></i>
                </div>
                <h4 class="font-black text-base text-stone-900 mb-1">১০০% শিশু বান্ধব</h4>
                <p class="text-xs text-stone-600 font-medium leading-relaxed">কোনো ক্ষতিকারক রশ্মি নেই, চোখের পূর্ণ সুরক্ষায় নিশ্চিত আনন্দ।</p>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-sky-200 shadow-sm text-center">
                <div class="w-12 h-12 mx-auto rounded-xl bg-sky-100 text-blue-700 flex items-center justify-center text-xl mb-3">
                    <i class="fas fa-truck-fast"></i>
                </div>
                <h4 class="font-black text-base text-stone-900 mb-1">সারা দেশে ডেলিভারি</h4>
                <p class="text-xs text-stone-600 font-medium leading-relaxed">ঢাকায় ২৪-৪৮ ঘণ্টায় এবং ঢাকার বাইরে ২-৩ দিনের মধ্যে ডেলিভারি।</p>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-sky-200 shadow-sm text-center">
                <div class="w-12 h-12 mx-auto rounded-xl bg-sky-100 text-blue-700 flex items-center justify-center text-xl mb-3">
                    <i class="fas fa-box-open"></i>
                </div>
                <h4 class="font-black text-base text-stone-900 mb-1">দেখে নেওয়ার সুযোগ</h4>
                <p class="text-xs text-stone-600 font-medium leading-relaxed">ডেলিভারিম্যানের সামনে চেক করে নিশ্চিন্তে পার্সেল রিসিভ করুন।</p>
            </div>
        </div>
    </section>

    <!-- 5. VERIFIED CUSTOMER REVIEWS (SOCIAL PROOF) -->
    <section class="max-w-6xl mx-auto px-4">
        <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
            <span class="text-xs uppercase font-extrabold text-blue-700 tracking-widest">অভিভাবকদের বাস্তব অভিজ্ঞতা</span>
            <h2 class="text-2xl sm:text-4xl font-black text-stone-900">সন্তুষ্ট মা-বাবাদের সৎ রিভিউ</h2>
            <div class="flex items-center justify-center gap-1 text-amber-500 text-sm">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                <span class="text-stone-700 font-bold ml-2">৪.৯/৫ (৩৫০+ অভিভাবক রিভিউ)</span>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-5 rounded-2xl border-2 border-sky-100 shadow-md flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center gap-1 text-amber-400 text-xs">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-xs sm:text-sm text-stone-700 font-medium leading-relaxed">
                        "আমার ৪ বছরের ছেলে সারা দিন মোবাইল দেখত, এই ম্যাজিক বুক পেয়ে এখন মোবাইলের কথা ভুলেই গেছে!"
                    </p>
                </div>
                <div class="pt-4 border-t border-sky-50 flex items-center justify-between mt-4">
                    <div>
                        <h4 class="text-xs font-bold text-sky-950">রোকেয়া সুলতানা</h4>
                        <span class="text-[11px] text-stone-500 font-medium">মিরপুর ১২, ঢাকা</span>
                    </div>
                    <span class="text-[10px] bg-green-100 text-green-800 font-bold px-2 py-0.5 rounded-full">ভেরিফায়েড</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-sky-100 shadow-md flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center gap-1 text-amber-400 text-xs">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-xs sm:text-sm text-stone-700 font-medium leading-relaxed">
                        "সাউন্ড বুকের উচ্চারণগুলো একদম পরিষ্কার ও বাংলা ছড়াগুলো শুনতে খুব মিষ্টি লাগে। ট্যাবটাও দারুণ।"
                    </p>
                </div>
                <div class="pt-4 border-t border-sky-50 flex items-center justify-between mt-4">
                    <div>
                        <h4 class="text-xs font-bold text-sky-950">ফারজানা ববি</h4>
                        <span class="text-[11px] text-stone-500 font-medium">চট্টগ্রাম সদর</span>
                    </div>
                    <span class="text-[10px] bg-green-100 text-green-800 font-bold px-2 py-0.5 rounded-full">ভেরিফায়েড</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-sky-100 shadow-md flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center gap-1 text-amber-400 text-xs">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-xs sm:text-sm text-stone-700 font-medium leading-relaxed">
                        "বাচ্চাদের পড়াশোনায় মনোযোগ বাড়াতে অসাধারণ একটা উপহার। ২ দিনের ভেতর পার্সেল হাতে পেয়েছি।"
                    </p>
                </div>
                <div class="pt-4 border-t border-sky-50 flex items-center justify-between mt-4">
                    <div>
                        <h4 class="text-xs font-bold text-sky-950">তাসলিমা নাসরিন</h4>
                        <span class="text-[11px] text-stone-500 font-medium">সিলেট সদর</span>
                    </div>
                    <span class="text-[10px] bg-green-100 text-green-800 font-bold px-2 py-0.5 rounded-full">ভেরিফায়েড</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-sky-100 shadow-md flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center gap-1 text-amber-400 text-xs">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-xs sm:text-sm text-stone-700 font-medium leading-relaxed">
                        "ক্যাশ অন ডেলিভারিতে চেক করে নিয়েছি। প্রডাক্ট কোয়ালিটি ও বাচ্চাদের সেফটি দুটোই নিখুঁত।"
                    </p>
                </div>
                <div class="pt-4 border-t border-sky-50 flex items-center justify-between mt-4">
                    <div>
                        <h4 class="text-xs font-bold text-sky-950">শামীম রেজা</h4>
                        <span class="text-[11px] text-stone-500 font-medium">রাজশাহী</span>
                    </div>
                    <span class="text-[10px] bg-green-100 text-green-800 font-bold px-2 py-0.5 rounded-full">ভেরিফায়েড</span>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. HIGH CONVERTING 1-PAGE CASH ON DELIVERY CHECKOUT FORM -->
    <section id="fast-order-form" class="max-w-4xl mx-auto px-4 scroll-mt-20">
        <div class="bg-white rounded-3xl border-4 border-sky-400 shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-sky-600 text-white p-6 sm:p-8 text-center">
                <span class="inline-block bg-yellow-300 text-stone-950 text-xs font-black uppercase px-3 py-1 rounded-full mb-2">
                    ⚡ সহজ ১-মিনিট ক্যাশ অন ডেলিভারি ফর্ম
                </span>
                <h3 class="text-2xl sm:text-4xl font-black">অর্ডার করতে নিচের তথ্যগুলো দিন</h3>
                <p class="text-sky-100 text-xs sm:text-sm mt-1">অগ্রিম ১ টাকাও লাগবে না, পার্সেল হাতে পেয়ে দেখে মূল্য পরিশোধ করবেন</p>
            </div>

            <form action="{{ route('single.fast.order', $slug ?? ($store->slug ?? 'shop001')) }}" method="POST" class="p-6 sm:p-10 space-y-6" id="kidsOrderForm">
                @csrf
                <input type="hidden" name="product_id" value="{{ $mainProduct->id ?? 1 }}">
                <input type="hidden" name="unit_price" id="kids_unit_price" value="{{ $offerPrice }}">
                <input type="hidden" name="product_variant" id="kids_selected_variant" value="স্কাই ব্লু (১টি কিডস লার্নিং কম্বো)">
                <input type="hidden" name="selected_color" id="kids_selected_color" value="স্কাই ব্লু">
                <input type="hidden" name="selected_package" id="kids_selected_package" value="১টি কিডস কম্বো">

                <!-- Step 1: Package Selection -->
                <div class="space-y-3">
                    <label class="block text-sm font-black text-sky-950">
                        ১. প্যাকেজ নির্বাচন করুন <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <label class="relative flex items-center justify-between p-4 rounded-2xl border-2 border-blue-500 bg-sky-50/70 cursor-pointer package-card hover:bg-sky-50 transition" onclick="selectKidsPackage(1, {{ $offerPrice }}, '১টি কিডস লার্নিং কম্বো', this)">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="pkg_choice" value="1" checked class="text-blue-600 focus:ring-blue-500">
                                <div>
                                    <span class="font-black text-stone-900 text-sm block">১টি কিডস লার্নিং কম্বো</span>
                                    <span class="text-xs text-stone-600 font-medium">ম্যাজিক বুক + ৮.৫" এলসিডি ট্যাব</span>
                                </div>
                            </div>
                            <span class="text-lg font-black text-blue-700">৳{{ number_format($offerPrice) }}</span>
                        </label>

                        <label class="relative flex items-center justify-between p-4 rounded-2xl border-2 border-stone-200 bg-white cursor-pointer package-card hover:bg-sky-50 transition" onclick="selectKidsPackage(2, 1850, '২টি কিডস কম্বো সেট (ফ্রি ডেলিভারি)', this)">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="pkg_choice" value="2" class="text-blue-600 focus:ring-blue-500">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-black text-stone-900 text-sm block">২টি মেগা কম্বো প্যাক</span>
                                        <span class="bg-red-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">ফ্রি ডেলিভারি</span>
                                    </div>
                                    <span class="text-xs text-stone-600 font-medium">৳১৩০ ছাড় + ফ্রি হোম ডেলিভারি</span>
                                </div>
                            </div>
                            <span class="text-lg font-black text-blue-700">৳১,৮৫০</span>
                        </label>
                    </div>
                </div>

                <!-- Step 2: Color Selection -->
                <div class="space-y-3">
                    <label class="block text-sm font-black text-sky-950">
                        ২. ট্যাবের কালার বেছে নিন <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 gap-3">
                        <button type="button" class="kids-color-btn py-3 px-3 rounded-xl border-2 border-blue-600 bg-sky-50 text-blue-950 font-bold text-xs sm:text-sm flex items-center justify-center gap-2 shadow-sm transition" onclick="setKidsColor('স্কাই ব্লু', this)">
                            <span class="w-3.5 h-3.5 rounded-full bg-sky-500 border border-white"></span>
                            <span>স্কাই ব্লু (ছেলেদের প্রিয়)</span>
                        </button>
                        <button type="button" class="kids-color-btn py-3 px-3 rounded-xl border-2 border-stone-200 bg-white text-stone-800 font-bold text-xs sm:text-sm flex items-center justify-center gap-2 transition hover:border-blue-400" onclick="setKidsColor('প্যাস্টেল পিংক', this)">
                            <span class="w-3.5 h-3.5 rounded-full bg-pink-400 border border-white"></span>
                            <span>প্যাস্টেল পিংক (মেয়েদের প্রিয়)</span>
                        </button>
                    </div>
                </div>

                <!-- Step 3: Customer Details -->
                <div class="space-y-4 pt-2">
                    <label class="block text-sm font-black text-sky-950">
                        ৩. আপনার ডেলিভারি তথ্য দিন <span class="text-red-500">*</span>
                    </label>

                    <div>
                        <label class="block text-xs font-bold text-stone-700 mb-1">আপনার পূর্ণ নাম *</label>
                        <input type="text" name="customer_name" required placeholder="যেমন: মোসাঃ রোকেয়া বেগম" class="w-full px-4 py-3 rounded-xl border-2 border-stone-300 focus:border-blue-600 focus:outline-none text-stone-900 font-medium text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-700 mb-1">সচল মোবাইল নম্বর *</label>
                        <input type="tel" name="customer_phone" required placeholder="যেমন: 017xxxxxxxx" class="w-full px-4 py-3 rounded-xl border-2 border-stone-300 focus:border-blue-600 focus:outline-none text-stone-900 font-medium text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-700 mb-1">সম্পূর্ণ ডেলিভারি ঠিকানা *</label>
                        <textarea name="customer_address" rows="2" required placeholder="যেমন: বাসা নং, রোড নং, থানা ও জেলার নাম" class="w-full px-4 py-3 rounded-xl border-2 border-stone-300 focus:border-blue-600 focus:outline-none text-stone-900 font-medium text-sm"></textarea>
                    </div>

                    <!-- Delivery Area -->
                    <div>
                        <label class="block text-xs font-bold text-stone-700 mb-2">ডেলিভারি এরিয়া বেছে নিন *</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <label class="flex items-center justify-between p-3.5 rounded-xl border-2 border-blue-600 bg-sky-50/60 cursor-pointer delivery-card transition" onclick="setKidsDelivery({{ $dhakaCharge }}, this)">
                                <div class="flex items-center gap-2">
                                    <input type="radio" name="delivery_location" value="dhaka" checked class="text-blue-600">
                                    <span class="text-xs sm:text-sm font-bold text-stone-900">ঢাকা সিটির ভিতরে</span>
                                </div>
                                <span class="text-xs sm:text-sm font-bold text-blue-700">৳{{ $dhakaCharge }}</span>
                            </label>

                            <label class="flex items-center justify-between p-3.5 rounded-xl border-2 border-stone-200 bg-white cursor-pointer delivery-card transition hover:bg-sky-50" onclick="setKidsDelivery({{ $outsideCharge }}, this)">
                                <div class="flex items-center gap-2">
                                    <input type="radio" name="delivery_location" value="outside" class="text-blue-600">
                                    <span class="text-xs sm:text-sm font-bold text-stone-900">ঢাকা সিটির বাইরে</span>
                                </div>
                                <span class="text-xs sm:text-sm font-bold text-blue-700">৳{{ $outsideCharge }}</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Price Summary Box -->
                <div class="p-5 bg-sky-50 rounded-2xl border-2 border-sky-200 space-y-2 text-sm">
                    <div class="flex justify-between text-stone-700 font-medium">
                        <span>পণ্যের মূল্য:</span>
                        <span class="font-bold text-stone-900" id="kids_subtotal_text">৳{{ number_format($offerPrice) }}</span>
                    </div>
                    <div class="flex justify-between text-stone-700 font-medium">
                        <span>ডেলিভারি চার্জ:</span>
                        <span class="font-bold text-stone-900" id="kids_delivery_text">৳{{ $dhakaCharge }}</span>
                    </div>
                    <div class="h-px bg-sky-200 my-1"></div>
                    <div class="flex justify-between text-base sm:text-lg font-black text-sky-950">
                        <span>সর্বমোট প্রদেয় বিল:</span>
                        <span class="text-2xl font-black text-blue-700" id="kids_total_text">৳{{ number_format($offerPrice + $dhakaCharge) }}</span>
                    </div>
                </div>

                <button type="submit" class="pulse-btn w-full bg-gradient-to-r from-blue-600 via-indigo-600 to-sky-600 hover:from-blue-700 hover:to-indigo-700 text-white font-black text-lg sm:text-xl py-4 rounded-2xl shadow-xl transition transform hover:-translate-y-0.5 flex items-center justify-center gap-3">
                    <i class="fas fa-lock text-yellow-300"></i>
                    <span>অর্ডার কনফার্ম করুন (ক্যাশ অন ডেলিভারি)</span>
                </button>
            </form>
        </div>
    </section>

    <!-- 7. FREQUENTLY ASKED QUESTIONS (FAQ) -->
    <section class="max-w-4xl mx-auto px-4 pb-12">
        <div class="text-center mb-8">
            <span class="text-xs uppercase font-extrabold text-blue-700 tracking-widest">সাধারণ প্রশ্নোত্তর</span>
            <h2 class="text-2xl sm:text-3xl font-black text-stone-900 mt-1">সচরাচর জানতে চাওয়া প্রশ্ন ও উত্তর</h2>
        </div>

        <div class="space-y-3">
            <div class="bg-white p-5 rounded-2xl border-2 border-sky-100 shadow-sm">
                <h4 class="font-black text-stone-900 text-sm sm:text-base flex items-center gap-2">
                    <i class="fas fa-question-circle text-blue-600"></i> ট্যাবটির আলো কি শিশুর চোখের ক্ষতি করবে?
                </h4>
                <p class="text-xs sm:text-sm text-stone-600 font-medium mt-2 leading-relaxed pl-6">
                    একদমই না! এটি প্রেসার-সেনসিটিভ এলসিডি ডিসপ্লে, এতে কোনো নীল আলো বা ক্ষতিকারক রশ্মি নেই। শিশু ঘণ্টার পর ঘণ্টা আঁকাআঁকি করলেও চোখ সুরক্ষিত থাকবে।
                </p>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-sky-100 shadow-sm">
                <h4 class="font-black text-stone-900 text-sm sm:text-base flex items-center gap-2">
                    <i class="fas fa-question-circle text-blue-600"></i> সাউন্ড বুকের উচ্চারণ কি বাংলা নাকি ইংরেজি?
                </h4>
                <p class="text-xs sm:text-sm text-stone-600 font-medium mt-2 leading-relaxed pl-6">
                    সাউন্ড বুকে বাংলা বর্ণমালা, সাধারণ জ্ঞান ও ছড়া বাংলায় এবং পাশাপাশি ইংরেজি ও আরবি হরফেরও স্পষ্ট দ্বৈত উচ্চারণ মোড রয়েছে।
                </p>
            </div>

            <div class="bg-white p-5 rounded-2xl border-2 border-sky-100 shadow-sm">
                <h4 class="font-black text-stone-900 text-sm sm:text-base flex items-center gap-2">
                    <i class="fas fa-question-circle text-blue-600"></i> পার্সেল চেক করে কি টাকা দিতে পারব?
                </h4>
                <p class="text-xs sm:text-sm text-stone-600 font-medium mt-2 leading-relaxed pl-6">
                    অবশ্যই! ডেলিভারিম্যানের সামনে প্যাকেট খুলে চেক করে নিশ্চিন্তে ক্যাশ অন ডেলিভারিতে দাম পরিশোধ করতে পারবেন।
                </p>
            </div>
        </div>
    </section>

</main>

<!-- FLOATING WHATSAPP BUTTON -->
<a href="https://wa.me/8801700000000?text=আসসালামু%20আলাইকুম!%20কিডস%20লার্নিং%20কম্বো%20সম্পর্কে%20জানতে%20চাই" target="_blank" class="fixed bottom-20 right-4 z-40 bg-green-500 hover:bg-green-600 text-white p-3.5 rounded-full shadow-2xl flex items-center justify-center transition transform hover:scale-110" title="হোয়াটসঅ্যাপে কথা বলুন">
    <i class="fab fa-whatsapp text-3xl"></i>
</a>

<!-- MOBILE STICKY CTA -->
<div class="fixed bottom-0 left-0 right-0 z-30 sm:hidden bg-white/95 backdrop-blur-md border-t-2 border-sky-300 p-3 shadow-2xl">
    <div class="flex items-center justify-between gap-3 max-w-md mx-auto">
        <div>
            <span class="text-[11px] text-stone-500 font-bold block">অফার প্রাইস</span>
            <span class="text-xl font-black text-blue-700">৳{{ number_format($offerPrice) }}</span>
        </div>
        <a href="#fast-order-form" class="bg-blue-600 hover:bg-blue-700 text-white font-black text-sm px-5 py-2.5 rounded-xl shadow-lg transition flex items-center gap-1.5">
            <i class="fas fa-pencil-alt"></i> এখনই কিনুন
        </a>
    </div>
</div>

<script>
    // Live Countdown Timer
    let kidsHours = 5, kidsMinutes = 22, kidsSeconds = 35;
    setInterval(function() {
        if (kidsSeconds > 0) {
            kidsSeconds--;
        } else {
            kidsSeconds = 59;
            if (kidsMinutes > 0) {
                kidsMinutes--;
            } else {
                kidsMinutes = 59;
                if (kidsHours > 0) kidsHours--;
            }
        }
        document.getElementById('kids_timer_hours').textContent = String(kidsHours).padStart(2, '0');
        document.getElementById('kids_timer_minutes').textContent = String(kidsMinutes).padStart(2, '0');
        document.getElementById('kids_timer_seconds').textContent = String(kidsSeconds).padStart(2, '0');
    }, 1000);

    let currentKidsSubtotal = {{ $offerPrice }};
    let currentKidsDelivery = {{ $dhakaCharge }};
    let isKidsFreeDelivery = false;
    let currentKidsColor = 'স্কাই ব্লু';
    let currentKidsPkg = '১টি কিডস কম্বো';

    function syncKidsVariant() {
        document.getElementById('kids_selected_variant').value = currentKidsColor + ' (' + currentKidsPkg + ')';
    }

    function selectKidsPackage(pkgId, price, label, el) {
        currentKidsSubtotal = price;
        isKidsFreeDelivery = (pkgId === 2);
        currentKidsPkg = label;
        syncKidsVariant();
        document.getElementById('kids_unit_price').value = price;
        document.getElementById('kids_selected_package').value = label + ' (৳' + price + ')';

        document.querySelectorAll('.package-card').forEach(c => {
            c.classList.remove('border-blue-500', 'bg-sky-50/70');
            c.classList.add('border-stone-200', 'bg-white');
        });
        el.classList.add('border-blue-500', 'bg-sky-50/70');
        el.classList.remove('border-stone-200', 'bg-white');
        updateKidsBill();
    }

    function setKidsColor(color, el) {
        currentKidsColor = color;
        syncKidsVariant();
        document.getElementById('kids_selected_color').value = color;
        document.querySelectorAll('.kids-color-btn').forEach(b => {
            b.classList.remove('border-blue-600', 'bg-sky-50', 'text-blue-950');
            b.classList.add('border-stone-200', 'bg-white', 'text-stone-800');
        });
        el.classList.add('border-blue-600', 'bg-sky-50', 'text-blue-950');
        el.classList.remove('border-stone-200', 'bg-white', 'text-stone-800');
    }

    function setKidsDelivery(charge, el) {
        currentKidsDelivery = charge;
        document.querySelectorAll('.delivery-card').forEach(d => {
            d.classList.remove('border-blue-600', 'bg-sky-50/60');
            d.classList.add('border-stone-200', 'bg-white');
        });
        el.classList.add('border-blue-600', 'bg-sky-50/60');
        el.classList.remove('border-stone-200', 'bg-white');
        updateKidsBill();
    }

    function updateKidsBill() {
        let deliveryToApply = isKidsFreeDelivery ? 0 : currentKidsDelivery;
        let total = currentKidsSubtotal + deliveryToApply;
        document.getElementById('kids_subtotal_text').textContent = '৳' + currentKidsSubtotal.toLocaleString();
        document.getElementById('kids_delivery_text').textContent = isKidsFreeDelivery ? 'ফ্রি (৳০)' : '৳' + deliveryToApply;
        document.getElementById('kids_total_text').textContent = '৳' + total.toLocaleString();
    }
</script>
@endsection
