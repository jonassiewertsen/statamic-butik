<?php

namespace Jonassiewertsen\Butik\Listeners;

use Jonassiewertsen\Butik\Http\Models\Variant;
use Statamic\Events\EntryDeleted;

class ProductDeleted
{
    public function handle(EntryDeleted $event)
    {
        /**
         * The entry is not a product? Let's do anything then.
         */
        if ($event->entry->collection()->handle() !== 'products') {
            return;
        }

        $this->deleteVariants($event);
    }

    private function deleteVariants($event)
    {
        $variants = Variant::where('product_slug', $event->entry->slug());

        /**
         * No variants? Do nothing.
         */
        if ($variants->count() === 0) {
            return;
        }

        $variants->delete();
    }
}
