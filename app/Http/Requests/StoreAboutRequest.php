<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAboutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'description' => 'required',
            'image' => 'required|image|mimes:png,jpg,jpeg',
            'img_title' => 'required',
            'img_body' => 'required',
            'client_count' => 'required',
            'client_desc' => 'required'
        ];
    }
}
