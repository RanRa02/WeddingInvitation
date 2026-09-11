<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubModule extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'name',
        'name_kh',
        'icon',
        'sort_order',
        'status',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }

    public function pages()
    {
        return $this->hasMany(Page::class, 'sub_module_id')->orderBy('sort_order', 'asc');
    }
}
