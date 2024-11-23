<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rules\Password;

class ResetRequest extends FormRequest{
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
            'email'                     => ['required', 'email'],
            'new_password'              => ['required', 'string', Password::min('8')->mixedCase()->letters()->numbers()->symbols()->uncompromised()],
            'new_password_confirmation' => ['required', 'string', 'same:new_password'],
            'terms'                     => ['accepted'],
            'h-captcha-response'        => ['required', 'HCaptcha'],
        ];
    }
}
