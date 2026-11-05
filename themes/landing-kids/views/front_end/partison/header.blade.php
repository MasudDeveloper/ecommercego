<header class="bg-white/95 border-gray-100 backdrop-blur-md sticky top-0 z-50 shadow-sm border-b">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('landing_page', $slug) }}" class="flex items-center gap-2">
                @if(isset($themeSettings['header_logo']) && !empty($themeSettings['header_logo']) && check_file($themeSettings['header_logo']))
                    <img src="{{ get_file($themeSettings['header_logo']) }}" alt="{{ $store->name }}" class="h-10 sm:h-12 w-auto object-contain">
                @else
                    <span class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight flex items-center gap-1.5">
                        <i class="fas fa-shapes text-primary"></i> {{ $store->name ?? 'Kids Magic Learning Tablet & Book' }}
                    </span>
                @endif
            </a>
        </div>

        <div class="flex items-center gap-2 sm:gap-4">
            @php
                $callPhone = $themeSettings['header_call'] ?? $store_phone ?? '01700-000000';
            @endphp
            @if(!empty($callPhone))
            <a href="tel:{{ $callPhone }}" class="flex items-center gap-1.5 px-3 py-2 text-xs sm:text-sm font-bold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
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