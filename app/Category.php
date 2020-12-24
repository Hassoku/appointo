<?php

namespace App;

use App\Observers\CategoryObserver;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::observe(CategoryObserver::class);
    }

    protected $guarded = ['id'];

    protected $appends =[
        'category_image_url'
    ];

    public function getCategoryImageUrlAttribute(){
        if(is_null($this->image)){
            return asset('img/no-image.jpg');
        }
        return asset_url('category/'.$this->image);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function services(){
        return $this->hasMany(BusinessService::class);
    }
}
