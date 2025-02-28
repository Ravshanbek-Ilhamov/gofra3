<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class CustomerCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'      => 'required|string|max:255',
            'phone'     => 'required|string|unique:customers,phone|regex:/^\d{9,15}$/',
            'balance'   => 'required|numeric|min:0',
            'longitude' => 'required|numeric|between:-180,180',
            'latitude'  => 'required|numeric|between:-90,90',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required'      => 'Customer name is required.',
            'phone.required'     => 'Phone number is required.',
            'phone.unique'       => 'This phone number is already taken.',
            'longitude.required' => 'Location selection is required.',
            'latitude.required'  => 'Location selection is required.',
        ];
    }
}
