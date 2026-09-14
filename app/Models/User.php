<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'status',
        'guest_limit',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function guests()
    {
        return $this->hasMany(Guest::class);
    }

    public function wedding()
    {
        return $this->hasOne(Wedding::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class)->where('status', 'active')->latestOfMany();
    }

    public function isCustomer()
    {
        if ($this->role && strtolower($this->role->slug) === 'customer') {
            return true;
        }
        return !$this->isAdmin();
    }

    public function isAdmin()
    {
        if ($this->role && strtolower($this->role->slug) === 'admin') {
            return true;
        }
        // Fallback for default superadmin
        return $this->id === 1 || ($this->email && str_contains(strtolower($this->email), 'admin'));
    }

    public function hasPermission($routeName, $action = 'can_view')
    {
        if ($this->isAdmin()) {
            return true;
        }

        if (!$this->role_id) {
            return false;
        }

        $page = Page::where('route_name', $routeName)
            ->orWhere('url_path', $routeName)
            ->orWhere('url_path', '/' . ltrim($routeName, '/'))
            ->first();

        if (!$page) {
            return true; // Default allow if page is not restricted in settings
        }

        $access = RolePageAccess::where('role_id', $this->role_id)
            ->where('page_id', $page->id)
            ->first();

        if (!$access) {
            return true;
        }

        return (bool) $access->{$action};
    }

    public function canViewPage($routeName)
    {
        return $this->hasPermission($routeName, 'can_view');
    }

    public function canCreateOnPage($routeName)
    {
        return $this->hasPermission($routeName, 'can_create');
    }

    public function canEditOnPage($routeName)
    {
        return $this->hasPermission($routeName, 'can_edit');
    }

    public function canDeleteOnPage($routeName)
    {
        return $this->hasPermission($routeName, 'can_delete');
    }

    public function hasReachedGuestLimit()
    {
        if ($this->isAdmin()) {
            return false;
        }

        $limit = $this->guest_limit ?? 100;
        return $this->guests()->count() >= $limit;
    }

    public function getGuestCountAttribute()
    {
        return $this->guests()->count();
    }
}
