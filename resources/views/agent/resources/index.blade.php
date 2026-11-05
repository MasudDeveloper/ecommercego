@extends('agent.layouts.app')

@section('page-title')
    {{ __('মার্কেটিং টুলকিট ও স্ক্রিপ্ট প্লেবুক') }}
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h3 class="font-weight-bold mb-1 d-flex align-items-center gap-2">
            <i class="ti ti-bookmarks text-success fs-2"></i> {{ __('মার্কেটিং টুলকিট ও কপি স্ক্রিপ্ট প্লেবুক') }}
        </h3>
        <p class="text-muted mb-0">
            ফেসবুক উদ্যোক্তাদের সাথে সফলভাবে যোগাযোগ ও কনভার্ট করার জন্য রেডিমেড কপি স্ক্রিপ্ট। প্রতিটি স্ক্রিপ্টে আপনার নিজস্ব রেফারেল লিংক অটো যুক্ত রয়েছে—শুধু কপি করে পেস্ট করুন!
        </p>
    </div>
</div>

<!-- Nav Tabs -->
<ul class="nav nav-pills mb-4 gap-2" id="resourceTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active d-flex align-items-center gap-1 font-weight-bold" id="inbox-tab" data-bs-toggle="pill" data-bs-target="#inbox-pane" type="button" role="tab">
            <i class="ti ti-message-circle fs-5"></i> {{ __('ইনবক্স পিচ স্ক্রিপ্ট') }} ({{ $inboxScripts->count() }})
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link d-flex align-items-center gap-1 font-weight-bold" id="comment-tab" data-bs-toggle="pill" data-bs-target="#comment-pane" type="button" role="tab">
            <i class="ti ti-messages fs-5"></i> {{ __('কমেন্ট ও গ্রুপ স্ক্রিপ্ট') }} ({{ $commentScripts->count() }})
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link d-flex align-items-center gap-1 font-weight-bold" id="objection-tab" data-bs-toggle="pill" data-bs-target="#objection-pane" type="button" role="tab">
            <i class="ti ti-shield-check fs-5"></i> {{ __('আপত্তি হ্যান্ডলিং (FAQ)') }} ({{ $objections->count() }})
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link d-flex align-items-center gap-1 font-weight-bold" id="media-tab" data-bs-toggle="pill" data-bs-target="#media-pane" type="button" role="tab">
            <i class="ti ti-photo fs-5"></i> {{ __('ব্যানার ও ভিডিও গাইড') }} ({{ $banners->count() + $videoGuides->count() }})
        </button>
    </li>
</ul>

<!-- Tab Content Panes -->
<div class="tab-content" id="resourceTabsContent">

    <!-- 1. Inbox Scripts -->
    <div class="tab-pane fade show active" id="inbox-pane" role="tabpanel">
        <div class="row g-4">
            @forelse($inboxScripts as $res)
            <div class="col-lg-6">
                <div class="card stat-card h-100">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 font-weight-bold text-dark">{{ $res->title }}</h6>
                        @if($res->badge)
                            <span class="badge bg-light-primary text-primary">{{ $res->badge }}</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="script-box">
                            <button type="button" class="btn btn-xs btn-outline-primary btn-copy-code d-flex align-items-center gap-1" onclick="copyTextToClipboard(`{{ addslashes($res->personalized_content ?? $res->content_text) }}`, this)">
                                <i class="ti ti-copy"></i> <span>কপি করুন</span>
                            </button>
                            <span class="text-dark">{{ $res->personalized_content ?? $res->content_text }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-4 text-muted">কোনো ইনবক্স স্ক্রিপ্ট পাওয়া যায়নি।</div>
            @endforelse
        </div>
    </div>

    <!-- 2. Comment Scripts -->
    <div class="tab-pane fade" id="comment-pane" role="tabpanel">
        <div class="row g-4">
            @forelse($commentScripts as $res)
            <div class="col-lg-6">
                <div class="card stat-card h-100">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 font-weight-bold text-dark">{{ $res->title }}</h6>
                        @if($res->badge)
                            <span class="badge bg-light-info text-info">{{ $res->badge }}</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="script-box">
                            <button type="button" class="btn btn-xs btn-outline-primary btn-copy-code d-flex align-items-center gap-1" onclick="copyTextToClipboard(`{{ addslashes($res->personalized_content ?? $res->content_text) }}`, this)">
                                <i class="ti ti-copy"></i> <span>কপি করুন</span>
                            </button>
                            <span class="text-dark">{{ $res->personalized_content ?? $res->content_text }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-4 text-muted">কোনো কমেন্ট স্ক্রিপ্ট পাওয়া যায়নি।</div>
            @endforelse
        </div>
    </div>

    <!-- 3. Objection Handling -->
    <div class="tab-pane fade" id="objection-pane" role="tabpanel">
        <div class="row g-4">
            @forelse($objections as $res)
            <div class="col-lg-6">
                <div class="card stat-card h-100 border-start border-4 border-success">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 font-weight-bold text-dark">{{ $res->title }}</h6>
                        @if($res->badge)
                            <span class="badge bg-light-success text-success">{{ $res->badge }}</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="script-box bg-light-success bg-opacity-25">
                            <button type="button" class="btn btn-xs btn-outline-success btn-copy-code d-flex align-items-center gap-1" onclick="copyTextToClipboard(`{{ addslashes($res->personalized_content ?? $res->content_text) }}`, this)">
                                <i class="ti ti-copy"></i> <span>উত্তর কপি</span>
                            </button>
                            <span class="text-dark">{{ $res->personalized_content ?? $res->content_text }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-4 text-muted">কোনো আপত্তি হ্যান্ডলিং তথ্য পাওয়া যায়নি।</div>
            @endforelse
        </div>
    </div>

    <!-- 4. Banners & Video Guides -->
    <div class="tab-pane fade" id="media-pane" role="tabpanel">
        <h5 class="font-weight-bold mb-3"><i class="ti ti-photo text-primary me-1"></i> {{ __('প্রমোশনাল সোশ্যাল ব্যানার') }}</h5>
        <div class="row g-4 mb-4">
            @forelse($banners as $banner)
            <div class="col-md-6 col-lg-4">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="bg-light rounded-3 p-4 text-center mb-3 border">
                            <i class="ti ti-photo fs-1 text-primary mb-2 d-block"></i>
                            <span class="badge bg-primary">{{ $banner->badge ?? 'ব্যানার টেমপ্লেট' }}</span>
                        </div>
                        <h6 class="font-weight-bold mb-1">{{ $banner->title }}</h6>
                        <p class="text-muted text-xs mb-3">{{ $banner->content_text }}</p>
                        <a href="{{ $banner->media_url }}" download class="btn btn-sm btn-outline-primary w-100">
                            <i class="ti ti-download"></i> {{ __('ব্যানার ডাউনলোড') }}
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-muted">কোনো ব্যানার পাওয়া যায়নি।</div>
            @endforelse
        </div>

        <h5 class="font-weight-bold mb-3"><i class="ti ti-video text-danger me-1"></i> {{ __('ভিডিও প্রশিক্ষণ ও টিউটোরিয়াল') }}</h5>
        <div class="row g-4">
            @forelse($videoGuides as $video)
            <div class="col-md-6">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <div class="ratio ratio-16x9 rounded-3 overflow-hidden mb-3 border">
                            <iframe src="{{ $video->media_url }}" title="{{ $video->title }}" allowfullscreen></iframe>
                        </div>
                        <h6 class="font-weight-bold mb-1">{{ $video->title }}</h6>
                        <p class="text-muted text-sm mb-0">{{ $video->content_text }}</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-muted">কোনো ভিডিও গাইড পাওয়া যায়নি।</div>
            @endforelse
        </div>
    </div>

</div>
@endsection
