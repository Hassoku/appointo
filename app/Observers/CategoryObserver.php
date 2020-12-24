<?php

namespace App\Observers;

use App\Helper\SearchLog;
use App\Category;

class CategoryObserver
{
    public function created(Category $category)
    {
        SearchLog::createSearchEntry($category->id, 'Category', $category->name, 'admin.categories.edit');

    }

    public function updating(Category $category)
    {
        SearchLog::updateSearchEntry($category->id, 'Category', $category->name, 'admin.categories.edit');
    }

    public function deleted(Category $category)
    {
        SearchLog::deleteSearchEntry($category->id, 'admin.categories.edit');
    }
}
