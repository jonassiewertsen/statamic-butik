<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    protected $table = 'butik_shippings';
    public    $incrementing = false;
    protected $primaryKey   = 'slug';
    protected $keyType      = 'string';

    protected $casts = [
        'price' => 'integer',
    ];
    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function products() {
        return $this->hasMany(Product::class, 'shipping_id');
    }

    public function editUrl()
    {
        return cp_route('butik.shippings.edit', $this);
    }
}
