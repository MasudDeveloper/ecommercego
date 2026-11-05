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
