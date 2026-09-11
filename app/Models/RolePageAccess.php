<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePageAccess extends Model
{
    use HasFactory;

    protected $table = 'role_page_access';

    protected $fillable = [
        'role_id',
        'page_id',
        'can_view',
        'can_create',
        'can_edit',
        'can_delete',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
