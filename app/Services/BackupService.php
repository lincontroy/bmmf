<?php

namespace App\Services;

use App\Facades\Backup;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;

class BackupService
{
    /**
     * BackupService constructor.
     *
     */
    public function __construct(
    ) {
    }

    /**
     * Form data of app setting
     *
     * @return array
     */
    public function formData(): array
    {
        $disks = Backup::getFiles();

        return compact('disks');
    }

    /**
     * Form data of app setting
     *
     * @return array
     */
    public function getFiles(object $request)
    {
        return collect(Backup::getFiles())->collapse()->toArray();
    }

    /**
     * Create backup
     *
     * @param  array  $attributes
     * @return void
     * @throws Exception
     */
    public function create(array $attributes): void
    {
        try {
            Backup::create($attributes['option'] ?? '');

        } catch (Exception $exception) {

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Backup create error"),
                'title'   => localize('Backup'),
                'errors'  => $exception,
            ], 422));
        }

    }

    /**
     * Delete backup
     *
     * @param  array  $attributes
     * @return bool
     * @throws Exception
     */
    public function destroy(array $attributes)
    {
        try {
            Backup::delete($attributes['disk'], $attributes['url']);

            return true;
        } catch (Exception $exception) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("Backup delete error"),
                'title'   => localize('Backup'),
            ], 422));
        }

    }

    /**
     * Delete backup
     *
     * @return bool
     * @throws Exception
     */
    public function destroyAll(): bool
    {
        try {
            Backup::clean();

            return true;
        } catch (Exception $exception) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("All Backup delete error"),
                'title'   => localize('All Backup'),
            ], 422));
        }

    }

    /**
     * Download backup
     *
     * @return bool
     * @throws Exception
     */
    public function download(array $attributes)
    {
        try {
            return Backup::download($attributes['disk'], $attributes['url']);
        } catch (Exception $exception) {
            return abort(404);
        }

    }

}
