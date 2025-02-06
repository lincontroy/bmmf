<?php

namespace App\Http\Controllers\Auth\Backend;

use App\Enums\AuthGuardEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use App\Services\SettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{

    /**
     * Display the login view.
     *
     * @return View
     */
    public function index(): View
    {
        cs_set('theme', [
            'title'       => 'Login',
            'description' => 'Login',
        ]);

        return view('backend.auth.login');
    }

    /**
     * Login check incoming authentication request.
     *
     * @param LoginRequest $request
     * @return RedirectResponse
     */
    public function loginCheck(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $settingService = app(SettingService::class);
        $setting        = $settingService->findById();
        $request->session()->regenerate();

        session()->put('locale', $setting->language->symbol ?? 'en');

        success_message(localize('Login successfully'));

        $intendedUrl = session()->get('url.intended', '');

        if (!Str::contains($intendedUrl, '/admin')) {
            $request->session()->forget('url.intended');
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Logout and authenticated session.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard(AuthGuardEnum::ADMIN->value)->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        success_message(localize('Logout successfully'));

        return redirect('/' . AuthGuardEnum::ADMIN->value);
    }

}