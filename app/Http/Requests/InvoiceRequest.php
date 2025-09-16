<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'number'           => 'required|string|max:50|unique:invoices,number,' . ($this->invoice->id ?? 'null'),
            'date'             => 'required|date',
            'customer_name'    => 'required|string|max:150',
            'customer_address' => 'nullable|string|max:255',
            'customer_phone'   => 'nullable|string|max:50',
            'package'          => 'nullable|string|max:100',
            'project'          => 'nullable|string|max:150',
            'currency'         => 'required|string|max:10',
            'items'            => 'required|array|min:1',
            'items.*.title'    => 'required|string|max:200',
            'items.*.description' => 'nullable|string',
            'items.*.subtotal' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'items.required' => 'Minimal satu item.',
        ];
    }
}
