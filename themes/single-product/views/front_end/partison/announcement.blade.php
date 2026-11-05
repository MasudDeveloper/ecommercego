@if (isset($themeSettings['announcement_status']) && $themeSettings['announcement_status'] == '1')
<div class="urgent-gradient text-white text-xs sm:text-sm font-semibold py-2 px-3 shadow-sm">
    <div class="max-w-6xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-1 text-center">
        <div class="flex items-center justify-center gap-2">
            <span class="inline-block w-2.5 h-2.5 bg-yellow-300 rounded-full animate-ping"></span>
            <span>{!! $themeSettings['announcement_text'] ?? '🔥 বিশেষ অফার চলছে! সারা বাংলাদেশে ক্যাশ অন ডেলিভারি (পণ্য হাতে পেয়ে টাকা দিন)' !!}</span>
        </div>
        @if(!empty($themeSettings['header_call']))
        <a href="tel:{{ $themeSettings['header_call'] }}" class="hidden sm:inline-flex items-center gap-1.5 bg-white/20 hover:bg-white/30 text-white px-3 py-0.5 rounded-full text-xs font-bold transition">
            <i class="fas fa-phone-alt"></i> {{ $themeSettings['header_call'] }}
        </a>
        @endif
    </div>
</div>
@endif

