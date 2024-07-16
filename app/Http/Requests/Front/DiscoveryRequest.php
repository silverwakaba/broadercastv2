<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class DiscoveryRequest extends FormRequest{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize() : bool{
        return true;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages() : array{
        return [
            'channelsubsrangefrom.lte'  => 'This range must be greater than the "To" column',
            'channelsubsrangeto.gte'    => 'This range must be lower than the "From" column',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules() : array{
        return [
            'channelsubsrangefrom'  => ['nullable', 'lte:channelsubsrangeto'],
            'channelsubsrangeto'    => ['nullable', 'gte:channelsubsrangefrom'],
        ];
    }
}
