<?php

namespace Jonassiewertsen\StatamicButik\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Jonassiewertsen\StatamicButik\Http\Traits\MoneyTrait;

abstract class ButikModel extends Model {
    use MoneyTrait;
}
