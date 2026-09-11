<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_kh',
        'icon',
        'sort_order',
        'status',
    ];

    public function subModules()
    {
        return $this->hasMany(SubModule::class, 'module_id')->orderBy('sort_order', 'asc');
    }

    public function pages()
    {
        return $this->hasMany(Page::class, 'module_id')->orderBy('sort_order', 'asc');
    }
}
