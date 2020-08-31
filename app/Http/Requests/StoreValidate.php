<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreValidate extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            //

              'employee_name' => 'bail|required|max:20',
                'email' => 'bail|required|unique:employees,id',
                'dob' =>'required',
                'password' =>'required',
                'gender' =>'required',
        ];
    }
}
