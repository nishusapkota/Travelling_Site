<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTourEnquiryRequest extends FormRequest
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
        'email'=>'required',
        'mobile_no'=>'required|numeric|digits:10',
        'num_of_person'=>'required',
        'package_id'=>'required|exists:packages,id',
        'tour_date'=>'required|date',
        'enquiry'=>'required'
        ];
    }
}
