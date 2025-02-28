<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeUpdateRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'department_id' => 'required|exists:departments,id',
            'name' => request()->route('employee') ? 'nullable' : 'required|string|max:255',
            'email' => request()->route('employee') 
                ? 'nullable|email|unique:employees,email,' . request()->route('employee')->id 
                : 'required|email|unique:employees,email',
            'password' => request()->route('employee') ? 'nullable' : 'required|string|min:6',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'img' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'work_schedule' => 'required|in:full_time,part_time,shift',
            'salary_type' => 'required',
            'salary' => 'nullable|numeric|min:0',
            'hourly_rate' => 'nullable|numeric|min:0',
            'task_rate' => 'nullable|numeric|min:0',
            'advance' => 'nullable|numeric|min:0',
            'fine' => 'nullable|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
        ];
        
    }
    public function messages()
    {
        return [
            'user_id.required' => 'Foydalanuvchi tanlanishi shart.',
            'user_id.exists' => 'Tanlangan foydalanuvchi mavjud emas.',
            'department_id.required' => 'Bo‘lim tanlanishi shart.',
            'department_id.exists' => 'Tanlangan bo‘lim mavjud emas.',
            'phone.required' => 'Telefon raqami kiritilishi shart.',
            'phone.string' => 'Telefon raqami matn shaklida bo‘lishi kerak.',
            'phone.max' => 'Telefon raqami 15 ta belgidan oshmasligi kerak.',
            'address.required' => 'Manzil kiritilishi shart.',
            'address.string' => 'Manzil matn shaklida bo‘lishi kerak.',
            'address.max' => 'Manzil 255 ta belgidan oshmasligi kerak.',
            'img.required' => 'Rasm yuklanishi shart.',
            'img.image' => 'Fayl rasm formatida bo‘lishi kerak.',
            'img.mimes' => 'Faqatgina jpeg, jpg, png yoki gif formatdagi rasm yuklash mumkin.',
            'img.max' => 'Rasm hajmi 2MB dan oshmasligi kerak.',
            'work_schedule.required' => 'Ish jadvali tanlanishi shart.',
            'work_schedule.in' => 'Ish jadvali noto‘g‘ri qiymatga ega.',
            'salary_type.required' => 'Maosh turi tanlanishi shart.',
            'salary_type.in' => 'Maosh turi noto‘g‘ri qiymatga ega.',
            'salary.numeric' => 'Maosh son bo‘lishi kerak.',
            'salary.min' => 'Maosh 0 dan kam bo‘lishi mumkin emas.',
            'hourly_rate.numeric' => 'Soatbay stavka son bo‘lishi kerak.',
            'hourly_rate.min' => 'Soatbay stavka 0 dan kam bo‘lishi mumkin emas.',
            'task_rate.numeric' => 'Ishbay to‘lov son bo‘lishi kerak.',
            'task_rate.min' => 'Ishbay to‘lov 0 dan kam bo‘lishi mumkin emas.',
            'advance.numeric' => 'Avans son bo‘lishi kerak.',
            'advance.min' => 'Avans 0 dan kam bo‘lishi mumkin emas.',
            'fine.numeric' => 'Jarima son bo‘lishi kerak.',
            'fine.min' => 'Jarima 0 dan kam bo‘lishi mumkin emas.',
            'bonus.numeric' => 'Bonus son bo‘lishi kerak.',
            'bonus.min' => 'Bonus 0 dan kam bo‘lishi mumkin emas.',
            'start_time.date_format' => 'Boshlanish vaqti "HH:MM" formatida bo‘lishi kerak.',
            'end_time.date_format' => 'Tugash vaqti "HH:MM" formatida bo‘lishi kerak.',
        ];
    }
}
