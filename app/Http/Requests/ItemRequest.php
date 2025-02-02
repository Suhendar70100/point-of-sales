<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
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
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:1',
        ];
    }

    /**
     *  
     *  
     *  
     * @return array
     *  
     * @throws \Illuminate\Validation\ValidationException
     *  
     *  
     * 
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama item wajib diisi.',
            'name.unique' => 'Nama item harus unik.',
            'category_id.required' => 'Kategori item wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'stock.required' => 'Stok item wajib diisi.',
        ];
    }
}
