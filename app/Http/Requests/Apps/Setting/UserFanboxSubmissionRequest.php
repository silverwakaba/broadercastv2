<?php

namespace App\Http\Requests\Apps\Setting;

use Illuminate\Foundation\Http\FormRequest;

class UserFanboxSubmissionRequest extends FormRequest{
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
        $default = [
            'h-captcha-response' => ['required', 'HCaptcha'],
        ];

        if(auth()->check() == true){
            $default['answer'] = ['required', 'string', 'min:10', 'max:10000'];
        }
        else{
            $default['answer'] = ['required', 'string', 'min:20', 'max:1000'];
        }

        return $request = $default;
    }
}
