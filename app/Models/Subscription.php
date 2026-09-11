<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'amount',
        'status',
        'payment_method',
        'transaction_id',
        'starts_at',
        'expires_at',
    ];

    protected $casts = [
        'amount' => 'float',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'plan_id');
    }

    public function isActive()
    {
        return $this->status === 'active' && ($this->expires_at === null || $this->expires_at->isFuture());
    }
}
