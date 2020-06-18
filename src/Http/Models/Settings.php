<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

class Settings extends ButikModel
{
    protected $table        = 'butik_settings';
    public    $incrementing = false;
    protected $primaryKey   = 'key';
    protected $keyType      = 'string';

    protected $guarded = [];

    // TODO: Remove the settings table

    public function getRouteKeyName()
    {
        return 'key';
    }
}
