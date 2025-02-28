<?php

namespace App\Http\Requests\Warehouse;

use Illuminate\Foundation\Http\FormRequest;

class ExportProductRequest extends FormRequest
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
            
            'product_id' => 'required|integer|exists:products,id',
            'to_id' => 'required|integer|exists:warehouses,id',
            'quantity' => 'required|integer|min:1',
        ];
    }
    public function messages()
    {
        return [
            'product_id.required' => 'Product ID talab qilinadi.',
            'product_id.exists' => 'Product mavjud emas.',
            'to_id.required' => 'Maqsad ombori talab qilinadi.',
            'to_id.exists' => 'Maqsad ombori mavjud emas.',
            'quantity.required' => 'Miqdor talab qilinadi.',
            'quantity.min' => 'Miqdor kamida 1 bo\'lishi kerak.',
        ];
    }
}
