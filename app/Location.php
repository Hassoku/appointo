<?php

namespace App;

use App\Observers\LocationObserver;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::observe(LocationObserver::class);
    }

    public function services() {
        return $this->hasMany(BusinessService::class);
    }
}
