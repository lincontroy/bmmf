<?php

namespace App\Http\Controllers\Dashboard\Customer\Account;

use App\Enums\AuthGuardEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\KycVerificationRequest;
use App\Services\CustomerKycVerificationService;
use App\Services\Customer\CustomerService;
use App\Services\LanguageService;
use App\Traits\ResponseTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class KycVerificationController extends Controller
{
    use ResponseTrait;

    /**
     * KycVerificationController of __construct
     *
     * @param CustomerService $customerService
     */
    public function __construct(
        private CustomerKycVerificationService $customerKycVerificationService,
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
            'title'       => localize('Kyc Verification'),
            'description' => localize('Kyc Verification'),
        ]);

        $data = $this->customerKycVerificationService->formData();
        return view('customer.account.kyc_verification', $data);
    }

    /**
     * Create Customer Kyc Verification
     *
     * @param KycVerificationRequest $request
     * @return RedirectResponse
     */
    public function store(KycVerificationRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $this->customerKycVerificationService->create($data);

        success_message(localize("Kyc Verification create successfully"));

        return redirect()->route('customer.account.profile');
    }

}
