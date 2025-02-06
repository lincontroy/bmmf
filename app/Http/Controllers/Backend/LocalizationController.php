<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class LocalizationController extends Controller
{
    /**
     * Setting Controller constructor
     *
     * @param SettingService $settingService
     */
    public function __construct()
    {
    }

    /**
     * Index
     *
     */
    public function switchLang($lang)
    {
        Session::put('locale', $lang);

        success_message(localize('Language Switch successfully'));


        return redirect()->back();
    }

}
