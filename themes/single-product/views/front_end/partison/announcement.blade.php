@if (isset($themeSettings['announcement_status']) && $themeSettings['announcement_status'] == '1')
<div style="background: linear-gradient(90deg, #b91c1c 0%, #dc2626 50%, #991b1b 100%); color: #ffffff;" class="text-xs sm:text-sm font-bold py-2.5 px-3 shadow-md">
    <div class="max-w-6xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-1 text-center">
        <div class="flex items-center justify-center gap-2">
            <span class="inline-block w-2.5 h-2.5 bg-yellow-300 rounded-full animate-ping"></span>
            <span class="text-white font-bold">{!! $themeSettings['announcement_text'] ?? '🔥 বিশেষ অফার চলছে! সারা বাংলাদেশে ক্যাশ অন ডেলিভারি (পণ্য হাতে পেয়ে টাকা দিন)' !!}</span>
        </div>
        @if(!empty($themeSettings['header_call']))
        <a href="tel:{{ $themeSettings['header_call'] }}" class="hidden sm:inline-flex items-center gap-1.5 bg-white text-red-700 hover:bg-yellow-300 hover:text-red-900 px-3 py-1 rounded-full text-xs font-black shadow transition">
            <i class="fas fa-phone-alt"></i> {{ $themeSettings['header_call'] }}
        </a>
        @endif
    </div>
</div>
@endif