@if($bookingTime->status == 'enabled')
    @if ($bookingTime->multiple_booking === 'yes' && $bookingTime->max_booking !== 0 && $bookings->count() >= $bookingTime->max_booking)
        <div class="alert alert-custom mt-3">
            @lang('front.maxBookingLimitReached')
        </div>
    @else
        <ul class="time-slots px-1 py-1 px-md-5 py-md-5">
            @for($d = $startTime;$d < $endTime;$d->addMinutes($bookingTime->slot_duration))
                @php $slotAvailable = 1; @endphp
                @if($bookingTime->multiple_booking === 'no' && $bookings->count() > 0)
                    @foreach($bookings as $booking)
                        @if($booking->date_time->format($settings->time_format) == $d->format($settings->time_format))
                            @php $slotAvailable = 0; @endphp
                        @endif
                    @endforeach
                @endif

                @if($slotAvailable == 1)
                    <li>
                        <label class="custom-control custom-radio">
                            <input type="radio" value="{{ $d->format('H:i:s') }}" class="custom-control-input" name="booking_time">
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">{{ $d->format($settings->time_format) }}</span>
                        </label>
                    </li>
                @endif
            @endfor
        </ul>
    @endif
@else
    <div class="alert alert-custom mt-3">
        @lang('front.bookingSlotNotAvailable')
    </div>
@endif
