<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreTestimonialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('pages.create');
    }

    public function rules(): array
    {
        return [
            'customer_name' => ['required', 'string', 'max:150'],
            'customer_role' => ['nullable', 'string', 'max:150'],
            'content' => ['required', 'string', 'max:1000'],
            'rating' => ['required', 'integer', 'between:1,5'],
            'avatar' => ['nullable', 'string', 'max:500'],
            'status' => ['required', 'string', 'in:draft,published'],
            'is_featured' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
