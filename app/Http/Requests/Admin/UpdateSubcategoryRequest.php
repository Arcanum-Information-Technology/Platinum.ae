<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubcategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('menu.update');
    }

    public function rules(): array
    {
        $subId = $this->route('subcategory')?->id ?? $this->route('subcategory');

        return [
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:subcategories,slug,' . $subId],
            'description' => ['nullable', 'string', 'max:1000'],
            'image' => ['nullable', 'string', 'max:500'],
            'status' => ['required', 'string', 'in:draft,published'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
