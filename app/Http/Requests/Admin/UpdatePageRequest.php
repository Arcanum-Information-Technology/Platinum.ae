<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('pages.update');
    }

    public function rules(): array
    {
        $pageId = $this->route('page')?->id ?? $this->route('page');

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:pages,slug,' . $pageId],
            'template' => ['required', 'string', 'in:default,home,menu,gallery,offers,contact,builder'],
            'status' => ['required', 'string', 'in:draft,published,scheduled'],
            'featured_image' => ['nullable', 'string', 'max:500'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'published_at' => ['nullable', 'date'],
            'create_redirect' => ['nullable', 'boolean'],
            // SEO fields
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'canonical_url' => ['nullable', 'url', 'max:255'],
            'robots' => ['nullable', 'string', 'max:50'],
            'og_title' => ['nullable', 'string', 'max:255'],
            'og_description' => ['nullable', 'string', 'max:500'],
            'og_image' => ['nullable', 'string', 'max:500'],
        ];
    }
}
