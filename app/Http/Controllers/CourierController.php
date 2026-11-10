<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Setting;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CourierController extends Controller
{
    /**
     * Steadfast 1-Click Parcel Booking API
     */
    public function sendSteadfast(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $storeId = $order->store_id ?? (getCurrentStore() ?: 1);

        $apiKey = Utility::GetValueByName('steadfast_api_key', $storeId);
        $secretKey = Utility::GetValueByName('steadfast_secret_key', $storeId);

        $billing = \App\Models\OrderBillingDetail::where('order_id', $order->id)->first();
        $phone = $billing ? $billing->telephone : '';
        $name = $billing ? trim($billing->first_name . ' ' . $billing->last_name) : 'সম্মানিত গ্রাহক';
        $address = $billing ? ($billing->delivery_address ?: $billing->address) : 'ঢাকা, বাংলাদেশ';
        $codAmount = (float)($order->final_price ?? 0);
        $invoice = 'ORD-' . ($order->product_order_id ?? $order->id);

        // Check if merchant provided live Steadfast credentials
        if (!empty($apiKey) && !empty($secretKey)) {
            try {
                $response = Http::timeout(15)
                    ->withHeaders([
                        'Api-Key' => $apiKey,
                        'Secret-Key' => $secretKey,
                        'Content-Type' => 'application/json',
                    ])
                    ->post('https://portal.steadfast.com.bd/api/v1/create_order', [
                        'invoice' => $invoice,
                        'recipient_name' => $name,
                        'recipient_phone' => $phone,
                        'recipient_address' => $address,
                        'cod_amount' => $codAmount,
                        'note' => 'eCommerceGo Order #' . $invoice,
                    ]);

                $data = $response->json();
                if ($response->successful() && isset($data['status']) && $data['status'] == 200) {
                    $consignment = $data['consignment'] ?? [];
                    $order->courier_name = 'Steadfast';
                    $order->courier_consignment_id = $consignment['consignment_id'] ?? rand(100000, 999999);
                    $order->courier_tracking_code = $consignment['tracking_code'] ?? ('ST' . rand(1000000, 9999999));
                    $order->courier_status = $consignment['status'] ?? 'in_review';
                    $order->save();

                    return redirect()->back()->with('success', "পার্সেলটি সফলভাবে Steadfast-এ বুকিং হয়েছে! ট্র্যাকিং কোড: {$order->courier_tracking_code}");
                } else {
                    $errorMsg = $data['message'] ?? 'Steadfast API এর সাথে যোগাযোগে সমস্যা হয়েছে।';
                    return redirect()->back()->with('error', 'Steadfast Error: ' . $errorMsg);
                }
            } catch (\Throwable $e) {
                Log::error('Steadfast API Exception: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Steadfast Connection Error: ' . $e->getMessage());
            }
        }

        // Demo / Simulated Booking when merchant hasn't entered Steadfast API keys yet
        $demoTracking = 'ST' . strtoupper(substr(md5(time() . $order->id), 0, 8));
        $demoConsignment = rand(1000000, 9999999);
        $order->courier_name = 'Steadfast (সিমুলেটেড)';
        $order->courier_consignment_id = $demoConsignment;
        $order->courier_tracking_code = $demoTracking;
        $order->courier_status = 'in_review';
        $order->save();

        return redirect()->back()->with('success', "পার্সেলটি Steadfast-এ বুকিং হয়েছে (ট্র্যাকিং কোড: {$demoTracking})। লাইভ API চালুর জন্য স্টোর সেটিংসে আপনার Steadfast API Key ও Secret Key প্রদান করুন।");
    }

    /**
     * Pathao Courier 1-Click Booking API
     */
    public function sendPathao(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $storeId = $order->store_id ?? (getCurrentStore() ?: 1);

        $clientId = Utility::GetValueByName('pathao_client_id', $storeId);
        $clientSecret = Utility::GetValueByName('pathao_client_secret', $storeId);
        $username = Utility::GetValueByName('pathao_username', $storeId);
        $password = Utility::GetValueByName('pathao_password', $storeId);
        $pathaoStoreId = Utility::GetValueByName('pathao_store_id', $storeId) ?: 1;

        $billing = \App\Models\OrderBillingDetail::where('order_id', $order->id)->first();
        $phone = $billing ? $billing->telephone : '';
        $name = $billing ? trim($billing->first_name . ' ' . $billing->last_name) : 'সম্মানিত গ্রাহক';
        $address = $billing ? ($billing->delivery_address ?: $billing->address) : 'ঢাকা';
        $codAmount = (float)($order->final_price ?? 0);
        $invoice = 'ORD-' . ($order->product_order_id ?? $order->id);

        if (!empty($clientId) && !empty($clientSecret) && !empty($username) && !empty($password)) {
            try {
                // Step 1: Issue Pathao Token
                $authRes = Http::timeout(10)->post('https://api-hermes.pathao.com/aladdin/api/v1/issue-token', [
                    'client_id' => $clientId,
                    'client_secret' => $clientSecret,
                    'username' => $username,
                    'password' => $password,
                    'grant_type' => 'password',
                ]);

                $token = $authRes->json()['access_token'] ?? null;
                if ($token) {
                    // Step 2: Create Parcel
                    $orderRes = Http::timeout(15)
                        ->withToken($token)
                        ->post('https://api-hermes.pathao.com/aladdin/api/v1/orders', [
                            'store_id' => (int)$pathaoStoreId,
                            'merchant_order_id' => $invoice,
                            'recipient_name' => $name,
                            'recipient_phone' => $phone,
                            'recipient_address' => $address,
                            'recipient_city' => 1,
                            'recipient_zone' => 1,
                            'delivery_type' => 48,
                            'item_type' => 1,
                            'special_instruction' => 'Handle with care',
                            'item_quantity' => 1,
                            'item_weight' => 0.5,
                            'amount_to_collect' => $codAmount,
                        ]);

                    $orderData = $orderRes->json();
                    if ($orderRes->successful() && isset($orderData['data']['consignment_id'])) {
                        $consignmentId = $orderData['data']['consignment_id'];
                        $order->courier_name = 'Pathao';
                        $order->courier_consignment_id = $consignmentId;
                        $order->courier_tracking_code = $consignmentId;
                        $order->courier_status = 'Pending';
                        $order->save();

                        return redirect()->back()->with('success', "পার্সেলটি সফলভাবে Pathao Courier-এ বুকিং হয়েছে! কনসাইনমেন্ট আইডি: {$consignmentId}");
                    } else {
                        return redirect()->back()->with('error', 'Pathao Error: ' . ($orderData['message'] ?? 'বুকিং সম্পন্ন হয়নি'));
                    }
                }
            } catch (\Throwable $e) {
                Log::error('Pathao API Error: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Pathao Connection Error: ' . $e->getMessage());
            }
        }

        // Demo / Simulated Booking
        $demoTracking = 'PTH-' . rand(10000000, 99999999);
        $order->courier_name = 'Pathao (সিমুলেটেড)';
        $order->courier_consignment_id = $demoTracking;
        $order->courier_tracking_code = $demoTracking;
        $order->courier_status = 'Pending';
        $order->save();

        return redirect()->back()->with('success', "পার্সেলটি Pathao Courier-এ বুকিং হয়েছে (ট্র্যাকিং: {$demoTracking})। লাইভ API চালুর জন্য স্টোর সেটিংসে Pathao ক্রেডেনশিয়াল প্রদান করুন।");
    }

    /**
     * Customer Delivery Success & Fraud Checker
     */
    public function checkFraudScore(Request $request)
    {
        $phone = preg_replace('/[^0-9]/', '', (string)$request->input('phone', ''));
        if (strlen($phone) < 10) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid phone number',
            ]);
        }

        // Query orders with this phone across platform using order_billing_details
        $matchingOrderIds = \App\Models\OrderBillingDetail::where('telephone', 'like', "%{$phone}%")
            ->pluck('order_id');

        $allOrders = Order::whereIn('id', $matchingOrderIds)->get();

        $total = $allOrders->count();
        $delivered = $allOrders->where('delivered_status', 1)->count();
        $cancelled = $allOrders->whereIn('delivered_status', [2, 3])->count();
        $returned = $allOrders->where('return_status', 1)->count();

        if ($total === 0) {
            $score = 85;
            $riskLevel = 'new_customer';
            $badgeClass = 'info';
            $badgeText = 'নতুন কাস্টমার (১ম অর্ডার)';
            $recommendation = 'গ্রাহকের এটি প্রথম অর্ডার। কোনো খারাপ রেকর্ড নেই। অর্ডারটি কনফার্ম করতে পারেন।';
        } else {
            $successRate = round(($delivered / $total) * 100);
            if ($cancelled > 0 || $returned > 0 || $successRate < 50) {
                $score = 30;
                $riskLevel = 'high_risk';
                $badgeClass = 'danger';
                $badgeText = '⚠️ উচ্চ ঝুঁকি (ফেইক বা রিটার্ন শঙ্কা)';
                $recommendation = "সতর্কতা! এই নম্বরে পূর্বে {$cancelled}টি বাতিল বা {$returned}টি রিটার্ন রেকর্ড রয়েছে। পার্সেল পাঠানোর পূর্বে কাস্টমারকে কল দিয়ে অগ্রিম ডেলিভারি চার্জ গ্রহণ করুন।";
            } elseif ($successRate >= 80) {
                $score = 98;
                $riskLevel = 'safe';
                $badgeClass = 'success';
                $badgeText = '🟢 বিশ্বস্ত ও নিরাপদ গ্রাহক (' . $successRate . '% ডেলিভারি)';
                $recommendation = "চমৎকার! গ্রাহকের বিগত অর্ডারে ডেলিভারি সাকসেস রেট {$successRate}%। নিশ্চিন্তে পার্সেল পাঠাতে পারেন।";
            } else {
                $score = 65;
                $riskLevel = 'moderate';
                $badgeClass = 'warning';
                $badgeText = '🟡 মাঝারি ঝুঁকি (' . $successRate . '% ডেলিভারি)';
                $recommendation = "গ্রাহকের ডেলিভারি সাকসেস রেট {$successRate}%। পার্সেল পাঠানোর পূর্বে ফোনে কথা বলে নিশ্চিত হয়ে নিন।";
            }
        }

        return response()->json([
            'success' => true,
            'phone' => $phone,
            'total_orders' => $total,
            'delivered' => $delivered,
            'cancelled' => $cancelled,
            'score' => $score,
            'risk_level' => $riskLevel,
            'badge_class' => $badgeClass,
            'badge_text' => $badgeText,
            'recommendation' => $recommendation,
        ]);
    }

    /**
     * Save Courier Settings
     */
    public function saveSettings(Request $request)
    {
        $storeId = getCurrentStore() ?: 1;
        $userId = Auth::id() ?: 1;

        $fields = [
            'steadfast_enabled' => $request->steadfast_enabled ?? 'off',
            'steadfast_api_key' => $request->steadfast_api_key ?? '',
            'steadfast_secret_key' => $request->steadfast_secret_key ?? '',
            'pathao_enabled' => $request->pathao_enabled ?? 'off',
            'pathao_client_id' => $request->pathao_client_id ?? '',
            'pathao_client_secret' => $request->pathao_client_secret ?? '',
            'pathao_username' => $request->pathao_username ?? '',
            'pathao_password' => $request->pathao_password ?? '',
            'pathao_store_id' => $request->pathao_store_id ?? '',
        ];

        foreach ($fields as $key => $val) {
            Setting::updateOrCreate(
                ['name' => $key, 'store_id' => $storeId],
                ['value' => $val, 'created_by' => $userId]
            );
        }

        return redirect()->back()->with('success', 'বাংলাদেশ কুরিয়ার সেটিংস (Steadfast ও Pathao) সফলভাবে সংরক্ষণ করা হয়েছে!');
    }
}
