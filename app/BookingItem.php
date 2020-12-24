<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingItem extends Model
{
    public function businessService(){
        return $this->belongsTo(BusinessService::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
