<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMenuItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('menu.update');
    }

    protected function prepareForValidation(): void
    {
        foreach (['ingredients', 'allergens', 'tags'] as $field) {
            if ($this->has($field) && is_string($this->input($field))) {
                $items = array_filter(array_map('trim', explode(',', $this->input($field))));
                $this->merge([$field => array_values($items)]);
            }
        }
    }

    public function rules(): array
    {
        $itemId = $this->route('menu_item')?->id ?? $this->route('menu_item');

        return [
            'category_id' => ['required', 'exists:categories,id'],
            'subcategory_id' => ['nullable', 'exists:subcategories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:menu_items,slug,' . $itemId],
            'short_description' => ['nullable', 'string', 'max:500'],
            'full_description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'discounted_price' => ['nullable', 'numeric', 'min:0'],
            'primary_image' => ['nullable', 'string', 'max:500'],
            'gallery_images' => ['nullable', 'array'],
            'ingredients' => ['nullable', 'array'],
            'allergens' => ['nullable', 'array'],
            'calories' => ['nullable', 'integer', 'min:0'],
            'preparation_time' => ['nullable', 'string', 'max:50'],
            'serving_size' => ['nullable', 'string', 'max:50'],
            'is_vegetarian' => ['nullable', 'boolean'],
            'is_vegan' => ['nullable', 'boolean'],
            'is_spicy' => ['nullable', 'boolean'],
            'spice_level' => ['nullable', 'integer', 'between:0,3'],
            'is_featured' => ['nullable', 'boolean'],
            'is_available' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'tags' => ['nullable', 'array'],
            'status' => ['required', 'string', 'in:draft,published'],
            // SEO
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
        ];
    }
}
