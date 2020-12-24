<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFrontBooking extends CoreRequest
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
        $rules = [];

        if(auth()->guest()){
            $rules = [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required',
                'calling_code' => 'required_with:phone'
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'email.unique' => __('front.emailRegistered')
        ];
    }
}
