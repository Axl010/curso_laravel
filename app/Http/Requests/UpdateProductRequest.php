<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
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
            'name' => 'sometimes|required|string|max:255',
            'sku' => [
                'sometimes',
                'required',
                'string',
                'max:50',
                Rule::unique('products')->ignore($this->route('id'))
            ],
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
            'stock' => 'sometimes|required|integer|min:0',
            'is_active' => 'sometimes|boolean',
            'category_id' => 'nullable|exists:categories,id',
            'expires_at' => 'nullable|date'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El :attribute es obligatorio.',
            'name.max' => 'El :attribute no puede tener más de :max caracteres.',

            'sku.required' => 'El :attribute es obligatorio.',
            'sku.unique' => 'El :attribute ya existe en otro producto.',
            'sku.max' => 'El :attribute no puede tener más de :max caracteres.',

            'price.required' => 'El :attribute es obligatorio.',
            'price.min' => 'El :attribute no puede ser negativo.',

            'stock.required' => 'El :attribute es obligatorio.',
            'stock.min' => 'El :attribute no puede ser menor que 0.',

            'category_id.exists' => 'La categoría seleccionada no existe.',
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
