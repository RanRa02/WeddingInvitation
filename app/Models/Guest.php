<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'side',
        'table_number',
        'attendance',
        'companions',
        'wishes',
        'gift_amount',
        'invitation_code',
        'note',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getInvitationUrlAttribute()
    {
        return route('wedding-invitation.index', ['guest' => $this->name]);
    }
}
