<?php
// app/Http/Controllers/ContactController.php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class ContactController extends Controller
{
    public function index()
    {
        return view('frontend.partials.contact-us');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:5000',
        ]);

        // Store in database
        Contact::create($validated);

        // Optional: Send email notification to admin
        Mail::to('admin@afrojee.store')->send(new ContactFormMail($validated));

        return back()->with('contact_success', __('common.contact.form.success'));
    }
}
