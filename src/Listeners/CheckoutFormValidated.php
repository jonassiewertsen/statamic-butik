<?php

namespace Jonassiewertsen\StatamicButik\Listeners;

use Jonassiewertsen\StatamicButik\Http\Controllers\Web\CheckoutController;
use Statamic\Events\FormSubmitted;

class CheckoutFormValidated
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
    public function handle(FormSubmitted $event)
    {
        // Simply do nothing in case the butik checkout form has not been called.
        if ($event->form->form->handle() !== 'butik_checkout') {
            return;
        }

        (new CheckoutController())->storeCustomerData($event->submission->data());
    }
}
