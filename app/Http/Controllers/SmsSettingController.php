<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Utility;
use App\Services\BanglaSmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SmsSettingController extends Controller
{
    /**
     * Save Local Bulk SMS Settings
     */
    public function saveSettings(Request $request)
    {
        $storeId = getCurrentStore() ?: 1;
        $userId = Auth::id() ?: 1;

        $fields = [
            'bangla_sms_enabled' => $request->bangla_sms_enabled ?? 'off',
            'bangla_sms_provider' => $request->bangla_sms_provider ?? 'greenweb',
            'bangla_sms_api_key' => $request->bangla_sms_api_key ?? '',
            'bangla_sms_sender_id' => $request->bangla_sms_sender_id ?? '',
            'bangla_sms_order_template' => $request->bangla_sms_order_template ?? '',
            'facebook_capi_enabled' => $request->facebook_capi_enabled ?? 'off',
            'facebook_capi_pixel_id' => $request->facebook_capi_pixel_id ?? '',
            'facebook_capi_access_token' => $request->facebook_capi_access_token ?? '',
            'tiktok_pixel_id' => $request->tiktok_pixel_id ?? '',
        ];

        foreach ($fields as $key => $val) {
            Setting::updateOrCreate(
                ['name' => $key, 'store_id' => $storeId],
                ['value' => $val, 'created_by' => $userId]
            );
        }

        return redirect()->back()->with('success', 'এসএমএস ও ট্র্যাকিং পিক্সেল সেটিংস সফলভাবে সেভ হয়েছে!');
    }

    /**
     * Send Test SMS
     */
    public function sendTestSms(Request $request)
    {
        $phone = $request->input('phone');
        $storeId = getCurrentStore() ?: 1;

        $provider = Utility::GetValueByName('bangla_sms_provider', $storeId) ?: 'greenweb';
        $apiKey = Utility::GetValueByName('bangla_sms_api_key', $storeId);
        $senderId = Utility::GetValueByName('bangla_sms_sender_id', $storeId);

        if (empty($apiKey)) {
            return response()->json(['success' => false, 'message' => 'দয়া করে প্রথমে SMS API Key / Token প্রদান করুন।']);
        }

        $res = BanglaSmsService::dispatchSms(
            $provider,
            $apiKey,
            $senderId,
            $phone,
            'edokanpro টেস্ট মেসেজ: আপনার এসএমএস গেটওয়ে সফলভাবে সক্রিয় রয়েছে!'
        );

        return response()->json($res);
    }
}

