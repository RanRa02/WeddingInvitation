<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PageAction extends Model
{
    use SoftDeletes;

    protected $table = 'page_actions';

    protected $fillable = [
        'page_id',
        'name',
        'name_kh',
        'name_ch',
        'route_name',
        'type',
        'position',
        'icon',
        'parent',
        'order',
    ];

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id');
    }
}
