<?php

namespace App\Http\Requests\Website;

use Illuminate\Foundation\Http\FormRequest;

class ContactFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email:rfc', 'max:150'],
            'phone' => ['nullable', 'string', 'max:30'],
            'subject' => ['nullable', 'string', 'max:150'],
            'territory' => ['nullable', 'string', 'max:150'],
            'message' => ['required', 'string', 'min:2', 'max:3000'],
            // Honeypot field for bot/spam protection
            'website_hp' => ['nullable', 'size:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please provide your full name.',
            'email.required' => 'A valid email address is required so we can reply.',
            'email.email' => 'Please enter a valid email address.',
            'message.required' => 'Please enter your message or reservation inquiry.',
            'message.min' => 'Please enter a short message.',
        ];
    }
}
