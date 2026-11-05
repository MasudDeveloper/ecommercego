<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\MarketingAgent;

class AgentAuthController extends Controller
{
    /**
     * Show Agent Login Form
     */
    public function showLoginForm()
    {
        if (Auth::guard('agent')->check()) {
            return redirect()->route('agent.dashboard');
        }

        return view('agent.auth.login');
    }

    /**
     * Process Agent Login
     */
    public function login(Request $request)
    {
        $request->validate([
            'login_identifier' => 'required|string',
            'password' => 'required|string',
        ], [
            'login_identifier.required' => 'আপনার মোবাইল নম্বর, ইমেইল অথবা রেফারেল কোড লিখুন।',
            'password.required' => 'পাসওয়ার্ড লিখুন।',
        ]);

        $identifier = trim($request->login_identifier);

        // Find agent by phone, email, or referral code
        $agent = MarketingAgent::where('phone', $identifier)
            ->orWhere('email', $identifier)
            ->orWhere('referral_code', strtoupper($identifier))
            ->first();

        if (!$agent || !Hash::check($request->password, $agent->password)) {
            return back()->withErrors([
                'login_identifier' => 'মোবাইল নম্বর/ইমেইল অথবা পাসওয়ার্ড সঠিক নয়।',
            ])->withInput($request->only('login_identifier', 'remember'));
        }

        // Check if agent is pending approval
        if ($agent->approval_status === 'pending') {
            return back()->withErrors([
                'login_identifier' => '⏳ আপনার অ্যাকাউন্টটি বর্তমানে অ্যাডমিন অনুমোদনের অপেক্ষায় (Pending Approval) রয়েছে। অ্যাডমিন অনুমোদন দিলে আপনি ড্যাশবোর্ডে প্রবেশ করতে পারবেন।',
            ])->withInput($request->only('login_identifier', 'remember'));
        }

        // Check if agent was rejected
        if ($agent->approval_status === 'rejected') {
            return back()->withErrors([
                'login_identifier' => '❌ দুঃখিত, আপনার এজেন্ট আবেদনটি অ্যাডমিন কর্তৃক বাতিল (Rejected) করা হয়েছে। বিস্তারিত জানতে সাপোর্টের সাথে যোগাযোগ করুন।',
            ])->withInput($request->only('login_identifier', 'remember'));
        }

        // Check if agent is suspended by super admin
        if (!$agent->is_active) {
            return back()->withErrors([
                'login_identifier' => '⚠️ আপনার অ্যাকাউন্টটি অ্যাডমিন কর্তৃক সাময়িকভাবে স্থগিত (Suspended) রাখা হয়েছে। বিস্তারিত জানতে সহায়তার জন্য অ্যাডমিনের সাথে যোগাযোগ করুন।',
            ])->withInput($request->only('login_identifier', 'remember'));
        }

        Auth::guard('agent')->login($agent, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->intended(route('agent.dashboard'))->with('success', 'স্বাগতম ' . $agent->name . '! আপনার ড্যাশবোর্ডে প্রবেশ করেছেন।');
    }

    /**
     * Show Agent Self-Registration Form
     */
    public function showRegisterForm()
    {
        if (Auth::guard('agent')->check()) {
            return redirect()->route('agent.dashboard');
        }

        return view('agent.auth.register');
    }

    /**
     * Process Agent Self-Registration
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:30|unique:marketing_agents,phone',
            'email' => 'nullable|email|max:255|unique:marketing_agents,email',
            'password' => 'required|string|min:6|confirmed',
            'payment_method' => 'required|string|in:bKash,Nagad,Rocket,Bank',
            'payout_details' => 'required|string|max:100',
            'marketing_experience' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'আপনার পূর্ণ নাম লিখুন।',
            'phone.required' => 'মোবাইল নম্বর লিখুন।',
            'phone.unique' => 'এই মোবাইল নম্বর দিয়ে ইতিমধ্যে একটি অ্যাকাউন্ট রয়েছে।',
            'email.unique' => 'এই ইমেইল দিয়ে ইতিমধ্যে একটি অ্যাকাউন্ট রয়েছে।',
            'password.required' => 'পাসওয়ার্ড লিখুন।',
            'password.min' => 'পাসওয়ার্ড সর্বনিম্ন ৬ অক্ষরের হতে হবে।',
            'password.confirmed' => 'পাসওয়ার্ড কনফার্মেশন মিলছে না।',
            'payment_method.required' => 'উইথড্রয়াল পেমেন্ট মাধ্যম সিলেক্ট করুন।',
            'payout_details.required' => 'উইথড্রয়াল অ্যাকাউন্ট বা মোবাইল নম্বর লিখুন।',
        ]);

        // Generate unique referral code from name
        $cleanName = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $request->name));
        $prefix = substr($cleanName, 0, 5);
        if (strlen($prefix) < 3) {
            $prefix = 'AGENT';
        }

        do {
            $referralCode = $prefix . rand(100, 999);
        } while (MarketingAgent::where('referral_code', $referralCode)->exists());

        $notes = "ওয়েবসাইট থেকে সেলফ-রেজিস্ট্রেশন আবেদন।";
        if ($request->filled('marketing_experience')) {
            $notes .= " অভিজ্ঞতা/পরিকল্পনা: " . $request->marketing_experience;
        }

        $agent = MarketingAgent::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'referral_code' => $referralCode,
            'commission_rate' => 15.00,
            'commission_type' => 'percentage',
            'payment_method' => $request->payment_method,
            'payout_details' => $request->payout_details,
            'is_active' => false, // Inactive until approved by Super Admin
            'approval_status' => 'pending', // Pending Admin Approval
            'notes' => $notes,
        ]);

        return redirect()->route('agent.login')->with('registration_success', [
            'name' => $agent->name,
            'phone' => $agent->phone,
            'code' => $agent->referral_code,
        ]);
    }

    /**
     * Agent Logout
     */
    public function logout(Request $request)
    {
        Auth::guard('agent')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('agent.login')->with('info', 'আপনি সফলভাবে লগআউট হয়েছেন।');
    }
}
