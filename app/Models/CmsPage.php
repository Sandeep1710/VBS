<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CmsPage extends Model
{
    protected $table = 'cms_pages';

    protected $fillable = [
        'slug', 'title', 'content',
        'meta_title', 'meta_description',
        'is_active', 'show_in_footer', 'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'show_in_footer' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
