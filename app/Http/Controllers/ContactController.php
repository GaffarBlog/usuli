<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContactController extends Controller
{
    public function index(): Response
    {
        return response()->view('contact', [
            'navItems' => buildNavbarItems(),
            'activeNav' => 'যোগাযোগ',
        ]);
    }

    public function store(Request $request): Response
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'body' => 'required|string|max:5000',
        ]);

        Contact::create($validated);

        return redirect()->route('contact')->with('success', 'আপনার বার্তা সফলভাবে পাঠানো হয়েছে। আমরা শীঘ্রই আপনার সাথে যোগাযোগ করব।');
    }
}
