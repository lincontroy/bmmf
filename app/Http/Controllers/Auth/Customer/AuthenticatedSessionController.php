<?php

namespace App\Http\Controllers\Auth\Customer;

use App\Enums\AuthGuardEnum;
use App\Enums\UserLogTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CustomerAuthVerifyRequest;
use App\Http\Requests\Auth\CustomerLoginRequest;
use App\Services\Customer\CustomerService;
use App\Services\Customer\UserLogService;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Customer;
use App\Models\WalletManage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Jenssegers\Agent\Agent;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class AuthenticatedSessionController extends Controller
{
    /**
     * AuthenticatedSessionController of __construct
     *
     * @param CustomerService $customerService
     */
    public function __construct(
        private CustomerService $customerService,
        private UserLogService $userLogService,
    ) {
    }

    /**
     * Display the login view.
     */
    public function index(): View
    {
        cs_set('theme', [
            'title'       => localize('Customer Login'),
            'description' => localize('Customer Login'),
        ]);

        return view('customer.auth.login');
    }

    public function reg(): View
    {
        cs_set('theme', [
            'title'       => localize('Customer Register'),
            'description' => localize('Customer Register'),
        ]);

        return view('customer.auth.register');
    }

    public function regpost(Request $request)
    {

        
        $request->validate([
            'first-name' => 'required|string|max:255',
            'last-name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'country' => 'required|string',
            // 'phone' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);
        // dd($request->all());

        


        $user = User::create([
            'first_name' => $request->input('first-name'),
            'last_name' => $request->input('last-name'),
            'username' => $request->input('username'),
            'country' => $request->input('country'),
            // 'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        // Create the Customer linked to this User
        $customer = Customer::create([
            'user_id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'username' => $user->username,
            'email' => $user->email,
            'email_verified_at' => now(), // Set when verification is complete
            'email_verification_token' => null, // Generate if needed
            'password' => $user->password,
            'phone' => $request->input('phone'),
            'country' => $request->input('country'),
            'status' => 1, // Default status
            'verified_status' => 1, // Default verified status
            'merchant_verified_status' => 3,
            'created_at' => now(),
        ]);

        $wallet=WalletManage::create([
            'user_id'=>$user->id,
            'accept_currency_id'=>1,
        ]);


        return Redirect::route('customer.dashboard')->with('success', 'Registration successful!');

    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(CustomerLoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $customer = auth(AuthGuardEnum::CUSTOMER->value)->user();

        if ($customer->google2fa_enable) {
            session()->put("user_2fa_authentication", $customer->google2fa_enable);

            return redirect()->intended(route('customer.auth-verify'));
        }

        $this->customerService->lastLogin($request->ip());

        $agent = new Agent();

        $data = [
            'user_id'     => $customer->user_id,
            'type'        => UserLogTypeEnum::LOGIN->value,
            'access_time' => Carbon::now(),
            'user_agent'  => $agent->browser(),
            'user_ip'     => $request->ip(),
        ];
        $this->userLogService->create($data);

        success_message(localize('Welcome Back') . ' - ' . $customer->first_name . ' ' . $customer->last_name);

        $intendedUrl = session()->get('url.intended', '');

        if (Str::contains($intendedUrl, '/admin') || !$this->isValidRoute($intendedUrl)) {
            $request->session()->forget('url.intended');
        }

        return redirect()->intended(AuthGuardEnum::CUSTOMER_HOME->value);
    }

    private function isValidRoute($url): bool
    {
        try {
            $route = app('router')->getRoutes()->match(app('request')->create($url));
            return $route->getName() !== null;
        } catch (\Exception $e) {
            return false;
        }

    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $this->customerService->lastLogout();

        $agent = new Agent();

        $data = [
            'user_id'     => auth(AuthGuardEnum::CUSTOMER->value)->user()->user_id,
            'type'        => UserLogTypeEnum::LOGOUT->value,
            'access_time' => Carbon::now(),
            'user_agent'  => $agent->browser(),
            'user_ip'     => $request->ip(),
        ];

        $this->userLogService->create($data);

        Auth::guard(AuthGuardEnum::CUSTOMER->value)->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/' . AuthGuardEnum::CUSTOMER->value);
    }

    /**
     * Display the login view.
     */
    public function auth_verify(): View | RedirectResponse
    {
        cs_set('theme', [
            'title'       => localize('Customer Auth Verify'),
            'description' => localize('Customer Auth Verify'),
        ]);

        if (!session()->has('user_2fa_authentication')) {
            return redirect()->route('customer.dashboard');
        }

        return view('customer.auth.auth-verify');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function auth_verify_confirm(CustomerAuthVerifyRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $verificationCode = $data['verification_code'];

        if (!session()->has('user_2fa_authentication')) {
            return redirect()->back()->with('exception', localize('Something went wrong!!'))->withInput();
        }

        $google2fa    = new Google2FA();
        $verifyStatus = $google2fa->verifyKey(
            auth(AuthGuardEnum::CUSTOMER->value)->user()->google2fa_secret,
            $verificationCode
        );

        if (!$verifyStatus) {
            return redirect()->back()->with('exception', localize('Invalid verification code!'))->withInput();
        }

        $this->customerService->lastLogin($request->ip());

        session()->forget("user_2fa_authentication");
        session()->regenerate();

        success_message(localize('Login successfully'));

        $message = 'Welcome Back - ';

        return redirect()->intended(AuthGuardEnum::CUSTOMER_HOME->value)->with('success', $message);
    }

}
