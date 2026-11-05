<header class="bg-slate-900/95 border-slate-800 backdrop-blur-md sticky top-0 z-50 shadow-sm border-b">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('landing_page', $slug) }}" class="flex items-center gap-2">
                @if(isset($themeSettings['header_logo']) && !empty($themeSettings['header_logo']) && check_file($themeSettings['header_logo']))
                    <img src="{{ get_file($themeSettings['header_logo']) }}" alt="{{ $store->name }}" class="h-10 sm:h-12 w-auto object-contain">
                @else
                    <span class="text-xl sm:text-2xl font-black text-white tracking-tight flex items-center gap-1.5">
                        <i class="fas fa-heart-pulse text-primary"></i> {{ $store->name ?? 'Body Massage Gun & Pain Relief' }}
                    </span>
                @endif
            </a>
        </div>

        <div class="flex items-center gap-2 sm:gap-4">
            @php
                $callPhone = $themeSettings['header_call'] ?? $store_phone ?? '01700-000000';
            @endphp
            @if(!empty($callPhone))
            <a href="tel:{{ $callPhone }}" class="flex items-center gap-1.5 px-3 py-2 text-xs sm:text-sm font-bold text-gray-200 bg-slate-800 hover:bg-slate-700 rounded-lg transition">
                <i class="fas fa-phone-alt text-primary"></i>
                <span class="hidden md:inline">{{ __('কল করুন:') }}</span>
                <span>{{ $callPhone }}</span>
            </a>
            @endif

            <a href="#fast-order-form" class="pulse-btn inline-flex items-center gap-2 bg-primary hover:bg-primary-dark text-white px-4 py-2 sm:px-6 sm:py-2.5 rounded-lg text-sm sm:text-base font-bold shadow-md transition-all">
                <i class="fas fa-shopping-basket"></i>
                <span>{{ __('অর্ডার করুন') }}</span>
            </a>
        </div>
    </div>
</header>