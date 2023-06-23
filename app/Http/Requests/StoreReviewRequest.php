<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
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
            'destination_id' => 'nullable|exists:destinations,id',
            'package_id' => 'required|exists:packages,id',
            'star' => 'required|string',
            'review' => 'nullable',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg',
        ];
    }
}
