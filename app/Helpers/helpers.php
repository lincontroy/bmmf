<?php

use App\Enums\AssetsFolderEnum;
use App\Enums\DateFormatEnum;
use App\Facades\Localizer;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

/**
 * Return all public asset form public/assets folder
 */

if (!function_exists('assets')) {
    function assets($file = ''): string
    {
        return asset(AssetsFolderEnum::PUBLIC_ASSETS->value . '/' . $file);
    }

}

/**
 * Return all uploaded asset from public/storage
 */

if (!function_exists('storage_asset')) {
    function storage_asset($file = ''): string
    {
        if (!file_exists(storage_path('app/public/' . $file))) {
            return asset('/assets/img/noimage.jpg');
        }
        return asset(AssetsFolderEnum::STORAGE_ASSETS->value . '/' . $file);
    }

}

/**
 * module asset url
 *
 * @param string|null $file
 * @param string|null $default
 *
 * @return string
 */

if (!function_exists('module_asset')) {
    function module_asset(string $module, string $path): string
    {
        return route('module.asset', ['module' => $module, 'all' => $path]);
    }

}

/**
 * To set config and seo
 *
 * @param  mixed  $name
 * @param  mixed  $data
 *
 * @return void
 */

if (!function_exists('cs_set')) {

    function cs_set($name, $data): void
    {
        config_set($name, $data);
        Artesaos\SEOTools\Facades\SEOMeta::setTitle(config('theme.title'))
            ->setDescription(config('theme.description'));
        Artesaos\SEOTools\Facades\OpenGraph::setDescription(config('theme.description'))->setTitle(config('theme.title'));
        Artesaos\SEOTools\Facades\JsonLd::addImage(config('theme.images'));
    }

}

/**
 * To set config
 *
 * @param  mixed  $name
 * @param  mixed  $data
 *
 * @return void
 */

if (!function_exists('config_set')) {

    function config_set($name, $data): void
    {

        if (is_array($data)) {

            foreach ($data as $key => $value) {
                Illuminate\Support\Facades\Config::set($name . '.' . $key, $value);
            }

        } else {
            Illuminate\Support\Facades\Config::set($name, $data);
        }

    }

}

/**
 * Set success message
 *
 * @param string $message
 *
 * @return void
 */

if (!function_exists('success_message')) {

    function success_message(string $message): void
    {
        // alert()->success($message);
        toast($message, 'success');

    }

}

/**
 * Set error message
 *
 * @param string $message
 *
 * @return void
 */

if (!function_exists('error_message')) {

    function error_message(string $message): void
    {
        // alert()->error($message);
        toast($message, 'error');
    }

}

/**
 * Set warning message
 *
 * @param string $message
 *
 * @return void
 */

if (!function_exists('warning_message')) {

    function warning_message(string $message): void
    {
        // alert()->warning($message);
        toast($message, 'warning');

    }

}

/**
 * Check the existence of file in filesystem
 *
 * @param  string|null  $filename
 *
 * @return bool|false
 */

if (!function_exists('storage_exist')) {
    /**
     * Check the existence of file in filesystem
     *
     * @param string|null $filename
     * @return bool|false
     */
    function storage_exist(string $filename = null): bool
    {
        $uploadDisk = env('FILESYSTEM_DISK', 'local');

        return !empty($filename) && Storage::disk($uploadDisk)->exists($filename);
    }

}

/**
 * Delete file from storage
 *
 * @param  string|null  $file
 *
 * @return bool
 */

if (!function_exists('delete_file')) {
    /**
     * Delete file from storage
     *
     * @param string|null $file
     * @return bool
     */
    function delete_file(?string $file): bool
    {

        if (storage_exist($file)) {
            $uploadDisk = env('FILESYSTEM_DISK', 'local');

            return Storage::disk($uploadDisk)->delete($file);
        }

        return false;
    }

}

/**
 * Convert size to human readable format (KB, MB, GB, TB, PB)
 * @param  int  $size
 *
 * @return string
 */

if (!function_exists('size_convert')) {

    function size_convert(int $size): string
    {
        $unit = ['b', 'kb', 'mb', 'gb', 'tb', 'pb'];

        return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
    }

}

/**
 * Read the contents of a .env file into an array
 *
 * @return array
 */

if (!function_exists('readEnvFile')) {

    function readEnvFile(): array
    {
        $path = base_dir('.env');
        // Open the .env file for reading
        $file = fopen($path, 'r');
        // Initialize an empty array to store the keys and values
        $env = [];

        /**
         * Loop through each line in the file
         */

        while (($line = fgets($file)) !== false) {

            /**
             * Ignore any comment lines
             */

            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            // Extract the key and value from the line
            $parts = explode('=', trim($line), 2);

            if (count($parts) !== 2) {
                continue;
            }

            $key = $parts[0];
            // Remove quotes from value
            $value = trim($parts[1], '"\'');

            // Add the key and value to the array
            $env[$key] = $value;
        }

        // Close the file
        fclose($file);

        // Return the array
        return $env;
    }

}

/**
 * Write an array of key/value pairs to a .env file
 *
 * @param array $env
 *
 * @return void
 */

if (!function_exists('writeEnvFile')) {
    function writeEnvFile(array $env, $path = __DIR__ . '/../../.env'): void
    {
        $str = file_get_contents($path);

        /**
         * replace the value of the specific key or create a new key
         */

        foreach ($env as $key => $value) {

            /**
             * if value is true or false
             */

            if ($value == 'true' || $value == 'false') {
                $key_value = "$key=$value";
            } else {
                $key_value = "$key=";

                if ($value && is_numeric($value)) {
                    $key_value .= $value;
                } elseif ($value) {
                    $key_value .= "\"$value\"";
                }

            }

            /**
             * check if key exists
             */

            if (strpos($str, $key) !== false) {
                $str = preg_replace("/^$key=.*/m", $key_value, $str);
            } else {
                $str .= $key_value . PHP_EOL;
            }

        }

        file_put_contents($path, $str);
        // forget mail config cache
        \Illuminate\Support\Facades\Artisan::call('config:cache');
    }

}

/**
 * showing base directory
 *
 * @param string $file
 */

if (!function_exists('base_dir')) {
    function base_dir(string $file): string
    {
        return dirname(dirname(dirname(__FILE__))) . '/' . $file;
    }

}

/**
 * localize current word
 *
 * @param string|null $key
 * @param string|null $default_value
 * @param string|null $locale
 *
 * @return string|null
 */

if (!function_exists('localize')) {

    function localize(?string $key, ?string $default_value = null, ?string $locale = null): ?string
    {

        if (is_null($key) || $key == '' || $key == ' ' || empty($key)) {
            return '';
        }

        return Localizer::localize($key, $default_value, $locale);
    }

}

if (!function_exists('get_ymd')) {
    /**
     * Get date in "Y-m-d" format
     *
     * @param string|null $date
     * @return string|null
     */
    function get_ymd(string $date = null): string | null
    {
        return !empty($date) ? Carbon::createFromFormat(get_date_format(), $date)->format(
            DateFormatEnum::YYYY_MM_DD->value,
        ) : null;
    }

}

if (!function_exists('get_date_format')) {
    /**
     * Date format
     *
     * @return string
     */
    function get_date_format(): string
    {
        return DateFormatEnum::YYYY_MM_DD_HH_I_S->value;
    }

}

if (!function_exists('get_day_time_format')) {
    /**
     * Day & Time format
     *
     * @return string
     */
    function get_day_time_format(): string
    {
        return DateFormatEnum::WD_H_I_AA->value;
    }

}

if (!function_exists('get_jsmy_date')) {
    /**
     * Get date in configured format
     *
     * @param  string|null  $date
     * @return string|null
     */
    function get_jsmy_date(string $date = null): string | null
    {
        return !empty($date) ? Carbon::make($date)->format(DateFormatEnum::DS_SM_YYYY->value) : null;
    }

}

if (!function_exists('getAbbreviatedMonthNames')) {
    function getAbbreviatedMonthNames(): array
    {
        $currentMonth = Carbon::now()->month;
        $currentYear  = Carbon::now()->year;
        $months       = [];

        for ($month = 1; $month <= $currentMonth; $month++) {
            $date      = Carbon::create($currentYear, $month, 1);
            $monthName = $date->format('M');
            $months[]  = $monthName;
        }

        return $months;
    }

}

if (!function_exists('ucfirst_case')) {
    /**
     * Name in first character uppercase
     *
     * @param string $enum_name
     * @return string
     */
    function ucfirst_case(string $enum_name): string
    {
        return localize(ucfirst(strtolower(str_replace('_', ' ', $enum_name))));
    }

}

if (!function_exists('enum_ucfirst_case')) {
    /**
     * Enum name in first character uppercase
     *
     * @param string $enum_name
     * @return string
     */
    function enum_ucfirst_case(string $enum_name): string
    {
        return localize(ucfirst(strtolower(str_replace('_', ' ', $enum_name))));
    }

}

if (!function_exists('public_folder_files')) {
    /**
     * Public folder files
     *
     * @param string $folder_path
     * @return array
     */
    function public_folder_files(string $folder_path): array
    {
        $fileNames = [];
        $path      = public_path($folder_path);
        $files     = \File::allFiles($path);

        foreach ($files as $file) {
            array_push($fileNames, [
                'file_name' => pathinfo($file)['filename'],
                'file_path' => $folder_path . "/" . pathinfo($file)['filename'],
            ]);
        }

        return $fileNames;
    }

}

if (!function_exists('qr_code_in_base_64')) {
    /**
     * Qr Code using bacon-qr-code in base64
     *
     * @param string $value
     * @return array
     */
    function qr_code_in_base_64(string $value, string $path = null): string
    {
        $renderer = new BaconQrCode\Renderer\ImageRenderer(
            new BaconQrCode\Renderer\RendererStyle\RendererStyle(200),
            new BaconQrCode\Renderer\Image\ImagickImageBackEnd()
        );
        $writer     = new BaconQrCode\Writer($renderer);
        $qrCodeData = $writer->writeString($value);

        if ($path) {
            // Load QR code and logo images
            $qrCode   = imagecreatefromstring($qrCodeData);
            $logoPath = public_path('assets/img/logo.png');
            $logo     = imagecreatefrompng($logoPath);

            // Calculate logo placement
            $qrWidth       = imagesx($qrCode);
            $qrHeight      = imagesy($qrCode);
            $logoWidth     = imagesx($logo);
            $logoHeight    = imagesy($logo);
            $logoSize      = $qrWidth / 5; // Adjust as needed
            $scale         = min($logoSize / $logoWidth, $logoSize / $logoHeight);
            $newLogoWidth  = $logoWidth * $scale;
            $newLogoHeight = $logoHeight * $scale;
            $logoX         = ($qrWidth - $newLogoWidth) / 2;
            $logoY         = ($qrHeight - $newLogoHeight) / 2;

            // Combine QR code and logo
            imagecopyresampled($qrCode, $logo, $logoX, $logoY, 0, 0, $newLogoWidth, $newLogoHeight, $logoWidth, $logoHeight);

            // Capture output and convert to base64
            ob_start();
            imagepng($qrCode);
            $qrCodeData = ob_get_contents();
            ob_end_clean();

            // Clean up
            imagedestroy($qrCode);
            imagedestroy($logo);
        }

        return 'data:image/png;base64,' . base64_encode($qrCodeData);

    }

}

if (!function_exists('qr_code_simple_in_base_64')) {
    /**
     * Qr Code using simple-qrcode in base64
     *
     * @param string $value
     * @return array
     */
    function qr_code_simple_in_base_64(string $value, int $size = 256, string $path = null): string
    {
        return SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size($size)->generate($value);
    }

}

if (!function_exists('handleException')) {
    /**
     * Handle exceptions based on request type.
     *
     * @param \Exception $exception
     * @param string|null $message
     * @param string|null $messageTitle
     * @return void
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    function handleException(\Exception $exception, string $message = null, string $messageTitle = null)
    {

        if (!$message) {
            $message = localize("Error");
        }

        if (request()->expectsJson() || request()->isXmlHttpRequest()) {
            $response = response()->json([
                'success' => false,
                'message' => $message,
                'title'   => $messageTitle,
                'errors'  => $exception->getMessage(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        } else {
            $response = redirect()->back()->withErrors($exception)->withInput();
            // throw new Symfony\Component\HttpKernel\Exception\HttpException(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, $message, $exception);
        }

        throw new \Illuminate\Http\Exceptions\HttpResponseException($response);

    }

}
