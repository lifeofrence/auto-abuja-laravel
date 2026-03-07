<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // If User is Admin
        if ($user->role === 'admin') {
            return view('admin.dashboard');
        }

        // If the user is a vendor and has a VIO portal ID, sync their license status
        if ($user->role === 'vendor' && $user->vio_user_id) {
            $this->syncLicenseStatus($user);
        }

        return view('dashboard');
    }

    /**
     * Sync license status with the external API.
     */
    private function syncLicenseStatus($user)
    {
        $apiUrl = config('services.trade_license.url') ?: env('TRADE_LICENSE_API_URL');
        $apiToken = config('services.trade_license.token') ?: env('TRADE_LICENSE_API_TOKEN');
        $apiUser = config('services.trade_license.user') ?: env('TRADE_LICENSE_API_USER');
        $apiPass = config('services.trade_license.pass') ?: env('TRADE_LICENSE_API_PASS');

        if (!$apiUrl) {
            return;
        }

        try {
            $response = Http::asJson()->withHeaders([
                'X-Api-Token' => $apiToken,
            ])->withBasicAuth($apiUser, $apiPass)
                ->post($apiUrl, [
                    'trade_license_number' => $user->vio_user_id,
                    'portal_id' => $user->vio_user_id,
                ]);

            if ($response->successful()) {
                $responseData = $response->json();

                if (isset($responseData['response_code']) && $responseData['response_code'] == "200") {
                    $licenseInfo = $responseData['data']['license_information'] ?? null;

                    if ($licenseInfo) {
                        $user->update([
                            'license_start_date' => $licenseInfo['last_payment_start_date'] ?? $user->license_start_date,
                            'license_end_date' => $licenseInfo['last_payment_end_date'] ?? $user->license_end_date,
                            'license_status' => $licenseInfo['validity_status'] ?? $user->license_status,
                        ]);

                        Log::info("License synced for user {$user->id} (VIO ID: {$user->vio_user_id})");
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error("Failed to sync license for user {$user->id}: " . $e->getMessage());
        }
    }
}
