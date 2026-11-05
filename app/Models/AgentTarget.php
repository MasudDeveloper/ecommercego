<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AgentTarget extends Model
{
    use HasFactory;

    protected $table = 'agent_targets';

    protected $fillable = [
        'title',
        'target_count',
        'period_type',
        'bonus_amount',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'bonus_amount' => 'decimal:2',
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function commissions()
    {
        return $this->hasMany(AgentCommission::class, 'bonus_target_id');
    }

    /**
     * Get human readable period name in Bengali
     */
    public function getPeriodLabelAttribute(): string
    {
        return match ($this->period_type) {
            'weekly' => 'সাপ্তাহিক (Weekly)',
            'monthly' => 'মাসিক (Monthly)',
            'custom' => 'কাস্টম সময়কাল (Custom)',
            default => ucfirst($this->period_type),
        };
    }
}
