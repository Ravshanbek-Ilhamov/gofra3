<?php

namespace App\Http\Requests\InvoiceMaterial;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceMaterialCreateRequest extends FormRequest
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
            'excel_file' => 'required|mimes:xlsx,csv|max:4096', 
            'company_name'=>'required|string|max:255'
        ];
    }
    public function messages()
    {
        return [
            'excel_file.required' => 'Excel fayl yuklash majburiy.',
            'excel_file.mimes' => 'Fayl formati faqat .xlsx yoki .csv bo‘lishi kerak.',
            'excel_file.max' => 'Fayl hajmi 4MB dan oshmasligi kerak.',
            'company_name.required'=>'Input company name'
        ];
    }
}
