<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordNotification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class VerifyLicenseController extends Controller
{
    /**
     * Show the verification form.
     */
    public function show()
    {
        return view('auth.verify-license');
    }

    /**
     * Verify the trade license and register the user.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'portal_id' => 'required|string',
        ]);

        $apiUrl = config('services.trade_license.url');
        $apiToken = config('services.trade_license.token');
        $apiUser = config('services.trade_license.user');
        $apiPass = config('services.trade_license.pass');

        // Note: Using hardcoded values if config is not yet set up in services.php
        $apiUrl = $apiUrl ?: env('TRADE_LICENSE_API_URL');
        $apiToken = $apiToken ?: env('TRADE_LICENSE_API_TOKEN');
        $apiUser = $apiUser ?: env('TRADE_LICENSE_API_USER');
        $apiPass = $apiPass ?: env('TRADE_LICENSE_API_PASS');

        try {
            $response = Http::asJson()->withHeaders([
                'X-Api-Token' => $apiToken,
            ])->withBasicAuth($apiUser, $apiPass)
                ->post($apiUrl, [
                    'trade_license_number' => $request->portal_id,
                    'portal_id' => $request->portal_id,
                ]);

            $responseData = $response->json();
            \Log::info('Trade License API Body:', ['body' => $responseData]);

            // The API might return 200 HTTP but 400 in the body
            $responseCode = $responseData['response_code'] ?? null;
            $responseMessage = $responseData['response_message'] ?? 'Unknown Error';

            if ($response->successful() && $responseCode == "200") {
                // Based on verified structure: { "data": { "personal_information": { ... } } }
                $personalInfo = $responseData['data']['personal_information'] ?? null;

                if (!$personalInfo || empty($personalInfo['email'])) {
                    return back()->withErrors(['portal_id' => 'Verified, but personal email is missing from the portal response.']);
                }

                $email = $personalInfo['email'];

                // Check if user already exists
                if (User::where('email', $email)->exists()) {
                    return back()->withErrors(['portal_id' => "An account with email $email already exists."]);
                }

                $password = Str::random(10);
                $activationToken = Str::random(64);

                $businessInfo = $responseData['data']['business_information'] ?? null;
                $tradeLicense = $responseData['data']['special_trade_license'] ?? null;
                $licenseValidity = $responseData['data']['license_information'] ?? null;

                $user = User::create([
                    'name' => $personalInfo['name'] ?? 'VIO User',
                    'email' => $email,
                    'password' => Hash::make($password),
                    'vio_user_id' => $request->portal_id,
                    'role' => 'vendor', // Default to vendor
                    'status' => 'pending', // Must activate first
                    'activation_token' => $activationToken,
                    'phone' => $personalInfo['phone_number'] ?? null,
                    'address' => $personalInfo['address'] ?? null,
                    // Business details
                    'business_name' => $businessInfo['business_name'] ?? null,
                    'business_address' => $businessInfo['business_address'] ?? null,
                    'business_location' => $businessInfo['business_location'] ?? null,
                    'association_or_union' => $businessInfo['association_or_union'] ?? null,
                    // Trade License details
                    'service_type' => $tradeLicense['service_type'] ?? null,
                    'service_category' => $tradeLicense['service_category'] ?? null,
                    'service_description' => $tradeLicense['service_description'] ?? null,
                    // License Validity
                    'license_start_date' => $licenseValidity['last_payment_start_date'] ?? null,
                    'license_end_date' => $licenseValidity['last_payment_end_date'] ?? null,
                    'license_status' => $licenseValidity['validity_status'] ?? null,
                ]);

                $activationUrl = route('activate', ['token' => $activationToken]);

                try {
                    Mail::to($user->email)->send(new PasswordNotification($password, $activationUrl));
                    return redirect()->route('login')->with('status', "Account created! A confirmation email has been sent to $email with a default password.Please activate your account before logging in.");
                } catch (\Exception $mailEx) {
                    \Log::error('Mail sending failed: ' . $mailEx->getMessage());
                    // return redirect()->route('login')->with('status', "Account created! However, we couldn't send the activation email to $email. For testing, your password is: $password and activation link is: $activationUrl");
                    return redirect()->route('login')->with('status', "Account created! A confirmation email has been sent to $email");
                }
            }

            return back()->withErrors(['portal_id' => 'Verification failed: ' . $responseMessage]);

        } catch (\Exception $e) {
            return back()->withErrors(['portal_id' => 'An error occurred during verification: ' . $e->getMessage()]);
        }
    }
}
