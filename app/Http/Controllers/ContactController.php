<?php
// app/Http/Controllers/ContactController.php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class ContactController extends Controller
{
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
        // Mail::to('admin@afrojee.store')->send(new ContactFormMail($validated));

        return back()->with('contact_success', 'Thank you for your message! We\'ll get back to you within 24 hours.');
    }
}

// app/Http/Controllers/NewsletterController.php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeNewsletterMail;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'newsletter_email' => 'required|email|max:255',
        ]);

        // Check if already subscribed
        $existing = NewsletterSubscriber::where('email', $validated['newsletter_email'])->first();

        if ($existing) {
            if ($existing->is_active) {
                return back()->with('newsletter_success', 'You are already subscribed to our newsletter!');
            } else {
                // Reactivate subscription
                $existing->update([
                    'is_active' => true,
                    'subscribed_at' => now(),
                    'unsubscribed_at' => null,
                ]);
                return back()->with('newsletter_success', 'Welcome back! Your subscription has been reactivated.');
            }
        }

        // Create new subscriber
        NewsletterSubscriber::create([
            'email' => $validated['newsletter_email'],
            'is_active' => true,
            'subscribed_at' => now(),
        ]);

        // Optional: Send welcome email
        // Mail::to($validated['newsletter_email'])->send(new WelcomeNewsletterMail());

        return back()->with('newsletter_success', 'Thank you for subscribing! Check your inbox for a welcome email.');
    }

    public function unsubscribe(Request $request)
    {
        $email = $request->query('email');
        
        $subscriber = NewsletterSubscriber::where('email', $email)->first();
        
        if ($subscriber) {
            $subscriber->update([
                'is_active' => false,
                'unsubscribed_at' => now(),
            ]);
            
            return view('newsletter.unsubscribed')->with('success', 'You have been unsubscribed from our newsletter.');
        }
        
        return view('newsletter.unsubscribed')->with('error', 'Email not found in our subscriber list.');
    }
}