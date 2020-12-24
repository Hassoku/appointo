<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('withoutCustomerRole', function (Builder $builder) {
            $builder->where('name', '<>', 'customer');
        });
    }

    public function getMemberCountAttribute()
    {
        return $this->users->count();
    }
}
