<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\MarketingAgent;
use App\Models\AgentLead;
use App\Models\AgentPayoutRequest;
use App\Models\AgentCommission;
use App\Models\AgentTarget;
use App\Models\MarketingResource;
use Carbon\Carbon;

class AgentPortalController extends Controller
{
    /**
     * Get Current Authenticated Agent
     */
    protected function agent(): MarketingAgent
    {
        return Auth::guard('agent')->user();
    }

    /**
     * Agent Dashboard Overview
     */
    public function dashboard()
    {
        $agent = $this->agent();

        // Calculate Metrics
        $totalMerchants = $agent->totalReferredCount();
        $totalPaidOrders = $agent->totalPaidOrdersCount();
        $totalEarnings = $agent->totalEarnings();
        $pendingBalance = $agent->pendingBalance();
        $inProcessing = $agent->inProcessingPayoutAmount();
        $paidEarnings = $agent->paidEarnings();
        $rank = $agent->rank_details;

        // Targets & Challenges
        $targets = AgentTarget::where('is_active', true)->get()->map(function ($t) use ($agent) {
            $t->progress = $agent->getTargetProgress($t);
            return $t;
        });

        // Leads summary
        $leadCounts = [
            'total' => $agent->leads()->count(),
            'new' => $agent->leads()->where('status', 'new')->count(),
            'contacted' => $agent->leads()->where('status', 'contacted')->count(),
            'trial_started' => $agent->leads()->where('status', 'trial_started')->count(),
            'converted' => $agent->leads()->where('status', 'converted')->count(),
        ];

        // Recent Commissions
        $recentCommissions = $agent->commissions()->with('user')->latest()->take(6)->get();

        // Recent Merchants
        $recentMerchants = $agent->referredUsers()->latest()->take(5)->get();

        return view('agent.dashboard', compact(
            'agent',
            'totalMerchants',
            'totalPaidOrders',
            'totalEarnings',
            'pendingBalance',
            'inProcessing',
            'paidEarnings',
            'rank',
            'targets',
            'leadCounts',
            'recentCommissions',
            'recentMerchants'
        ));
    }

    /**
     * Agent Competition Leaderboard
     */
    public function leaderboard(Request $request)
    {
        $currentAgent = $this->agent();
        $timeframe = $request->get('timeframe', 'monthly'); // weekly, monthly, all_time

        $query = MarketingAgent::where('is_active', true);

        // Fetch all agents and calculate period stats
        $agents = $query->get()->map(function ($ag) use ($timeframe) {
            $commQuery = $ag->commissions()->where('status', '!=', 'cancelled')->whereNotNull('plan_order_id');

            if ($timeframe === 'weekly') {
                $commQuery->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            } elseif ($timeframe === 'monthly') {
                $commQuery->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
            }

            $conversions = $commQuery->count();
            $earnings = (float) $commQuery->sum('commission_amount');

            return (object) [
                'id' => $ag->id,
                'name' => $ag->name,
                'referral_code' => $ag->referral_code,
                'avatar' => $ag->avatar,
                'rank_details' => $ag->rank_details,
                'conversions' => $conversions,
                'earnings' => $earnings,
                'is_current' => ($ag->id === Auth::guard('agent')->id()),
            ];
        })->sortByDesc('conversions')->values();

        // Assign rankings
        $myRankPosition = null;
        foreach ($agents as $idx => $item) {
            $item->position = $idx + 1;
            if ($item->is_current) {
                $myRankPosition = $idx + 1;
            }
        }

        $topThree = $agents->take(3);
        $allRankings = $agents;

        return view('agent.leaderboard', compact('topThree', 'allRankings', 'myRankPosition', 'timeframe', 'currentAgent'));
    }

    /**
     * Mini CRM: Leads Management
     */
    public function leads(Request $request)
    {
        $agent = $this->agent();
        $query = $agent->leads()->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('shop_name', 'like', "%{$search}%")
                  ->orWhere('owner_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $leads = $query->paginate(15)->withQueryString();

        $counts = [
            'all' => $agent->leads()->count(),
            'new' => $agent->leads()->where('status', 'new')->count(),
            'contacted' => $agent->leads()->where('status', 'contacted')->count(),
            'trial_started' => $agent->leads()->where('status', 'trial_started')->count(),
            'converted' => $agent->leads()->where('status', 'converted')->count(),
            'follow_up' => $agent->leads()->where('status', 'follow_up')->count(),
            'lost' => $agent->leads()->where('status', 'lost')->count(),
        ];

        return view('agent.leads.index', compact('agent', 'leads', 'counts'));
    }

    /**
     * Store a new Lead in CRM
     */
    public function storeLead(Request $request)
    {
        $agent = $this->agent();

        $request->validate([
            'shop_name' => 'required|string|max:255',
            'owner_name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:30',
            'facebook_page' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:100',
            'status' => 'required|in:new,contacted,trial_started,converted,follow_up,lost',
            'expected_revenue' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $agent->leads()->create([
            'shop_name' => $request->shop_name,
            'owner_name' => $request->owner_name,
            'phone' => $request->phone,
            'facebook_page' => $request->facebook_page,
            'category' => $request->category,
            'status' => $request->status,
            'expected_revenue' => $request->expected_revenue ?? 0,
            'notes' => $request->notes,
            'last_contacted_at' => in_array($request->status, ['contacted', 'trial_started', 'converted', 'follow_up']) ? Carbon::now() : null,
        ]);

        return redirect()->route('agent.leads')->with('success', 'নতুন লিড সফলভাবে CRM-এ যুক্ত হয়েছে!');
    }

    /**
     * Update an existing Lead
     */
    public function updateLead(Request $request, $id)
    {
        $agent = $this->agent();
        $lead = $agent->leads()->findOrFail($id);

        $request->validate([
            'shop_name' => 'required|string|max:255',
            'owner_name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:30',
            'facebook_page' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:100',
            'status' => 'required|in:new,contacted,trial_started,converted,follow_up,lost',
            'expected_revenue' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $lead->update([
            'shop_name' => $request->shop_name,
            'owner_name' => $request->owner_name,
            'phone' => $request->phone,
            'facebook_page' => $request->facebook_page,
            'category' => $request->category,
            'status' => $request->status,
            'expected_revenue' => $request->expected_revenue ?? 0,
            'notes' => $request->notes,
            'last_contacted_at' => Carbon::now(),
        ]);

        return redirect()->route('agent.leads')->with('success', 'লিডের তথ্য সফলভাবে আপডেট হয়েছে!');
    }

    /**
     * Delete a Lead
     */
    public function deleteLead($id)
    {
        $agent = $this->agent();
        $lead = $agent->leads()->findOrFail($id);
        $lead->delete();

        return redirect()->route('agent.leads')->with('success', 'লিড সফলভাবে মুছে ফেলা হয়েছে!');
    }

    /**
     * Marketing Toolkit & Ready Scripts Playbook
     */
    public function resources()
    {
        $agent = $this->agent();

        $allResources = MarketingResource::active()->get();

        // Automatically replace placeholders with agent's actual link and code!
        $referralUrl = $agent->referral_url;
        $referralCode = $agent->referral_code;

        $resources = $allResources->map(function ($item) use ($referralUrl, $referralCode) {
            if ($item->content) {
                $item->personalized_content = str_replace(
                    ['{{referral_url}}', '{{referral_code}}'],
                    [$referralUrl, $referralCode],
                    $item->content
                );
            }
            return $item;
        });

        $inboxScripts = $resources->where('category', 'inbox_script');
        $commentScripts = $resources->where('category', 'comment_script');
        $objections = $resources->filter(fn($r) => in_array($r->category, ['objection', 'objection_handling']));
        $guides = $resources->where('category', 'guide');
        $banners = $resources->where('category', 'banner');
        $videoGuides = $resources->where('category', 'video_guide');
        $ebooks = $resources->where('category', 'ebook');

        return view('agent.resources.index', compact(
            'agent',
            'inboxScripts',
            'commentScripts',
            'objections',
            'guides',
            'banners',
            'videoGuides',
            'ebooks'
        ));
    }

    /**
     * Earnings Ledger & Wallet
     */
    public function wallet()
    {
        $agent = $this->agent();

        $totalEarnings = $agent->totalEarnings();
        $pendingBalance = $agent->pendingBalance();
        $inProcessing = $agent->inProcessingPayoutAmount();
        $paidEarnings = $agent->paidEarnings();

        // Payout Requests History
        $payoutRequests = $agent->payoutRequests()->latest()->paginate(10, ['*'], 'payout_page');

        // Commissions Ledger
        $commissions = $agent->commissions()->with('user')->latest()->paginate(15, ['*'], 'comm_page');

        return view('agent.wallet.index', compact(
            'agent',
            'totalEarnings',
            'pendingBalance',
            'inProcessing',
            'paidEarnings',
            'payoutRequests',
            'commissions'
        ));
    }

    /**
     * Submit Withdrawal Request (Min 500 BDT)
     */
    public function requestPayout(Request $request)
    {
        $agent = $this->agent();

        $request->validate([
            'amount' => 'required|numeric|min:500',
            'payment_method' => 'required|in:bKash,Nagad,Rocket,Bank',
            'account_details' => 'required|string|max:100',
            'notes' => 'nullable|string|max:255',
        ], [
            'amount.min' => 'সর্বনিম্ন উত্তোলন সীমা ৳৫০০ টাকা।',
            'account_details.required' => 'আপনার পেমেন্ট মোবাইল নম্বর বা ব্যাংক অ্যাকাউন্ট লিখুন।',
        ]);

        $available = $agent->pendingBalance();

        if ($request->amount > $available) {
            return back()->with('error', 'আপনার উত্তোলনযোগ্য ব্যালেন্সের চেয়ে বেশি রিকোয়েস্ট করেছেন। বর্তমান উত্তোলনযোগ্য ব্যালেন্স: ৳' . number_format($available, 2));
        }

        AgentPayoutRequest::create([
            'agent_id' => $agent->id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'account_details' => $request->account_details,
            'agent_notes' => $request->notes,
            'status' => 'pending',
        ]);

        return redirect()->route('agent.wallet')->with('success', '৳' . number_format($request->amount, 2) . ' উত্তোলনের রিকোয়েস্ট সফলভাবে জমা হয়েছে! অ্যাডমিন ভেরিফাই করে দ্রুত পেমেন্ট পরিশোধ করবেন।');
    }

    /**
     * Agent Profile View & Edit
     */
    public function profile()
    {
        $agent = $this->agent();
        return view('agent.profile', compact('agent'));
    }

    /**
     * Update Agent Profile
     */
    public function updateProfile(Request $request)
    {
        $agent = $this->agent();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'payment_method' => 'required|string',
            'payout_details' => 'required|string',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:6|confirmed',
        ]);

        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $agent->password)) {
                return back()->withErrors(['current_password' => 'বর্তমান পাসওয়ার্ড সঠিক নয়!']);
            }
            $agent->password = Hash::make($request->new_password);
        }

        $agent->name = $request->name;
        $agent->phone = $request->phone;
        $agent->payment_method = $request->payment_method;
        $agent->payout_details = $request->payout_details;
        $agent->save();

        return back()->with('success', 'আপনার প্রোফাইল তথ্য সফলভাবে আপডেট হয়েছে!');
    }
}

