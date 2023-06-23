<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTripEnquiryRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'=>'required',
            'email'=>'required|email',
            'mobile_num'=>'required|numeric|digits:10',
            'group_size'=>'required',
            'travel_dates.*'=>'required',
            'destination_id'=>'nullable|exists:destinations,id',
            'estimate_budget'=>'required',
            'budget_flexible'=>'boolean',
            'primary_age'=>'required',
            'experience'=>'nullable'
            ];
    }
}
