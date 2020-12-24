<?php

namespace App;

use App\Observers\PageObserver;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::observe(PageObserver::class);
    }
}
