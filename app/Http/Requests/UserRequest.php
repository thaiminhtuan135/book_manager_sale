<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $data = $this->all();
//        dd(!Rule::unique('users')->when(['email' => $data['email']]));
//        $id = $this->user;
//        dd($id);
//        $rule = [
//            'name0' => 'required|max:255',
//            'address0' => 'required|max:255',
//            'dob0' => 'required|date_format:Y-m-d|before_or_equal:' . Carbon::now()->format('Y-m-d'),
//            'telephone0' => [
//                'required',
//                'regex:/^0(\d{9})+$/',
//            ],
//            'password0' => 'required|min:8|max:255',
//        ];
//        $rule['email0'] = [
//            'email',
//            'required',
//            'max:255',
//            !Rule::unique('users')->when(['email' => $data['email0']]),
//
//        ];
//        if (!Rule::unique('users')->when(['email' => $data['email0']])) {
//
//            return redirect()->route('register.index');
//        }
        $rule = [];
        for ($i = 0; $i < $this->size; $i++) {
            $rule["name" . $i] = 'required|max:255';
            $rule["address" . $i] = 'required|max:255';
            $rule["dob" . $i] = 'required|date_format:Y-m-d|before_or_equal:' . Carbon::now()->format('Y-m-d');
            $rule["telephone" . $i] = 'required|regex:/^0(\d{9})+$/';
            $rule["email" . $i] = [
                'email',
                'required',
                'max:255',
                !Rule::unique('users')->when(['email' => $data['email' . $i]]),
            ];
            $rule["password" . $i] = 'required|min:8|max:255';
        }
        return $rule;
    }

}
