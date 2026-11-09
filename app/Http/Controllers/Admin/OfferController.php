<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreOfferRequest;
use App\Models\ActivityLog;
use App\Models\Offer;
use App\Services\SlugService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OfferController extends Controller
{
    public function index(): View
    {
        $offers = Offer::orderBy('sort_order')->paginate(15);
        return view('admin.offers.index', compact('offers'));
    }

    public function create(): View
    {
        return view('admin.offers.create');
    }

    public function store(StoreOfferRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $slug = $data['slug'] ?: SlugService::generate($data['title'], Offer::class);

        $offer = Offer::create([
            'title' => $data['title'],
            'slug' => $slug,
            'subtitle' => $data['subtitle'] ?? null,
            'description' => $data['description'] ?? null,
            'badge' => $data['badge'] ?? null,
            'image' => $data['image'] ?? null,
            'discount_amount' => $data['discount_amount'] ?? null,
            'promo_code' => $data['promo_code'] ?? null,
            'start_date' => $data['start_date'] ?? null,
            'end_date' => $data['end_date'] ?? null,
            'is_active' => $request->boolean('is_active', true),
            'is_featured' => $request->boolean('is_featured'),
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        ActivityLog::log('offer_created', "Created offer '{$offer->title}'", $offer);

        return redirect()->route('admin.offers.index')->with('success', 'Offer created successfully.');
    }

    public function edit(Offer $offer): View
    {
        return view('admin.offers.edit', compact('offer'));
    }

    public function update(Request $request, Offer $offer): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:offers,slug,' . $offer->id],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'badge' => ['nullable', 'string', 'max:100'],
            'image' => ['nullable', 'string', 'max:500'],
            'discount_amount' => ['nullable', 'string', 'max:100'],
            'promo_code' => ['nullable', 'string', 'max:50'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'is_active' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $offer->update([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'subtitle' => $validated['subtitle'] ?? null,
            'description' => $validated['description'] ?? null,
            'badge' => $validated['badge'] ?? null,
            'image' => $validated['image'] ?? null,
            'discount_amount' => $validated['discount_amount'] ?? null,
            'promo_code' => $validated['promo_code'] ?? null,
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
            'is_active' => $request->boolean('is_active'),
            'is_featured' => $request->boolean('is_featured'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        ActivityLog::log('offer_updated', "Updated offer '{$offer->title}'", $offer);

        return redirect()->route('admin.offers.index')->with('success', 'Offer updated successfully.');
    }

    public function destroy(Offer $offer): RedirectResponse
    {
        $title = $offer->title;
        $offer->delete();

        ActivityLog::log('offer_deleted', "Deleted offer '{$title}'");

        return redirect()->route('admin.offers.index')->with('success', "Offer '{$title}' deleted.");
    }
}
