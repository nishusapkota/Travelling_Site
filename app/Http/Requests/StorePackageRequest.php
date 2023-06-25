<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePackageRequest extends FormRequest
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
            'title' => 'required',
            'image' => 'required',
            'price' => 'required',
            'overview' => 'required',
            'duration' => 'required',
            'destinations_id' => 'required',
            'whats_included' => 'required',
            'day' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'package_categories_id' => 'required|array',
            'package_categories_id.*' => 'required|exists:package_categories,id'
        ];
    }
}
