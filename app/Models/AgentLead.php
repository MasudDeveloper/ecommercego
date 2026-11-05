<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentLead extends Model
{
    use HasFactory;

    protected $table = 'agent_leads';

    protected $fillable = [
        'agent_id',
        'shop_name',
        'owner_name',
        'phone',
        'page_url',
        'category',
        'status',
        'follow_up_date',
        'notes',
    ];

    protected $casts = [
        'follow_up_date' => 'date',
    ];

    public function agent()
    {
        return $this->belongsTo(MarketingAgent::class, 'agent_id');
    }

    /**
     * Get status label and color badge in Bengali
     */
    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {
            'new' => [
                'label' => 'নতুন লিড',
                'bg' => 'crm-badge-new',
                'style' => 'background: #fef3c7; color: #92400e; border: 1px solid #fcd34d;',
            ],
            'contacted' => [
                'label' => 'মেসেজ/কল হয়েছে',
                'bg' => 'crm-badge-contacted',
                'style' => 'background: #e0f2fe; color: #075985; border: 1px solid #bae6fd;',
            ],
            'trial_started' => [
                'label' => 'ট্রায়াল শুরু করেছে',
                'bg' => 'crm-badge-trial',
                'style' => 'background: #f3e8ff; color: #6b21a8; border: 1px solid #e9d5ff;',
            ],
            'converted' => [
                'label' => 'কনভার্টেড 🎉',
                'bg' => 'crm-badge-converted',
                'style' => 'background: #dcfce7; color: #166534; border: 1px solid #86efac;',
            ],
            'follow_up' => [
                'label' => 'ফলো-আপ রিমাইন্ডার',
                'bg' => 'crm-badge-followup',
                'style' => 'background: #ffedd5; color: #9a3412; border: 1px solid #fdba74;',
            ],
            'lost' => [
                'label' => 'আগ্রহী নয়',
                'bg' => 'crm-badge-lost',
                'style' => 'background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1;',
            ],
            default => [
                'label' => 'নতুন',
                'bg' => 'crm-badge-new',
                'style' => 'background: #fef3c7; color: #92400e; border: 1px solid #fcd34d;',
            ],
        };
    }

    /**
     * Generate direct WhatsApp messaging link
     */
    public function getWhatsAppUrlAttribute(): string
    {
        $cleanPhone = preg_replace('/[^0-9]/', '', $this->phone);
        if (str_starts_with($cleanPhone, '01')) {
            $cleanPhone = '88' . $cleanPhone;
        }

        $message = "আসসালামু আলাইকুম {$this->owner_name}! আপনার '{$this->shop_name}' শপের অনলাইন ওয়েবসাইট ও বিকাশ অটোমেশন নিয়ে কথা বলতে নক দিয়েছিলাম। মাত্র ৫ মিনিটে নিজস্ব ইকমার্স শপ চালু করার অফার বিস্তারিত দেখতে পারেন: " . ($this->agent ? $this->agent->referral_url : url('/'));

        return "https://api.whatsapp.com/send?phone={$cleanPhone}&text=" . urlencode($message);
    }
}

