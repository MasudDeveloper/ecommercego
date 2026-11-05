<footer class="bg-gray-950 text-gray-300 pt-12 pb-8 border-t-4 border-primary">
    <div class="max-w-6xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 pb-10 border-b border-gray-800">
            <div>
                <h3 class="text-xl font-bold text-white mb-3 flex items-center gap-2">
                    <i class="fas fa-spa text-primary"></i> {{ $store->name ?? 'Organic Glow Serum & Beauty' }}
                </h3>
                <p class="text-sm text-gray-400 leading-relaxed mb-4">
                    {!! $themeSettings['footer_description'] ?? 'আমরা সর্বোচ্চ গুণগত মানের সেরা পণ্য সরাসরি আপনার দোরগোড়ায় পৌঁছে দিতে প্রতিশ্রুতিবদ্ধ।' !!}
                </p>
                <div class="flex items-center gap-2 text-yellow-400 text-sm">
                    <i class="fas fa-shield-alt text-lg"></i>
                    <span class="font-medium">১০০% ক্যাশ অন ডেলিভারি ও নিরাপদ কেনাকাটা</span>
                </div>
            </div>

            <div>
                <h4 class="text-base font-bold text-white uppercase tracking-wider mb-3">জরুরি যোগাযোগ</h4>
                <ul class="space-y-2.5 text-sm">
                    <li class="flex items-center gap-2">
                        <i class="fas fa-phone-alt text-primary"></i>
                        <span>হটলাইন: </span>
                        <a href="tel:{{ $themeSettings['footer_phone'] ?? $themeSettings['header_call'] ?? '01700-000000' }}" class="text-white hover:text-primary font-bold">
                            {{ $themeSettings['footer_phone'] ?? $themeSettings['header_call'] ?? '01700-000000' }}
                        </a>
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fas fa-map-marker-alt text-primary"></i>
                        <span>ঠিকানা: {{ $themeSettings['footer_address'] ?? 'ঢাকা, বাংলাদেশ' }}</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fas fa-envelope text-primary"></i>
                        <span>ইমেইল: {{ $themeSettings['footer_email'] ?? $store->email ?? 'support@myshop.com' }}</span>
                    </li>
                </ul>
            </div>

            <div>
                <h4 class="text-base font-bold text-white uppercase tracking-wider mb-3">আমাদের প্রতিশ্রুতি</h4>
                <div class="bg-gray-900/80 p-4 rounded-xl border border-gray-800 space-y-2">
                    <div class="flex items-start gap-2.5">
                        <i class="fas fa-box-check text-green-400 text-lg mt-0.5"></i>
                        <p class="text-xs text-gray-300">ডেলিভারিম্যানের সামনে পার্সেল খুলে পণ্য দেখে মূল্য পরিশোধ করার সুবিধা।</p>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <i class="fas fa-undo-alt text-yellow-400 text-lg mt-0.5"></i>
                        <p class="text-xs text-gray-300">কোনো সমস্যা পেলে তাৎক্ষণিক রিটার্ন ও পরিবর্তনের সুযোগ।</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-6 flex flex-col sm:flex-row items-center justify-between text-xs text-gray-400 gap-2">
            <div>&copy; {{ date('Y') }} {{ $store->name ?? 'edokanpro' }}. সর্বস্বত্ব সংরক্ষিত।</div>
            <div>{{ $themeSettings['footer_copyright'] ?? 'edokanpro • Developed by MR Developer' }}</div>
        </div>
    </div>
</footer>