<?php

namespace Modules\Catalog\Services\Category;

use Illuminate\Support\Facades\Cache;
use Modules\Catalog\Models\Category;

class CategoryQueryService
{
    public function handle() {}

    public static function getCategory()
    {
        $key = 'categories';

        return Cache::remember($key, now()->addDays(6), function () {
            return Category::pluck('name', 'id')->toArray();
        });
    }

    public function getTreeCategories()
    {
        $key = 'tree_categories';

        return Cache::remember($key, now()->addDays(6), function () {
            $parents = Category::whereNull('parent_id')
                ->with('children')
                ->get();

            return $parents;
        });

    }

    public function getCategoryById(int $id)
    {
        return Category::where('id', $id)->with('parent')->with('children')->first();
    }
}
