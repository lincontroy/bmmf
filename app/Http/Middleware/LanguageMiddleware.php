<?php

namespace App\Http\Middleware;

use App\Models\Language;
use App\Models\Setting;
use Closure;

class LanguageMiddleware
{
    public function handle($request, Closure $next)
    {
        $languageCode = $request->header('Accept-Language');
        $language = Language::where('symbol', $languageCode)->first();
        if (!$language) {
            $settingData = Setting::first();
            $languageId = $settingData->language_id;
        } else {
            $languageId = $language->id;
        }
        app()->instance('language_id', $languageId);

        return $next($request);
    }
}

