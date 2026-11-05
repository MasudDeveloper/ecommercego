<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentPayoutRequest extends Model
{
    use HasFactory;

    protected $table = 'agent_payout_requests';

    protected $fillable = [
        'agent_id',
        'amount',
        'payment_method',
        'account_number',
        'status',
        'transaction_id',
        'admin_note',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function agent()
    {
        return $this->belongsTo(MarketingAgent::class, 'agent_id');
    }

    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {
            'pending' => ['label' => 'পেন্ডিং অনুমোদন', 'class' => 'bg-warning text-dark'],
            'approved' => ['label' => 'পরিশোধিত (Paid)', 'class' => 'bg-success text-white'],
            'rejected' => ['label' => 'বাতিল (Rejected)', 'class' => 'bg-danger text-white'],
            default => ['label' => 'অজ্ঞাত', 'class' => 'bg-secondary text-white'],
        };
    }
}

