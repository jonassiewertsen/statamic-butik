<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    protected $table = 'taxes';

    protected $casts = [
        'percentage' => 'integer',
    ];
    protected $guarded = [];

    public function editUrl()
    {
        $cp_route = config('statamic.cp.route');

        return "/{$cp_route}/butik/taxes/{$this->id}/edit";
    }
}
