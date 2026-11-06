@extends('agent.layouts.app')

@section('page-title')
    {{ __('মার্কেটিং লিড ম্যানেজার (CRM)') }}
@endsection

@push('custom-css')
<style>
    .crm-filter-bar {
        background: #ffffff;
        border: 1px solid var(--agent-border);
        border-radius: 16px;
        padding: 16px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.02);
    }
    .crm-status-pill {
        padding: 7px 16px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #f8fafc;
        color: #475569;
        border: 1px solid #e2e8f0;
    }
    .crm-status-pill:hover {
        background: #f1f5f9;
        color: #1e293b;
    }
    .crm-status-pill.active {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%) !important;
        color: #ffffff !important;
        border-color: #4338ca !important;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3) !important;
    }
    .crm-status-pill.active .badge {
        background: #ffffff !important;
        color: #4338ca !important;
    }
    .crm-table-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid var(--agent-border);
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    }
    .btn-whatsapp-direct {
        background: linear-gradient(135deg, #25d366 0%, #128c7e 100%) !important;
        color: #ffffff !important;
        border: 0 !important;
        font-weight: 700 !important;
        padding: 5px 12px !important;
        border-radius: 50px !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 5px !important;
        font-size: 12px !important;
        box-shadow: 0 2px 8px rgba(37, 211, 102, 0.3) !important;
        transition: all 0.2s ease !important;
        text-decoration: none !important;
    }
    .btn-whatsapp-direct:hover {
        opacity: 0.95 !important;
        color: #ffffff !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 4px 12px rgba(37, 211, 102, 0.45) !important;
    }
    .btn-page-visit {
        background: #eff6ff !important;
        color: #2563eb !important;
        border: 1px solid #bfdbfe !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        padding: 4px 10px !important;
        border-radius: 50px !important;
        text-decoration: none !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 4px !important;
        transition: all 0.2s ease !important;
    }
    .btn-page-visit:hover {
        background: #2563eb !important;
        color: #ffffff !important;
    }
</style>
@endpush

@section('content')

<!-- Header Section -->
<div class="row align-items-center mb-4 g-3">
    <div class="col-lg-6">
        <h3 class="font-weight-bold text-dark mb-1 d-flex align-items-center gap-2">
            <span class="p-2 rounded-3 bg-info bg-opacity-10 text-info d-inline-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                <i class="ti ti-users fs-3"></i>
            </span>
            <span>{{ __('মার্কেটিং লিড ম্যানেজার (Mini CRM)') }}</span>
        </h3>
        <p class="text-muted mb-0">সম্ভাব্য মার্চেন্ট ও ফেসবুক শপ ওনারদের ট্র্যাক করুন এবং হোয়াটসঅ্যাপে সেলস ক্লোজ করুন</p>
    </div>

    <div class="col-lg-6 text-lg-end">
        <button type="button" class="btn btn-primary px-4 py-2 rounded-3 font-weight-bold d-inline-flex align-items-center gap-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#createLeadModal">
            <i class="ti ti-user-plus fs-5"></i>
            <span>{{ __('নতুন মার্চেন্ট লিড যোগ করুন') }}</span>
        </button>
    </div>
</div>

<!-- ============================================== -->
<!-- CRM STATUS PIPELINE TABS & SEARCH              -->
<!-- ============================================== -->
<div class="crm-filter-bar mb-4">
    <div class="row align-items-center g-3">
        <div class="col-xl-9 col-lg-8">
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('agent.leads') }}" class="crm-status-pill {{ !request('status') ? 'active' : '' }}">
                    <span>সকল লিড</span>
                    <span class="badge rounded-pill" style="{{ !request('status') ? 'background: #ffffff; color: #4338ca;' : 'background: #e2e8f0; color: #475569;' }}">{{ $counts['all'] }}</span>
                </a>

                <a href="{{ route('agent.leads', ['status' => 'new']) }}" class="crm-status-pill {{ request('status') == 'new' ? 'active' : '' }}">
                    <span>নতুন লিড</span>
                    <span class="badge rounded-pill" style="{{ request('status') == 'new' ? 'background: #ffffff; color: #4338ca;' : 'background: #fef3c7; color: #92400e;' }}">{{ $counts['new'] }}</span>
                </a>

                <a href="{{ route('agent.leads', ['status' => 'contacted']) }}" class="crm-status-pill {{ request('status') == 'contacted' ? 'active' : '' }}">
                    <span>যোগাযোগ হয়েছে</span>
                    <span class="badge rounded-pill" style="{{ request('status') == 'contacted' ? 'background: #ffffff; color: #4338ca;' : 'background: #e0f2fe; color: #075985;' }}">{{ $counts['contacted'] }}</span>
                </a>

                <a href="{{ route('agent.leads', ['status' => 'trial_started']) }}" class="crm-status-pill {{ request('status') == 'trial_started' ? 'active' : '' }}">
                    <span>ট্রায়াল শুরু</span>
                    <span class="badge rounded-pill" style="{{ request('status') == 'trial_started' ? 'background: #ffffff; color: #4338ca;' : 'background: #f3e8ff; color: #6b21a8;' }}">{{ $counts['trial_started'] }}</span>
                </a>

                <a href="{{ route('agent.leads', ['status' => 'converted']) }}" class="crm-status-pill {{ request('status') == 'converted' ? 'active' : '' }}">
                    <span>কনভার্টেড 🎉</span>
                    <span class="badge rounded-pill" style="{{ request('status') == 'converted' ? 'background: #ffffff; color: #4338ca;' : 'background: #dcfce7; color: #166534;' }}">{{ $counts['converted'] }}</span>
                </a>

                <a href="{{ route('agent.leads', ['status' => 'follow_up']) }}" class="crm-status-pill {{ request('status') == 'follow_up' ? 'active' : '' }}">
                    <span>ফলো-আপ</span>
                    <span class="badge rounded-pill" style="{{ request('status') == 'follow_up' ? 'background: #ffffff; color: #4338ca;' : 'background: #ffedd5; color: #9a3412;' }}">{{ $counts['follow_up'] }}</span>
                </a>
            </div>
        </div>

        <div class="col-xl-3 col-lg-4">
            <form method="GET" action="{{ route('agent.leads') }}">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="ti ti-search"></i></span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="দোকান বা ফোন নম্বর খুঁজুন..." value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit">সার্চ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- LEADS TABLE CARD                               -->
<!-- ============================================== -->
<div class="crm-table-card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="min-width: 900px;">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4" style="width: 28%;">{{ __('শপ ও ওনারের বিবরণ') }}</th>
                        <th style="width: 22%;">{{ __('মোবাইল ও হোয়াটসঅ্যাপ') }}</th>
                        <th style="width: 12%;">{{ __('ক্যাটাগরি') }}</th>
                        <th style="width: 13%;">{{ __('ফেসবুক পেইজ') }}</th>
                        <th style="width: 13%;">{{ __('স্ট্যাটাস') }}</th>
                        <th style="width: 12%;">{{ __('ফলো-আপ') }}</th>
                        <th class="text-end pe-4" style="width: 10%;">{{ __('অ্যাকশন') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leads as $lead)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-3 bg-light-primary text-primary d-flex align-items-center justify-content-center font-weight-bold flex-shrink-0" style="width: 40px; height: 40px; font-size: 16px;">
                                    <i class="ti ti-building-store"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <h6 class="mb-0 font-weight-bold text-dark text-truncate">{{ $lead->shop_name }}</h6>
                                    <div class="d-flex align-items-center gap-2 mt-1 text-xs">
                                        @if($lead->owner_name)
                                            <span class="font-weight-bold" style="color: #334155 !important;"><i class="ti ti-user me-0.5"></i> {{ $lead->owner_name }}</span>
                                        @endif
                                        @if($lead->notes)
                                            <span class="text-truncate font-weight-medium" style="max-width: 240px; color: #475569 !important;" title="{{ $lead->notes }}">
                                                • {{ $lead->notes }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span class="font-monospace text-dark font-weight-bold" style="font-size: 13.5px;">{{ $lead->phone }}</span>
                                <a href="{{ $lead->whatsapp_url }}" target="_blank" class="btn-whatsapp-direct" title="হোয়াটসঅ্যাপে মেসেজ পাঠান">
                                    <i class="ti ti-brand-whatsapp"></i> <span>WhatsApp</span>
                                </a>
                            </div>
                        </td>
                        <td>
                            @if($lead->category)
                                <span class="badge font-weight-semibold px-2 py-1" style="background: #f1f5f9; color: #0f172a; border: 1px solid #cbd5e1;">{{ $lead->category }}</span>
                            @else
                                <span class="text-muted text-xs">-</span>
                            @endif
                        </td>
                        <td>
                            @if($lead->page_url)
                                <a href="{{ str_starts_with($lead->page_url, 'http') ? $lead->page_url : 'https://' . $lead->page_url }}" target="_blank" class="btn-page-visit" title="ফেসবুক পেইজ ভিজিট করুন">
                                    <i class="ti ti-brand-facebook"></i> <span>পেইজ দেখুন</span>
                                </a>
                            @else
                                <span class="text-muted text-xs">-</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $badge = $lead->status_badge;
                            @endphp
                            <span class="badge px-2.5 py-1.5 font-weight-bold" style="{{ $badge['style'] ?? 'background: #fef3c7; color: #92400e; border: 1px solid #fcd34d;' }}">
                                {{ $badge['label'] }}
                            </span>
                        </td>
                        <td>
                            @if($lead->follow_up_date)
                                <span class="badge bg-light-warning text-dark font-weight-bold" style="background: #fffbeb; color: #b45309; border: 1px solid #fde68a;">
                                    <i class="ti ti-calendar me-1"></i> {{ $lead->follow_up_date->format('d M') }}
                                </span>
                            @else
                                <span class="text-muted text-xs">-</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-inline-flex gap-1">
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-2 px-2 py-1" data-bs-toggle="modal" data-bs-target="#editLeadModal{{ $lead->id }}" title="এডিট">
                                    <i class="ti ti-pencil"></i>
                                </button>
                                <form method="POST" action="{{ route('agent.leads.delete', $lead->id) }}" onsubmit="return confirm('আপনি কি এই লিডটি মুছে ফেলতে চান?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-2 px-2 py-1" title="মুছে ফেলুন">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </form>
                            </div>

                            <!-- Edit Lead Modal -->
                            <div class="modal fade" id="editLeadModal{{ $lead->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered text-start">
                                    <div class="modal-content rounded-4 border-0 shadow">
                                        <form action="{{ route('agent.leads.update', $lead->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header border-bottom p-4">
                                                <h5 class="modal-title font-weight-bold text-dark">{{ __('লিড তথ্য আপডেট - ') }} {{ $lead->shop_name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <div class="mb-3">
                                                    <label class="form-label font-weight-bold">{{ __('দোকান / পেইজের নাম') }} <span class="text-danger">*</span></label>
                                                    <input type="text" name="shop_name" class="form-control" value="{{ $lead->shop_name }}" required>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">{{ __('মালিকের নাম') }}</label>
                                                        <input type="text" name="owner_name" class="form-control" value="{{ $lead->owner_name }}">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label font-weight-bold">{{ __('মোবাইল নম্বর') }} <span class="text-danger">*</span></label>
                                                        <input type="text" name="phone" class="form-control" value="{{ $lead->phone }}" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">{{ __('ফেসবুক পেইজ লিংক') }}</label>
                                                        <input type="text" name="facebook_page" class="form-control" value="{{ $lead->page_url }}">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">{{ __('প্রোডাক্ট ক্যাটাগরি') }}</label>
                                                        <input type="text" name="category" class="form-control" value="{{ $lead->category }}">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label font-weight-bold">{{ __('পাইপলাইন স্ট্যাটাস') }} <span class="text-danger">*</span></label>
                                                        <select name="status" class="form-select">
                                                            <option value="new" {{ $lead->status == 'new' ? 'selected' : '' }}>নতুন লিড</option>
                                                            <option value="contacted" {{ $lead->status == 'contacted' ? 'selected' : '' }}>মেসেজ/কল দেওয়া হয়েছে</option>
                                                            <option value="trial_started" {{ $lead->status == 'trial_started' ? 'selected' : '' }}>ট্রায়াল শুরু করেছে</option>
                                                            <option value="converted" {{ $lead->status == 'converted' ? 'selected' : '' }}>কনভার্টেড (পেইড)</option>
                                                            <option value="follow_up" {{ $lead->status == 'follow_up' ? 'selected' : '' }}>ফলো-আপ রিমাইন্ডার</option>
                                                            <option value="lost" {{ $lead->status == 'lost' ? 'selected' : '' }}>আগ্রহী নয়</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">{{ __('ফলো-আপ তারিখ') }}</label>
                                                        <input type="date" name="follow_up_date" class="form-control" value="{{ $lead->follow_up_date ? $lead->follow_up_date->format('Y-m-d') : '' }}">
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">{{ __('নোট ও আলোচনা') }}</label>
                                                    <textarea name="notes" class="form-control" rows="3">{{ $lead->notes }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-top p-3">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('বাতিল') }}</button>
                                                <button type="submit" class="btn btn-primary font-weight-bold px-4">{{ __('আপডেট সংরক্ষণ করুন') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="ti ti-users-off fs-1 d-block mb-2 text-gray-400"></i>
                            <h6 class="font-weight-bold text-dark">{{ __('কোনো লিড রেকর্ড পাওয়া যায়নি') }}</h6>
                            <p class="text-sm mb-3">ফেসবুক পেজ ও গ্রুপ থেকে সম্ভাব্য মার্চেন্টদের তথ্য সংগ্রহ করে এখানে সংরক্ষণ করুন।</p>
                            <button type="button" class="btn btn-sm btn-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#createLeadModal">
                                <i class="ti ti-plus"></i> {{ __('প্রথম লিড যোগ করুন') }}
                            </button>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3 border-top">
            {{ $leads->links() }}
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- CREATE LEAD MODAL                              -->
<!-- ============================================== -->
<div class="modal fade" id="createLeadModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <form action="{{ route('agent.leads.store') }}" method="POST">
                @csrf
                <div class="modal-header border-bottom p-4">
                    <h5 class="modal-title font-weight-bold text-dark d-flex align-items-center gap-2">
                        <span class="p-2 rounded-3 bg-primary bg-opacity-10 text-primary d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                            <i class="ti ti-user-plus"></i>
                        </span>
                        <span>{{ __('নতুন মার্চেন্ট লিড সংগ্রহ করুন') }}</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">{{ __('দোকান / ফেসবুক পেইজের নাম') }} <span class="text-danger">*</span></label>
                        <input type="text" name="shop_name" class="form-control" placeholder="যেমন: ফ্যাশন অ্যান্ড স্টাইল বিডি" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('মালিকের নাম') }}</label>
                            <input type="text" name="owner_name" class="form-control" placeholder="যেমন: তানভীর আহমেদ">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold">{{ __('মোবাইল / হোয়াটসঅ্যাপ নম্বর') }} <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control" placeholder="017xxxxxxxx" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('ফেসবুক পেইজ লিংক') }}</label>
                            <input type="text" name="facebook_page" class="form-control" placeholder="facebook.com/pagename">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('প্রোডাক্ট ক্যাটাগরি') }}</label>
                            <input type="text" name="category" class="form-control" placeholder="যেমন: ক্লথিং, গ্যাজেট, মধু/ফুড">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold">{{ __('স্ট্যাটাস') }} <span class="text-danger">*</span></label>
                            <select name="status" class="form-select">
                                <option value="new" selected>নতুন লিড</option>
                                <option value="contacted">মেসেজ/কল দেওয়া হয়েছে</option>
                                <option value="trial_started">ট্রায়াল শুরু করেছে</option>
                                <option value="converted">কনভার্টেড (পেইড)</option>
                                <option value="follow_up">ফলো-আপ রিমাইন্ডার</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('ফলো-আপ তারিখ (ঐচ্ছিক)') }}</label>
                            <input type="date" name="follow_up_date" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('নোট বা মন্তব্য') }}</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="মার্চেন্টের সাথে কী বিষয়ে কথা হলো..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top p-3">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('বাতিল') }}</button>
                    <button type="submit" class="btn btn-primary font-weight-bold px-4">{{ __('লিড সেভ করুন') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
