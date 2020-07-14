<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        if($this->method() == 'PATCH') {
            $email = 'required|string|email|unique:users,email,'.$this->get('id');
        } else {
            $email = 'required|string|email|unique:users';
        }
        return [
            'name' => 'required|string',
            'email' => $email,
            'password' => 'sometimes|required|min:8',
            'type' => 'required',

        ];
    }

    public function messages()
    {
        return [
        
            'name.required' => '<b>User name is required.</b>',
            'email.required' => '<b>Email address is required.</b>',
            'email.email' => '<b>Please enter a valid email address.</b>',
            'email.unique' => '<b>The email address you entered already exist.</b>',
            'password.required' => '<b>Password is required.</b>',
            'password.min' => '<b>Password is weak, Password must be at least 8 characters.</b>',
            'type.required' => '<b>User type is required.</b>',
        
        ];
    }
}
