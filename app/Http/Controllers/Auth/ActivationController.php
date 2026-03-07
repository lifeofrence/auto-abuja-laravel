<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivationController extends Controller
{
    public function activate($token)
    {
        $user = User::where('activation_token', $token)->first();

        if (!$user) {
            return redirect()->route('login')->withErrors(['email' => 'Invalid or expired activation token.']);
        }

        $user->update([
            'status' => 'active',
            'activation_token' => null,
            'email_verified_at' => now(),
        ]);

        // Automatically log the user in
        Auth::login($user);

        // Redirect to dashboard with a success message
        return redirect()->intended('/dashboard')->with('status', 'Your account has been successfully activated and you have been logged in!');
    }
}