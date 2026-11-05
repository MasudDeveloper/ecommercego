@extends('agent.layouts.app')

@section('page-title')
    {{ __('মার্কেটিং লিড ম্যানেজার (CRM)') }}
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h3 class="font-weight-bold mb-1 d-flex align-items-center gap-2">
                    <i class="ti ti-users text-info fs-2"></i> {{ __('মার্কেটিং লিড ম্যানেজার (Mini CRM)') }}
                </h3>
                <p class="text-muted mb-0">আপনার টার্গেটেড ফেসবুক পেজ ও শপ ওনারদের ট্র্যাক ও সেলস ক্লোজ করুন</p>
            </div>
            <button type="button" class="btn btn-primary d-flex align-items-center gap-1 shadow-sm" data-bs-toggle="modal" data-bs-target="#createLeadModal">
                <i class="ti ti-user-plus"></i> {{ __('নতুন লিড যুক্ত করুন') }}
            </button>
        </div>
    </div>
</div>

<!-- CRM Pipeline Filter Tabs -->
<div class="card stat-card mb-4 border-0">
    <div class="card-body p-3">
        <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between">
            <div class="d-flex flex-wrap gap-1">
                <a href="{{ route('agent.leads') }}" class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-outline-secondary' }}">
                    সকল লিড ({{ $counts['all'] }})
                </a>
                <a href="{{ route('agent.leads', ['status' => 'new']) }}" class="btn btn-sm {{ request('status') == 'new' ? 'btn-warning text-dark' : 'btn-outline-warning' }}">
                    নতুন ({{ $counts['new'] }})
                </a>
                <a href="{{ route('agent.leads', ['status' => 'contacted']) }}" class="btn btn-sm {{ request('status') == 'contacted' ? 'btn-info text-white' : 'btn-outline-info' }}">
                    মেসেজ/কল হয়েছে ({{ $counts['contacted'] }})
                </a>
                <a href="{{ route('agent.leads', ['status' => 'trial_started']) }}" class="btn btn-sm {{ request('status') == 'trial_started' ? 'btn-dark' : 'btn-outline-dark' }}">
                    ট্রায়াল শুরু করেছে ({{ $counts['trial_started'] }})
                </a>
                <a href="{{ route('agent.leads', ['status' => 'converted']) }}" class="btn btn-sm {{ request('status') == 'converted' ? 'btn-success' : 'btn-outline-success' }}">
                    কনভার্টেড 🎉 ({{ $counts['converted'] }})
                </a>
                <a href="{{ route('agent.leads', ['status' => 'follow_up']) }}" class="btn btn-sm {{ request('status') == 'follow_up' ? 'btn-secondary' : 'btn-outline-secondary' }}">
                    ফলো-আপ ({{ $counts['follow_up'] }})
                </a>
            </div>

            <!-- Search input -->
            <form method="GET" action="{{ route('agent.leads') }}" class="d-flex gap-1" style="max-width: 280px; width: 100%;">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <input type="text" name="search" class="form-control form-control-sm" placeholder="দোকানের নাম বা ফোন..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-sm btn-outline-primary"><i class="ti ti-search"></i></button>
            </form>
        </div>
    </div>
</div>

<!-- Leads Data Table -->
<div class="card stat-card">
    <div class="card-body table-border-style p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>{{ __('দোকানের নাম ও ওনার') }}</th>
                        <th>{{ __('মোবাইল ও হোয়াটসঅ্যাপ') }}</th>
                        <th>{{ __('ক্যাটাগরি') }}</th>
                        <th>{{ __('ফেসবুক পেজ') }}</th>
                        <th>{{ __('পাইপলাইন স্ট্যাটাস') }}</th>
                        <th>{{ __('ফলো-আপ তারিখ') }}</th>
                        <th>{{ __('নোট') }}</th>
                        <th class="text-end">{{ __('অ্যাকশন') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leads as $lead)
                    <tr>
                        <td>
                            <strong class="text-dark">{{ $lead->shop_name }}</strong>
                            @if($lead->owner_name)
                                <br><small class="text-muted"><i class="ti ti-user"></i> {{ $lead->owner_name }}</small>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span class="font-monospace text-dark">{{ $lead->phone }}</span>
                                <a href="{{ $lead->whatsapp_url }}" target="_blank" class="btn btn-xs btn-success d-flex align-items-center gap-1 rounded-pill px-2" title="সরাসরি হোয়াটসঅ্যাপে রেডি পিচ মেসেজ পাঠান">
                                    <i class="ti ti-brand-whatsapp"></i> <span>WhatsApp</span>
                                </a>
                            </div>
                        </td>
                        <td>
                            @if($lead->category)
                                <span class="badge bg-light-primary text-primary">{{ $lead->category }}</span>
                            @else
                                <span class="text-muted text-xs">-</span>
                            @endif
                        </td>
                        <td>
                            @if($lead->page_url)
                                <a href="{{ str_starts_with($lead->page_url, 'http') ? $lead->page_url : 'https://' . $lead->page_url }}" target="_blank" class="btn btn-xs btn-outline-primary d-inline-flex align-items-center gap-1" title="পেজ ভিজিট করুন">
                                    <i class="ti ti-brand-facebook"></i> <span>পেজ দেখুন</span>
                                </a>
                            @else
                                <span class="text-muted text-xs">-</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $badge = $lead->status_badge;
                            @endphp
                            <span class="badge {{ $badge['bg'] }} border px-2 py-1">
                                {{ $badge['label'] }}
                            </span>
                        </td>
                        <td>
                            @if($lead->follow_up_date)
                                <small class="text-dark font-weight-bold"><i class="ti ti-calendar"></i> {{ $lead->follow_up_date->format('d M, Y') }}</small>
                            @else
                                <span class="text-muted text-xs">-</span>
                            @endif
                        </td>
                        <td>
                            @if($lead->notes)
                                <small class="text-muted" title="{{ $lead->notes }}">{{ Str::limit($lead->notes, 30) }}</small>
                            @else
                                <span class="text-muted text-xs">-</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-1">
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editLeadModal{{ $lead->id }}" title="এডিট বা স্ট্যাটাস পরিবর্তন">
                                    <i class="ti ti-pencil"></i>
                                </button>
                                <form method="POST" action="{{ route('agent.leads.delete', $lead->id) }}" onsubmit="return confirm('আপনি কি এই লিডটি মুছে ফেলতে চান?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="মুছে ফেলুন">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </form>
                            </div>

                            <!-- Edit Modal for this Lead -->
                            <div class="modal fade" id="editLeadModal{{ $lead->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered text-start">
                                    <div class="modal-content">
                                        <form action="{{ route('agent.leads.update', $lead->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title">{{ __('লিড আপডেট - ') }} {{ $lead->shop_name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label font-weight-bold">{{ __('শপ / পেইজের নাম') }} <span class="text-danger">*</span></label>
                                                    <input type="text" name="shop_name" class="form-control" value="{{ $lead->shop_name }}" required>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">{{ __('ওনারের নাম') }}</label>
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
                                                        <label class="form-label">{{ __('পরবর্তী ফলো-আপ তারিখ') }}</label>
                                                        <input type="date" name="follow_up_date" class="form-control" value="{{ $lead->follow_up_date ? $lead->follow_up_date->format('Y-m-d') : '' }}">
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">{{ __('কথোপকথন ও নোট') }}</label>
                                                    <textarea name="notes" class="form-control" rows="3">{{ $lead->notes }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('বাতিল') }}</button>
                                                <button type="submit" class="btn btn-primary">{{ __('আপডেট করুন') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <div class="text-muted">
                                <i class="ti ti-users-off fs-1 d-block mb-2 text-gray-400"></i>
                                <h6 class="font-weight-bold">{{ __('কোনো লিড পাওয়া যায়নি') }}</h6>
                                <p class="text-xs mb-3">{{ __('ফেসবুক গ্রুপ ও পেজ থেকে সম্ভাব্য মার্চেন্টদের তথ্য সংগ্রহ করে এখানে সংরক্ষণ করুন।') }}</p>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createLeadModal">
                                    <i class="ti ti-plus"></i> {{ __('প্রথম লিড যোগ করুন') }}
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">
            {{ $leads->links() }}
        </div>
    </div>
</div>

<!-- Create Lead Modal -->
<div class="modal fade" id="createLeadModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('agent.leads.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold"><i class="ti ti-user-plus text-primary me-1"></i> {{ __('নতুন মার্চেন্ট লিড সংগ্রহ করুন') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">{{ __('দোকান / ফেসবুক পেইজের নাম') }} <span class="text-danger">*</span></label>
                        <input type="text" name="shop_name" class="form-control" placeholder="যেমন: ফ্যাশন হাউজ বিডি" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('মালিকের নাম (যদি জানা থাকে)') }}</label>
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
                            <input type="text" name="facebook_page" class="form-control" placeholder="facebook.com/shopname">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('প্রোডাক্ট ক্যাটাগরি') }}</label>
                            <input type="text" name="category" class="form-control" placeholder="যেমন: পোশাক, গ্যাজেট, খাবার">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold">{{ __('প্রাথমিক স্ট্যাটাস') }} <span class="text-danger">*</span></label>
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
                        <textarea name="notes" class="form-control" rows="2" placeholder="মার্চেন্টের প্রয়োজন বা কথা বলার সারসংক্ষেপ..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('বাতিল') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('লিড সেভ করুন') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
