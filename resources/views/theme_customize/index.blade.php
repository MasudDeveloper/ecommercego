@extends('layouts.app')

@section('page-title', __('Themes'))

@section('breadcrumb')
 <li class="breadcrumb-item">{{ __('Themes') }}</li>
@endsection

@push('custom-css')
<style>
    .business-view-inner {
        transition: all 0.3s ease;
        border-radius: 14px;
        padding: 12px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
    }
    .business-view-inner:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
        border-color: #6366f1;
    }
    .business-view-inner .buisness-img {
        position: relative;
        padding-top: 60%;
        display: block;
        border-radius: 10px;
        overflow: hidden;
        background: #0f172a;
        border: 1px solid #f1f5f9;
    }
    .business-view-inner .buisness-img img {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: top;
        transition: object-position 4.5s cubic-bezier(0.2, 0.8, 0.2, 1) !important;
    }
    .business-view-inner:hover .buisness-img img {
        object-position: bottom !important;
    }
    .hover-scroll-badge {
        position: absolute;
        bottom: 8px;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(15, 23, 42, 0.82);
        backdrop-filter: blur(4px);
        color: #ffffff;
        font-size: 10.5px;
        padding: 3px 10px;
        border-radius: 20px;
        pointer-events: none;
        opacity: 0.9;
        transition: opacity 0.25s ease;
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 4px;
        border: 1px solid rgba(255, 255, 255, 0.15);
    }
    .business-view-inner:hover .hover-scroll-badge {
        opacity: 0;
    }
</style>
@endpush

@section('content')
<div class="tab-content mb-4">
    <div class="tab-pane fade show active" id="theme-setting" role="tabpanel" aria-labelledby="theme-setting-tab">
        <div class="card p-3 mb-0">
            <div class="card-body p-0">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="theme-layout" role="tabpanel"
                        aria-labelledby="theme-layout-tab">
                        <div class="row row-gap-2">
                             @foreach ($themes as $folder)
                                @if (!in_array($folder, $addons))
                                    @continue
                                @endif
                                @php
                                    $isLandingTheme = in_array($folder, [
                                        'landing-panjabi', 'landing-saree', 'landing-gadget', 'landing-skincare',
                                        'landing-kitchen', 'landing-leather', 'landing-islamic', 'landing-fitness',
                                        'landing-kids', 'single-product'
                                    ]);
                                    $previewUrl = $isLandingTheme ? route('landing.preview', $folder) : url($folder . '/home');
                                @endphp
                                <div class="col-xxl-3 col-lg-4 col-sm-6 col-12 business-view-card mb-3">
                                    <div class="business-view-inner">
                                        <div class="buisness-img mb-3">
                                            <img src="{{ asset('themes/'.$folder.'/theme_img/img_1.png') }}" alt="{{ $folder }} preview" loading="lazy">
                                            <span class="hover-scroll-badge">
                                                <i class="ti ti-arrows-vertical"></i> মাউস রাখলে স্ক্রল হবে
                                            </span>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap">
                                            <div>
                                                <h2 class="h6 mb-1 text-break font-weight-bold" style="font-size: 14px;">{{ ucfirst($folder) }}</h2>
                                                @if($isLandingTheme)
                                                    <span style="display: inline-block; padding: 2px 8px; font-size: 10.5px; font-weight: 700; border-radius: 4px; background: #eef2ff; color: #4338ca; border: 1px solid #c7d2fe;">১-পেজ ফাস্ট COD</span>
                                                @else
                                                    <span style="display: inline-block; padding: 2px 8px; font-size: 10.5px; font-weight: 700; border-radius: 4px; background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1;">মাল্টি-পেজ স্টোর</span>
                                                @endif
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between gap-1">
                                                <a class="btn btn-sm btn-outline-info text-end px-2" href="{{ $previewUrl }}" target="_blank" title="{{ __('লাইভ ডেমো দেখুন') }}">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                                <a class="btn btn-sm btn-primary text-end px-2" href="{{ route('theme.pages',$folder) }}">
                                                    {{ __('Customize') }}
                                                </a>
                                                @if (APP_THEME() != $folder)
                                                    {!! Form::open(['method' => 'POST', 'route' => ['theme-preview.make-active'], 'class' => 'd-inline']) !!}
                                                        @csrf
                                                        <input type="hidden" name="theme_id" value="{{ $folder }}">
                                                        <button type="submit" class="btn btn-sm btn-outline-primary text-end px-2" {{ (APP_THEME()  == $folder ? 'disabled' : '') }}>
                                                        {{ __('Make Active') }}
                                                        </button>
                                                    {!! Form::close() !!}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('custom-script')
<script type="text/javascript">
    $(document).on('keyup','#theme-search', function() {
        var value = $(this).val().toLowerCase();
        $('#theme-list .theme-item').filter(function() {
            $(this).toggle($(this).find('.theme-card-lable').text().toLowerCase().indexOf(value) > -1)
        });
    });
</script>
@endpush
