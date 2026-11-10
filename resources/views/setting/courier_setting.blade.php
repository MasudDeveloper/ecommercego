<div class="card" id="Courier_Setting">
    <div class="card-header">
        <h5 class="mb-1"><i class="ti ti-truck-delivery me-1"></i> বাংলাদেশ কুরিয়ার অটোমেশন (Steadfast ও Pathao API)</h5>
        <small class="text-muted">আপনার Steadfast বা Pathao মার্চেন্ট অ্যাকাউন্টের ক্রেডেনশিয়াল দিলে অর্ডার পেজ থেকে ১-ক্লিকে পার্সেল বুকিং হয়ে যাবে।</small>
    </div>
    {!! Form::open(['route' => 'courier.save.settings', 'method' => 'POST']) !!}
    <div class="card-body">
        <div class="row">
            <!-- Steadfast Courier Section -->
            <div class="col-md-6 border-end pe-md-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0 text-primary"><i class="ti ti-package me-1"></i> Steadfast Courier API</h6>
                    <div class="form-check form-switch mb-0">
                        <input type="checkbox" class="form-check-input" id="steadfast_enabled" name="steadfast_enabled" value="on" 
                            {{ \App\Models\Utility::GetValueByName('steadfast_enabled', getCurrentStore()) == 'on' ? 'checked' : '' }}>
                        <label class="form-check-label" for="steadfast_enabled">সক্রিয় করুন</label>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label font-weight-bold">Steadfast API Key</label>
                    <input type="text" name="steadfast_api_key" class="form-control" placeholder="যেমন: stdf_xxxxxxxxxxxx"
                        value="{{ \App\Models\Utility::GetValueByName('steadfast_api_key', getCurrentStore()) }}">
                    <small class="text-muted">Steadfast মার্চেন্ট পোর্টালে API Credentials থেকে কপি করুন।</small>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label font-weight-bold">Steadfast Secret Key</label>
                    <input type="password" name="steadfast_secret_key" class="form-control" placeholder="Steadfast Secret Key"
                        value="{{ \App\Models\Utility::GetValueByName('steadfast_secret_key', getCurrentStore()) }}">
                </div>
                <div class="alert alert-info py-2 small mb-0">
                    <i class="ti ti-info-circle me-1"></i> এপিআই কি না দিলেও সিস্টেমে ডেমো মোডে ট্র্যাকিং ও চালান জেনারেট কাজ করবে।
                </div>
            </div>

            <!-- Pathao Courier Section -->
            <div class="col-md-6 ps-md-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0 text-danger"><i class="ti ti-bike me-1"></i> Pathao Courier API</h6>
                    <div class="form-check form-switch mb-0">
                        <input type="checkbox" class="form-check-input" id="pathao_enabled" name="pathao_enabled" value="on"
                            {{ \App\Models\Utility::GetValueByName('pathao_enabled', getCurrentStore()) == 'on' ? 'checked' : '' }}>
                        <label class="form-check-label" for="pathao_enabled">সক্রিয় করুন</label>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label class="form-label font-weight-bold">Client ID</label>
                    <input type="text" name="pathao_client_id" class="form-control" placeholder="Pathao Client ID"
                        value="{{ \App\Models\Utility::GetValueByName('pathao_client_id', getCurrentStore()) }}">
                </div>
                <div class="form-group mb-2">
                    <label class="form-label font-weight-bold">Client Secret</label>
                    <input type="password" name="pathao_client_secret" class="form-control" placeholder="Pathao Client Secret"
                        value="{{ \App\Models\Utility::GetValueByName('pathao_client_secret', getCurrentStore()) }}">
                </div>
                <div class="row">
                    <div class="col-6 form-group mb-2">
                        <label class="form-label font-weight-bold">Username / Email</label>
                        <input type="text" name="pathao_username" class="form-control" placeholder="Email"
                            value="{{ \App\Models\Utility::GetValueByName('pathao_username', getCurrentStore()) }}">
                    </div>
                    <div class="col-6 form-group mb-2">
                        <label class="form-label font-weight-bold">Password</label>
                        <input type="password" name="pathao_password" class="form-control" placeholder="Password"
                            value="{{ \App\Models\Utility::GetValueByName('pathao_password', getCurrentStore()) }}">
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label class="form-label font-weight-bold">Pathao Store ID</label>
                    <input type="text" name="pathao_store_id" class="form-control" placeholder="যেমন: 12345"
                        value="{{ \App\Models\Utility::GetValueByName('pathao_store_id', getCurrentStore()) }}">
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer text-end">
        <button type="submit" class="btn btn-primary px-4 font-weight-bold">
            <i class="ti ti-device-floppy me-1"></i> কুরিয়ার সেটিংস সংরক্ষণ করুন
        </button>
    </div>
    {!! Form::close() !!}
</div>

