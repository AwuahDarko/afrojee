<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AdminCustomEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class EmailController extends Controller
{
    public function index()
    {
        return view('backend.send-email');
    }

    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'to' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->all());
        }

        try {
            $emailData = [
                'subject' => $request->subject,
                'message' => $request->message,
                'recipient_name' => $request->recipient_name ?? 'Valued Customer',
            ];

            Mail::to($request->to)->send(new AdminCustomEmail($emailData));

            return redirect()->back()
                ->with('success', 'Email sent successfully to ' . $request->to);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to send email: ' . $e->getMessage())
                ->withInput($request->all());
        }
    }
}

