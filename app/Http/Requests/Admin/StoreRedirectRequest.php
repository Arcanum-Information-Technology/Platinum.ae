<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreRedirectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('seo.update');
    }

    public function rules(): array
    {
        return [
            'source_url' => ['required', 'string', 'max:255', 'unique:redirects,source_url'],
            'destination_url' => ['required', 'string', 'max:255', 'different:source_url'],
            'status_code' => ['required', 'integer', 'in:301,302'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
