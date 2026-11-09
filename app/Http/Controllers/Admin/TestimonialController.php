<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTestimonialRequest;
use App\Models\ActivityLog;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    public function index(): View
    {
        $testimonials = Testimonial::orderBy('sort_order')->paginate(15);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create(): View
    {
        return view('admin.testimonials.create');
    }

    public function store(StoreTestimonialRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $testimonial = Testimonial::create([
            'customer_name' => $data['customer_name'],
            'customer_role' => $data['customer_role'] ?? null,
            'content' => $data['content'],
            'rating' => $data['rating'],
            'avatar' => $data['avatar'] ?? null,
            'status' => $data['status'],
            'is_featured' => $request->boolean('is_featured'),
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        ActivityLog::log('testimonial_created', "Created testimonial from '{$testimonial->customer_name}'", $testimonial);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial created successfully.');
    }

    public function edit(Testimonial $testimonial): View
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:150'],
            'customer_role' => ['nullable', 'string', 'max:150'],
            'content' => ['required', 'string', 'max:1000'],
            'rating' => ['required', 'integer', 'between:1,5'],
            'avatar' => ['nullable', 'string', 'max:500'],
            'status' => ['required', 'string', 'in:draft,published'],
            'is_featured' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $testimonial->update([
            'customer_name' => $validated['customer_name'],
            'customer_role' => $validated['customer_role'] ?? null,
            'content' => $validated['content'],
            'rating' => $validated['rating'],
            'avatar' => $validated['avatar'] ?? null,
            'status' => $validated['status'],
            'is_featured' => $request->boolean('is_featured'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        ActivityLog::log('testimonial_updated', "Updated testimonial from '{$testimonial->customer_name}'", $testimonial);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial updated.');
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $name = $testimonial->customer_name;
        $testimonial->delete();

        ActivityLog::log('testimonial_deleted', "Deleted testimonial from '{$name}'");

        return redirect()->route('admin.testimonials.index')->with('success', "Testimonial from '{$name}' deleted.");
    }
}
