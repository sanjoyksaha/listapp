<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            'name' => 'required|string',
            'category_id' => 'required',
            'established_at' => 'required',
            'email' => 'required|string|email',
            'address' => 'required',
            'total_office' => 'required|numeric',

        ];
    }

    public function messages()
    {
        return [
        
            'name.required' => '<b>Company name is required.</b>',
            'category_id.required' => '<b>Category is required.</b>',
            'established_at.required' => '<b>Established Year is required.</b>',
            'email.required' => '<b>Email address is required.</b>',
            'email.email' => '<b>Please enter a valid email address.</b>',
            'address.required' => '<b>Company Head Office Address is required.</b>',
            'total_office.required' => '<b>Total Office is required.</b>',
            'total_office.numeric' => '<b>Total Office must be numeric.</b>',
        
        ];
    }
}
