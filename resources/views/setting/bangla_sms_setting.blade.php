<div class="card" id="Bangla_Sms_Setting">
    <div class="card-header">
        <h5 class="mb-1"><i class="ti ti-message-dots me-1"></i> লোকাল বাংলা বাল্ক এসএমএস (GreenwebBD / BulksmsBD)</h5>
        <small class="text-muted">অর্ডার হওয়ামাত্র গ্রাহকের মোবাইলে স্বয়ংক্রিয় বাংলা কনফার্মেশন ও ট্র্যাকিং এসএমএস পাঠানো হবে।</small>
    </div>
    {!! Form::open(['route' => 'sms.save.settings', 'method' => 'POST']) !!}
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 border-end pe-md-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0 text-success"><i class="ti ti-bell-ringing me-1"></i> এসএমএস গেটওয়ে কনফিগারেশন</h6>
                    <div class="form-check form-switch mb-0">
                        <input type="checkbox" class="form-check-input" id="bangla_sms_enabled" name="bangla_sms_enabled" value="on"
                            {{ \App\Models\Utility::GetValueByName('bangla_sms_enabled', getCurrentStore()) == 'on' ? 'checked' : '' }}>
                        <label class="form-check-label" for="bangla_sms_enabled">অটো এসএমএস অন</label>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label font-weight-bold">এসএমএস সার্ভিস প্রোভাইডার</label>
                    @php
                        $selectedProvider = \App\Models\Utility::GetValueByName('bangla_sms_provider', getCurrentStore()) ?: 'greenweb';
                    @endphp
                    <select name="bangla_sms_provider" class="form-select form-control">
                        <option value="greenweb" {{ $selectedProvider == 'greenweb' ? 'selected' : '' }}>GreenwebBD (টোকেন ভিত্তিক)</option>
                        <option value="bulksmsbd" {{ $selectedProvider == 'bulksmsbd' ? 'selected' : '' }}>BulkSMSBD (ইউজার কি / API Key)</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label font-weight-bold">API Key / Token</label>
                    <input type="text" name="bangla_sms_api_key" class="form-control" placeholder="আপনার SMS Gateway Token বা API Key"
                        value="{{ \App\Models\Utility::GetValueByName('bangla_sms_api_key', getCurrentStore()) }}">
                </div>

                <div class="form-group mb-3">
                    <label class="form-label font-weight-bold">Sender ID / Masking (ঐচ্ছিক)</label>
                    <input type="text" name="bangla_sms_sender_id" class="form-control" placeholder="যেমন: 8809612443880 বা শপের নাম"
                        value="{{ \App\Models\Utility::GetValueByName('bangla_sms_sender_id', getCurrentStore()) }}">
                    <small class="text-muted">নন-মাস্কিং হলে খালি রাখুন অথবা প্রোভাইডারের ডিফল্ট সেন্ডার আইডি দিন।</small>
                </div>
            </div>

            <div class="col-md-6 ps-md-4">
                <h6 class="fw-bold mb-3 text-primary"><i class="ti ti-mail-forward me-1"></i> অর্ডার কনফার্মেশন এসএমএস টেমপ্লেট</h6>
                <div class="form-group mb-3">
                    <label class="form-label font-weight-bold">মেসেজ বডি (বাংলা বা ইংরেজি)</label>
                    @php
                        $defaultTpl = "প্রিয় {name}, {store_name} এ আপনার অর্ডার #{order_id} সফলভাবে গৃহীত হয়েছে! মোট বিল: ৳{total}। শীঘ্রই কুরিয়ারে পাঠানো হবে।";
                        $savedTpl = \App\Models\Utility::GetValueByName('bangla_sms_order_template', getCurrentStore());
                    @endphp
                    <textarea name="bangla_sms_order_template" class="form-control" rows="4" placeholder="{{ $defaultTpl }}">{{ !empty($savedTpl) ? $savedTpl : $defaultTpl }}</textarea>
                    <small class="text-muted mt-1 d-block">
                        শর্টকোড ব্যবহার করতে পারেন: <code>{name}</code>, <code>{order_id}</code>, <code>{total}</code>, <code>{store_name}</code>
                    </small>
                </div>

                <!-- Test SMS Tool -->
                <div class="card bg-light border p-3 mt-3">
                    <label class="form-label font-weight-bold mb-1"><i class="ti ti-send me-1"></i> টেস্ট এসএমএস পাঠান</label>
                    <div class="input-group">
                        <input type="text" id="test_sms_phone" class="form-control" placeholder="017xxxxxxxx">
                        <button type="button" class="btn btn-outline-success font-weight-bold" onclick="sendQuickTestSms()">টেস্ট পাঠান</button>
                    </div>
                    <div id="test_sms_result" class="small mt-2" style="display: none;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer text-end">
        <button type="submit" class="btn btn-success px-4 font-weight-bold">
            <i class="ti ti-device-floppy me-1"></i> এসএমএস সেটিংস সংরক্ষণ করুন
        </button>
    </div>
    {!! Form::close() !!}
</div>

<script>
function sendQuickTestSms() {
    var phone = $('#test_sms_phone').val();
    if (!phone) {
        alert('দয়া করে ফোন নম্বর লিখুন!');
        return;
    }
    $('#test_sms_result').show().html('<span class="text-primary">এসএমএস পাঠানো হচ্ছে...</span>');
    $.ajax({
        url: "{{ route('sms.send.test') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            phone: phone
        },
        success: function(res) {
            if (res.success) {
                $('#test_sms_result').html('<span class="text-success fw-bold">✓ টেস্ট এসএমএস সফলভাবে পাঠানো হয়েছে!</span>');
            } else {
                $('#test_sms_result').html('<span class="text-danger">' + (res.message || res.error || 'ব্যর্থ হয়েছে') + '</span>');
            }
        },
        error: function(err) {
            $('#test_sms_result').html('<span class="text-danger">সার্ভার ত্রুটি: ' + err.statusText + '</span>');
        }
    });
}
</script>

