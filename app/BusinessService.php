<?php

namespace App;

use App\Observers\BusinessServiceObserver;
use Illuminate\Database\Eloquent\Model;

class BusinessService extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::observe(BusinessServiceObserver::class);
    }

    protected $appends =[
        'service_image_url',
        'service_detail_url',
        'discounted_price'
    ];

    public function getServiceImageUrlAttribute(){
        if(is_null($this->image)){
            return asset('img/no-image.jpg');
        }
        return asset_url('service/'.$this->image);
    }

    public function getServiceDetailUrlAttribute()
    {
        return route('front.serviceDetail', ['categorySlug' => $this->category->slug, 'serviceSlug' => $this->slug]);
    }

    public function getDiscountedPriceAttribute(){
        if($this->discount > 0){
            if($this->discount_type == 'fixed'){
                return ($this->price - $this->discount);
            }
            elseif($this->discount_type == 'percent'){
                $discount = (($this->discount/100)*$this->price);
                return round(($this->price - $discount), 2);
            }
        }
        return $this->price;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function location(){
        return $this->belongsTo(Location::class);
    }

    public function bookingItems(){
        return $this->hasMany(BookingItem::class);
    }
}
