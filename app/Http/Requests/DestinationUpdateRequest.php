<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DestinationUpdateRequest extends FormRequest
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
            'destination'=>'string',
                'portrait_image'=>'image|mimes:png,jpg,jpeg',
                'short_description'=>'nullable',
                'description'=>'string',
                'package_categories_id'=>'nullable|array',      
                'package_categories_id.*'=>'nullable|exists:package_categories,id',
        ];
    }
}
