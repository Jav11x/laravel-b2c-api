<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Valida creación de categorías.
 */

class CategoryStoreRequest extends FormRequest
{
    /** Autoriza siempre (no hay roles en la prueba). */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación.
     * 
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return ['name' => ['required', 'string', 'max:255', Rule::unique('categories', 'name')]];
        
    }
}
