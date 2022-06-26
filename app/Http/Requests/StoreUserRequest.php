<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => "required|string|unique:users,name|max:20|min:5",
            'email' => "required|email|unique:users,email",
            'phone' => "required|unique:users|max:13|min:10",
            'password' => "required|min:5|max:100",
        ];
    }
    public function messages()
    {
        return [
            /* start of name validation */
            'name.required' => 'The name field is required',
            'name.string' => 'Wrong format',
            'name.unique' => 'This name is already used',
            'name.max' => 'The name cannot be more than 20 characters',
            'name.min' => 'Your name cannot be less than 5 characters ',
            /* end of name validation */

            /*start of email validation */
            'email.required' => 'The email field is required',
            'email.email' => 'Wrong format',
            'email.unique' => 'This email is already used',
            /* end of email validation *. 
            
            /*start of phone validation */
            'phone.phone' => 'The phone field is required',
            'phone.unique' => 'This phone number is already used',
            'email.max' => 'The phone number cannot be more than 13 characters',
            'email.min' => 'The phone cannot be less than 10 characters',
            /* end of phone validation */

            /*start of password validation */
            'password.max' => 'Password cannot be more than 100 characters',
            'password.min' => 'Password cannot be less than 5 characters',
            /* end of password validation */
        ];
    }
}
