<?php

namespace App\Http\Requests\Apps\Setting;

use Illuminate\Foundation\Http\FormRequest;

class UserFanboxRequest extends FormRequest{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize() : bool{
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules() : array{
        return [
            'public'        => ['boolean', 'string'],
            'title'         => ['required', 'string', 'min: 5', 'max:50'],
            'description'   => ['required', 'string', 'min: 20', 'max:160'],
        ];
    }
}
