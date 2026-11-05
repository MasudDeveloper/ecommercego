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
            'new' => ['label' => 'নতুন লিড', 'bg' => 'bg-amber-100 text-amber-800 border-amber-300'],
            'contacted' => ['label' => 'মেসেজ/কল দেওয়া হয়েছে', 'bg' => 'bg-blue-100 text-blue-800 border-blue-300'],
            'trial_started' => ['label' => 'ট্রায়াল শুরু করেছে', 'bg' => 'bg-purple-100 text-purple-800 border-purple-300'],
            'converted' => ['label' => 'সফল সাবস্ক্রিপশন', 'bg' => 'bg-emerald-100 text-emerald-800 border-emerald-300'],
            'follow_up' => ['label' => 'ফলো-আপ রিমাইন্ডার', 'bg' => 'bg-orange-100 text-orange-800 border-orange-300'],
            'lost' => ['label' => 'আগ্রহী নয়', 'bg' => 'bg-gray-100 text-gray-700 border-gray-300'],
            default => ['label' => 'নতুন', 'bg' => 'bg-gray-100 text-gray-800 border-gray-300'],
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

