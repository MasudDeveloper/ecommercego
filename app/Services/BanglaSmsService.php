<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Setting;
use App\Models\Store;
use App\Models\Utility;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BanglaSmsService
{
    /**
     * Send Order Confirmation SMS using GreenwebBD or BulksmsBD
     */
    public static function sendOrderConfirmation(Order $order): array
    {
        $storeId = $order->store_id ?? (getCurrentStore() ?: 1);
        $store = Store::find($storeId);

        // Check if SMS is enabled
        $isEnabled = Utility::GetValueByName('bangla_sms_enabled', $storeId);
        if ($isEnabled !== 'on') {
            return ['success' => false, 'message' => 'SMS gateway is disabled for this store'];
        }

        $provider = Utility::GetValueByName('bangla_sms_provider', $storeId) ?: 'greenweb';
        $apiKey = Utility::GetValueByName('bangla_sms_api_key', $storeId);
        $senderId = Utility::GetValueByName('bangla_sms_sender_id', $storeId);
        $customTemplate = Utility::GetValueByName('bangla_sms_order_template', $storeId);

        if (empty($apiKey)) {
            return ['success' => false, 'message' => 'SMS API Key / Token is missing'];
        }

        // Get customer billing / delivery detail
        $billing = \App\Models\OrderBillingDetail::where('order_id', $order->id)->first();
        if ($billing && !empty($billing->telephone)) {
            $phone = $billing->telephone;
            $customerName = trim($billing->first_name . ' ' . $billing->last_name) ?: 'সম্মানিত গ্রাহক';
        } else {
            $deliveryInfo = is_array($order->delivery_informations) 
                ? $order->delivery_informations 
                : json_decode($order->delivery_informations ?? '[]', true);
            $phone = $deliveryInfo['phone'] ?? ($deliveryInfo['billing_user_telephone'] ?? '');
            $customerName = $deliveryInfo['name'] ?? 'সম্মানিত গ্রাহক';
        }

        // Sanitize phone (e.g. 017xxxxxxxx or +88017xxxxxxxx)
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
        if (strlen($cleanPhone) === 11 && str_starts_with($cleanPhone, '01')) {
            $cleanPhone = '88' . $cleanPhone;
        } elseif (strlen($cleanPhone) === 10 && str_starts_with($cleanPhone, '1')) {
            $cleanPhone = '880' . $cleanPhone;
        }

        if (strlen($cleanPhone) < 13) {
            return ['success' => false, 'message' => 'Invalid Bangladeshi phone number: ' . $phone];
        }

        $storeName = $store->name ?? 'edokanpro';
        $totalAmount = number_format($order->final_price ?? 0, 0);
        $orderId = $order->product_order_id ?? ($order->order_id ?? $order->id);

        // Message body
        if (!empty($customTemplate)) {
            $message = str_replace(
                ['{name}', '{order_id}', '{total}', '{store_name}'],
                [$customerName, $orderId, $totalAmount, $storeName],
                $customTemplate
            );
        } else {
            $message = "প্রিয় {$customerName}, {$storeName} এ আপনার অর্ডার #{$orderId} সফল হয়েছে! মোট বিল: ৳{$totalAmount}। দ্রুতই ডেলিভারি করা হবে।";
        }

        return self::dispatchSms($provider, $apiKey, $senderId, $cleanPhone, $message);
    }

    /**
     * Dispatch SMS to the selected Bangladeshi SMS provider
     */
    public static function dispatchSms(string $provider, string $apiKey, ?string $senderId, string $phone, string $message): array
    {
        try {
            if ($provider === 'bulksmsbd') {
                // BulksmsBD API
                $url = 'http://bulksmsbd.net/api/smsapi';
                $params = [
                    'api_key' => $apiKey,
                    'type' => 'text',
                    'number' => $phone,
                    'senderid' => $senderId ?: '8809612443880',
                    'message' => $message,
                ];
                $response = Http::timeout(10)->get($url, $params);
                $resBody = $response->body();
                Log::info('BulksmsBD Response: ' . $resBody);

                return [
                    'success' => $response->successful(),
                    'provider' => 'BulksmsBD',
                    'response' => $resBody,
                ];
            } else {
                // GreenwebBD API
                $url = 'http://api.greenweb.com.bd/api.php';
                $params = [
                    'token' => $apiKey,
                    'to' => $phone,
                    'message' => $message,
                ];
                $response = Http::timeout(10)->post($url, $params);
                $resBody = $response->body();
                Log::info('GreenwebBD Response: ' . $resBody);

                return [
                    'success' => $response->successful(),
                    'provider' => 'GreenwebBD',
                    'response' => $resBody,
                ];
            }
        } catch (\Throwable $e) {
            Log::error('SMS Dispatch Error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
