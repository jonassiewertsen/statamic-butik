<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

class Category extends ButikModel
{
    protected $table        = 'butik_categories';
    protected $primaryKey   = 'slug';
    protected $keyType      = 'string';

    protected $guarded = [];

    protected $casts = [
        'is_visible' => 'boolean',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function products()
    {
        return $this->belongsToMany(Category::class, 'butik_category_product');
    }
}
