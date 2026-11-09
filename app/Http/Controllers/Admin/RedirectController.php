<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRedirectRequest;
use App\Models\ActivityLog;
use App\Models\Redirect;
use App\Services\RedirectService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RedirectController extends Controller
{
    public function __construct(
        protected RedirectService $redirectService
    ) {}

    public function index(Request $request): View
    {
        $query = Redirect::query();

        if ($request->filled('search')) {
            $term = $request->query('search');
            $query->where('source_url', 'like', "%{$term}%")
                  ->orWhere('destination_url', 'like', "%{$term}%");
        }

        $redirects = $query->latest()->paginate(15);

        return view('admin.redirects.index', compact('redirects'));
    }

    public function store(StoreRedirectRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $redirect = $this->redirectService->createRedirect(
            source: $data['source_url'],
            destination: $data['destination_url'],
            statusCode: (int) $data['status_code']
        );

        if (!$redirect) {
            return back()->with('error', 'Cannot create circular redirect to the same URL.');
        }

        ActivityLog::log('redirect_created', "Created redirect from {$redirect->source_url} to {$redirect->destination_url}");

        return back()->with('success', 'Redirect created successfully.');
    }

    public function update(Request $request, Redirect $redirect): RedirectResponse
    {
        $validated = $request->validate([
            'destination_url' => ['required', 'string', 'max:255', 'different:source_url'],
            'status_code' => ['required', 'integer', 'in:301,302'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $redirect->update([
            'destination_url' => $validated['destination_url'],
            'status_code' => $validated['status_code'],
            'is_active' => $request->boolean('is_active'),
        ]);

        ActivityLog::log('redirect_updated', "Updated redirect #{$redirect->id}");

        return back()->with('success', 'Redirect updated.');
    }

    public function destroy(Redirect $redirect): RedirectResponse
    {
        $redirect->delete();
        ActivityLog::log('redirect_deleted', "Deleted redirect #{$redirect->id}");

        return back()->with('success', 'Redirect removed.');
    }
}
