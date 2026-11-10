@extends('layouts.app')

@section('page-title', __('Dashboard'))

@section('action-button')
@endsection

@section('breadcrumb')
@endsection

@php
$setting = getAdminAllSetting();
    $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users text-blue-500 h-6 w-6"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>';
    $customer_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-plus text-blue-500 h-6 w-6"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>';
    $pending_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock text-blue-500 h-6 w-6"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>';
    $return_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-rotate-ccw text-blue-500 h-6 w-6"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path><path d="M3 3v5h5"></path></svg>';
    $confirmed_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-circle text-blue-500 h-6 w-6"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>';
    $cancel_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-circle text-blue-500 h-6 w-6"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>';
    $shipped_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-truck text-blue-500 h-6 w-6"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>';
    $delivered_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package w-6 h-6 text-primary" data-replit-metadata="client/src/components/dashboard/StatsGrid.tsx:85:18" data-component-name="Icon"><path d="M11 21.73a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73z"></path><path d="M12 22V12"></path><path d="m3.3 7 7.703 4.734a2 2 0 0 0 1.994 0L20.7 7"></path><path d="m7.5 4.27 9 5.15"></path></svg>';
    $total_order_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart text-blue-500 h-6 w-6"><circle cx="8" cy="21" r="1"></circle><circle cx="19" cy="21" r="1"></circle><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path></svg>';
@endphp

@section('content')
<div class="row">
    <!-- [ sample-page ] start -->
    <div class="col-12">

        {{-- Merchant Onboarding 3-Step Wizard --}}
        @php
            $currStoreId = getCurrentStore() ?: 1;
            $totalProducts = \App\Models\Product::where('store_id', $currStoreId)->count();
            $isProfileDone = !empty($store->name);
            $isThemeDone = !empty(APP_THEME());
            $isProductDone = $totalProducts > 0;
            
            $completedSteps = ($isProfileDone ? 1 : 0) + ($isThemeDone ? 1 : 0) + ($isProductDone ? 1 : 0);
            $progressPct = round(($completedSteps / 3) * 100);
        @endphp

        <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: #ffffff; border-radius: 16px;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
                    <div>
                        <span class="badge bg-primary px-3 py-1 mb-2 font-weight-bold" style="border-radius: 20px;">
                            🚀 মার্চেন্ট সাকসেস হাব
                        </span>
                        <h4 class="text-white font-weight-bold mb-1">৩-ধাপে আপনার স্টোর শুরু করুন</h4>
                        <p class="text-white-50 text-sm mb-0">মাত্র কয়েক মিনিটেই আপনার অনলাইন ব্যবসা ও ল্যান্ডিং পেজ সম্পূর্ণ প্রস্তুত করে ফেলুন</p>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-warning font-weight-bold px-3 py-2 d-flex align-items-center gap-2 rounded-pill shadow-sm text-dark" data-bs-toggle="modal" data-bs-target="#videoTutorialModal">
                            <span>🎥</span> <span>ভিডিও টিউটোরিয়াল ও হেল্প সেন্টার</span>
                        </button>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between text-xs text-white-50 mb-1 font-weight-bold">
                        <span>স্টোর সেটআপ প্রোগ্রেস</span>
                        <span class="text-warning">{{ $progressPct }}% সম্পন্ন</span>
                    </div>
                    <div class="progress" style="height: 10px; border-radius: 10px; background: rgba(255,255,255,0.15);">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $progressPct }}%; border-radius: 10px;"></div>
                    </div>
                </div>

                <!-- 3 Steps Grid -->
                <div class="row g-3">
                    <!-- Step 1 -->
                    <div class="col-md-4">
                        <div class="p-3 rounded-3 d-flex align-items-center justify-content-between" style="background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.1);">
                            <div>
                                <div class="text-xs text-white-50 font-weight-bold">ধাপ ১: শপ প্রোফাইল</div>
                                <div class="text-white font-weight-bold text-sm">শপের নাম ও মোবাইল সেট করুন</div>
                            </div>
                            <span class="badge {{ $isProfileDone ? 'bg-success' : 'bg-secondary' }} rounded-circle p-2">
                                <i class="ti ti-{{ $isProfileDone ? 'check' : 'clock' }} fs-5"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="col-md-4">
                        <div class="p-3 rounded-3 d-flex align-items-center justify-content-between" style="background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.1);">
                            <div>
                                <div class="text-xs text-white-50 font-weight-bold">ধাপ ২: ল্যান্ডিং পেজ থিম</div>
                                <div class="text-white font-weight-bold text-sm">পছন্দের প্রিমিয়াম থিম সিলেক্ট করুন</div>
                            </div>
                            @if($isThemeDone)
                                <span class="badge bg-success rounded-circle p-2"><i class="ti ti-check fs-5"></i></span>
                            @else
                                <a href="{{ route('theme.index') }}" class="btn btn-sm btn-outline-warning rounded-pill">সিলেক্ট করুন</a>
                            @endif
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="col-md-4">
                        <div class="p-3 rounded-3 d-flex align-items-center justify-content-between" style="background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.1);">
                            <div>
                                <div class="text-xs text-white-50 font-weight-bold">ধাপ ৩: প্রথম প্রোডাক্ট</div>
                                <div class="text-white font-weight-bold text-sm">বিক্রির জন্য ১ম প্রোডাক্ট যোগ করুন</div>
                            </div>
                            @if($isProductDone)
                                <span class="badge bg-success rounded-circle p-2"><i class="ti ti-check fs-5"></i></span>
                            @else
                                <a href="{{ route('product.create') }}" class="btn btn-sm btn-warning font-weight-bold rounded-pill text-dark">প্রোডাক্ট যোগ করুন</a>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Video Guide Modal -->
        <div class="modal fade" id="videoTutorialModal" tabindex="-1" aria-labelledby="videoTutorialModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <div class="modal-header bg-gradient-primary text-white" style="background: linear-gradient(135deg, #1e3a8a, #3b82f6); border-radius: 16px 16px 0 0;">
                        <h5 class="modal-title text-white font-weight-bold" id="videoTutorialModalLabel">
                            <i class="ti ti-video me-1"></i> বাংলা ভিডিও টিউটোরিয়াল ও মার্চেন্ট হেল্প সেন্টার
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card h-100 border rounded-3 p-3 hover-shadow">
                                    <div class="d-flex align-items-center gap-3 mb-2">
                                        <div class="bg-primary text-white p-2 rounded-3 fs-4">
                                            <i class="ti ti-layout-dashboard"></i>
                                        </div>
                                        <div>
                                            <h6 class="font-weight-bold mb-0">১. ল্যান্ডিং পেজ সেটআপ</h6>
                                            <small class="text-muted">সময়: ৩ মিনিট ২০ সেকেন্ড</small>
                                        </div>
                                    </div>
                                    <p class="text-muted text-xs mb-3">কীভাবে ১ ক্লিকে প্রিমিয়াম সিঙ্গেল প্রোডাক্ট ল্যান্ডিং পেজ লাইভ করবেন এবং ছবি ও মূল্য পরিবর্তন করবেন।</p>
                                    <a href="https://www.youtube.com/results?search_query=ecommerce+landing+page+setup" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill font-weight-bold">
                                        <i class="ti ti-player-play"></i> ভিডিও দেখুন
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card h-100 border rounded-3 p-3 hover-shadow">
                                    <div class="d-flex align-items-center gap-3 mb-2">
                                        <div class="bg-success text-white p-2 rounded-3 fs-4">
                                            <i class="ti ti-truck"></i>
                                        </div>
                                        <div>
                                            <h6 class="font-weight-bold mb-0">২. কুরিয়ার অটোমেশন</h6>
                                            <small class="text-muted">সময়: ২ মিনিট ৪৫ সেকেন্ড</small>
                                        </div>
                                    </div>
                                    <p class="text-muted text-xs mb-3">Steadfast ও Pathao এপিআই কানেক্ট করে কীভাবে অর্ডার পেজ থেকে ১-ক্লিকে পার্সেল বুক করবেন।</p>
                                    <a href="https://www.youtube.com/results?search_query=steadfast+courier+api+order" target="_blank" class="btn btn-sm btn-outline-success rounded-pill font-weight-bold">
                                        <i class="ti ti-player-play"></i> ভিডিও দেখুন
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card h-100 border rounded-3 p-3 hover-shadow">
                                    <div class="d-flex align-items-center gap-3 mb-2">
                                        <div class="bg-warning text-dark p-2 rounded-3 fs-4">
                                            <i class="ti ti-brand-whatsapp"></i>
                                        </div>
                                        <div>
                                            <h6 class="font-weight-bold mb-0">৩. হোয়াটসঅ্যাপ সেলস রিকভারি</h6>
                                            <small class="text-muted">সময়: ৩ মিনিট</small>
                                        </div>
                                    </div>
                                    <p class="text-muted text-xs mb-3">ড্রপ-আউট বা অ্যাব্যান্ডনড কার্টের গ্রাহকদের ১-ক্লিকে হোয়াটসঅ্যাপে বার্তা পাঠিয়ে ৩০% বাড়তি সেলস আনার কৌশল।</p>
                                    <a href="https://www.youtube.com/results?search_query=abandoned+cart+whatsapp+recovery" target="_blank" class="btn btn-sm btn-outline-warning text-dark rounded-pill font-weight-bold">
                                        <i class="ti ti-player-play"></i> ভিডিও দেখুন
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card h-100 border rounded-3 p-3 hover-shadow">
                                    <div class="d-flex align-items-center gap-3 mb-2">
                                        <div class="bg-danger text-white p-2 rounded-3 fs-4">
                                            <i class="ti ti-chart-dots"></i>
                                        </div>
                                        <div>
                                            <h6 class="font-weight-bold mb-0">৪. ফেসবুক CAPI ও পিক্সেল</h6>
                                            <small class="text-muted">সময়: ৪ মিনিট</small>
                                        </div>
                                    </div>
                                    <p class="text-muted text-xs mb-3">অ্যাড-ব্লকার বাইপাস করে মেটা Conversions API ও টিকটক পিক্সেল দিয়ে নির্ভুল আরওএএস (ROAS) ট্র্যাকিং।</p>
                                    <a href="https://www.youtube.com/results?search_query=facebook+conversion+api+tracking" target="_blank" class="btn btn-sm btn-outline-danger rounded-pill font-weight-bold">
                                        <i class="ti ti-player-play"></i> ভিডিও দেখুন
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4 dash-order-status g-4">
            <div class="col-12">
                <div class="row g-4">
                        <x-dashboard-card :count="$pending_order" :label="__('Pending orders')" :icon="$pending_icon" />
                        <x-dashboard-card :count="$return_order" :label="__('Order Return')" :icon="$return_icon" />
                    <x-dashboard-card :count="$confirmed_order" :label="__('Confirmed Order')"
                            :icon="$confirmed_icon" />
                        <x-dashboard-card :count="$cancel_order" :label="__('Cancel Order')" :icon="$cancel_icon" />
                        <x-dashboard-card :count="$shipped_order" :label="__('Order Shipped')" :icon="$shipped_icon" />
                    <x-dashboard-card :count="$delivered_order" :label="__('Order Delivered')"
                            :icon="$delivered_icon" />
                        <x-dashboard-card :count="$totle_order" :label="__('Total Orders')" :icon="$total_order_icon" />
                        <x-dashboard-card :count="$totle_customers" :label="__('Total Customers')" :icon="$customer_icon" />

                </div>
            </div>
            <div class="col-12 admin-cards">
                <div class="row g-4">
                        <div class="col-xxl-4 col-12 theme-card">
                            <div class="dashboard-theme-card  dashboard-card">
                                <div class="theme-image buisness-img">
                                    <span class="card-badge btn btn-sm btn-primary btn-badge">{{ ucfirst($store->name ?? '')
                                                                        }}</span>
                                    <img src="{{ asset('themes/' . APP_THEME() . '/theme_img/img_1.png') }}"
                                        alt="theme-image">
                                </div>
                                    <div class="theme-card-button">
                                        <a class="btn btn-outline-primary btn-badge h-100 d-flex align-items-center justify-content-center"
                                            href="{{ route('theme.pages', APP_THEME()) }}">
                                            {{ __('Customize') }}
                                        </a>
                                        <a class="btn btn-primary d-flex align-items-center justify-content-center"
                                            href="{{ route('theme.index') }}">
                                            {{ __('Manage Themes') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <div class="col-xxl-4 col-12">
                <div class="dashboard-card">
                    <div class="d-flex align-items-center justify-content-between gap-3 mb-4">
                        <h4 class="m-0">{{ __('Top Category') }}</h4>
                        <p class="m-0">{{ __('By Sales') }}</p>
                    </div>
                    <div class="dash-category-tab" id="useradd-sidenav">
                                    <ul class="nav nav-pills w-100 pro-cat row store-setting-tab" id="pills-cat-tab"
                                        role="tablist">
                            <li class="nav-item  col-xxl-2 col-xl-3 col-md-4 col-sm-6 col-12 text-center"
                                role="presentation">
                                <a href="#all-category-order" class="nav-link btn-sm f-w-600 active"
                                                id="all-category-tab" data-bs-toggle="pill"
                                                data-bs-target="#all-category-home" type="button" role="tab"
                                                aria-controls="all-category-home" aria-selected="true">
                                    {{ __('All') }}
                                </a>
                            </li>
                            <li class="nav-item col-xxl-2 col-xl-3 col-md-4 col-sm-6 col-12 text-center"
                                role="presentation">
                                            <a href="#today-category-order" class="nav-link btn-sm f-w-600"
                                                id="today-category-tab" data-bs-toggle="pill"
                                                data-bs-target="#today-category" type="button" role="tab"
                                    aria-controls="today-category" aria-selected="true">
                                    {{ __('Today') }}
                                </a>
                            </li>
                            <li class="nav-item col-xxl-2 col-xl-3 col-md-4 col-sm-6 col-12 text-center"
                                role="presentation">
                                            <a href="#week-category-order" class="nav-link btn-sm f-w-600"
                                                id="pills-seo-tab" data-bs-toggle="pill" data-bs-target="#pills-seo"
                                                type="button" role="tab" aria-controls="pills-seo" aria-selected="true">
                                    {{ __('Week') }}
                                </a>
                            </li>
                            <li class="nav-item col-xxl-2 col-xl-3 col-md-4 col-sm-6 col-12 text-center"
                                role="presentation">
                                            <a href="#month-category-order" class="nav-link btn-sm f-w-600"
                                                id="pills-seo-tab" data-bs-toggle="pill" data-bs-target="#pills-seo"
                                                type="button" role="tab" aria-controls="pills-seo" aria-selected="true">
                                    {{ __('Month') }}
                                </a>
                            </li>
                            <li class="nav-item col-xxl-2 col-xl-3 col-md-4 col-sm-6 col-12 text-center"
                                role="presentation">
                                            <a href="#year-category-order" class="nav-link btn-sm f-w-600"
                                                id="pills-seo-tab" data-bs-toggle="pill" data-bs-target="#pills-seo"
                                                type="button" role="tab" aria-controls="pills-seo" aria-selected="true">
                                    {{ __('Year') }}
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content dash-category-tab-content mt-4">
                            <div id="category-tab-data"></div>
                        </div>
                    </div>
                </div>
            </div>
                        <div class="col-xxl-4 col-12">
                <div class="dashboard-card">
                    <div class="d-flex align-items-center justify-content-between gap-3 mb-4">
                        <h4 class="m-0">{{ __('Top Brand') }}</h4>
                        <p class="m-0">{{ __('By Sales') }}</p>
                    </div>
                    <div class="dash-brand-tab" id="brand-sidenav">
                        <ul class="nav nav-pills w-100 pro-cat row store-setting-tab" id="pills-brand-tab"
                            role="tablist">
                            <li class="nav-item col-xxl-2 col-xl-3 col-md-4 col-sm-6 col-12 text-center"
                                role="presentation">
                                            <a href="#all-brand-order" class="nav-link btn-sm f-w-600 active"
                                                id="all-brand-tab" data-bs-toggle="pill" data-bs-target="#all-brand"
                                                type="button" role="tab" aria-controls="all-brand" aria-selected="true">
                                    {{ __('All') }}
                                </a>
                            </li>
                            <li class="nav-item col-xxl-2 col-xl-3 col-md-4 col-sm-6 col-12 text-center"
                                role="presentation">
                                            <a href="#today-brand-order" class="nav-link btn-sm f-w-600"
                                                id="today-brand-tab" data-bs-toggle="pill" data-bs-target="#today-brand"
                                                type="button" role="tab" aria-controls="today-brand" aria-selected="true">
                                    {{ __('Today') }}
                                </a>
                            </li>
                            <li class="nav-item col-xxl-2 col-xl-3 col-md-4 col-sm-6 col-12 text-center"
                                role="presentation">
                                <a href="#week-brand-order" class="nav-link btn-sm f-w-600" id="pills-seo-tab"
                                    data-bs-toggle="pill" data-bs-target="#pills-seo" type="button" role="tab"
                                    aria-controls="pills-seo" aria-selected="true">
                                    {{ __('Week') }}
                                </a>
                            </li>
                            <li class="nav-item col-xxl-2 col-xl-3 col-md-4 col-sm-6 col-12 text-center"
                                role="presentation">
                                <a href="#month-brand-order" class="nav-link btn-sm f-w-600" id="pills-seo-tab"
                                    data-bs-toggle="pill" data-bs-target="#pills-seo" type="button" role="tab"
                                    aria-controls="pills-seo" aria-selected="true">
                                    {{ __('Month') }}
                                </a>
                            </li>
                            <li class="nav-item col-xxl-2 col-xl-3 col-md-4 col-sm-6 col-12 text-center"
                                role="presentation">
                                <a href="#year-brand-order" class="nav-link btn-sm f-w-600" id="pills-seo-tab"
                                    data-bs-toggle="pill" data-bs-target="#pills-seo" type="button" role="tab"
                                    aria-controls="pills-seo" aria-selected="true">
                                    {{ __('Year') }}
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content dash-category-tab-content mt-4">
                            <div id="brand-tab-data"></div>
                        </div>
                    </div>
                </div>
            </div>
                    </div>
                </div>
            </div>
            <div class="row g-4 admin-cards">
                <div class="col-xxl-4 col-12">
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="dashboard-card">
                                <div class="card-content-info d-flex gap-3 flex-wrap flex-column flex-sm-row">
                                    <div class="d-flex align-items-center align-items-sm-start gap-3 flex-1 flex-column flex-sm-row">
                                        <a href="{{ !empty(auth()->user()->profile_image) && file_exists(auth()->user()->profile_image) ? get_file(auth()->user()->profile_image) : asset(Storage::url('uploads/profile/avatar.png')) }}"
                                            target="_blank" class="user-img">
                                            <img src="{{ !empty(auth()->user()->profile_image) && file_exists(auth()->user()->profile_image) ? get_file(auth()->user()->profile_image) : asset(Storage::url('uploads/profile/avatar.png')) }}"
                                                alt="user-image">
                                        </a>
                                        <div class="user-info">
                                            <h4 class="mb-2">{{ __(auth()->user()->name) }}
                                            </h4>
                                            <p>{{ __('Have a nice day! Did you know that you can quickly add your favorite
                                                                            product or category to the theme?') }}
                                            </p>
                                             <div class="d-flex align-items-center gap-2 flex-wrap justify-content-center justify-content-sm-start">
                                            <div class="dropdown quick-add-btn">
                                                <a class="btn btn-primary btn-sm btn-q-add btn-badge gap-1"
                                                    data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                                                    aria-expanded="false">
                                                    <i class="ti ti-plus"></i>
                                                    <span>{{ __('Quick Add') }}</span>
                                                </a>
                                                <div class="dropdown-menu">
                                                    <a href="{{ route('product.create') }}" data-size="lg"
                                                        data-title="{{ __('Add Product') }}" class="dropdown-item text-wrap"
                                                        data-bs-placement="top "><span>{{ __('Add New Product') }}</span></a>
                                                    <a href="#" data-size="md" data-url="{{ route('taxes.create') }}"
                                                        data-ajax-popup="true" data-title="{{ __('Create Tax') }}"
                                                        class="dropdown-item text-wrap"
                                                        data-bs-placement="top "><span>{{__('Add New Tax') }}</span></a>
                                                    <a href="#" data-size="md" data-url="{{ route('category.create') }}"
                                                        data-ajax-popup="true" data-title="{{ __('Create Main Category') }}"
                                                        class="dropdown-item text-wrap" data-bs-placement="top"><span>{{ __('Add
                                                                                        New Main Category') }}</span></a>
                                                    <a href="#" data-size="md" data-url="{{ route('coupon.create') }}"
                                                        data-ajax-popup="true" data-title="{{ __('Create Coupon') }}"
                                                        class="dropdown-item text-wrap"
                                                        data-bs-placement="top "><span>{{__('Add New Coupon') }}</span></a>
                                                </div>
                                            </div>
                                              <a href="#" id="socialShareButton"
                                                class="socialShareButton btn btn-sm btn-outline-primary btn-badge">
                                                <i class="ti ti-share"></i>
                                            </a>
                                            <a href="#" class="btn btn-outline-primary btn-sm cp_link btn-badge"
                                                data-link="{{ $theme_url }}" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="{{ __('Click to copy link') }}">
                                                {{ __('Theme Link') }}
                                                <i class="ms-1" data-feather="copy"></i>
                                            </a>
                                          
                                            <div id="sharingButtonsContainer" class="sharingButtonsContainer"
                                                style="display: none;">
                                                <div
                                                    class="Demo1 d-flex align-items-center justify-content-center mb-5 hidden">
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                <div class="qr-code-wrp">
                                        <h5 class="text-capitalize text-center">{{ $store->name }}</h5>
                                        <div class="code-img">
                                            {!! QrCode::generate($theme_url) !!}
                                        </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                <div class="dashboard-card">
                    <div class="card-header">
                                    <h4>{{ __('Storage Status ') }}<small>({{ $users->storage_limit . 'MB' }}
                                /
                                            {{ ($plan->storage_limit ?? 0) . 'MB' }})</small></h4>
                    </div>
                    <div class="card-body">
                        <div id="device-chart"></div>
                    </div>
                </div>
        </div>
                    </div>
                </div>
            {{-- latest product --}}
                <div class="col-xxl-4 col-12">
                <div class="overflow-auto dashboard-card">
                    <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap">
                        <h4 class="m-0">{{ __('Latest Products') }}</h4>
                        @if ($latests && count($latests) > 0)
                                <a class="text-primary" href="{{ route('product.index') }}">{{ __('View All') }}</a>
                        @endif
                    </div>
                    <div class="table-responsive">
                        <table class="table dataTable">
                            <thead>
                                <tr>
                                    <th>
                                        {{ __('Image') }}
                                    </th>
                                    <th scope="col" class="sort" data-sort="name">
                                        {{ __('Product') }}
                                    </th>

                                    <th scope="col" class="sort text-right" data-sort="completion">
                                            {{ __('Price') }}
                                        </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($latests) && count($latests) > 0)
                                @foreach ($latests as $latest)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="{{ route('product.index') }}" target="_blank" class="rounded-1 border overflow-hidden border border-primary border-2 rounded">
                                                @if ($latest->cover_image_path)
                                                <img src="{{ get_file($latest->cover_image_path) }}" width="100"
                                                    class="cover_img1" alt="images">
                                                @endif
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <h6 class="m-0">{{ $latest->name }}
                                            </h6>
                                        </div>
                                    </td>
                                    @if ($latest->variant_product == 0)

                                    <td>
                                        <h6 class="m-0">
                                                                                {{ currency_format_with_sym($latest->final_price ?? 0, getCurrentStore()) ??
                                                    SetNumberFormat($latest->final_price) }}
                                        </h6>
                                    </td>
                                    @else

                                    <td>
                                        <h6 class="m-0">{{ __('In Variant') }}</h6>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
                <div class="col-xxl-4 col-12">
                <div class="dashboard-card">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <h4>{{ __('Recent Orders') }}</h4>
                        @if ($new_orders && count($new_orders) > 0)
                        <a class="text-primary" href="{{ route('order.index') }}">{{ __('View All') }}</a>
                        @endif
                    </div>
                    <div class="table-responsive">
                        <table class="table dataTable">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('Orders') }}</th>
                                    <th scope="col" class="sort">{{ __('Date') }}</th>
                                    <th scope="col" class="sort">{{ __('Status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($new_orders) > 0)
                                @foreach ($new_orders as $order)
                                @if ($order->status != 'Cancel Order')
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center table-inner-text">
                                            <a href="{{ route('order.view', \Illuminate\Support\Facades\Crypt::encrypt($order->id)) }}"
                                                                @php $btn_class = 'bg-info';
                                                                    if (
                                                                        $order->delivered_status == 2 ||
                                                                        $order->delivered_status == 3
                                                                    ) {
                                                $btn_class = 'bg-danger';
                                                                    } elseif ($order->delivered_status == 1) {
                                                $btn_class = 'bg-success';
                                                                    } elseif ($order->delivered_status == 4) {
                                                $btn_class = ' bg-warning';
                                                                    } elseif ($order->delivered_status == 5) {
                                                $btn_class = 'bg-secondary';
                                                                    } elseif ($order->delivered_status == 6) {
                                                $btn_class = 'bg-dark';
                                                } @endphp
                                                                class="btn bg-primary btn-sm text-sm btn-badge" data-bs-toggle="tooltip"
                                                title="{{ __('Invoice ID') }}">
                                                <span class="btn-inner--icon"></span>
                                                <span class="btn-inner--text">#{{ $order->product_order_id }}</span>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <h6 class="m-0">
                                            {{ \App\Models\Utility::dateFormat($order->order_date) }}
                                        </h6>
                                    </td>
                                    

                                   
                                    <td class="">
                                        @if ($order->delivered_status == 0)
                                                            <button type="button" class="btn btn-sm btn-info btn-icon">

                                                                <span class="btn-inner--text"> {{ __('Pending') }}
                                            </span>
                                        </button>
                                        @elseif ($order->delivered_status == 1)
                                                            <button type="button" class="btn btn-sm btn-success btn-icon">

                                            <span class="btn-inner--text"> {{ __('Delivered') }}
                                            </span>
                                        </button>
                                        @elseif ($order->delivered_status == 2)
                                                            <button type="button" class="btn btn-sm btn-danger btn-icon">

                                            <span class="btn-inner--text"> {{ __('Cancel') }} 
                                            </span>
                                        </button>
                                        @elseif ($order->delivered_status == 3)
                                                            <button type="button" class="btn btn-sm btn-danger btn-icon">

                                            <span class="btn-inner--text"> {{ __('Return') }} 
                                            </span>
                                        </button>
                                        @elseif ($order->delivered_status == 4)
                                                            <button type="button" class="btn btn-sm btn-warning btn-icon">

                                            <span class="btn-inner--text"> {{ __('Confirmed') }}
                                                
                                            </span>
                                        </button>
                                        @elseif ($order->delivered_status == 5)
                                                            <button type="button" class="btn btn-sm btn-secondary btn-icon">

                                            <span class="btn-inner--text"> {{ __('Picked Up') }}
                                                
                                            </span>
                                        </button>
                                        @elseif ($order->delivered_status == 6)
                                                            <button type="button" class="btn btn-sm btn-dark btn-icon">

                                                                <span class="btn-inner--text"> {{ __('Shipped') }}
                                            </span>
                                        </button>
                                        @elseif ($order->delivered_status == 8)
                                                            <button type="button" class="btn btn-sm btn-dark btn-icon">
                                            <span class="btn-inner--text"> {{ __('Pre Order') }}

                                            </span>
                                        </button>
                                        @endif
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    @endsection

    @push('custom-script')
    @if (auth()->user()->type != 'superadmin')
    <script>
            $(document).ready(function () {
                $('.cp_link').on('click', function () {
            var value = $(this).attr('data-link');
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(value).select();
            document.execCommand("copy");
            $temp.remove();
            show_toastr('Success', '{{ __("Link copied") }}', 'success')
        });
    });
    </script>
    @endif
    <script>
        
    // new-chart-js-start
        $(document).ready(function () {
        var options = {
            series: [{{ round($storage_limit, 2) }}],
            chart: {
                    height: 550,
                type: 'radialBar',
                offsetY: -20,
                sparkline: {
                    enabled: true
                },
                toolbar: {
                    show: false
                },
            },
            plotOptions: {
                radialBar: {
                    startAngle: -90,
                    endAngle: 90,
                    track: {
                            background: "var(--third-color)",
                        strokeWidth: '97%',
                        margin: 5, // margin is in pixels
                    },
                    dataLabels: {
                        name: {
                            show: true,
                            fontSize: '16px',
                        },
                        value: {
                            offsetY: -50,
                            fontSize: '20px'
                        }
                    }
                }
            },
            grid: {
                padding: {
                    top: -10
                }
            },
                colors: ["var(--theme-color)"],
            labels: ['Used'],
            responsive: [{
                    breakpoint: 600,
                    options: {
                        chart: {
                            height: 300,
                        },
                        plotOptions: {
                            radialBar: {
                                startAngle: -90,
                                endAngle: 90,
                                size: '70%',
                            }
                        },
                        dataLabels: {
                            value: {
                                offsetY: -40,
                                fontSize: '18px',
                            },
                        }
                    }
                },
                {
                    breakpoint: 1024,
                    options: {
                        chart: {
                            height: 450,
                        },
                        plotOptions: {
                            radialBar: {
                                size: '80%',
                            }
                        },
                        dataLabels: {
                            value: {
                                offsetY: -45,
                                fontSize: '18px',
                            },
                        }
                    }
                }
            ]
        };

        var chart = new ApexCharts(document.querySelector("#device-chart"), options);
        chart.render();
    });
    

    // Assuming this value is injected from your backend
    var defaultTimezone = "{{ $setting['defult_timezone'] ?? 'Asia/Kolkata' }}"; // Example: -5 for EST

    // Function to get the current hour in the specified timezone
    function getHourInTimezone(timezone) {
        var date = new Date();
        var options = {
            timeZone: timezone,
            hour: '2-digit',
            hour12: false,
        };
        var formatter = new Intl.DateTimeFormat([], options);
        var formattedTime = formatter.formatToParts(date);
        var hour = formattedTime.find(part => part.type === 'hour').value;
        return parseInt(hour, 10);
    }

    // Get the current hour in the specified timezone
    var curHr = getHourInTimezone(defaultTimezone);

    // Set greeting based on the calculated hour
    var target = document.getElementById("greetings");
    if (target && curHr < 12) {
        target.innerHTML = "{{ __('Good Morning,') }}";
    } else if (target && curHr < 17) {
        target.innerHTML = "{{ __('Good Afternoon,') }}";
    } else {
        if (target) {
            target.innerHTML = "{{ __('Good Evening,') }}";
        }
    }
    </script>
    <script>
        $(document).on('click', '.code', function () {
        var type = $(this).val();
        $('#code_text').addClass('col-md-12').removeClass('col-md-8');
        $('#autogerate_button').addClass('d-none');
        if (type == 'auto') {
            $('#code_text').addClass('col-md-8').removeClass('col-md-12');
            $('#autogerate_button').removeClass('d-none');
        }
    });

        $(document).on('click', '#code-generate', function () {
        var length = 10;
        var result = '';
        var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        var charactersLength = characters.length;
        for (var i = 0; i < length; i++) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        $('#auto-code').val(result);
    });
    </script>
    <script>
    function add_more_customer_choice_option(i, name) {
        $('#customer_choice_options').append(
            '<div class="form-group"><input type="hidden" name="choice_no[]" value="' + i + '">' +
            '<label for="choice_attributes">' + name + ':</label>' +
            '<input type="text" class="form-control variant_choice" name="choice_options_' + i +
            '[]" __="{{ __('Enter choice values') }}"  data-role="tagsinput" id="variant_tag' + i +
            '" onchange="update_sku($(this).val())">' +
            '</div>');
        comman_function();
    }

        $(document).ready(function () {
        var customURL = {!! json_encode($theme_url) !!};
        console.log('customURL', customURL);
        $('.Demo1').socialSharingPlugin({
            url: customURL,
            title: $('meta[property="og:title"]').attr('content'),
            description: $('meta[property="og:description"]').attr('content'),
            img: $('meta[property="og:image"]').attr('content'),
            enable: ['whatsapp', 'facebook', 'twitter', 'pinterest', 'instagram']
        });

            $('.socialShareButton').click(function (e) {
            e.preventDefault();
            $('.sharingButtonsContainer').toggle();
        });

        // Fetch order details for "Today" tab
        fetchOrderDetails('all-category', 'category');
        fetchOrderDetails('all-category', 'brand');

        // Add event listener for tab changes
            $('.dash-category-tab .nav-pills a[data-bs-toggle="pill"]').on('shown.bs.tab', function (e) {
            // Get the ID of the active tab
            var tabId = $(e.target).attr('href');
            $('#loader').fadeIn();
            // Fetch order details for "Today" tab
            fetchOrderDetails(tabId, 'category');


        });

        // Add event listener for tab changes
            $('.dash-brand-tab .nav-pills a[data-bs-toggle="pill"]').on('shown.bs.tab', function (e) {
            // Get the ID of the active tab
            var tabId = $(e.target).attr('href');
            $('#loader').fadeIn();
            // Fetch order details for "Today" tab
            fetchOrderDetails(tabId, 'brand');


        });

        // Function to fetch order details based on tab ID
        function fetchOrderDetails(tabId, type) {
            // Make an AJAX request to fetch order details
            $.ajax({
                url: "{{ route('top.brand.category.chart') }}", // Replace with your Laravel route
                type: 'POST',
                data: {
                    tabId: tabId,
                    type: type
                },
                    success: function (response) {
                    // Update UI with fetched order details
                    // For example, you can update a div with the fetched data
                    $('#' + type + '-tab-data').html('');
                    $('#' + type + '-tab-data').html(response.html);
                    $('#loader').fadeOut();
                },
                    error: function (xhr, status, error) {
                    // Handle error
                    console.error(error);
                }
            });
        }
    });
    </script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-DN7D163CD8"></script>
    <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'G-DN7D163CD8');
    </script>
    @endpush