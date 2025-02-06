<?php

namespace App\Http\Controllers\Auth;

use App\Enums\StatusEnum;
use App\Models\Customer;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use Illuminate\Http\Request;

class ActivationController extends Controller
{
    public function __construct(
        protected CustomerRepositoryInterface $customerRepository,
    )
    {
    }
    public function activate(Request $request)
    {
        $token = $request->get("token");

        $user = Customer::where('email_verification_token', $token)->first();

        if (!$user) {
            return redirect('customer/login')->with('warning', localize('User not found.'));
        }

        if ($user->hasVerifiedEmail()) {
            return redirect('customer/login')->with('success', localize('Email already verified.'));
        }

        if ($user->markEmailAsVerified()) {

            $data['status'] = StatusEnum::ACTIVE->value;
            $user = $this->customerRepository->activateCustomer($user->id, $data);

            return redirect('customer/login')->with('success', localize('Your account activated successfully!'));
        }

        return redirect('customer/login')->with('warning', localize('Email verification failed.'));

    }
}
