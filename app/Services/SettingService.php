<?php

namespace App\Services;

use App\Enums\MailMailerEnum;
use App\Enums\SiteAlignEnum;
use App\Helpers\ImageHelper;
use App\Repositories\Interfaces\LanguageRepositoryInterface;
use App\Repositories\Interfaces\SettingRepositoryInterface;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;

class SettingService
{
    /**
     * SettingService constructor.
     *
     * @param SettingRepositoryInterface $settingRepository
     */
    public function __construct(
        private SettingRepositoryInterface $settingRepository,
        private LanguageRepositoryInterface $languageRepository,
    ) {
    }

    /**
     * Form data of app setting
     *
     * @return array
     */
    public function formData(): array
    {
        $siteAligns = SiteAlignEnum::values();
        $setting    = $this->settingRepository->first();
        $languages  = $this->languageRepository->all();

        return compact('siteAligns', 'setting', 'languages');
    }

    /**
     * Form data of email setting
     *
     * @return array
     */
    public function emailFormData(): array
    {
        $mailMailers = MailMailerEnum::values();

        $data = [
            'MAIL_MAILER'       => config('mail.mailer'),
            'MAIL_HOST'         => config('mail.host'),
            'MAIL_PORT'         => config('mail.port'),
            'MAIL_USERNAME'     => config('mail.username'),
            'MAIL_PASSWORD'     => config('mail.password'),
            'MAIL_ENCRYPTION'   => config('mail.encryption'),
            'MAIL_FROM_ADDRESS' => config('mail.from_address'),
            'MAIL_FROM_NAME'    => config('mail.from_name'),
        ];

        return compact('data', 'mailMailers');
    }

    /**
     * Form data of sms setting
     *
     * @return array
     */
    public function smsFormData(): array
    {
        $data = [
            'TWILIO_SID'        => config('twilio.sid'),
            'TWILIO_AUTH_TOKEN' => config('twilio.token'),
            'TWILIO_NUMBER'     => config('twilio.number'),
        ];

        return compact('data');
    }

    /**
     * Find by id
     *
     * @return void
     */
    public function findById(): ?object
    {
        $setting = $this->settingRepository->findSettingWithLanguage();
        $setting->append(['logo_url', 'favicon_url']);
        return $setting;
    }

    /**
     * Update application setting
     *
     * @param  array  $attributes
     * @return bool
     * @throws Exception
     */
    public function update(array $attributes): bool
    {
        $setting = $this->settingRepository->first();

        $attributes['logo']    = ImageHelper::upload($attributes['logo'] ?? null, 'application', $setting->logo ?? null);
        $attributes['favicon'] = ImageHelper::upload($attributes['favicon'] ?? null, 'application', $setting->favicon ?? null);
        $attributes['login_bg_img'] = ImageHelper::upload($attributes['login_bg_img'] ?? null, 'application', $setting->login_bg_img ?? null);

        try {
            DB::beginTransaction();

            if ($setting) {
                $this->settingRepository->updateById($setting->id, $attributes);
            } else {
                $attributes['updated_at'] = auth()->user()->id;

                $this->settingRepository->create($attributes);
            }

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Application setting update error"),
                'title'   => localize("Application setting"),
                'errors'  => $exception,
            ], 422));
        }

    }

    /**
     * Update email setting
     *
     * @param  array  $attributes
     * @return bool
     * @throws Exception
     */
    public function updateEmail(array $attributes): bool
    {

        try {
            writeEnvFile($attributes);

            return true;
        } catch (Exception $exception) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Mail setting update error"),
                'title'   => localize("Mail setting"),
                'errors'  => $exception,
            ], 422));
        }

    }

    /**
     * Update sms setting
     *
     * @param  array  $attributes
     * @return bool
     * @throws Exception
     */
    public function updateSMS(array $attributes): bool
    {

        try {
            writeEnvFile($attributes);

            return true;
        } catch (Exception $exception) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("SMS setting update error"),
                'title'   => localize("SMS setting"),
                'errors'  => $exception,
            ], 422));
        }

    }

}
