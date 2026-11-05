@extends('agent.layouts.app')

@section('page-title')
    {{ __('মার্কেটিং টুলকিট ও স্ক্রিপ্ট প্লেবুক') }}
@endsection

@push('custom-css')
<style>
    .toolkit-tab-btn {
        padding: 9px 20px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 14px;
        color: #64748b;
        background: #ffffff;
        border: 1px solid var(--agent-border);
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .toolkit-tab-btn:hover {
        color: #4f46e5;
        background: #f8fafc;
    }
    .toolkit-tab-btn.active {
        background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%) !important;
        color: #ffffff !important;
        border-color: transparent !important;
        box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);
    }
    .script-modern-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid var(--agent-border);
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.03);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    .script-modern-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.06);
    }
    .script-copy-body {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 18px;
        font-size: 14px;
        line-height: 1.7;
        color: #1e293b;
        white-space: pre-wrap;
        position: relative;
        flex-grow: 1;
    }
    .link-tag-highlight {
        background: #eef2ff;
        color: #4338ca;
        padding: 2px 6px;
        border-radius: 4px;
        font-weight: bold;
        border: 1px solid #c7d2fe;
    }
</style>
@endpush

@section('content')

<!-- Header Section -->
<div class="row align-items-center mb-4 g-3">
    <div class="col-lg-8">
        <h3 class="font-weight-bold text-dark mb-1 d-flex align-items-center gap-2">
            <span class="p-2 rounded-3 bg-success bg-opacity-10 text-success d-inline-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                <i class="ti ti-bookmarks fs-3"></i>
            </span>
            <span>{{ __('মার্কেটিং টুলকিট ও স্ক্রিপ্ট প্লেবুক') }}</span>
        </h3>
        <p class="text-muted mb-0">
            ফেসবুক উদ্যোক্তাদের কনভার্ট করার জন্য পরীক্ষিত কপি স্ক্রিপ্ট। প্রতিটি স্ক্রিপ্টে আপনার রেফারেল লিংক স্বয়ংক্রিয়ভাবে ইনপুট করা রয়েছে!
        </p>
    </div>
</div>

<!-- ============================================== -->
<!-- CATEGORY TABS                                  -->
<!-- ============================================== -->
<ul class="nav nav-pills mb-4 gap-2 flex-wrap" id="toolkitTabs" role="tablist">
    <li class="nav-item">
        <button class="toolkit-tab-btn active" id="inbox-tab" data-bs-toggle="pill" data-bs-target="#inbox-pane" type="button" role="tab">
            <i class="ti ti-message-circle fs-5"></i>
            <span>{{ __('ইনবক্স পিচ স্ক্রিপ্ট') }}</span>
            <span class="badge bg-white text-primary rounded-pill ms-1">{{ $inboxScripts->count() }}</span>
        </button>
    </li>
    <li class="nav-item">
        <button class="toolkit-tab-btn" id="comment-tab" data-bs-toggle="pill" data-bs-target="#comment-pane" type="button" role="tab">
            <i class="ti ti-messages fs-5"></i>
            <span>{{ __('গ্রুপ ও কমেন্ট ফর্মুলা') }}</span>
            <span class="badge bg-light text-muted rounded-pill ms-1">{{ $commentScripts->count() }}</span>
        </button>
    </li>
    <li class="nav-item">
        <button class="toolkit-tab-btn" id="objection-tab" data-bs-toggle="pill" data-bs-target="#objection-pane" type="button" role="tab">
            <i class="ti ti-shield-check fs-5"></i>
            <span>{{ __('আপত্তি হ্যান্ডলিং (Objection FAQ)') }}</span>
            <span class="badge bg-light text-muted rounded-pill ms-1">{{ $objections->count() }}</span>
        </button>
    </li>
    <li class="nav-item">
        <button class="toolkit-tab-btn" id="media-tab" data-bs-toggle="pill" data-bs-target="#media-pane" type="button" role="tab">
            <i class="ti ti-photo-video fs-5"></i>
            <span>{{ __('সোশ্যাল ব্যানার ও ভিডিও') }}</span>
            <span class="badge bg-light text-muted rounded-pill ms-1">{{ $banners->count() + $videoGuides->count() }}</span>
        </button>
    </li>
</ul>

<!-- ============================================== -->
<!-- TAB CONTENT PANES                              -->
<!-- ============================================== -->
<div class="tab-content" id="toolkitTabsContent">

    <!-- 1. INBOX SCRIPTS PANE -->
    <div class="tab-pane fade show active" id="inbox-pane" role="tabpanel">
        <div class="row g-4">
            @forelse($inboxScripts as $res)
            <div class="col-lg-6">
                <div class="script-modern-card p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h6 class="font-weight-bold text-dark mb-1">{{ $res->title }}</h6>
                            <small class="text-muted">ফেসবুক পেজ ও মেসেঞ্জারে সরাসরি ব্যবহারের জন্য</small>
                        </div>
                        @if($res->badge)
                            <span class="badge bg-primary bg-opacity-10 text-primary font-weight-bold px-3 py-1 rounded-pill" style="font-size: 11px;">
                                {{ $res->badge }}
                            </span>
                        @endif
                    </div>

                    <div class="script-copy-body mb-3">
                        {{ $res->personalized_content ?? $res->content_text }}
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-auto pt-2">
                        <small class="text-muted"><i class="ti ti-link text-primary me-1"></i> আপনার রেফারেল লিংক যুক্ত আছে</small>
                        <button type="button" class="btn btn-primary btn-sm px-3 rounded-pill font-weight-bold d-inline-flex align-items-center gap-1 shadow-sm" onclick="copyTextToClipboard(`{{ addslashes($res->personalized_content ?? $res->content_text) }}`, this)">
                            <i class="ti ti-copy"></i> <span>কপি করুন</span>
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5 text-muted">কোনো ইনবক্স স্ক্রিপ্ট পাওয়া যায়নি।</div>
            @endforelse
        </div>
    </div>

    <!-- 2. COMMENT SCRIPTS PANE -->
    <div class="tab-pane fade" id="comment-pane" role="tabpanel">
        <div class="row g-4">
            @forelse($commentScripts as $res)
            <div class="col-lg-6">
                <div class="script-modern-card p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h6 class="font-weight-bold text-dark mb-1">{{ $res->title }}</h6>
                            <small class="text-muted">ফেসবুক গ্রুপ ও পোস্টের কমেন্টে ভ্যালু ড্রাইভেন পিচ</small>
                        </div>
                        @if($res->badge)
                            <span class="badge bg-info bg-opacity-10 text-info font-weight-bold px-3 py-1 rounded-pill" style="font-size: 11px;">
                                {{ $res->badge }}
                            </span>
                        @endif
                    </div>

                    <div class="script-copy-body mb-3">
                        {{ $res->personalized_content ?? $res->content_text }}
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-auto pt-2">
                        <small class="text-muted"><i class="ti ti-info-circle text-info me-1"></i> গ্রুপে স্প্যাম না করে হেল্পফুলভাবে কমেন্ট করুন</small>
                        <button type="button" class="btn btn-outline-primary btn-sm px-3 rounded-pill font-weight-bold d-inline-flex align-items-center gap-1" onclick="copyTextToClipboard(`{{ addslashes($res->personalized_content ?? $res->content_text) }}`, this)">
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

    <!-- 3. OBJECTION HANDLING PANE -->
    <div class="tab-pane fade" id="objection-pane" role="tabpanel">
        <div class="row g-4">
            @forelse($objections as $res)
            <div class="col-lg-6">
                <div class="script-modern-card p-4 border-start border-4 border-success">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-success bg-opacity-10 text-success p-2 rounded-circle">
                                <i class="ti ti-shield-check fs-5"></i>
                            </span>
                            <h6 class="font-weight-bold text-dark mb-0">{{ $res->title }}</h6>
                        </div>
                        @if($res->badge)
                            <span class="badge bg-success bg-opacity-10 text-success font-weight-bold px-2 py-1 rounded-pill" style="font-size: 11px;">
                                {{ $res->badge }}
                            </span>
                        @endif
                    </div>

                    <div class="script-copy-body bg-light-success bg-opacity-10 mb-3" style="border-color: rgba(34, 197, 94, 0.2);">
                        {{ $res->personalized_content ?? $res->content_text }}
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-auto pt-2">
                        <small class="text-muted">কাস্টমারকে কনভিন্স করার সঠিক বাংলা উত্তর</small>
                        <button type="button" class="btn btn-success btn-sm px-3 rounded-pill font-weight-bold d-inline-flex align-items-center gap-1 shadow-sm" onclick="copyTextToClipboard(`{{ addslashes($res->personalized_content ?? $res->content_text) }}`, this)">
                            <i class="ti ti-copy"></i> <span>উত্তর কপি</span>
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5 text-muted">কোনো আপত্তি হ্যান্ডলিং তথ্য পাওয়া যায়নি।</div>
            @endforelse
        </div>
    </div>

    <!-- 4. MEDIA & BANNERS PANE -->
    <div class="tab-pane fade" id="media-pane" role="tabpanel">
        <div class="row g-4 mb-4">
            <div class="col-12">
                <h5 class="font-weight-bold text-dark mb-3 d-flex align-items-center gap-2">
                    <i class="ti ti-photo text-primary"></i>
                    <span>{{ __('সোশ্যাল মিডিয়া প্রমোশনাল ব্যানার') }}</span>
                </h5>
            </div>

            @forelse($banners as $banner)
            <div class="col-md-6 col-lg-4">
                <div class="script-modern-card p-4 text-center">
                    <div class="rounded-3 bg-light p-4 mb-3 border d-flex flex-column align-items-center justify-content-center" style="height: 180px;">
                        <i class="ti ti-photo fs-1 text-primary mb-2"></i>
                        <span class="badge bg-primary px-3 py-1 rounded-pill">{{ $banner->badge ?? 'ব্যানার টেমপ্লেট' }}</span>
                    </div>
                    <h6 class="font-weight-bold text-dark mb-2">{{ $banner->title }}</h6>
                    <p class="text-muted text-xs mb-3">{{ $banner->content_text }}</p>
                    <a href="{{ $banner->media_url }}" download class="btn btn-outline-primary btn-sm rounded-pill w-100 font-weight-bold">
                        <i class="ti ti-download me-1"></i> {{ __('ব্যানার ডাউনলোড') }}
                    </a>
                </div>
            </div>
            @empty
            <div class="col-12 text-muted">কোনো ব্যানার পাওয়া যায়নি।</div>
            @endforelse
        </div>

        <div class="row g-4">
            <div class="col-12">
                <h5 class="font-weight-bold text-dark mb-3 d-flex align-items-center gap-2">
                    <i class="ti ti-video text-danger"></i>
                    <span>{{ __('ভিডিও ট্রেনিং ও লাইভ ডেমো') }}</span>
                </h5>
            </div>

            @forelse($videoGuides as $video)
            <div class="col-md-6">
                <div class="script-modern-card p-4">
                    <div class="ratio ratio-16x9 rounded-3 overflow-hidden mb-3 border shadow-sm">
                        <iframe src="{{ $video->media_url }}" title="{{ $video->title }}" allowfullscreen></iframe>
                    </div>
                    <h6 class="font-weight-bold text-dark mb-1">{{ $video->title }}</h6>
                    <p class="text-muted text-sm mb-0">{{ $video->content_text }}</p>
                </div>
            </div>
            @empty
            <div class="col-12 text-muted">কোনো ভিডিও টিউটোরিয়াল পাওয়া যায়নি।</div>
            @endforelse
        </div>
    </div>

</div>

@endsection
