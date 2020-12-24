<?php

namespace App\Http\Requests\BookingTime;

use App\Http\Requests\CoreRequest;

class UpdateBookingTime extends CoreRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->has('start_time')) {
            $rules = [
                'start_time' => 'required_if:status,enabled|date_format:'.$this->settings->time_format,
                'end_time' => 'required_if:status,enabled|date_format:'.$this->settings->time_format,
                'status' => 'required|in:enabled,disabled',
                'multiple_booking' => 'required|in:yes,no',
                'max_booking' => 'required_if:multiple_booking,yes|integer|min:0',
                'slot_duration' => 'required_if:status,enabled|integer|min:1'
            ];
        }
        else {
            $rules = [
                'status' => 'required|in:enabled,disabled'
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'start_time.required_if' => 'Open Time is required when :other is :value.',
            'start_time.date_format' => 'Open Time must be in format 09:00 AM.',
            'end_time.date_format' => 'Close Time must be in format 09:00 AM.',
            'end_time.required_if' => 'Close Time is required when :other is :value.',
            'slot_duration.required_if' => 'Slot Duration is required when :other is :value.',
            'slot_duration.integer' => 'Slot Duration must be an integer.',
            'slot_duration.min' => 'Minimum value of Slot Duration must be 1.',
            'max_booking.required_if' => 'Maximum Number of Booking is required when :other is :value.',
            'max_booking.integer' => 'Maximum Number of Booking must be an integer.',
            'max_booking.min' => 'Minimum value of Maximum Number of Booking must be 0.',
        ];
    }
}
