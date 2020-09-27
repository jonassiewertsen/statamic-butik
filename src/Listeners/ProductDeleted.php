<?php

namespace Jonassiewertsen\StatamicButik\Listeners;

use Facades\Jonassiewertsen\StatamicButik\Http\Models\Product;
use Statamic\Events\EntryDeleted;

class ProductDeleted
{
    public function handle(EntryDeleted $event)
    {
        /**
         * The entry is not a product? Let's do anything then.
         */
        if (! $event->entry->collection()->handle() === 'products') {
            return;
        }

        $this->deleteVariants($event);
    }

    private function deleteVariants($event)
    {
        $variants = Product::find($event->entry->slug())->variants;

        /**
         * No variants? Do nothing.
         */
        if ($variants->count() === 0) {
            return;
        }

        $variants->each->delete();
    }
}
