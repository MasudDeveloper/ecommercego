<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\PlanOrder;
use App\Models\User;
use App\Models\Setting;
use App\Models\ReceivedSmsNotification;
use App\Models\MarketingAgent;
use App\Models\AgentCommission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class BkashPlanPaymentController extends Controller
{
    /**
     * Show bKash Send Money Payment Checkout Page for a Plan
     */
    public function showCheckout($encryptedPlanId)
    {
        try {
            $planId = Crypt::decrypt($encryptedPlanId);
        } catch (\Exception $e) {
            $planId = $encryptedPlanId;
        }

        $plan = Plan::findOrFail($planId);

        if ($plan->price <= 0) {
            return redirect()->route('plan.index')->with('error', 'ফ্রি প্ল্যানে কোনো পেমেন্ট প্রয়োজন নেই।');
        }

        $bkashNumber = Setting::where('name', 'bkash_personal_number')->value('value') ?? '01899112233';
        $nagadNumber = Setting::where('name', 'nagad_personal_number')->value('value') ?? '01899112233';
        $rocketNumber = Setting::where('name', 'rocket_personal_number')->value('value') ?? '01899112233';
        $user = Auth::user();

        return view('plans.bkash_checkout', compact('plan', 'bkashNumber', 'nagadNumber', 'rocketNumber', 'user'));
    }

    /**
     * Process User's bKash TrxID Submission
     */
    public function submitPayment(Request $request)
    {
        $gateway = strtolower($request->input('gateway', 'bkash'));
        $gatewayLabel = ($gateway == 'nagad') ? 'নগদ' : (($gateway == 'rocket') ? 'রকেট' : 'বিকাশ');

        $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'sender_number' => 'required|string|min:11|max:15',
            'trx_id' => 'required|string|min:6|max:30',
        ], [
            'sender_number.required' => "প্রেরকের {$gatewayLabel} নম্বর দিন।",
            'trx_id.required' => "{$gatewayLabel} ট্রানজেকশন আইডি (TrxID) দিন।",
        ]);

        $user = Auth::user();
        $plan = Plan::findOrFail($request->plan_id);
        $trxId = strtoupper(trim($request->trx_id));
        $senderNumber = preg_replace('/[^0-9]/', '', $request->sender_number);

        // Check if TrxID was already used in a completed order
        $existingSuccess = PlanOrder::where('txn_id', $trxId)
            ->where('payment_status', 'success')
            ->first();

        if ($existingSuccess) {
            return back()->with('error', 'এই ট্রানজেকশন আইডি (TrxID) দিয়ে ইতিপূর্বে একটি পেমেন্ট সম্পন্ন করা হয়েছে।');
        }

        // Check if this TrxID was already intercepted by Android SMS Verifier App
        $smsMatch = ReceivedSmsNotification::where('trx_id', $trxId)
            ->where('status', 'unmatched')
            ->first();

        $gatewayUpper = ucfirst($gateway);

        // If amount matches SMS notification, auto-activate immediately!
        if ($smsMatch && (float)$smsMatch->amount >= (float)$plan->price) {
            // 1. Create completed PlanOrder
            $order = PlanOrder::create([
                'order_id' => strtoupper($gateway) . '-' . strtoupper(uniqid()),
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'plan_name' => $plan->name,
                'plan_id' => $plan->id,
                'price' => $plan->price,
                'price_currency' => 'BDT',
                'txn_id' => $trxId,
                'payment_type' => $gatewayUpper . ' Send Money',
                'sender_number' => $senderNumber,
                'payment_status' => 'success',
                'verified_at' => Carbon::now(),
                'verified_by' => 'android_app',
                'admin_notes' => 'Android SMS Verifier App দ্বারা তাৎক্ষণিকভাবে অটো-ভেরিফাইড।',
            ]);

            // 2. Mark SMS notification as matched
            $smsMatch->update([
                'status' => 'matched',
                'matched_order_id' => $order->id,
            ]);

            // 3. Activate Plan on User
            $this->activateUserPlan($user, $plan, $order);

            return redirect()->route('plan.index')->with('success', '🎉 চমৎকার! আপনার ' . $gatewayLabel . ' পেমেন্ট (TrxID: ' . $trxId . ') সফলভাবে অটো-ভেরিফাই হয়েছে এবং "' . $plan->name . '" প্ল্যানটি তাৎক্ষণিকভাবে সক্রিয় করা হয়েছে!');
        }

        // Otherwise create Pending PlanOrder and wait for Android App to intercept SMS
        $order = PlanOrder::create([
            'order_id' => strtoupper($gateway) . '-' . strtoupper(uniqid()),
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'plan_name' => $plan->name,
            'plan_id' => $plan->id,
            'price' => $plan->price,
            'price_currency' => 'BDT',
            'txn_id' => $trxId,
            'payment_type' => $gatewayUpper . ' Send Money',
            'sender_number' => $senderNumber,
            'payment_status' => 'pending',
            'admin_notes' => 'গ্রাহক দ্বারা TrxID জমা দেওয়া হয়েছে। SMS নোটিফিকেশনের অপেক্ষায় রয়েছে।',
        ]);

        return redirect()->route('plan.order.waiting', $order->id);
    }

    /**
     * Waiting Page with Real-Time Auto-Verification Status Poller
     */
    public function orderWaiting($orderId)
    {
        $order = PlanOrder::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($order->payment_status === 'success') {
            return redirect()->route('plan.index')->with('success', '🎉 আপনার প্ল্যানটি সক্রিয় করা হয়েছে!');
        }

        $plan = Plan::find($order->plan_id);

        return view('plans.bkash_waiting', compact('order', 'plan'));
    }

    /**
     * AJAX Endpoint to Poll Pending Order Status
     */
    public function checkOrderStatus($orderId)
    {
        $order = PlanOrder::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->first();

        if (!$order) {
            return response()->json(['status' => 'not_found'], 404);
        }

        return response()->json([
            'status' => $order->payment_status,
            'is_success' => $order->payment_status === 'success',
            'verified_by' => $order->verified_by,
        ]);
    }

    /**
     * API Webhook: Called by Android Notification Verifier App
     */
    public function receiveNotificationApi(Request $request)
    {
        // 1. Verify Secret Token
        $configuredToken = Setting::where('name', 'sms_verifier_token')->value('value') ?? 'edokanpro_verifier_secret_2026';
        $providedToken = $request->header('X-Device-Token') ?? $request->input('token');

        if (!$providedToken || $providedToken !== $configuredToken) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized device. Invalid security token.',
            ], 401);
        }

        $request->validate([
            'amount' => 'required|numeric',
            'trx_id' => 'required|string',
        ]);

        $trxId = strtoupper(trim($request->input('trx_id')));
        $amount = (float)$request->input('amount');
        $sender = preg_replace('/[^0-9]/', '', (string)$request->input('sender', ''));
        $gateway = strtolower($request->input('gateway', 'bkash'));
        $rawNotification = $request->input('raw_notification', '');
        $deviceInfo = $request->input('device_info', $request->userAgent());

        Log::info("bKash Android App Intercepted: TrxID: {$trxId}, Amount: {$amount}, Sender: {$sender}");

        // Prevent duplicate insertion of identical TrxID notification
        $existingLog = ReceivedSmsNotification::where('trx_id', $trxId)->first();
        if ($existingLog) {
            // If already matched, return success
            if ($existingLog->status === 'matched') {
                return response()->json([
                    'success' => true,
                    'matched' => true,
                    'message' => 'Notification already matched with order #' . $existingLog->matched_order_id,
                ]);
            }
            $smsLog = $existingLog;
        } else {
            $smsLog = ReceivedSmsNotification::create([
                'gateway' => $gateway,
                'sender_number' => $sender,
                'amount' => $amount,
                'trx_id' => $trxId,
                'raw_notification' => $rawNotification,
                'status' => 'unmatched',
                'device_info' => $deviceInfo,
            ]);
        }

        // 2. Search for a pending PlanOrder with matching TrxID (or matching amount & sender)
        $pendingOrder = PlanOrder::where('payment_status', 'pending')
            ->where(function ($q) use ($trxId, $amount, $sender) {
                $q->where('txn_id', $trxId);
                if (!empty($sender)) {
                    $q->orWhere(function ($sub) use ($amount, $sender) {
                        $sub->where('price', '<=', $amount)
                            ->where('sender_number', $sender);
                    });
                }
            })
            ->latest()
            ->first();

        if ($pendingOrder) {
            $user = User::find($pendingOrder->user_id);
            $plan = Plan::find($pendingOrder->plan_id);

            if ($user && $plan) {
                // Update Order Status
                $pendingOrder->update([
                    'payment_status' => 'success',
                    'verified_at' => Carbon::now(),
                    'verified_by' => 'android_app',
                    'txn_id' => $trxId,
                    'admin_notes' => 'Android App দ্বারা নোটিফিকেশন রিড করে স্বয়ংক্রিয়ভাবে সক্রিয় করা হয়েছে।',
                ]);

                // Update SMS Log
                $smsLog->update([
                    'status' => 'matched',
                    'matched_order_id' => $pendingOrder->id,
                ]);

                // Activate Plan & Commission
                $this->activateUserPlan($user, $plan, $pendingOrder);

                return response()->json([
                    'success' => true,
                    'matched' => true,
                    'order_id' => $pendingOrder->order_id,
                    'user' => $user->name,
                    'plan' => $plan->name,
                    'amount' => $amount,
                    'message' => "Order #{$pendingOrder->order_id} verified and '{$plan->name}' activated for user {$user->name}!",
                ]);
            }
        }

        // Notification saved in DB, waiting for user to submit form
        return response()->json([
            'success' => true,
            'matched' => false,
            'trx_id' => $trxId,
            'amount' => $amount,
            'message' => 'Notification logged successfully. Awaiting user submission in web portal.',
        ]);
    }

    /**
     * Super Admin Plan Payment Requests Management
     */
    public function adminPaymentRequests()
    {
        if (!Auth::check() || Auth::user()->type !== 'super admin') {
            abort(403, 'Permission denied.');
        }

        $orders = PlanOrder::where('payment_type', 'like', '%bKash%')
            ->orWhereNotNull('sender_number')
            ->latest()
            ->paginate(15);

        $smsLogs = ReceivedSmsNotification::latest()->take(20)->get();
        $bkashNumber = Setting::where('name', 'bkash_personal_number')->value('value') ?? '01899112233';
        $verifierToken = Setting::where('name', 'sms_verifier_token')->value('value') ?? 'edokanpro_verifier_secret_2026';

        return view('plans.admin_payment_requests', compact('orders', 'smsLogs', 'bkashNumber', 'verifierToken'));
    }

    /**
     * Super Admin Manual Approval
     */
    public function adminApproveOrder($orderId)
    {
        if (!Auth::check() || Auth::user()->type !== 'super admin') {
            abort(403, 'Permission denied.');
        }

        $order = PlanOrder::findOrFail($orderId);
        $user = User::findOrFail($order->user_id);
        $plan = Plan::findOrFail($order->plan_id);

        $order->update([
            'payment_status' => 'success',
            'verified_at' => Carbon::now(),
            'verified_by' => 'super_admin_manual',
            'admin_notes' => 'সুপার অ্যাডমিন কর্তৃক ম্যানুয়ালি যাচাই ও সক্রিয় করা হয়েছে।',
        ]);

        $this->activateUserPlan($user, $plan, $order);

        return back()->with('success', "অর্ডার #{$order->order_id} সফলভাবে অনুমোদন করা হয়েছে এবং {$user->name}-এর অ্যাকাউন্টে '{$plan->name}' সক্রিয় করা হয়েছে।");
    }

    /**
     * Super Admin Manual Reject
     */
    public function adminRejectOrder(Request $request, $orderId)
    {
        if (!Auth::check() || Auth::user()->type !== 'super admin') {
            abort(403, 'Permission denied.');
        }

        $order = PlanOrder::findOrFail($orderId);
        $order->update([
            'payment_status' => 'rejected',
            'admin_notes' => $request->input('notes', 'অ্যাডমিন কর্তৃক পেমেন্ট তথ্য অমিল হওয়ায় বাতিল করা হয়েছে।'),
        ]);

        return back()->with('error', "অর্ডার #{$order->order_id} বাতিল করা হয়েছে।");
    }

    /**
     * Super Admin Save bKash Settings
     */
    public function adminSaveSettings(Request $request)
    {
        if (!Auth::check() || Auth::user()->type !== 'super admin') {
            abort(403, 'Permission denied.');
        }

        $request->validate([
            'bkash_personal_number' => 'required|string',
            'sms_verifier_token' => 'required|string',
        ]);

        Setting::updateOrCreate(['name' => 'bkash_personal_number'], ['value' => $request->bkash_personal_number, 'store_id' => 1]);
        Setting::updateOrCreate(['name' => 'sms_verifier_token'], ['value' => $request->sms_verifier_token, 'store_id' => 1]);

        return back()->with('success', 'বিকাশ সেন্ড মানি নম্বর ও ভেরিফায়ার সিক্রেট টোকেন সফলভাবে সংরক্ষণ করা হয়েছে!');
    }

    /**
     * Helper to Activate User Plan and Process Agent Commission
     */
    protected function activateUserPlan(User $user, Plan $plan, PlanOrder $order)
    {
        // 1. Assign plan on user
        $user->assignPlan($plan->id);
        $user->trial_expire_date = null;
        if ($plan->duration === 'Month') {
            $user->plan_expire_date = Carbon::now()->addMonths(1)->format('Y-m-d');
        } elseif ($plan->duration === 'Year') {
            $user->plan_expire_date = Carbon::now()->addYears(1)->format('Y-m-d');
        } else {
            $user->plan_expire_date = Carbon::now()->addDays(30)->format('Y-m-d');
        }
        $user->save();

        // 2. Award Referral Commission to Marketing Agent if applicable
        if ($user->referred_by_agent_id) {
            $agent = MarketingAgent::find($user->referred_by_agent_id);
            if ($agent && $agent->is_active) {
                // Prevent duplicate commission for the same plan order
                $existingCommission = AgentCommission::where('plan_order_id', $order->id)->first();
                if (!$existingCommission) {
                    $rate = $agent->commission_rate ?? 15.00;
                    $commissionAmount = ($plan->price * $rate) / 100;

                    AgentCommission::create([
                        'agent_id' => $agent->id,
                        'user_id' => $user->id,
                        'plan_order_id' => $order->id,
                        'plan_id' => $plan->id,
                        'plan_name' => $plan->name,
                        'plan_price' => $plan->price,
                        'commission_rate' => $rate,
                        'commission_amount' => $commissionAmount,
                        'status' => 'approved',
                    ]);

                    Log::info("Agent Commission of ৳{$commissionAmount} awarded to Agent #{$agent->id} ({$agent->name}) for Plan #{$plan->id}");
                }
            }
        }
    }
}
