<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookRequest extends FormRequest
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
        $image = $this->hasFile('image');
        $rule = [
            'title' => 'required|max:255',
            'author'=>'required|max:255',
            'release_date' => 'required|date_format:Y-m-d|before_or_equal:' . Carbon::now()->format('Y-m-d'),
            'number_page' => 'required',
            'category' => 'required',
        ];
        if ($image) {
            $rule['image'] = 'max:20480|image|mimes:jpeg,png,jpg';
        }
        return $rule;
    }
}
