<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubcategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('menu.create');
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:subcategories,slug'],
            'description' => ['nullable', 'string', 'max:1000'],
            'image' => ['nullable', 'string', 'max:500'],
            'status' => ['required', 'string', 'in:draft,published'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
