<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class MarketingAgent extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'marketing_agents';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'avatar',
        'rank_badge',
        'referral_code',
        'commission_rate',
        'commission_type',
        'payment_method',
        'payout_details',
        'is_active',
        'approval_status',
        'notes',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'commission_rate' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Users registered through this agent's referral link
     */
    public function referredUsers()
    {
        return $this->hasMany(User::class, 'referred_by_agent_id');
    }

    public function merchants()
    {
        return $this->referredUsers();
    }

    /**
     * All commissions earned by this agent
     */
    public function commissions()
    {
        return $this->hasMany(AgentCommission::class, 'agent_id');
    }

    /**
     * Leads managed by this agent
     */
    public function leads()
    {
        return $this->hasMany(AgentLead::class, 'agent_id');
    }

    /**
     * Payout withdrawal requests
     */
    public function payoutRequests()
    {
        return $this->hasMany(AgentPayoutRequest::class, 'agent_id');
    }

    /**
     * Generate Full Referral URL
     */
    public function getReferralUrlAttribute(): string
    {
        return url('/register?ref=' . $this->referral_code);
    }

    /**
     * Total number of merchants registered
     */
    public function totalReferredCount(): int
    {
        return $this->referredUsers()->count();
    }

    /**
     * Total number of paid subscriptions generated
     */
    public function totalPaidOrdersCount(): int
    {
        return $this->commissions()->where('status', '!=', 'cancelled')->whereNotNull('plan_order_id')->count();
    }

    /**
     * Total commission earned (commission + bonus)
     */
    public function totalEarnings(): float
    {
        return (float) ($this->commissions()
            ->where('status', '!=', 'cancelled')
            ->selectRaw('SUM(commission_amount + bonus_amount) as total')
            ->value('total') ?? 0);
    }

    /**
     * Pending balance waiting for payout
     */
    public function pendingBalance(): float
    {
        $rawPending = (float) ($this->commissions()
            ->where('status', 'pending')
            ->selectRaw('SUM(commission_amount + bonus_amount) as total')
            ->value('total') ?? 0);

        // Subtract payout requests currently waiting for admin approval
        $inRequest = (float) ($this->payoutRequests()
            ->where('status', 'pending')
            ->sum('amount') ?? 0);

        return max(0, $rawPending - $inRequest);
    }

    /**
     * Total pending in withdrawal request queue
     */
    public function inProcessingPayoutAmount(): float
    {
        return (float) ($this->payoutRequests()
            ->where('status', 'pending')
            ->sum('amount') ?? 0);
    }

    /**
     * Already paid out earnings
     */
    public function paidEarnings(): float
    {
        return (float) ($this->commissions()
            ->where('status', 'paid')
            ->selectRaw('SUM(commission_amount + bonus_amount) as total')
            ->value('total') ?? 0);
    }

    /**
     * Dynamic Rank & Badge Calculator
     */
    public function getRankDetailsAttribute(): array
    {
        $paid = $this->totalPaidOrdersCount();

        if ($paid >= 100) {
            return [
                'tier' => 'legend',
                'name' => 'লিজেন্ড এলিট',
                'badge' => '👑',
                'badge_class' => 'tier-badge-legend',
                'badge_style' => 'background: linear-gradient(135deg, #1e1b4b 0%, #7c3aed 100%); color: #fbbf24; border: 1px solid rgba(251, 191, 36, 0.4);',
                'min' => 100,
                'next_target' => null,
                'progress_percent' => 100,
                'target_remaining' => 0,
            ];
        } elseif ($paid >= 50) {
            $diff = 100 - 50;
            $current = $paid - 50;
            return [
                'tier' => 'diamond',
                'name' => 'ডায়মন্ড লিডার',
                'badge' => '💎',
                'badge_class' => 'tier-badge-diamond',
                'badge_style' => 'background: linear-gradient(135deg, #4f46e5 0%, #818cf8 100%); color: #ffffff;',
                'min' => 50,
                'next_target' => 100,
                'progress_percent' => min(100, round(($current / $diff) * 100)),
                'target_remaining' => 100 - $paid,
            ];
        } elseif ($paid >= 20) {
            $diff = 50 - 20;
            $current = $paid - 20;
            return [
                'tier' => 'gold',
                'name' => 'গোল্ড চ্যাম্পিয়ন',
                'badge' => '🥇',
                'badge_class' => 'tier-badge-gold',
                'badge_style' => 'background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%); color: #ffffff;',
                'min' => 20,
                'next_target' => 50,
                'progress_percent' => min(100, round(($current / $diff) * 100)),
                'target_remaining' => 50 - $paid,
            ];
        } elseif ($paid >= 5) {
            $diff = 20 - 5;
            $current = $paid - 5;
            return [
                'tier' => 'silver',
                'name' => 'সিলভার মাস্টার',
                'badge' => '🥈',
                'badge_class' => 'tier-badge-silver',
                'badge_style' => 'background: linear-gradient(135deg, #0284c7 0%, #38bdf8 100%); color: #ffffff;',
                'min' => 5,
                'next_target' => 20,
                'progress_percent' => min(100, round(($current / $diff) * 100)),
                'target_remaining' => 20 - $paid,
            ];
        }

        // Bronze (0-4)
        return [
            'tier' => 'bronze',
            'name' => 'ব্রোঞ্জ পার্টনার',
            'badge' => '🥉',
            'badge_class' => 'tier-badge-bronze',
            'badge_style' => 'background: linear-gradient(135deg, #b45309 0%, #d97706 100%); color: #ffffff;',
            'min' => 0,
            'next_target' => 5,
            'progress_percent' => min(100, round(($paid / 5) * 100)),
            'target_remaining' => 5 - $paid,
        ];
    }

    /**
     * Get agent's progress towards a specific target
     */
    public function getTargetProgress(AgentTarget $target): array
    {
        $query = $this->commissions()
            ->where('status', '!=', 'cancelled')
            ->whereNotNull('plan_order_id');

        if ($target->period_type === 'weekly') {
            $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        } elseif ($target->period_type === 'monthly') {
            $query->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
        } elseif ($target->period_type === 'custom' && $target->start_date && $target->end_date) {
            $query->whereBetween('created_at', [$target->start_date, $target->end_date]);
        }

        $achieved = $query->count();
        $targetCount = max(1, $target->target_count);
        $percent = min(100, round(($achieved / $targetCount) * 100));

        return [
            'achieved' => $achieved,
            'target' => $target->target_count,
            'percent' => $percent,
            'completed' => $achieved >= $target->target_count,
        ];
    }
}
