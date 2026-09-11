<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'price',
        'original_price',
        'discount_percentage',
        'guest_limit',
        'duration_days',
        'description',
        'features',
        'is_active',
    ];

    protected $casts = [
        'price' => 'float',
        'original_price' => 'float',
        'discount_percentage' => 'float',
        'guest_limit' => 'integer',
        'duration_days' => 'integer',
        'features' => 'array',
        'is_active' => 'boolean',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'plan_id');
    }
}
