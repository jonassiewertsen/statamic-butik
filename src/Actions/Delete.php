<?php

namespace Jonassiewertsen\StatamicButik\Actions;

use Jonassiewertsen\StatamicButik\Http\Models\Order;
use Statamic\Actions\Action;
use Statamic\Contracts\Auth\User as UserContract;

class Delete extends Action
{
    protected $dangerous = true;

    public static function title()
    {
        return __('Delete');
    }

    public function visibleTo($item)
    {
        return$item instanceof Order;
    }

    public function authorize($user, $item)
    {
        return true; // TODO: Authorize the delete action

        if ($item instanceof UserContract && $user->id() === $item->id()) {
            return false;
        }

        return $user->can('delete', $item);
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
        // TODO: Add a delete methods
        // $items->each->delete();
    }
}
