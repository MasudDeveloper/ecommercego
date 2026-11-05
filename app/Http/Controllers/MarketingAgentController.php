<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MarketingAgent;
use App\Models\AgentTarget;
use App\Models\AgentCommission;
use App\Models\User;
use App\Models\PlanOrder;
use Carbon\Carbon;
use Illuminate\Support\Str;

class MarketingAgentController extends Controller
{
    /**
     * Display a listing of marketing agents & performance dashboard
     */
    public function index()
    {
        if (!auth()->check() || auth()->user()->type != 'super admin') {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $agents = MarketingAgent::with(['referredUsers', 'commissions'])->latest()->get();
        $targets = AgentTarget::where('is_active', true)->get();

        // Calculate Summary Stats
        $totalAgents = $agents->count();
        $totalReferredUsers = User::whereNotNull('referred_by_agent_id')->count();
        $totalCommissions = AgentCommission::where('status', '!=', 'cancelled')->sum('commission_amount');
        $totalBonuses = AgentCommission::where('status', '!=', 'cancelled')->sum('bonus_amount');
        $totalEarned = $totalCommissions + $totalBonuses;
        $pendingPayout = AgentCommission::where('status', 'pending')->selectRaw('SUM(commission_amount + bonus_amount) as total')->value('total') ?? 0;
        $totalPaidOut = AgentCommission::where('status', 'paid')->selectRaw('SUM(commission_amount + bonus_amount) as total')->value('total') ?? 0;

        return view('marketing_agents.index', compact(
            'agents',
            'targets',
            'totalAgents',
            'totalReferredUsers',
            'totalEarned',
            'pendingPayout',
            'totalPaidOut'
        ));
    }

    /**
     * Store a new marketing agent
     */
    public function store(Request $request)
    {
        if (!auth()->check() || auth()->user()->type != 'super admin') {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'email' => 'nullable|email|max:255',
            'referral_code' => 'nullable|string|max:50|unique:marketing_agents,referral_code',
            'commission_rate' => 'required|numeric|min:1|max:100',
            'commission_type' => 'required|in:percentage,fixed',
            'payment_method' => 'nullable|string',
            'payout_details' => 'nullable|string',
        ]);

        $code = !empty($request->referral_code) 
            ? strtoupper(Str::slug($request->referral_code, '')) 
            : strtoupper(Str::random(6));

        MarketingAgent::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'referral_code' => $code,
            'commission_rate' => $request->commission_rate,
            'commission_type' => $request->commission_type,
            'payment_method' => $request->payment_method ?? 'bKash',
            'payout_details' => $request->payout_details ?? $request->phone,
            'is_active' => true,
            'notes' => $request->notes,
        ]);

        return redirect()->route('marketing-agents.index')->with('success', __('মার্কেটিং এজেন্ট সফলভাবে যুক্ত করা হয়েছে।'));
    }

    /**
     * Update agent details
     */
    public function update(Request $request, $id)
    {
        if (!auth()->check() || auth()->user()->type != 'super admin') {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $agent = MarketingAgent::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'referral_code' => 'required|string|max:50|unique:marketing_agents,referral_code,' . $agent->id,
            'commission_rate' => 'required|numeric|min:1|max:100',
            'commission_type' => 'required|in:percentage,fixed',
        ]);

        $agent->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'referral_code' => strtoupper(Str::slug($request->referral_code, '')),
            'commission_rate' => $request->commission_rate,
            'commission_type' => $request->commission_type,
            'payment_method' => $request->payment_method,
            'payout_details' => $request->payout_details,
            'is_active' => $request->has('is_active') ? true : false,
            'notes' => $request->notes,
        ]);

        return redirect()->route('marketing-agents.index')->with('success', __('এজেন্টের তথ্য আপডেট করা হয়েছে।'));
    }

    /**
     * Delete an agent
     */
    public function destroy($id)
    {
        if (!auth()->check() || auth()->user()->type != 'super admin') {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $agent = MarketingAgent::findOrFail($id);
        $agent->delete();

        return redirect()->route('marketing-agents.index')->with('success', __('এজেন্ট মুছে ফেলা হয়েছে।'));
    }

    /**
     * Manage Target Campaigns & Bonuses
     */
    public function targets()
    {
        if (!auth()->check() || auth()->user()->type != 'super admin') {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $targets = AgentTarget::latest()->get();
        $agents = MarketingAgent::where('is_active', true)->with('commissions')->get();

        return view('marketing_agents.targets', compact('targets', 'agents'));
    }

    /**
     * Store new Target Campaign
     */
    public function storeTarget(Request $request)
    {
        if (!auth()->check() || auth()->user()->type != 'super admin') {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'target_count' => 'required|integer|min:1',
            'period_type' => 'required|in:weekly,monthly,custom',
            'bonus_amount' => 'required|numeric|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        AgentTarget::create([
            'title' => $request->title,
            'target_count' => $request->target_count,
            'period_type' => $request->period_type,
            'bonus_amount' => $request->bonus_amount,
            'start_date' => $request->start_date ?? Carbon::now(),
            'end_date' => $request->end_date ?? ($request->period_type == 'weekly' ? Carbon::now()->addWeek() : Carbon::now()->addMonth()),
            'is_active' => true,
        ]);

        return redirect()->route('marketing-agents.targets')->with('success', __('নতুন টার্গেট বোনাস ক্যাম্পেইন তৈরি করা হয়েছে।'));
    }

    /**
     * Delete Target Campaign
     */
    public function destroyTarget($id)
    {
        if (!auth()->check() || auth()->user()->type != 'super admin') {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        AgentTarget::findOrFail($id)->delete();
        return redirect()->route('marketing-agents.targets')->with('success', __('টার্গেট মুছে ফেলা হয়েছে।'));
    }

    /**
     * View Commissions Ledger & Payouts
     */
    public function commissions(Request $request)
    {
        if (!auth()->check() || auth()->user()->type != 'super admin') {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $query = AgentCommission::with(['agent', 'user', 'target'])->latest();

        if ($request->has('agent_id') && !empty($request->agent_id)) {
            $query->where('agent_id', $request->agent_id);
        }

        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        $commissions = $query->paginate(25);
        $agents = MarketingAgent::all();

        return view('marketing_agents.commissions', compact('commissions', 'agents'));
    }

    /**
     * Process Payout / Mark as Paid
     */
    public function payout(Request $request, $id)
    {
        if (!auth()->check() || auth()->user()->type != 'super admin') {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        $commission = AgentCommission::findOrFail($id);

        $commission->update([
            'status' => 'paid',
            'payout_date' => Carbon::now(),
            'payout_method' => $request->payout_method ?? $commission->agent->payment_method ?? 'bKash',
            'payout_trx_id' => $request->payout_trx_id,
            'payout_notes' => $request->payout_notes,
        ]);

        return redirect()->back()->with('success', __('কমিশন সফলভাবে পরিশোধ (Paid) হিসেবে চিহ্নিত করা হয়েছে।'));
    }

    /**
     * Static Helper: Track Commission on Plan Order Success
     */
    public static function processPlanCommission($planOrder, $user)
    {
        if (!$user || empty($user->referred_by_agent_id)) {
            return;
        }

        $agent = MarketingAgent::find($user->referred_by_agent_id);
        if (!$agent || !$agent->is_active) {
            return;
        }

        // Avoid duplicate commission for same order
        $existing = AgentCommission::where('agent_id', $agent->id)
            ->where('plan_order_id', $planOrder->id ?? $planOrder->order_id)
            ->first();

        if ($existing) {
            return;
        }

        $planPrice = (float) ($planOrder->price ?? 0);
        if ($planPrice <= 0) {
            return; // Free plan or trial
        }

        // Calculate base commission
        if ($agent->commission_type == 'percentage') {
            $commissionAmount = round(($planPrice * $agent->commission_rate) / 100, 2);
        } else {
            $commissionAmount = (float) $agent->commission_rate;
        }

        // Record Base Commission
        $commissionRecord = AgentCommission::create([
            'agent_id' => $agent->id,
            'user_id' => $user->id,
            'plan_order_id' => $planOrder->id ?? $planOrder->order_id,
            'plan_id' => $planOrder->plan_id ?? null,
            'plan_name' => $planOrder->plan_name ?? 'Subscription Plan',
            'plan_price' => $planPrice,
            'commission_rate' => $agent->commission_rate,
            'commission_amount' => $commissionAmount,
            'status' => 'pending',
        ]);

        // Check if any active targets are completed by this order
        self::checkAndAwardTargetBonus($agent);
    }

    /**
     * Check if agent has reached a target and award bonus
     */
    protected static function checkAndAwardTargetBonus(MarketingAgent $agent)
    {
        $activeTargets = AgentTarget::where('is_active', true)->get();

        foreach ($activeTargets as $target) {
            // Check if bonus already awarded for this target in the current period
            $alreadyAwarded = AgentCommission::where('agent_id', $agent->id)
                ->where('bonus_target_id', $target->id)
                ->where('created_at', '>=', $target->start_date ?? Carbon::now()->startOfWeek())
                ->exists();

            if ($alreadyAwarded) {
                continue;
            }

            $progress = $agent->getTargetProgress($target);
            if ($progress['completed']) {
                // Award the Bonus!
                AgentCommission::create([
                    'agent_id' => $agent->id,
                    'user_id' => null,
                    'plan_order_id' => null,
                    'plan_name' => 'টার্গেট বোনাস: ' . $target->title,
                    'plan_price' => 0.00,
                    'commission_rate' => 0.00,
                    'commission_amount' => 0.00,
                    'bonus_target_id' => $target->id,
                    'bonus_amount' => $target->bonus_amount,
                    'status' => 'pending',
                    'payout_notes' => 'টার্গেট ' . $target->target_count . 'টি পেইড সাবস্ক্রিপশন সম্পন্ন করার বোনাস।',
                ]);
            }
        }
    }
}
