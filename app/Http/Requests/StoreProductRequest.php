<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
        return [
            'name' => "required|string|max:50|min:2",
            'description' => "required|string|max:1050|min:5",
            'short_description' => "required|string|min:5|max:1050",
            'sale_price' => "required|integer",
            'regular_price' => "required|integer",
            'image' => 'required|mimes:jpg,jpeg,png',

        ];
    }
}
