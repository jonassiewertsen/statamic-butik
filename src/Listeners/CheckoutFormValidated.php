<?php

namespace Jonassiewertsen\StatamicButik\Listeners;

use Jonassiewertsen\StatamicButik\Http\Controllers\Web\CheckoutController;
use Statamic\Events\FormSubmitted;

class CheckoutFormValidated
{
    public function handle(FormSubmitted $event)
    {
        /**
         * We will simply call our storeCustomerData method from our controller
         * to handle the logic.
         *
         * This way we will use the internal form validation provied by statamic, so
         * the forms can be edited as a blueprint.
         *
         * We are still able to keep our butik flow though.
         */
        (new CheckoutController())->storeCustomerData($event->submission->data());
    }
}
