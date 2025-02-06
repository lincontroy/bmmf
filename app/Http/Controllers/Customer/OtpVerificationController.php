<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\OtpVerificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class OtpVerificationController extends Controller
{

    public function __construct(
        private OtpVerificationService $otpVerificationService
    ) {

    }

    public function codeVerify(): View
    {

        if (!session()->has('otp_verify')) {
            return view("customer.error");
        }

        $data['email'] = Str::substr(auth()->user()->email, 0, 3) . '******' . Str::substr(auth()->user()->email, -9);

        return view("customer.otpVerify", $data);
    }

    public function verify(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'verification_code' => ['required', 'string', 'size:6'],
        ]);

        if (!session()->has('otp_verify')) {
            return redirect()->route('otp.verify');
        }

        $otpData = session('otp_data');

        $verifyResult = $this->otpVerificationService->otpVerify([
            'customer_id' => auth(0)->user()->id,
            'verify_type' => $otpData['verify_type'],
            'code'        => $validatedData['verification_code'],
        ]);

        if ($verifyResult->status != "success") {
            $wrongLimit = session("wrong_limit");
            $wrongLimit--;

            if ($wrongLimit <= 0) {
                session()->forget(['otp_verify', 'wrong_limit', 'otp_data']);
                return redirect()->route('otp.verify')->with('exception', localize('You have exceeded the maximum number of verification attempts.'));
            }

            session()->put([
                'wrong_limit' => $wrongLimit,
            ]);

            return redirect()->route('otp.verify')->with('exception', $verifyResult->message);
        }

        session()->forget(['otp_verify', 'wrong_limit', 'otp_data']);

        session()->put([
            'otp_verified' => true,
            'verify_id'    => $verifyResult->data->id,
        ]);

        return redirect()->route($otpData['callback']);
    }

}
