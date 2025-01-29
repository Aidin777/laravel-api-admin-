<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PhoneUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected $stopOnFirstFailure = true;
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "phone"=> "required|numeric|min_digits:10",
        ];


    }

    public function messages(): array
    {
        return [
            'phone.required' => 'Введите номер телефона',
            'phone.min_digits' => 'Номер телефона введен не коректно',
        ];
    }
}
