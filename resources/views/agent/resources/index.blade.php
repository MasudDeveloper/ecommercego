@extends('agent.layouts.app')

@section('page-title')
    {{ __('মার্কেটিং টুলকিট ও স্ক্রিপ্ট প্লেবুক') }}
@endsection

@push('custom-css')
<style>
    /* Hero Banner */
    .toolkit-hero-banner {
        background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%);
        border-radius: 24px;
        padding: 30px;
        color: #ffffff;
        box-shadow: 0 12px 36px rgba(49, 46, 129, 0.25);
        position: relative;
        overflow: hidden;
        margin-bottom: 25px;
    }

    .toolkit-hero-banner::after {
        content: '';
        position: absolute;
        width: 320px;
        height: 320px;
        background: radial-gradient(circle, rgba(99, 102, 241, 0.3) 0%, rgba(99, 102, 241, 0) 70%);
        top: -80px;
        right: -60px;
        border-radius: 50%;
        pointer-events: none;
    }

    /* Tab Buttons */
    .toolkit-tab-btn {
        padding: 10px 22px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 14px;
        color: #475569;
        background: #ffffff;
        border: 1px solid var(--agent-border);
        transition: all 0.25s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        cursor: pointer;
    }
    .toolkit-tab-btn:hover {
        color: #4338ca;
        background: #f8fafc;
        border-color: #cbd5e1;
        transform: translateY(-1px);
    }
    .toolkit-tab-btn.active {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%) !important;
        color: #ffffff !important;
        border-color: #4338ca !important;
        box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);
    }
    .toolkit-tab-btn.active .tab-counter-badge {
        background: #ffffff !important;
        color: #4338ca !important;
    }

    /* Script Modern Card */
    .script-modern-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid var(--agent-border);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        height: 100%;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    .script-modern-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
        border-color: #c7d2fe;
    }

    .script-header {
        padding: 20px 22px 16px 22px;
        border-bottom: 1px solid #f1f5f9;
    }

    .script-body-wrapper {
        padding: 20px 22px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .script-copy-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 18px 20px;
        font-size: 14px;
        line-height: 1.8;
        color: #1e293b;
        white-space: pre-wrap;
        position: relative;
        flex-grow: 1;
        font-family: 'Hind Siliguri', sans-serif;
    }

    .script-footer-actions {
        padding: 14px 22px 18px 22px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #fafbfc;
        flex-wrap: wrap;
        gap: 10px;
    }

    .badge-pill-tag {
        font-size: 11.5px;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 50px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    /* Guide Playbook Card */
    .guide-step-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid var(--agent-border);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        padding: 26px;
        height: 100%;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .guide-step-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.07);
        border-color: #c7d2fe;
    }
    .guide-step-number {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 18px;
        color: #ffffff;
        flex-shrink: 0;
    }

    /* Objection Box */
    .objection-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid var(--agent-border);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        padding: 24px;
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .objection-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.07);
        border-color: #86efac;
    }

    /* Live Search Input */
    .toolkit-search-box {
        position: relative;
        max-width: 360px;
        width: 100%;
    }
    .toolkit-search-box input {
        border-radius: 50px;
        padding: 10px 18px 10px 42px;
        font-size: 13.5px;
        border: 1.5px solid #cbd5e1;
        transition: all 0.2s ease;
    }
    .toolkit-search-box input:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
    }
    .toolkit-search-box i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 18px;
    }
</style>
@endpush

@section('content')

<!-- ============================================== -->
<!-- HERO BANNER WITH INSTANT COPY                  -->
<!-- ============================================== -->
<div class="toolkit-hero-banner">
    <div class="row align-items-center g-4">
        <div class="col-xl-7 col-lg-7">
            <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" style="background: rgba(255, 255, 255, 0.15); border: 1px solid rgba(255, 255, 255, 0.25); font-size: 12px; font-weight: 700;">
                <i class="ti ti-flame text-warning"></i>
                <span>প্রমাণিত ৮৫%+ কনভার্টিং বাংলা পিচ প্লেবুক</span>
            </div>
            <h2 class="text-white font-weight-bold mb-2" style="font-size: 26px;">
                মার্কেটিং টুলকিট ও সেলস স্ক্রিপ্ট প্লেবুক 🚀
            </h2>
            <p class="text-white-50 text-sm mb-3" style="max-width: 620px; line-height: 1.7;">
                ফেসবুক শপ ও অনলাইন উদ্যোক্তাদের সাথে যোগাযোগের সময় কী বলবেন, কীভাবে ইনবক্সে কথা শুরু করবেন এবং কীভাবে দ্রুত ফ্রি ট্রায়াল চালু করাবেন—তার সবকিছু এখানে তৈরি রয়েছে। প্রতিটি স্ক্রিপ্টে আপনার নিজস্ব রেফারেল লিংক স্বয়ংক্রিয়ভাবে ইনপুট করা আছে!
            </p>
        </div>

        <div class="col-xl-5 col-lg-5">
            <div class="p-3 rounded-4" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2);">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-xs text-white-50 font-weight-bold text-uppercase letter-spacing-1">আপনার ইউনিক এফিলিয়েট লিংক</span>
                    <span class="badge bg-warning text-dark font-weight-bold" style="font-size: 11px;">অটো-ইনসার্ট সক্রিয়</span>
                </div>
                <div class="d-flex align-items-center gap-2 bg-white p-2 rounded-3 text-dark mb-2">
                    <i class="ti ti-link text-primary fs-5 ms-1"></i>
                    <input type="text" id="playbookRefLinkInput" class="form-control border-0 font-monospace text-dark font-weight-bold px-1" value="{{ $agent->referral_url }}" readonly style="font-size: 13px; background: transparent;">
                    <button type="button" class="btn btn-primary btn-sm px-3 font-weight-bold text-nowrap rounded-2" onclick="copyToolkitHeroLink(this)">
                        <i class="ti ti-copy"></i> <span>কপি</span>
                    </button>
                </div>
                <small class="text-white-50 text-xs d-block">
                    💡 নিচের যেকোনো স্ক্রিপ্ট কপি করলে এই লিংকটি স্বয়ংক্রিয়ভাবে যুক্ত থাকবে।
                </small>
            </div>
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- CATEGORY NAVIGATION TABS & SEARCH              -->
<!-- ============================================== -->
<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <ul class="nav nav-pills gap-2 flex-wrap mb-0" id="toolkitTabs" role="tablist">
        <li class="nav-item">
            <button class="toolkit-tab-btn active" id="inbox-tab" data-bs-toggle="pill" data-bs-target="#inbox-pane" type="button" role="tab">
                <i class="ti ti-message-circle fs-5"></i>
                <span>{{ __('ইনবক্স পিচ স্ক্রিপ্ট') }}</span>
                <span class="tab-counter-badge badge rounded-pill ms-1" style="background: #ffffff; color: #4338ca;">{{ $inboxScripts->count() }}</span>
            </button>
        </li>
        <li class="nav-item">
            <button class="toolkit-tab-btn" id="comment-tab" data-bs-toggle="pill" data-bs-target="#comment-pane" type="button" role="tab">
                <i class="ti ti-messages fs-5"></i>
                <span>{{ __('গ্রুপ ও কমেন্ট ফর্মুলা') }}</span>
                <span class="tab-counter-badge badge rounded-pill ms-1" style="background: #e2e8f0; color: #475569;">{{ $commentScripts->count() }}</span>
            </button>
        </li>
        <li class="nav-item">
            <button class="toolkit-tab-btn" id="objection-tab" data-bs-toggle="pill" data-bs-target="#objection-pane" type="button" role="tab">
                <i class="ti ti-shield-check fs-5"></i>
                <span>{{ __('আপত্তি হ্যান্ডলিং FAQ') }}</span>
                <span class="tab-counter-badge badge rounded-pill ms-1" style="background: #e2e8f0; color: #475569;">{{ $objections->count() }}</span>
            </button>
        </li>
        <li class="nav-item">
            <button class="toolkit-tab-btn" id="guide-tab" data-bs-toggle="pill" data-bs-target="#guide-pane" type="button" role="tab">
                <i class="ti ti-school fs-5"></i>
                <span>{{ __('৪-ধাপের মার্কেটিং গাইড') }}</span>
                <span class="tab-counter-badge badge rounded-pill ms-1" style="background: #e2e8f0; color: #475569;">{{ $guides->count() }}</span>
            </button>
        </li>
        <li class="nav-item">
            <button class="toolkit-tab-btn" id="media-tab" data-bs-toggle="pill" data-bs-target="#media-pane" type="button" role="tab">
                <i class="ti ti-photo-video fs-5"></i>
                <span>{{ __('সোশ্যাল ব্যানার ও ক্যাপশন') }}</span>
                <span class="tab-counter-badge badge rounded-pill ms-1" style="background: #e2e8f0; color: #475569;">{{ $banners->count() + $videoGuides->count() }}</span>
            </button>
        </li>
    </ul>

    <!-- Live Realtime Filter Search -->
    <div class="toolkit-search-box">
        <i class="ti ti-search"></i>
        <input type="text" id="scriptSearchInput" placeholder="স্ক্রিপ্ট বা কীওয়ার্ড খুঁজুন (যেমন: শপিফাই, বিকাশ, পোশাক)..." onkeyup="filterScriptsRealtime()">
    </div>
</div>

<!-- ============================================== -->
<!-- TAB CONTENT PANES                              -->
<!-- ============================================== -->
<div class="tab-content" id="toolkitTabsContent">

    <!-- ============================================== -->
    <!-- 1. INBOX SCRIPTS PANE                          -->
    <!-- ============================================== -->
    <div class="tab-pane fade show active" id="inbox-pane" role="tabpanel">
        <div class="row g-4" id="inboxScriptContainer">
            @forelse($inboxScripts as $res)
            <div class="col-lg-6 script-item-card" data-title="{{ strtolower($res->title) }}" data-content="{{ strtolower($res->content_text) }}">
                <div class="script-modern-card">
                    <div class="script-header d-flex justify-content-between align-items-start gap-2">
                        <div>
                            <h6 class="font-weight-bold text-dark mb-1" style="font-size: 15px;">{{ $res->title }}</h6>
                            <small class="text-muted"><i class="ti ti-brand-facebook text-primary me-1"></i> ফেসবুক পেজ ইনবক্স ও মেসেঞ্জারে সরাসরি ব্যবহারের জন্য</small>
                        </div>
                        @if($res->badge)
                            <span class="badge-pill-tag flex-shrink-0" style="background: #eef2ff; color: #4338ca; border: 1px solid #c7d2fe;">
                                {{ $res->badge }}
                            </span>
                        @endif
                    </div>

                    <div class="script-body-wrapper">
                        <div class="script-copy-box">
                            {{ $res->personalized_content ?? $res->content_text }}
                        </div>
                    </div>

                    <div class="script-footer-actions">
                        <small class="text-muted d-flex align-items-center gap-1">
                            <i class="ti ti-link text-primary fs-5"></i> <span>রেফারেল লিংক অটো-যুক্ত</span>
                        </small>
                        <div class="d-flex align-items-center gap-2">
                            @php
                                $encodedText = urlencode($res->personalized_content ?? $res->content_text);
                            @endphp
                            <a href="https://api.whatsapp.com/send?text={{ $encodedText }}" target="_blank" class="btn btn-sm btn-whatsapp-direct" title="হোয়াটসঅ্যাপে পাঠান">
                                <i class="ti ti-brand-whatsapp"></i> <span>WhatsApp</span>
                            </a>
                            <button type="button" class="btn btn-primary btn-sm px-3 rounded-pill font-weight-bold d-inline-flex align-items-center gap-1" onclick="copyTextToClipboard(`{{ addslashes($res->personalized_content ?? $res->content_text) }}`, this)">
                                <i class="ti ti-copy"></i> <span>কপি করুন</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5 text-muted">কোনো ইনবক্স স্ক্রিপ্ট পাওয়া যায়নি।</div>
            @endforelse
        </div>
    </div>

    <!-- ============================================== -->
    <!-- 2. COMMENT SCRIPTS PANE                        -->
    <!-- ============================================== -->
    <div class="tab-pane fade" id="comment-pane" role="tabpanel">
        <div class="row g-4" id="commentScriptContainer">
            @forelse($commentScripts as $res)
            <div class="col-lg-6 script-item-card" data-title="{{ strtolower($res->title) }}" data-content="{{ strtolower($res->content_text) }}">
                <div class="script-modern-card">
                    <div class="script-header d-flex justify-content-between align-items-start gap-2">
                        <div>
                            <h6 class="font-weight-bold text-dark mb-1" style="font-size: 15px;">{{ $res->title }}</h6>
                            <small class="text-muted"><i class="ti ti-users text-info me-1"></i> ফেসবুক গ্রুপ ও কমেন্টে ভ্যালু ড্রাইভেন পিচ</small>
                        </div>
                        @if($res->badge)
                            <span class="badge-pill-tag flex-shrink-0" style="background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd;">
                                {{ $res->badge }}
                            </span>
                        @endif
                    </div>

                    <div class="script-body-wrapper">
                        <div class="script-copy-box">
                            {{ $res->personalized_content ?? $res->content_text }}
                        </div>
                    </div>

                    <div class="script-footer-actions">
                        <small class="text-muted d-flex align-items-center gap-1">
                            <i class="ti ti-info-circle text-info fs-5"></i> <span>গ্রুপে স্প্যাম না করে পরামর্শ হিসেবে পোস্ট করুন</span>
                        </small>
                        <button type="button" class="btn btn-primary btn-sm px-3 rounded-pill font-weight-bold d-inline-flex align-items-center gap-1" onclick="copyTextToClipboard(`{{ addslashes($res->personalized_content ?? $res->content_text) }}`, this)">
                            <i class="ti ti-copy"></i> <span>কপি করুন</span>
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5 text-muted">কোনো কমেন্ট স্ক্রিপ্ট পাওয়া যায়নি।</div>
            @endforelse
        </div>
    </div>

    <!-- ============================================== -->
    <!-- 3. OBJECTION HANDLING FAQ PANE                 -->
    <!-- ============================================== -->
    <div class="tab-pane fade" id="objection-pane" role="tabpanel">
        <div class="row g-4" id="objectionContainer">
            @forelse($objections as $res)
            <div class="col-lg-6 script-item-card" data-title="{{ strtolower($res->title) }}" data-content="{{ strtolower($res->content_text) }}">
                <div class="objection-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-3 bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center flex-shrink-0" style="width: 38px; height: 38px; font-size: 18px;">
                                <i class="ti ti-shield-check"></i>
                            </div>
                            <h6 class="font-weight-bold text-dark mb-0" style="font-size: 15px;">{{ $res->title }}</h6>
                        </div>
                        @if($res->badge)
                            <span class="badge-pill-tag flex-shrink-0" style="background: #dcfce7; color: #15803d; border: 1px solid #86efac;">
                                {{ $res->badge }}
                            </span>
                        @endif
                    </div>

                    <div class="script-copy-box mb-3" style="background: #f0fdf4; border-color: #bbf7d0;">
                        {{ $res->personalized_content ?? $res->content_text }}
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top">
                        <small class="text-muted"><i class="ti ti-check text-success me-1"></i> কাস্টমারকে কনভিন্স করার সঠিক উত্তর</small>
                        <button type="button" class="btn btn-success btn-sm px-3 rounded-pill font-weight-bold d-inline-flex align-items-center gap-1 shadow-sm" onclick="copyTextToClipboard(`{{ addslashes($res->personalized_content ?? $res->content_text) }}`, this)">
                            <i class="ti ti-copy"></i> <span>উত্তর কপি করুন</span>
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5 text-muted">কোনো আপত্তি হ্যান্ডলিং তথ্য পাওয়া যায়নি।</div>
            @endforelse
        </div>
    </div>

    <!-- ============================================== -->
    <!-- 4. STEP-BY-STEP AGENT PLAYBOOK GUIDES          -->
    <!-- ============================================== -->
    <div class="tab-pane fade" id="guide-pane" role="tabpanel">
        <div class="row g-4" id="guideContainer">
            @forelse($guides as $index => $res)
            <div class="col-lg-6 script-item-card" data-title="{{ strtolower($res->title) }}" data-content="{{ strtolower($res->content_text) }}">
                <div class="guide-step-card">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="guide-step-number" style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);">
                            {{ $loop->iteration }}
                        </div>
                        <div>
                            <h5 class="font-weight-bold text-dark mb-1" style="font-size: 16px;">{{ $res->title }}</h5>
                            <span class="badge-pill-tag" style="background: #fdf4ff; color: #a21caf; border: 1px solid #f0abfc;">
                                {{ $res->badge ?? 'স্ট্র্যাটেজিক গাইডলাইন' }}
                            </span>
                        </div>
                    </div>

                    <div class="script-copy-box" style="background: #ffffff; border-color: #e2e8f0; font-size: 14px;">
                        {{ $res->personalized_content ?? $res->content_text }}
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5 text-muted">কোনো মার্কেটিং গাইড পাওয়া যায়নি।</div>
            @endforelse
        </div>
    </div>

    <!-- ============================================== -->
    <!-- 5. SOCIAL MEDIA BANNERS & CAPTIONS             -->
    <!-- ============================================== -->
    <div class="tab-pane fade" id="media-pane" role="tabpanel">
        <!-- Ready Post Captions Box -->
        <div class="card p-4 rounded-4 mb-4" style="border: 1px solid var(--agent-border); background: #ffffff;">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-3 bg-warning bg-opacity-10 text-warning d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                        <i class="ti ti-speakerphone fs-4"></i>
                    </div>
                    <div>
                        <h6 class="font-weight-bold text-dark mb-0">রেডিমেড সোশ্যাল মিডিয়া পোস্ট ক্যাপশন</h6>
                        <small class="text-muted">আপনার ফেসবুক প্রোফাইল, পেজ বা গ্রুপে ব্যানারসহ পোস্ট করার জন্য তৈরি ক্যাপশন</small>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-primary px-3 rounded-pill font-weight-bold" onclick="copyReadyPostCaption(this)">
                    <i class="ti ti-copy me-1"></i> পুরো ক্যাপশন কপি করুন
                </button>
            </div>

            <div class="p-3 rounded-3 bg-light border font-monospace text-dark text-sm" id="readyPostCaptionBox" style="line-height: 1.8; white-space: pre-wrap;">
ফেসবুক ইনবক্সে মেসেজ রিপ্লাই দিতে দিতে ক্লান্ত? আর কাস্টমার ড্রপ নয়! 🛑

দেশীয় সেরা ই-কমার্স প্ল্যাটফর্ম edokanpro দিয়ে আজই মাত্র ৫ মিনিটে চালু করুন আপনার নিজস্ব অনলাইন শপ।
✅ ১-ক্লিকে বিকাশ ও নগদ অটোমেটিক পেমেন্ট
✅ পাঠাও ও স্টিডফাস্ট কুরিয়ারে ১-ক্লিকে পার্সেল বুকিং
✅ কোনো কোডিং বা টেকনিক্যাল জ্ঞানের ঝামেলা নেই

সম্পূর্ণ ফ্রিতে এখনই ট্রায়াল নিয়ে আপনার শপ রেডি করুন:
👉 {{ $agent->referral_url }}

#edokanpro #fcommerce #onlinebusinessbd #clothingbd #onlineshopbd #entrepreneurbd #dhakagram</div>
        </div>

        <!-- Banners Row -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <h5 class="font-weight-bold text-dark mb-2 d-flex align-items-center gap-2">
                    <i class="ti ti-photo text-primary"></i>
                    <span>{{ __('অফিসিয়াল প্রমোশনাল ব্যানার ও গ্রাফিক্স') }}</span>
                </h5>
            </div>

            @forelse($banners as $banner)
            <div class="col-md-6 col-lg-6">
                <div class="script-modern-card p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h6 class="font-weight-bold text-dark mb-1">{{ $banner->title }}</h6>
                            <small class="text-muted">সোশ্যাল মিডিয়ায় ব্যবহারের জন্য অপ্টিমাইজড</small>
                        </div>
                        <span class="badge-pill-tag" style="background: #eef2ff; color: #4338ca; border: 1px solid #c7d2fe;">
                            {{ $banner->badge ?? 'ব্যানার' }}
                        </span>
                    </div>

                    <div class="rounded-3 bg-light p-4 mb-3 border d-flex flex-column align-items-center justify-content-center text-center" style="min-height: 160px; background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
                        <i class="ti ti-photo fs-1 text-primary mb-2"></i>
                        <span class="badge bg-white text-dark border px-3 py-1 rounded-pill font-weight-bold">{{ $banner->title }}</span>
                        <small class="text-muted mt-2">১০৮০x১০৮০ পিক্সেলে ডাউনলোড হবে</small>
                    </div>

                    <div class="script-copy-box mb-3 text-xs" style="font-size: 13px;">
                        {{ $banner->personalized_content ?? $banner->content_text }}
                    </div>

                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-primary btn-sm flex-grow-1 rounded-pill font-weight-bold" onclick="copyTextToClipboard(`{{ addslashes($banner->personalized_content ?? $banner->content_text) }}`, this)">
                            <i class="ti ti-copy me-1"></i> ক্যাপশন কপি
                        </button>
                        <a href="{{ $banner->media_url }}" download class="btn btn-primary btn-sm px-4 rounded-pill font-weight-bold">
                            <i class="ti ti-download me-1"></i> ডাউনলোড
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-4 text-muted">কোনো ব্যানার পাওয়া যায়নি।</div>
            @endforelse
        </div>

        <!-- Video Masterclass Guides -->
        @if($videoGuides->count() > 0)
        <div class="row g-4">
            <div class="col-12">
                <h5 class="font-weight-bold text-dark mb-2 d-flex align-items-center gap-2">
                    <i class="ti ti-video text-danger"></i>
                    <span>{{ __('এজেন্ট ভিডিও ট্রেনিং ও ডেমো গাইড') }}</span>
                </h5>
            </div>

            @foreach($videoGuides as $video)
            <div class="col-md-6">
                <div class="script-modern-card p-4">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="font-weight-bold text-dark mb-1">{{ $video->title }}</h6>
                        <span class="badge bg-danger bg-opacity-10 text-danger font-weight-bold px-2 py-1 rounded-pill text-xs">ভিডিও</span>
                    </div>
                    <p class="text-muted text-xs mb-3">{{ $video->content_text }}</p>
                    <div class="ratio ratio-16x9 rounded-3 overflow-hidden border shadow-sm">
                        <iframe src="{{ $video->media_url }}" title="{{ $video->title }}" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

</div>

@push('custom-script')
<script>
// Copy Hero Referral Link
function copyToolkitHeroLink(btn) {
    var linkInput = document.getElementById('playbookRefLinkInput');
    navigator.clipboard.writeText(linkInput.value).then(function() {
        var original = btn.innerHTML;
        btn.innerHTML = '<i class="ti ti-check"></i> কপিকৃত!';
        btn.classList.remove('btn-primary');
        btn.classList.add('btn-success');
        setTimeout(function() {
            btn.innerHTML = original;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-primary');
        }, 1800);
    });
}

// Copy Ready Post Caption Box
function copyReadyPostCaption(btn) {
    var text = document.getElementById('readyPostCaptionBox').innerText;
    navigator.clipboard.writeText(text).then(function() {
        var original = btn.innerHTML;
        btn.innerHTML = '<i class="ti ti-check me-1"></i> ক্যাপশন কপিকৃত!';
        btn.classList.remove('btn-primary');
        btn.classList.add('btn-success');
        setTimeout(function() {
            btn.innerHTML = original;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-primary');
        }, 1800);
    });
}

// Realtime Keyword Search Filtering
function filterScriptsRealtime() {
    var query = document.getElementById('scriptSearchInput').value.toLowerCase().trim();
    var allCards = document.querySelectorAll('.script-item-card');

    allCards.forEach(function(card) {
        if (!query) {
            card.style.display = '';
            return;
        }
        var title = card.getAttribute('data-title') || '';
        var content = card.getAttribute('data-content') || '';
        if (title.includes(query) || content.includes(query)) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
}

// Auto-switch tab based on URL hash
document.addEventListener('DOMContentLoaded', function() {
    var hash = window.location.hash;
    if (hash) {
        var triggerEl = document.querySelector('button[data-bs-target="' + hash + '"]');
        if (triggerEl) {
            var tab = new bootstrap.Tab(triggerEl);
            tab.show();
        }
    }

    // Update URL hash on tab change
    var tabButtons = document.querySelectorAll('button[data-bs-toggle="pill"]');
    tabButtons.forEach(function(btn) {
        btn.addEventListener('shown.bs.tab', function(e) {
            var target = e.target.getAttribute('data-bs-target');
            if (window.history.replaceState) {
                window.history.replaceState(null, null, target);
            }
        });
    });
});
</script>
@endpush

@endsection
