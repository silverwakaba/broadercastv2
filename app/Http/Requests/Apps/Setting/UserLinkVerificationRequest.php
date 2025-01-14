<?php

namespace App\Http\Requests\Apps\Setting;

use Illuminate\Foundation\Http\FormRequest;

class UserLinkVerificationRequest extends FormRequest{
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
            'unique'                => ['nullable'],
            'service'               => ['required'],
            'channel'               => ['required'],
            'terms'                 => ['accepted'],
        ];

        if(!(auth()->user()->hasRole('Admin|Moderator'))){
            $default['h-captcha-response'] = ['required', 'HCaptcha'];
        }

        return $request = $default;
    }
}
