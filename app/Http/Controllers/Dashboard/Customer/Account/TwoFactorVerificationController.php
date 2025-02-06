<?php

namespace App\Http\Controllers\Dashboard\Customer\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\TwoFactorVerificationRequest;
use App\Services\Customer\CustomerService;
use App\Services\LanguageService;
use App\Traits\ResponseTrait;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class TwoFactorVerificationController extends Controller
{
    use ResponseTrait;

    /**
     * TwoFactorVerificationController of __construct
     *
     * @param CustomerService $customerService
     */
    public function __construct(
        private CustomerService $customerService,
        private LanguageService $languageService,
    ) {
    }

    /**
     * Index
     *
     * @return View
     */
    public function index(): View
    {
        cs_set('theme', [
            'title'       => localize('Two factor Verification'),
            'description' => localize('Two factor Verification'),
        ]);

        $data = $this->customerService->twoFactorFormData();



        return view('customer.account.two_factor', $data);
    }

    /**
     * Update Customer Two Factor Verification Information
     *
     * @param TwoFactorVerificationRequest $request
     * @return RedirectResponse
     */
    public function update(TwoFactorVerificationRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $this->customerService->updateTwoFactorVerification($data);

        success_message(localize("Two Factor Verification update successfully"));

        return redirect()->back();
    }

}
