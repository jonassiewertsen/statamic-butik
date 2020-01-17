<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    protected $table        = 'taxes';
    public    $incrementing = false;
    protected $primaryKey   = 'slug';
    protected $keyType      = 'string';

    protected $casts = [
        'percentage' => 'integer',
    ];
    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function products() {
        return $this->hasMany(Product::class, 'tax_id');
    }

    public function editUrl()
    {
        $cp_route = config('statamic.cp.route');

        return "/{$cp_route}/butik/taxes/{$this->slug}/edit";
    }
}
