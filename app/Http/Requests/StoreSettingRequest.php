<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSettingRequest extends FormRequest
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
            'name' => "required|string|max:100",
            'email' => "required|email",
            'address' => 'string|max:80',
            'header_text' => 'string|max:50',
            'newsletter_header' => 'string|max:50',
            'newsletter_text' => 'string|max:250',
            'footer_description' => 'string|max:250',
            'phone_number' => "required|numeric",
            'logo' => 'required|mimes:jpg,jpeg,png,svg|max:2048',


        ];
    }
}
