<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingResource extends Model
{
    use HasFactory;

    protected $table = 'marketing_resources';

    protected $fillable = [
        'title',
        'category',
        'badge',
        'content_text',
        'media_url',
        'order_priority',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order_priority' => 'integer',
    ];

    public function getContentAttribute()
    {
        return $this->content_text;
    }

    public function setContentAttribute($value)
    {
        $this->attributes['content_text'] = $value;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order_priority', 'asc');
    }

    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
