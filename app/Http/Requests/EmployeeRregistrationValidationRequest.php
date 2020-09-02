<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

//Request responsity 2.9.2020
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class EmployeeRregistrationValidationRequest extends FormRequest
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
    //Request responsity 2.9.2020
    public function rules()
    {
        
        return [
                'employee_name' => 'bail|required|max:20',
                'email' => 'bail|required|email|unique:employees,email',
                'dob' =>'bail|nullable|date_format:"Y-m-d"|before:18 years ago',
                'password' =>'required|min:8',
                'gender' =>'required|in:1,2',
                'position_id' =>'required',
                'department_id' =>'required',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['message'=>$validator->errors()], 400));
    }
    public function messages()
    {     
        return [
            'employee_name.required' => "Employee name is required!",
            'employee_name.string' => "Employee name must be string!",
            'dob.required' => "Date of Birth is required!",
            'dob.date_format' => "Date Format is invalid!",
            'email.required' => "Email is required!",
            'email.email' => "Email Format is invalid!",
            'email.unique' => "Email is already exists!",
            'password.required' => "Password is required!",
            'password.min' => "Password must be minimum 10 characters!",
            'gender.required' => "Gender is required!",
            'gender.in' => "Gender must be 0 or 1!",
        ];
    }
}
