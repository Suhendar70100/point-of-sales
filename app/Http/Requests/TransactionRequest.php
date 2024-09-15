<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
    public function rules()
    {
        return [
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'transaction_date' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'item_id.required' => 'Item wajib dipilih.',
            'item_id.exists' => 'Item yang dipilih tidak valid.',
            'quantity.required' => 'Jumlah item wajib diisi.',
            'quantity.min' => 'Jumlah item harus lebih dari 0.',
            'transaction_date.required' => 'Tanggal transaksi wajib diisi.',
            'transaction_date.date' => 'Format tanggal transaksi tidak valid.',
        ];
    }
}
