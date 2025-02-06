<?php

namespace App\Http\Controllers\Dashboard\Customer\Account;

use App\Enums\AuthGuardEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\CustomerUpdateAvatarRequest;
use App\Http\Requests\Customer\CustomerUpdateRequest;
use App\Services\Customer\CustomerService;
use App\Services\LanguageService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AccountController extends Controller
{
    use ResponseTrait;

    /**
     * AccountController of __construct
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
            'title'       => localize('Customer Account'),
            'description' => localize('Customer Account'),
        ]);

        $data              = [];
        $data['customer']  = auth(AuthGuardEnum::CUSTOMER->value)->user();
        $data['languages'] = $this->languageService->activeLanguages();
        return view('customer.account.account', $data);
    }

    /**
     * Update Customer Information
     *
     * @param CustomerUpdateRequest $request
     * @return RedirectResponse
     */
    public function update(CustomerUpdateRequest $request): RedirectResponse
    {

        $data = $request->validated();
        
        $check = $this->customerService->update($data);
        if(!$check){
            return redirect()->back()->withInput();
        }
        success_message(localize("Customer Information update successfully"));

        return redirect()->back();
    }

    /**
     * Update Customer Avatar
     *
     * @param CustomerUpdateAvatarRequest $request
     * @return RedirectResponse
     */
    public function update_avatar(CustomerUpdateAvatarRequest $request):RedirectResponse
    {

        $data = $request->validated();
        $this->customerService->update_avatar($data);

        success_message(localize("Customer avatar update successfully"));

        return redirect()->back();
    }

}
