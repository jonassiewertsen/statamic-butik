<?php

namespace Jonassiewertsen\StatamicButik\Listeners;

use Illuminate\Support\Facades\Cache;
use Statamic\Events\EntrySaving;
use Statamic\Facades\Entry;

class CacheOldProductSlug
{
    protected EntrySaving $event;

    public function handle(EntrySaving $entry)
    {
        /**
         * The entry is not a product? Let's do anything then.
         */
        if (! $entry->entry->collection()->handle() === 'products') {
            return;
        }

        if (! request()->route() || ! request()->route()->getName() === 'statamic.cp.collections.entries.update') {
            return;
        }

        $entry = Entry::find($entry->entry->id());

        if (! $entry || ! $slug = $entry->slug()) {
            return;
        }

        Cache::put('old-product-slug', $slug);
    }
}
