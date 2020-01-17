<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    protected $table = 'shippings';

    protected $casts = [
        'price' => 'integer',
    ];
    protected $guarded = [];

    public function editUrl()
    {
        $cp_route = config('statamic.cp.route');

        return "/{$cp_route}/butik/shippings/{$this->id}/edit";
    }
}
