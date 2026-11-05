<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentCommission extends Model
{
    use HasFactory;

    protected $table = 'agent_commissions';

    protected $fillable = [
        'agent_id',
        'user_id',
        'plan_order_id',
        'plan_id',
        'plan_name',
        'plan_price',
        'commission_rate',
        'commission_amount',
        'bonus_target_id',
        'bonus_amount',
        'status',
        'payout_date',
        'payout_method',
        'payout_trx_id',
        'payout_notes',
    ];

    protected $casts = [
        'plan_price' => 'decimal:2',
        'commission_rate' => 'decimal:2',
        'commission_amount' => 'decimal:2',
        'bonus_amount' => 'decimal:2',
        'payout_date' => 'datetime',
    ];

    public function agent()
    {
        return $this->belongsTo(MarketingAgent::class, 'agent_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function target()
    {
        return $this->belongsTo(AgentTarget::class, 'bonus_target_id');
    }

    /**
     * Total amount for this record (commission + bonus)
     */
    public function getTotalAmountAttribute(): float
    {
        return (float) ($this->commission_amount + $this->bonus_amount);
    }
}

