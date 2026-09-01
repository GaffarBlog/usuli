<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContactController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Contact::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('body', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_seen', $request->input('status') === 'seen');
        }

        $contacts = $query->latest()->paginate(15)->withQueryString();

        return response()->view('admin.contacts.index', [
            'pageTitle' => 'যোগাযোগসমূহ',
            'contacts' => $contacts,
        ]);
    }

    public function show(Contact $contact): Response
    {
        $contact->update(['is_seen' => true]);

        return response()->view('admin.contacts.show', [
            'pageTitle' => 'যোগাযোগের বিস্তারিত',
            'contact' => $contact,
        ]);
    }

    public function destroy(Contact $contact): Response
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')->with('success', 'যোগাযোগ সফলভাবে মুছে ফেলা হয়েছে।');
    }
}
