@extends('front_end.layouts.app')

@section('page-title')
    {{ $store->name ?? 'Islamic Lifestyle & Quran Lamp' }}
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
    $productTitle = $mainProduct ? $mainProduct->name : ($themeSettings['hero_title'] ?? 'রিমোট কন্ট্রোল ৭ কালার টাচ ডিজিটাল কুরআন স্পিকার ও মুন ল্যাম্প');
    $productDesc = $mainProduct ? strip_tags($mainProduct->description) : ($themeSettings['hero_subtitle'] ?? '১৮ জন বিশ্ববিখ্যাত ক্বারীর সুরে পূর্ণাঙ্গ কুরআন তেলাওয়াত, বাংলা তাফসীর ও অনুবাদ, সহিহ বুখারী, রিয়াযুস সালেহীন ও দোয়া সমূহ।');
    
    $regularPrice = $mainProduct ? $toNum($mainProduct->price, 2400) : $toNum($themeSettings['hero_regular_price'] ?? 2400, 2400);
    $offerPrice = $mainProduct ? $toNum($mainProduct->sale_price ?? $mainProduct->price, 1650) : $toNum($themeSettings['hero_offer_price'] ?? 1650, 1650);
    
    if ($regularPrice <= 0) $regularPrice = 2400;
    if ($offerPrice <= 0) $offerPrice = 1650;
    if ($offerPrice > $regularPrice) {
        $offerPrice = round($regularPrice * 0.75);
    }
    
    $productImg = ($mainProduct && !empty($mainProduct->cover_image_url)) ? get_file($mainProduct->cover_image_url) : asset('themes/' . $currentTheme . '/assets/images/product-01.png');
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

<main class="space-y-12 sm:space-y-20 bg-[#06241b] text-emerald-50">

    <!-- 1. ISLAMIC MIHRAB ARCH HERO -->
    <section class="relative pt-10 sm:pt-16 pb-16 bg-gradient-to-b from-[#06241b] via-[#093528] to-[#06241b] text-emerald-50 border-b border-yellow-600/30">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center max-w-3xl mx-auto space-y-6">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-900 border border-yellow-500/50 text-yellow-300 text-xs font-bold">
                    <i class="fas fa-moon text-yellow-400"></i>
                    <span>{{ $themeSettings['hero_badge'] ?? '🌙 ডিজিটাল কুরআন লাইফস্টাইল • পরিবার ও সন্তানদের জন্য সেরা উপহার' }}</span>
                </div>

                <h1 class="text-3xl sm:text-5xl font-black text-white leading-tight font-serif">
                    {{ $productTitle }}
                </h1>

                <p class="text-emerald-200/90 text-sm sm:text-base leading-relaxed">
                    {{ $productDesc }}
                </p>

                <!-- Arch Card -->
                <div class="p-6 rounded-3xl bg-emerald-900/60 border-2 border-yellow-600/40 shadow-2xl max-w-md mx-auto">
                    <img src="{{ $productImg }}" alt="{{ $productTitle }}" class="w-full h-72 object-contain drop-shadow-xl mb-4">
                    <div class="flex items-center justify-around border-t border-yellow-600/30 pt-4">
                        <div>
                            <span class="text-xs text-emerald-300 block">রেগুলার মূল্য</span>
                            <span class="text-lg font-bold text-emerald-400 line-through">৳{{ number_format($regularPrice) }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-yellow-400 font-bold block">বরকতপূর্ণ অফার</span>
                            <span class="text-3xl font-black text-yellow-300">৳{{ number_format($offerPrice) }}</span>
                        </div>
                    </div>
                </div>

                <div>
                    <a href="#fast-order-form" class="pulse-btn inline-flex items-center gap-3 bg-gradient-to-r from-yellow-500 to-amber-600 hover:from-yellow-400 hover:to-amber-500 text-emerald-950 font-black text-lg px-8 py-4 rounded-xl shadow-xl transition">
                        <i class="fas fa-hand-holding-heart text-xl"></i>
                        <span>{{ $themeSettings['hero_button_text'] ?? '👉 এখনই অর্ডার করুন (ক্যাশ অন ডেলিভারি)' }}</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. DISTINCT CATEGORY FEATURES SECTION -->
    <section class="max-w-6xl mx-auto px-4">
        <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
            <span class="text-xs uppercase font-extrabold text-primary tracking-widest">ইসলামিক লাইফস্টাইল ও উপহার</span>
            <h2 class="text-2xl sm:text-4xl font-black text-white">আমাদের সেরা বিশেষত্ব ও সুযোগ-সুবিধা</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-[#093528]/90 p-6 rounded-2xl border-2 border-yellow-600/40 shadow-sm hover:shadow-lg transition">
                <div class="w-12 h-12 rounded-xl bg-primary/20 text-primary flex items-center justify-center text-xl mb-4">
                    <i class="fas fa-certificate"></i>
                </div>
                <h3 class="font-black text-lg mb-2">১০০% অরিজিনাল ও অথেনটিক</h3>
                <p class="text-xs sm:text-sm text-gray-400 leading-relaxed">সর্বোচ্চ গুণমান নিশ্চিত করে সরাসরি প্রস্তুতকারক বা বিশ্বস্ত উৎস থেকে সংগৃহীত।</p>
            </div>

            <div class="bg-[#093528]/90 p-6 rounded-2xl border-2 border-yellow-600/40 shadow-sm hover:shadow-lg transition">
                <div class="w-12 h-12 rounded-xl bg-primary/20 text-primary flex items-center justify-center text-xl mb-4">
                    <i class="fas fa-truck-ramp-box"></i>
                </div>
                <h3 class="font-black text-lg mb-2">ক্যাশ অন ডেলিভারি</h3>
                <p class="text-xs sm:text-sm text-gray-400 leading-relaxed">আগে কোনো টাকা দিতে হবে না, পণ্য হাতে পেয়ে দেখে তবেই মূল্য পরিশোধ করুন।</p>
            </div>

            <div class="bg-[#093528]/90 p-6 rounded-2xl border-2 border-yellow-600/40 shadow-sm hover:shadow-lg transition">
                <div class="w-12 h-12 rounded-xl bg-primary/20 text-primary flex items-center justify-center text-xl mb-4">
                    <i class="fas fa-arrows-rotate"></i>
                </div>
                <h3 class="font-black text-lg mb-2">সহজ রিটার্ন ও রিপ্লেসমেন্ট</h3>
                <p class="text-xs sm:text-sm text-gray-400 leading-relaxed">কোনো ত্রুটি বা অমিল পেলে দ্রুত পরিবর্তন বা রিটার্ন করার শতভাগ সুযোগ।</p>
            </div>

            <div class="bg-[#093528]/90 p-6 rounded-2xl border-2 border-yellow-600/40 shadow-sm hover:shadow-lg transition">
                <div class="w-12 h-12 rounded-xl bg-primary/20 text-primary flex items-center justify-center text-xl mb-4">
                    <i class="fas fa-headset"></i>
                </div>
                <h3 class="font-black text-lg mb-2">২৪/৭ কাস্টমার সাপোর্ট</h3>
                <p class="text-xs sm:text-sm text-gray-400 leading-relaxed">যেকোনো তথ্য বা সহায়তার জন্য আমাদের হটলাইনে সরাসরি কথা বলুন।</p>
            </div>
        </div>
    </section>

    <!-- 3. YOUTUBE VIDEO SECTION (SHOWN ONLY IF URL IS SET) -->
    @if(!empty($embedUrl))
    <section class="max-w-5xl mx-auto px-4">
        <div class="bg-[#093528]/90 p-6 sm:p-10 rounded-3xl border-2 border-yellow-600/40 shadow-2xl text-center space-y-6">
            <div class="space-y-2">
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-100 text-red-600 text-xs font-bold uppercase">
                    <i class="fab fa-youtube text-base"></i> ভিডিও রিভিউ
                </span>
                <h2 class="text-2xl sm:text-3xl font-black text-white">
                    {{ $themeSettings['video_title'] ?? 'পণ্যটির আসল ব্যবহার ও কার্যকারিতা সরাসরি ভিডিওতে দেখুন' }}
                </h2>
                <p class="text-xs sm:text-sm text-gray-400 max-w-xl mx-auto">
                    {{ $themeSettings['video_subtitle'] ?? 'অর্ডার করার আগে ভিডিওটি দেখে পণ্যের কোয়ালিটি যাচাই করে নিন' }}
                </p>
            </div>

            <!-- Responsive 16:9 Video Frame -->
            <div class="relative w-full rounded-2xl overflow-hidden shadow-2xl border-2 border-yellow-600/40 aspect-video max-w-4xl mx-auto bg-black">
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
                <a href="#fast-order-form" class="inline-flex items-center gap-2 bg-primary hover:bg-primary-dark text-white font-extrabold text-base px-8 py-3.5 rounded-xl shadow-lg transition">
                    <i class="fas fa-hand-point-right"></i> ভিডিও দেখা শেষ হলে অর্ডার করতে এখানে ক্লিক করুন
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- 4. 1-CLICK CASH ON DELIVERY CHECKOUT FORM -->
    <section id="fast-order-form" class="max-w-4xl mx-auto px-4 scroll-mt-24">
        <div class="bg-[#093528]/90 rounded-3xl shadow-2xl border-4 border-yellow-600/40 overflow-hidden">
            
            <div class="bg-primary text-white p-6 sm:p-8 text-center space-y-2">
                <span class="inline-block bg-white/20 text-white text-xs font-black uppercase px-3.5 py-1 rounded-full">ক্যাশ অন ডেলিভারি</span>
                <h2 class="text-2xl sm:text-3xl font-black">অর্ডার ফর্মটি সঠিকভাবে পূরণ করুন</h2>
                <p class="text-xs sm:text-sm text-white/90">পণ্য হাতে পেয়ে দেখে টাকা পরিশোধ করুন। কোনো প্রকার অগ্রিম পেমেন্টের প্রয়োজন নেই।</p>
            </div>

            <form id="singleProductFastForm" class="p-6 sm:p-10 space-y-8" method="POST" action="{{ route('single.fast.order', $slug) }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $mainProduct->id ?? 1 }}">
                <input type="hidden" id="base_price" value="{{ $offerPrice }}">

                <!-- STEP 1: PACKAGE SELECTOR -->
                <div>
                    <label class="block text-sm font-extrabold text-white uppercase tracking-wider mb-3">
                        ১. আপনার প্যাকেজ বা পরিমাণ নির্বাচন করুন:
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <label class="relative flex items-center justify-between p-4 rounded-2xl border-2 border-primary bg-primary/10 cursor-pointer package-card hover:shadow-md transition">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="order_package" value="1" class="w-5 h-5 text-primary accent-primary" checked onchange="updateTotalCalculation()">
                                <div>
                                    <span class="font-extrabold text-white text-sm sm:text-base block">১টি ডিজিটাল কুরআন মুন ল্যাম্প (ফুল সেট)</span>
                                    <span class="text-xs text-gray-400">স্ট্যান্ডার্ড প্যাক</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="font-black text-primary text-lg">৳{{ number_format($offerPrice) }}</span>
                            </div>
                        </label>

                        <label class="relative flex items-center justify-between p-4 rounded-2xl border-2 border-slate-700 bg-slate-800/60 cursor-pointer package-card hover:border-primary/50 transition">
                            <span class="absolute -top-2.5 right-4 bg-amber-500 text-white text-[10px] font-black uppercase px-2 py-0.5 rounded-full shadow-sm">
                                সেরা অফার
                            </span>
                            <div class="flex items-center gap-3">
                                <input type="radio" name="order_package" value="2" data-special-price="3100" class="w-5 h-5 text-primary accent-primary" onchange="updateTotalCalculation()">
                                <div>
                                    <span class="font-extrabold text-white text-sm sm:text-base block">২টি কুরআন ল্যাম্প (প্রিয়জনকে উপহার দেওয়ার স্পেশাল ডিল)</span>
                                    <span class="text-xs text-gray-400">ফ্যামিলি মেগা সেভিংস</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="font-black text-primary text-lg">৳3,100</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- STEP 2: CUSTOMER DETAILS -->
                <div class="space-y-4">
                    <label class="block text-sm font-extrabold text-white uppercase tracking-wider">
                        ২. আপনার নাম, মোবাইল নম্বর ও ঠিকানা লিখুন:
                    </label>

                    <div>
                        <label class="block text-xs font-bold text-gray-300 mb-1">আপনার পূর্ণ নাম <span class="text-red-500">*</span></label>
                        <input type="text" name="customer_name" required placeholder="যেমন: মোঃ সাকিব হোসেন" class="w-full px-4 py-3 rounded-xl border-2 border-slate-700 bg-slate-800 text-white focus:border-primary focus:bg-white text-sm outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-300 mb-1">মোবাইল নম্বর (১১ ডিজিট) <span class="text-red-500">*</span></label>
                        <input type="tel" name="customer_phone" required placeholder="যেমন: 01712345678" pattern="[0-9]{11}" class="w-full px-4 py-3 rounded-xl border-2 border-slate-700 bg-slate-800 text-white focus:border-primary focus:bg-white text-sm outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-300 mb-1">সম্পূর্ণ ডেলিভারি ঠিকানা <span class="text-red-500">*</span></label>
                        <textarea name="delivery_address" rows="3" required placeholder="বাড়ি নম্বর, রোড নম্বর/গ্রাম, থানা এবং জেলার নাম বিস্তারিত লিখুন..." class="w-full px-4 py-3 rounded-xl border-2 border-slate-700 bg-slate-800 text-white focus:border-primary focus:bg-white text-sm outline-none transition"></textarea>
                    </div>
                </div>

                <!-- STEP 3: SHIPPING AREA -->
                <div>
                    <label class="block text-sm font-extrabold text-white uppercase tracking-wider mb-3">
                        ৩. আপনার ডেলিভারি এলাকা নির্বাচন করুন:
                    </label>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <label class="flex items-center justify-between p-3.5 rounded-xl border-2 border-primary bg-primary/10 cursor-pointer shipping-option">
                            <div class="flex items-center gap-2.5">
                                <input type="radio" name="shipping_area" value="dhaka" data-charge="{{ $dhakaCharge }}" class="w-4 h-4 text-primary accent-primary" checked onchange="updateTotalCalculation()">
                                <span class="text-xs sm:text-sm font-bold text-white">ঢাকার ভেতরে ডেলিভারি</span>
                            </div>
                            <span class="text-xs sm:text-sm font-black text-primary">৳{{ $dhakaCharge }}</span>
                        </label>

                        <label class="flex items-center justify-between p-3.5 rounded-xl border-2 border-slate-700 bg-slate-800/60 cursor-pointer shipping-option">
                            <div class="flex items-center gap-2.5">
                                <input type="radio" name="shipping_area" value="outside" data-charge="{{ $outsideCharge }}" class="w-4 h-4 text-primary accent-primary" onchange="updateTotalCalculation()">
                                <span class="text-xs sm:text-sm font-bold text-white">ঢাকার বাইরে (সারা দেশ)</span>
                            </div>
                            <span class="text-xs sm:text-sm font-black text-primary">৳{{ $outsideCharge }}</span>
                        </label>
                    </div>
                </div>

                <!-- STEP 4: ORDER SUMMARY & SUBMIT -->
                <div class="bg-slate-800/80 border-slate-700 p-5 rounded-2xl border space-y-3">
                    <div class="flex justify-between text-xs sm:text-sm text-gray-300">
                        <span>পণ্যের মূল্য:</span>
                        <span id="summary_subtotal" class="font-bold text-white">৳{{ number_format($offerPrice) }}</span>
                    </div>
                    <div class="flex justify-between text-xs sm:text-sm text-gray-300">
                        <span>ডেলিভারি চার্জ:</span>
                        <span id="summary_shipping" class="font-bold text-white">৳{{ $dhakaCharge }}</span>
                    </div>
                    <div class="border-t border-slate-700 pt-3 flex justify-between items-center text-base sm:text-lg font-black">
                        <span class="text-white">সর্বমোট প্রদেয় মূল্য:</span>
                        <span id="summary_total" class="text-2xl text-primary font-black">৳{{ number_format($offerPrice + $dhakaCharge) }}</span>
                    </div>
                </div>

                <button type="submit" id="submitOrderBtn" class="pulse-btn w-full bg-primary hover:bg-primary-dark text-white font-black text-lg sm:text-xl py-4 sm:py-5 rounded-2xl shadow-xl flex items-center justify-center gap-3 transition">
                    <i class="fas fa-check-circle text-2xl"></i>
                    <span>অর্ডার কনফার্ম করুন (ক্যাশ অন ডেলিভারি)</span>
                </button>

                <p class="text-center text-xs text-gray-400">
                    🔒 আপনার তথ্য সম্পূর্ণ নিরাপদ। কোনো প্রশ্ন থাকলে সরাসরি কল করুন: 
                    <a href="tel:{{ $themeSettings['header_call'] ?? '01700-000000' }}" class="text-primary font-bold">{{ $themeSettings['header_call'] ?? '01700-000000' }}</a>
                </p>
            </form>
        </div>
    </section>

    <!-- 5. FAQS ACCORDION -->
    <section class="max-w-4xl mx-auto px-4 pb-16">
        <div class="text-center mb-8">
            <h2 class="text-2xl sm:text-3xl font-black text-white">সাধারণ জিজ্ঞাসা ও উত্তর (FAQ)</h2>
        </div>

        <div class="space-y-4">
            <div class="bg-[#093528]/90 p-5 rounded-2xl border border-yellow-600/40 shadow-sm space-y-2">
                <h3 class="font-extrabold text-base text-white flex items-center gap-2">
                    <i class="fas fa-circle-question text-primary"></i> পণ্য হাতে পাওয়ার পর কি চেক করতে পারব?
                </h3>
                <p class="text-xs sm:text-sm text-gray-400 pl-6 leading-relaxed">
                    হ্যাঁ, অবশ্যই! ডেলিভারিম্যানের সামনে পার্সেল খুলে পণ্য দেখে সন্তুষ্ট হয়ে তবেই মূল্য পরিশোধ করবেন।
                </p>
            </div>

            <div class="bg-[#093528]/90 p-5 rounded-2xl border border-yellow-600/40 shadow-sm space-y-2">
                <h3 class="font-extrabold text-base text-white flex items-center gap-2">
                    <i class="fas fa-circle-question text-primary"></i> ডেলিভারি পেতে কতদিন সময় লাগবে?
                </h3>
                <p class="text-xs sm:text-sm text-gray-400 pl-6 leading-relaxed">
                    ঢাকার ভেতরে ২৪ থেকে ৪৮ ঘণ্টার মধ্যে এবং ঢাকার বাইরে সারা বাংলাদেশে ২ থেকে ৩ কার্যদিবসের মধ্যে হোম ডেলিভারি পাবেন।
                </p>
            </div>

            <div class="bg-[#093528]/90 p-5 rounded-2xl border border-yellow-600/40 shadow-sm space-y-2">
                <h3 class="font-extrabold text-base text-white flex items-center gap-2">
                    <i class="fas fa-circle-question text-primary"></i> কোনো সমস্যা হলে রিটার্ন করার নিয়ম কী?
                </h3>
                <p class="text-xs sm:text-sm text-gray-400 pl-6 leading-relaxed">
                    ডেলিভারির সময় বা পণ্য ব্যবহারে কোনো প্রকার সমস্যা পেলে আমাদের হটলাইনে কল দিন, আমরা বিনামূল্যে রিপ্লেসমেন্ট বা রিটার্ন ব্যবস্থা করব।
                </p>
            </div>
        </div>
    </section>

</main>

<!-- FLOATING MOBILE BOTTOM CTA -->
<div class="sm:hidden fixed bottom-0 left-0 right-0 bg-slate-900/95 border-slate-800 backdrop-blur-md p-3 border-t shadow-2xl z-40 flex items-center justify-between gap-3">
    <div>
        <span class="text-[10px] text-gray-400 uppercase font-bold block">অফার মূল্য</span>
        <span class="text-lg font-black text-primary">৳{{ number_format($offerPrice) }}</span>
    </div>
    <a href="#fast-order-form" class="pulse-btn flex-1 bg-primary text-white text-center font-black py-2.5 px-4 rounded-xl text-sm shadow-md flex items-center justify-center gap-2">
        <i class="fas fa-shopping-cart"></i>
        <span>অর্ডার করুন</span>
    </a>
</div>

@endsection

@push('custom-scripts')
<script>
    function updateTotalCalculation() {
        var basePrice = parseFloat($("#base_price").val()) || 1650;
        var selectedPkg = $('input[name="order_package"]:checked');
        var pkgVal = parseInt(selectedPkg.val()) || 1;
        var subtotal = basePrice;
        
        if (pkgVal === 2) {
            var specialPrice = parseFloat(selectedPkg.data('special-price'));
            subtotal = specialPrice ? specialPrice : (basePrice * 2 * 0.9);
        } else {
            subtotal = basePrice * pkgVal;
        }

        var shippingCharge = parseFloat($('input[name="shipping_area"]:checked').data('charge')) || 70;
        var total = subtotal + shippingCharge;

        $("#summary_subtotal").text("৳" + Math.round(subtotal).toLocaleString());
        $("#summary_shipping").text("৳" + Math.round(shippingCharge).toLocaleString());
        $("#summary_total").text("৳" + Math.round(total).toLocaleString());
    }

    $(document).ready(function() {
        updateTotalCalculation();

        $(".package-card").click(function() {
            $(".package-card").removeClass("border-primary bg-primary/10 shadow-lg").addClass("border-slate-700 bg-slate-800/60");
            $(this).removeClass("border-slate-700 bg-slate-800/60").addClass("border-primary bg-primary/10 shadow-lg");
        });

        $(".shipping-option").click(function() {
            $(".shipping-option").removeClass("border-primary bg-primary/10 shadow-md").addClass("border-slate-700 bg-slate-800/60");
            $(this).removeClass("border-slate-700 bg-slate-800/60").addClass("border-primary bg-primary/10 shadow-md");
        });
    });
</script>
@endpush