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
        $rule = [
            'name' => 'required|max:255',
            'address'=>'required|max:255',
            'dob' => 'required|date_format:Y-m-d|before_or_equal:' . Carbon::now()->format('Y-m-d'),
            'telephone' => [
                'required',
                'regex:/^0(\d{9})+$/',
            ],
            'password' => 'required|min:8|max:255',
        ];
        $rule['email'] =[
                'email',
                'required',
                'max:255',
            !Rule::unique('users')->when(['email' => $data['email']]),

        ];
        if (!Rule::unique('users')->when(['email' => $data['email']])) {

            return redirect()->route('register.index');
        }
        return $rule;
    }
}
