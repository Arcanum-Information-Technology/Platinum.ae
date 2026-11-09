<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreFaqRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('pages.create');
    }

    public function rules(): array
    {
        return [
            'question' => ['required', 'string', 'max:300'],
            'answer' => ['required', 'string'],
            'category' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'string', 'in:draft,published'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
