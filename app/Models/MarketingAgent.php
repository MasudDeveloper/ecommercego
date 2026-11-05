<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class MarketingAgent extends Model
{
    use HasFactory;

    protected $table = 'marketing_agents';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'referral_code',
        'commission_rate',
        'commission_type',
        'payment_method',
        'payout_details',
        'is_active',
        'notes',
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
        return (float) $this->commissions()
            ->where('status', '!=', 'cancelled')
            ->selectRaw('SUM(commission_amount + bonus_amount) as total')
            ->value('total') ?? 0;
    }

    /**
     * Pending balance waiting for payout
     */
    public function pendingBalance(): float
    {
        return (float) $this->commissions()
            ->where('status', 'pending')
            ->selectRaw('SUM(commission_amount + bonus_amount) as total')
            ->value('total') ?? 0;
    }

    /**
     * Already paid out earnings
     */
    public function paidEarnings(): float
    {
        return (float) $this->commissions()
            ->where('status', 'paid')
            ->selectRaw('SUM(commission_amount + bonus_amount) as total')
            ->value('total') ?? 0;
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
