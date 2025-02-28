<?php

namespace App\Http\Requests\Permission;

use Illuminate\Foundation\Http\FormRequest;

class PermissionUpdateRequest extends FormRequest
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
            'name' => 'required|string|max:255', 
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Permission nomi majburiy! Iltimos, nomni kiriting.',
            'name.string' => 'Permission nomi faqat matn bo\'lishi kerak.',
            'name.max' => 'Permission nomi 255 belgidan oshmasligi kerak.',
            
        ];
    }
}
