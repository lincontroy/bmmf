<?php

namespace App\Http\Controllers\Backend;

use App\Enums\PermissionActionEnum;
use App\Enums\PermissionMenuEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\BackupRequest;
use App\Services\BackupService;
use App\Traits\ChecksPermissionTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class BackupSettingController extends Controller
{
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * Setting Controller constructor
     *
     * @param BackupService $backupService
     */
    public function __construct(
        protected BackupService $backupService,
    ) {
        $this->mapActionPermission = [
            'index'         => PermissionMenuEnum::SETTING_BACKUP->value . '.' . PermissionActionEnum::READ->value,
            'dataTableAjax' => PermissionMenuEnum::SETTING_BACKUP->value . '.' . PermissionActionEnum::READ->value,
            'store'         => PermissionMenuEnum::SETTING_BACKUP->value . '.' . PermissionActionEnum::READ->value,
            'download'      => PermissionMenuEnum::SETTING_BACKUP->value . '.' . PermissionActionEnum::READ->value,
            'destroy'       => PermissionMenuEnum::SETTING_BACKUP->value . '.' . PermissionActionEnum::READ->value,
            'destroyAll'    => PermissionMenuEnum::SETTING_BACKUP->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Index
     *
     */
    public function index()
    {
        cs_set('theme', [
            'title'       => localize('Backup'),
            'description' => localize('Backup'),
        ]);

        $formData = $this->backupService->formData();
        return view('backend.setting.backup.index', $formData);
    }

    /**
     * Datatable Ajax
     *
     * @param Request $request
     */
    public function dataTableAjax(Request $request)
    {
        $backups = $this->backupService->getFiles($request);

        return DataTables::of($backups)
            ->editColumn('size', function ($item) {
                return size_convert($item['size']);
            })
            ->addColumn('action', function ($item) {
                $button = '<div class="d-flex align-items-center">';

                $button .= '<a href="' . route('admin.setting.backup.download', ['disk' => $item['disk'], 'url' => $item['url']]) . '" class="btn btn-info-soft btn-sm m-1" title="' . localize("Download") . '" target="_blank"> <i class="fa fa-download"></i></a>';

                $button .= '<a href="javascript:void(0);" class="btn btn-danger-soft btn-sm m-1 delete-button" title="' . localize("Delete") . '" data-action="' . route('admin.setting.backup.delete', ['disk' => $item['disk'], 'url' => $item['url']]) . '"><i class="fa fa-trash"></i></a>';

                $button .= '</div>';

                return $button;

            })
            ->rawColumns(['action'])
            ->setRowId('id')
            ->addIndexColumn()
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(BackupRequest $request): JsonResponse
    {
        $data = $request->validated();

        $this->backupService->create($data);

        return response()->json([
            'success' => true,
            'message' => localize("Backup create successfully"),
            'title'   => localize("Backup"),
            'data'    => [],
        ]);
    }

    /**
     * Download Backup
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function download(Request $request)
    {
        return $this->backupService->download($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $this->backupService->destroy($request->all());

        return response()->json([
            'success' => true,
            'message' => localize("Backup data delete successfully"),
            'title'   => localize("Backup"),
        ]);

    }

    /**
     * Remove all resource from storage.
     */
    public function destroyAll(Request $request)
    {
        $this->backupService->destroyAll();

        return response()->json([
            'success' => true,
            'message' => localize("All Backup data delete successfully"),
            'title'   => localize("All Backup"),
        ]);

    }

}
