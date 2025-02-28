<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class CustomerUpdateRequest extends FormRequest
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
            'phone'     => [
                'required', 'string', 'regex:/^\d{9,15}$/',
                Rule::unique('customers', 'phone')->ignore($this->route('customer')->id)
            ],
            'balance'   => 'required|numeric|min:0',
            'longitude' => 'required|numeric|between:-180,180',
            'latitude'  => 'required|numeric|between:-90,90',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Customer name is required.',
            'name.string'   => 'Customer name must be a string.',
            'name.max'      => 'Customer name cannot exceed 255 characters.',

            'phone.required' => 'Phone number is required.',
            'phone.string'   => 'Phone number must be a string.',
            'phone.regex'    => 'Phone number must contain 9 to 15 digits.',
            'phone.unique'   => 'This phone number is already taken.',

            'balance.numeric' => 'Balance must be a valid number.',
            'balance.min'     => 'Balance cannot be negative.',

            'longitude.required' => 'Please select a location on the map.',
            'longitude.numeric'  => 'Longitude must be a valid number.',
            'longitude.between'  => 'Longitude must be between -180 and 180.',

            'latitude.required' => 'Please select a location on the map.',
            'latitude.numeric'  => 'Latitude must be a valid number.',
            'latitude.between'  => 'Latitude must be between -90 and 90.',
        ];
    }
}
