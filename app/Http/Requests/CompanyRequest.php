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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'code' =>'required|min:8|regex:/^[A-Za-z0-9]*$/',
            'name' => 'required|max:255',
            'telephone' => [
                'required',
                'regex:/^0(\d{9})+$/',
            ],
            'address'=>'required|max:255',
        ];
    }
}
