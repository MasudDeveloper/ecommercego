<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Setting;
use App\Models\Utility;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FacebookCapiService
{
    /**
     * Send server-side Purchase event to Meta Conversions API
     */
    public static function sendPurchaseEvent(Order $order): array
    {
        $storeId = $order->store_id ?? (getCurrentStore() ?: 1);

        $pixelId = Utility::GetValueByName('facebook_capi_pixel_id', $storeId);
        $accessToken = Utility::GetValueByName('facebook_capi_access_token', $storeId);

        // Fallback to PixelFields if empty
        if (empty($pixelId)) {
            $pixel = \App\Models\PixelFields::where('store_id', $storeId)->where('platform', 'facebook')->first();
            if ($pixel) {
                $pixelId = $pixel->pixel_id;
            }
        }

        if (empty($pixelId) || empty($accessToken)) {
            return ['success' => false, 'message' => 'Facebook Pixel ID or CAPI Access Token not configured'];
        }

        $deliveryInfo = is_array($order->delivery_informations) 
            ? $order->delivery_informations 
            : json_decode($order->delivery_informations ?? '[]', true);

        $phone = $deliveryInfo['phone'] ?? ($deliveryInfo['billing_user_telephone'] ?? '');
        $email = $deliveryInfo['email'] ?? '';
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
        if (strlen($cleanPhone) === 11 && str_starts_with($cleanPhone, '01')) {
            $cleanPhone = '88' . $cleanPhone;
        }

        $userData = [
            'client_ip_address' => request()->ip() ?? '127.0.0.1',
            'client_user_agent' => request()->userAgent() ?? 'Mozilla/5.0',
        ];

        if (!empty($cleanPhone)) {
            $userData['ph'] = [hash('sha256', $cleanPhone)];
        }
        if (!empty($email)) {
            $userData['em'] = [hash('sha256', strtolower(trim($email)))];
        }

        $payload = [
            'data' => [
                [
                    'event_name' => 'Purchase',
                    'event_time' => time(),
                    'action_source' => 'website',
                    'event_source_url' => request()->fullUrl(),
                    'user_data' => $userData,
                    'custom_data' => [
                        'currency' => 'BDT',
                        'value' => (float)($order->final_price ?? 0),
                        'order_id' => (string)($order->order_id ?? $order->id),
                    ],
                ]
            ]
        ];

        try {
            $url = "https://graph.facebook.com/v19.0/{$pixelId}/events?access_token={$accessToken}";
            $response = Http::timeout(10)->post($url, $payload);
            Log::info('Facebook CAPI Response: ' . $response->body());

            return [
                'success' => $response->successful(),
                'response' => $response->json(),
            ];
        } catch (\Throwable $e) {
            Log::error('Facebook CAPI Error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}

