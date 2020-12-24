<?php

namespace App\Observers;

use App\Booking;
use App\Notifications\BookingStatusChange;

class BookingObserver
{
    public function updated(Booking $booking)
    {
        if ($booking->isDirty('status')) {
            $booking->user->notify(new BookingStatusChange($booking));
        }
    }
}
