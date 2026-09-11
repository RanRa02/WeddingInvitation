<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'sub_module_id',
        'name',
        'name_kh',
        'route_name',
        'url_path',
        'icon',
        'sort_order',
        'status',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function subModule()
    {
        return $this->belongsTo(SubModule::class, 'sub_module_id');
    }

    public function roleAccess()
    {
        return $this->hasMany(RolePageAccess::class);
    }

    public function pageActions()
    {
        return $this->hasMany(PageAction::class, 'page_id');
    }
}
