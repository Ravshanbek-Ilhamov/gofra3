<?php

namespace App\Http\Requests\Warehouse;

use Illuminate\Foundation\Http\FormRequest;

class WarehouseCreateRequest extends FormRequest
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
            'name'=>'required|max:255|string',
            'user_id'=>'required'
        ];
    }
    public function messages()
    {
        return [
            'name.required'=>'Warehouse name  not found',
            'name.string'=>'Warehouse name not be digit',
            'user_id.required'=>'Please select a user'
        ];
    }
}
