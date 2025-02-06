<?php

namespace App\Http\Controllers\Dashboard\Customer\Account;

use App\Enums\AuthGuardEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\PasswordChangeRequest;
use App\Services\Customer\CustomerService;
use App\Services\LanguageService;
use App\Traits\ResponseTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PasswordChangeController extends Controller
{
    use ResponseTrait;

    /**
     * PasswordChangeController of __construct
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
            'title'       => localize('Password Change'),
            'description' => localize('Password Change'),
        ]);

        $data             = [];
        $data['customer'] = auth(AuthGuardEnum::CUSTOMER->value)->user();
        return view('customer.account.password_change', $data);
    }

    /**
     * Update Customer Password Change Information
     *
     * @param PasswordChangeRequest $request
     * @return RedirectResponse
     */
    public function update(PasswordChangeRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $this->customerService->updatePassword($data);

        success_message(localize("Password Change update successfully"));

        return redirect()->back();
    }

}
