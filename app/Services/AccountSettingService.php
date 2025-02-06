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

class AccountSettingService
{
    /**
     * AccountSettingService constructor.
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
        $setting    = $this->settingRepository->find(1);
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
            'MAIL_MAILER'       => env('MAIL_MAILER') ?? null,
            'MAIL_HOST'         => env('MAIL_HOST') ?? null,
            'MAIL_PORT'         => env('MAIL_PORT') ?? null,
            'MAIL_USERNAME'     => env('MAIL_USERNAME') ?? null,
            'MAIL_PASSWORD'     => env('MAIL_PASSWORD') ?? null,
            'MAIL_ENCRYPTION'   => env('MAIL_ENCRYPTION') ?? null,
            'MAIL_FROM_ADDRESS' => env('MAIL_FROM_ADDRESS') ?? null,
            'MAIL_FROM_NAME'    => env('MAIL_FROM_NAME') ?? null,
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
            'TWILIO_SID'        => env('TWILIO_SID') ?? null,
            'TWILIO_AUTH_TOKEN' => env('TWILIO_AUTH_TOKEN') ?? null,
            'TWILIO_NUMBER'     => env('TWILIO_NUMBER') ?? null,
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
        return $this->settingRepository->find(1);
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
                'message' => "Application setting update error",
                'title'   => 'Application setting',
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
                'message' => "Mail setting update error",
                'title'   => 'Mail setting',
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
                'message' => "SMS setting update error",
                'title'   => 'SMS setting',
                'errors'  => $exception,
            ], 422));
        }

    }

}
