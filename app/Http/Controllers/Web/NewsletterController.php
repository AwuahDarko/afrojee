<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
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
        Mail::to($validated['newsletter_email'])->send(new WelcomeNewsletterMail($validated['newsletter_email']));

        return back()->with('newsletter_success', 'Thank you for subscribing! Check your inbox for a welcome email.');
    }

    public function unsubscribe(Request $request)
    {
        if (!$request->hasValidSignature()) {
            abort(403, 'Invalid unsubscribe link.');
        }
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