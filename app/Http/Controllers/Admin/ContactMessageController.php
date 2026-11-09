<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    public function index(Request $request): View
    {
        $query = ContactMessage::query();

        if ($request->filled('type')) {
            $query->where('type', $request->query('type'));
        }

        if ($request->filled('status')) {
            if ($request->query('status') === 'unread') {
                $query->unread();
            } elseif ($request->query('status') === 'read') {
                $query->read();
            } else {
                $query->where('status', $request->query('status'));
            }
        }

        if ($request->filled('search')) {
            $term = $request->query('search');
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('email', 'like', "%{$term}%")
                  ->orWhere('phone', 'like', "%{$term}%")
                  ->orWhere('subject', 'like', "%{$term}%")
                  ->orWhere('brand', 'like', "%{$term}%")
                  ->orWhere('message', 'like', "%{$term}%");
            });
        }

        $messages = $query->latest()->paginate(15)->withQueryString();

        return view('admin.messages.index', compact('messages'));
    }

    public function bookings(Request $request): View
    {
        $query = ContactMessage::bookings();

        if ($request->filled('status')) {
            if ($request->query('status') === 'unread') {
                $query->unread();
            } elseif ($request->query('status') === 'read') {
                $query->read();
            } else {
                $query->where('status', $request->query('status'));
            }
        }

        if ($request->filled('search')) {
            $term = $request->query('search');
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('email', 'like', "%{$term}%")
                  ->orWhere('phone', 'like', "%{$term}%")
                  ->orWhere('brand', 'like', "%{$term}%")
                  ->orWhere('message', 'like', "%{$term}%");
            });
        }

        $bookings = $query->latest()->paginate(15)->withQueryString();
        $unreadCount = ContactMessage::bookings()->unread()->count();

        return view('admin.inquiries.bookings', compact('bookings', 'unreadCount'));
    }

    public function franchise(Request $request): View
    {
        $query = ContactMessage::franchise();

        if ($request->filled('status')) {
            if ($request->query('status') === 'unread') {
                $query->unread();
            } elseif ($request->query('status') === 'read') {
                $query->read();
            } else {
                $query->where('status', $request->query('status'));
            }
        }

        if ($request->filled('search')) {
            $term = $request->query('search');
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('email', 'like', "%{$term}%")
                  ->orWhere('phone', 'like', "%{$term}%")
                  ->orWhere('brand', 'like', "%{$term}%")
                  ->orWhere('message', 'like', "%{$term}%");
            });
        }

        $franchiseInquiries = $query->latest()->paginate(15)->withQueryString();
        $unreadCount = ContactMessage::franchise()->unread()->count();

        return view('admin.inquiries.franchise', compact('franchiseInquiries', 'unreadCount'));
    }

    public function contact(Request $request): View
    {
        $query = ContactMessage::contact();

        if ($request->filled('status')) {
            if ($request->query('status') === 'unread') {
                $query->unread();
            } elseif ($request->query('status') === 'read') {
                $query->read();
            } else {
                $query->where('status', $request->query('status'));
            }
        }

        if ($request->filled('search')) {
            $term = $request->query('search');
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('email', 'like', "%{$term}%")
                  ->orWhere('phone', 'like', "%{$term}%")
                  ->orWhere('subject', 'like', "%{$term}%")
                  ->orWhere('message', 'like', "%{$term}%");
            });
        }

        $contactInquiries = $query->latest()->paginate(15)->withQueryString();
        $unreadCount = ContactMessage::contact()->unread()->count();

        return view('admin.inquiries.contact', compact('contactInquiries', 'unreadCount'));
    }

    public function show(ContactMessage $message): View
    {
        if (!$message->is_read) {
            $message->markAsRead();
        }

        return view('admin.messages.show', compact('message'));
    }

    public function toggleRead(ContactMessage $message): RedirectResponse
    {
        $message->update([
            'is_read' => !$message->is_read,
            'read_at' => !$message->is_read ? now() : null,
        ]);

        return back()->with('success', 'Status updated.');
    }

    public function updateStatus(Request $request, ContactMessage $message): RedirectResponse
    {
        $request->validate([
            'status' => 'required|string|max:50',
        ]);

        $message->update([
            'status' => $request->input('status'),
            'is_read' => true,
            'read_at' => $message->read_at ?? now(),
        ]);

        return back()->with('success', 'Inquiry status updated to: ' . ucfirst(str_replace('_', ' ', $request->input('status'))));
    }

    public function updateNotes(Request $request, ContactMessage $message): RedirectResponse
    {
        $message->update(['notes' => $request->input('notes')]);
        return back()->with('success', 'Internal notes updated.');
    }

    public function destroy(ContactMessage $message): RedirectResponse
    {
        $sender = $message->name;
        $type = $message->type;
        $message->delete();

        ActivityLog::log('message_deleted', "Deleted {$type} inquiry from '{$sender}'");

        $redirectRoute = match ($type) {
            'booking' => 'admin.inquiries.bookings',
            'franchise' => 'admin.inquiries.franchise',
            default => 'admin.inquiries.contact',
        };

        return redirect()->route($redirectRoute)->with('success', 'Inquiry deleted successfully.');
    }
}
