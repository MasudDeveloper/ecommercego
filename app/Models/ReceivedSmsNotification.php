<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceivedSmsNotification extends Model
{
    use HasFactory;

    protected $table = 'received_sms_notifications';

    protected $fillable = [
        'gateway',
        'sender_number',
        'amount',
        'trx_id',
        'raw_notification',
        'status',
        'matched_order_id',
        'device_info',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function matchedOrder()
    {
        return $this->belongsTo(PlanOrder::class, 'matched_order_id');
    }
}

