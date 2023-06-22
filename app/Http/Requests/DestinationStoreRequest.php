<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DestinationStoreRequest extends FormRequest
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
                'destination'=>'required',
                'portrait_image'=>'required|image|mimes:png,jpg,jpeg',
                'location'=>'required',
                'cover_image'=>'required',
                'short_description'=>'nullable',
                'description'=>'required',
                'package_categories_id'=>'nullable|array',      
                'package_categories_id.*'=>'nullable|exists:package_categories,id',
                

        ];
    }
}
