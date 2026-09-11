<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wedding extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'slug',
        'groom_name',
        'groom_name_en',
        'bride_name',
        'bride_name_en',
        'groom_parents',
        'bride_parents',
        'event_date',
        'lunar_date',
        'morning_time',
        'evening_time',
        'venue_name',
        'venue_address',
        'venue_location_url',
        'theme_template',
        'cover_image',
        'music_url',
        'bank_name',
        'bank_account_name',
        'bank_account_number',
        'bank_qr_image',
        'schedule',
        'settings',
        'is_published',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'schedule' => 'array',
        'settings' => 'array',
        'is_published' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function guests()
    {
        return $this->hasMany(Guest::class, 'user_id', 'user_id');
    }
}
