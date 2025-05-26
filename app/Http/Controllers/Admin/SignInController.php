<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SignInController extends Controller
{
     public function index(){
        return view('backend.signin');
    }

    /**
     * Handle admin login
     */
    public function login(Request $request)
    {
        // Validate the form data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }

        // Attempt to log the user in
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
            
            // Check if user is admin
            if ($user->isAdmin()) {
                // Regenerate session for security
                $request->session()->regenerate();
                
                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'Welcome back, ' . $user->name . '!');
            } else {
                // User is not admin, log them out
                Auth::logout();
                return redirect()->back()
                    ->withErrors(['email' => 'Access denied. Admin privileges required.'])
                    ->withInput($request->only('email'));
            }
        }

        // Authentication failed
        return redirect()->back()
            ->withErrors(['email' => 'Invalid credentials provided.'])
            ->withInput($request->only('email'));
    }

    /**
     * Handle admin logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login')
            ->with('success', 'You have been logged out successfully.');
    }
}
