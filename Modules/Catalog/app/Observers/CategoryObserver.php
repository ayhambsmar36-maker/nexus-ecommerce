<?php

namespace Modules\Catalog\Observers;

use Illuminate\Support\Facades\Cache;
use Modules\Catalog\Models\Category;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     */
    public function cacheClear()
    {
        Cache::forget('categories');
        Cache::forget('tree_categories');
    }

    public function created(Category $category): void
    {

        $this->cacheClear();
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $category): void
    {
        $this->cacheClear();
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        $this->cacheClear();
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(Category $category): void
    {
        $this->cacheClear();
    }

    /**
     * Handle the Category "force deleted" event.
     */
    public function forceDeleted(Category $category): void
    {
        $this->cacheClear();
    }
}
