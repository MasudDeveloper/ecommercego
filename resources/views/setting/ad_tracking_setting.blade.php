<div class="card" id="Ad_Tracking_Setting">
    <div class="card-header">
        <h5 class="mb-1"><i class="ti ti-chart-arrows-vertical me-1"></i> ফেসবুক Conversions API (CAPI) ও টিকটক পিক্সেল</h5>
        <small class="text-muted">ব্রাউজার অ্যাড-ব্লকার ও iOS 14+ এর কারণে হারানো ২৫-৪০% সেলস ডাটা নিখুঁতভাবে রিকভার করতে সার্ভার-সাইড পিক্সেল ব্যবহার করুন।</small>
    </div>
    {!! Form::open(['route' => 'sms.save.settings', 'method' => 'POST']) !!}
    <div class="card-body">
        <div class="row">
            <!-- Facebook CAPI -->
            <div class="col-md-6 border-end pe-md-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0 text-primary"><i class="ti ti-brand-facebook me-1"></i> Facebook Conversions API (CAPI)</h6>
                    <div class="form-check form-switch mb-0">
                        <input type="checkbox" class="form-check-input" id="facebook_capi_enabled" name="facebook_capi_enabled" value="on"
                            {{ \App\Models\Utility::GetValueByName('facebook_capi_enabled', getCurrentStore()) == 'on' ? 'checked' : '' }}>
                        <label class="form-check-label" for="facebook_capi_enabled">সক্রিয় করুন</label>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label font-weight-bold">Facebook Pixel ID / Dataset ID</label>
                    <input type="text" name="facebook_capi_pixel_id" class="form-control" placeholder="যেমন: 123456789012345"
                        value="{{ \App\Models\Utility::GetValueByName('facebook_capi_pixel_id', getCurrentStore()) }}">
                    <small class="text-muted">Meta Events Manager থেকে আপনার Pixel ID বা Dataset ID দিন।</small>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label font-weight-bold">Meta CAPI Access Token</label>
                    <textarea name="facebook_capi_access_token" class="form-control" rows="3" placeholder="EAABsbCS1... (Permanent System User Token)">{{ \App\Models\Utility::GetValueByName('facebook_capi_access_token', getCurrentStore()) }}</textarea>
                    <small class="text-muted">Meta Business Suite -> Events Manager -> Settings -> Generate Access Token থেকে সংগ্রহ করুন।</small>
                </div>

                <div class="alert alert-primary py-2 small mb-0">
                    <i class="ti ti-shield-check me-1"></i> প্রতিটি অর্ডারের সময় কাস্টমারের নাম, ফোন (SHA256 এনক্রিপ্টেড) ও টাকার পরিমাণ সরাসরি ফেসবুক সার্ভারে সুরক্ষিতভাবে পৌঁছাবে।
                </div>
            </div>

            <!-- TikTok Pixel -->
            <div class="col-md-6 ps-md-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0 text-dark"><i class="ti ti-brand-tiktok me-1"></i> TikTok Pixel Integration</h6>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label font-weight-bold">TikTok Pixel ID</label>
                    <input type="text" name="tiktok_pixel_id" class="form-control" placeholder="যেমন: C1234567890ABCDEFG"
                        value="{{ \App\Models\Utility::GetValueByName('tiktok_pixel_id', getCurrentStore()) }}">
                    <small class="text-muted">TikTok Ads Manager -> Assets -> Events -> Web Events থেকে পিক্সেল আইডি দিন।</small>
                </div>

                <div class="alert alert-dark py-2 small mb-0 mt-4">
                    <i class="ti ti-sparkles me-1"></i> টিকটক পিক্সেল সক্রিয় থাকলে সকল ল্যান্ডিং পেজে স্বয়ংক্রিয়ভাবে <code>PageView</code> এবং অর্ডার পেজে <code>CompletePayment</code> ইভেন্ট ফায়ার হবে।
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer text-end">
        <button type="submit" class="btn btn-primary px-4 font-weight-bold">
            <i class="ti ti-device-floppy me-1"></i> ট্র্যাকিং সেটিংস সংরক্ষণ করুন
        </button>
    </div>
    {!! Form::close() !!}
</div>

