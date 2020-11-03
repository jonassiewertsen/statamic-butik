<?php

namespace Jonassiewertsen\StatamicButik\Listeners;

use Illuminate\Support\Facades\Cache;
use Jonassiewertsen\StatamicButik\Http\Models\Variant;
use Statamic\Events\EntrySaved;

class RenameVariants
{
    protected EntrySaved $event;

    public function handle(EntrySaved $event)
    {
        $this->event = $event;

        /**
         * The entry is not a product? Let's do nothing then.
         */
        if ($event->entry->collection()->handle() !== 'products') {
            return;
        }

        if (! request()->route() || request()->route()->getName() !== 'statamic.cp.collections.entries.update') {
            return;
        }

        $this->renameVariants();
    }

    private function renameVariants()
    {
        $variants = Variant::where('product_slug', $this->oldSlug());

        /**
         * No variants? Do nothing.
         */
        if ($variants->count() === 0) {
            return;
        }

        $variants->update(['product_slug' => $this->newSlug()]);
    }

    private function oldSlug(): string
    {
        return Cache::get('old-product-slug');
    }

    private function newSlug(): string
    {
        return $this->event->entry->slug();
    }
}
