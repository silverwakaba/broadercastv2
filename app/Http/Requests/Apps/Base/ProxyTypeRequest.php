<?php

namespace App\Http\Requests\Apps\Base;

use Illuminate\Foundation\Http\FormRequest;

class ProxyTypeRequest extends FormRequest{
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
            'name' => ['required', 'string', 'min:2', 'max:255', 'unique:base_proxy_type'],
        ];
    }
}
