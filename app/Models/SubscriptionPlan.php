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
        'allowed_templates',
        'is_active',
    ];

    protected $casts = [
        'price' => 'float',
        'original_price' => 'float',
        'discount_percentage' => 'float',
        'guest_limit' => 'integer',
        'duration_days' => 'integer',
        'features' => 'array',
        'allowed_templates' => 'array',
        'is_active' => 'boolean',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'plan_id');
    }

    /**
     * Check if a specific template ID is allowed under this subscription plan.
     *
     * @param string $templateId
     * @return bool
     */
    public function isTemplateAllowed(string $templateId): bool
    {
        // If allowed_templates is configured in database
        if (is_array($this->allowed_templates) && !empty($this->allowed_templates)) {
            return in_array('*', $this->allowed_templates) || in_array($templateId, $this->allowed_templates);
        }

        // Fallback defaults based on plan slug
        $defaults = static::getDefaultTemplatesForSlug($this->slug);
        return in_array('*', $defaults) || in_array($templateId, $defaults);
    }

    /**
     * Get default allowed templates list based on plan slug.
     *
     * @param string|null $slug
     * @return array
     */
    public static function getDefaultTemplatesForSlug(?string $slug): array
    {
        return match ($slug) {
            'diamond-vip' => ['married', 'sapphire', 'lotus', 'ruby', 'romantic', 'golden', 'diamond', 'lavender', 'vintage'],
            'gold-premium' => ['married', 'sapphire', 'lotus', 'ruby', 'romantic', 'golden', 'diamond'],
            'silver' => ['married', 'sapphire', 'lotus', 'ruby', 'romantic'],
            default => ['married', 'sapphire'],
        };
    }
}
