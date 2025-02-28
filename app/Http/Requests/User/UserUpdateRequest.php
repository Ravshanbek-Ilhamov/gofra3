<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'password' => 'nullable|min:6',
            'role_id' => 'required|exists:roles,id',
        ];
        
    }

    public function messages(): array
    {
        return [
            'name.required' => 'User name majburiy!',
            'name.string' => 'User name matn bo‘lishi kerak!',
            'name.max' => 'User name 255 ta belgidan oshmasligi kerak!',

            'email.required' => 'Email majburiy!',
            'email.email' => 'Email to‘g‘ri formatda bo‘lishi kerak!',
            'email.unique' => 'Bu email allaqachon foydalanilgan!',

            'password.required' => 'Parol majburiy!',
            'password.min' => 'Parol kamida 6 ta belgi bo‘lishi kerak!',

            'role_id.required' => 'Role tanlash majburiy!',
            'role_id.exists' => 'Tanlangan role tizimda mavjud emas!',
        ];
    }
}
