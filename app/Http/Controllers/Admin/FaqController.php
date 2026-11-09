<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreFaqRequest;
use App\Models\ActivityLog;
use App\Models\Faq;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function index(): View
    {
        $faqs = Faq::orderBy('sort_order')->paginate(15);
        return view('admin.faqs.index', compact('faqs'));
    }

    public function create(): View
    {
        return view('admin.faqs.create');
    }

    public function store(StoreFaqRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $faq = Faq::create([
            'question' => $data['question'],
            'answer' => $data['answer'],
            'category' => $data['category'] ?? 'general',
            'status' => $data['status'],
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        ActivityLog::log('faq_created', "Created FAQ '{$faq->question}'", $faq);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ created successfully.');
    }

    public function edit(Faq $faq): View
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq): RedirectResponse
    {
        $validated = $request->validate([
            'question' => ['required', 'string', 'max:300'],
            'answer' => ['required', 'string'],
            'category' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'string', 'in:draft,published'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $faq->update([
            'question' => $validated['question'],
            'answer' => $validated['answer'],
            'category' => $validated['category'] ?? 'general',
            'status' => $validated['status'],
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        ActivityLog::log('faq_updated', "Updated FAQ '{$faq->question}'", $faq);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ updated.');
    }

    public function destroy(Faq $faq): RedirectResponse
    {
        $faq->delete();
        ActivityLog::log('faq_deleted', "Deleted FAQ");

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ deleted.');
    }
}
