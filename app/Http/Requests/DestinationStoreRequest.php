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
                'title'=>'required',
                'image'=>'required|image|mimes:png,jpg,jpeg',
                'short_description'=>'required',
                'description'=>'required',
                'package_categories_id'=>'nullable|array',      
                'package_categories_id.*'=>'nullable|exists:package_categories,id',
                'location'=>'re|exists:package_categories,id',
        ];
    }
}
