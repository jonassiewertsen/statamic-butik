<?php

namespace Jonassiewertsen\StatamicButik\Actions;

use Jonassiewertsen\StatamicButik\Exceptions\ButikConfigException;
use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Statamic\Actions\Action;

class DeleteButikOrders extends Action
{
    protected $dangerous = true;

    public static function title()
    {
        return __('Delete');
    }

    public function visibleTo($item)
    {
        return $item instanceof Order;
    }

    public function authorize($user, $item): bool
    {
        if (config('butik.orders_deletable') === 'users') {
            return $user->can('delete', $item);
        }

        if (config('butik.orders_deletable') === 'never') {
            return false;
        }

        if (config('butik.orders_deletable') === 'development') {
            return config('app.env') !== 'production';
        }

        throw new ButikConfigException('Make sure to set your butik orders_deletable config to \'never\', \'development\' or \'user\'. Yours is: '.config('butik.orders_deletable'));
    }

    public function buttonText()
    {
        /** @translation */
        return 'Delete|Delete :count orders?';
    }

    public function confirmationText()
    {
        /** @translation */
        return 'Are you sure you want to want to delete this order?|Are you sure you want to delete these :count orders?';
    }

    public function run($items, $values)
    {
        $items->each->delete();
    }
}
