<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
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
            'sku' => 'required|string|max:50|unique:products,sku',
            'description' => 'nullable|string',
            'price' => 'requires|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'is_active' >= 'boolean',
            'category_id' => 'nullable|exists:categories,id',
            'expires_at' => 'nullable|date'
        ];
    }

    public function messages()
    {
        return [
            // name
            'name.required' => 'El :attribute es obligatorio.',
            'name.max' => 'El :attribute no puede tener más de :max caracteres.',

            // sku
            'sku.required' => 'El :attribute es obligatorio.',
            'sku.unique' => 'El :attribute ya está en uso.',
            'sku.max' => 'El :attribute no puede superar los :max caracteres.',

            // price
            'price.required' => 'El :attribute es obligatorio.',
            'price.min' => 'El :attribute no puede ser negativo.',

            // stock
            'stock.required' => 'El :attribute es obligatorio.',
            'stock.min' => 'El :attribute no puede ser menor a 0.',

            // category
            'category_id.exists' => 'La categoría seleccionada no existe.',

            // expires_at
            'expires_at.date' => 'La fecha de expiración no es válida.'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nombre del producto',
            'sku' => 'SKU',
            'description' => 'descripción',
            'price' => 'precio del producto',
            'stock' => 'cantidad en stock',
            'is_active' => 'estado del producto',
            'category_id' => 'categoría',
            'expires_at' => 'fecha de expiración'
        ];
    }
}
