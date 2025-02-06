<?php

namespace App\Helpers;

use App\Enums\AssetsFolderEnum;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as ImageIntervention;

class ImageHelper
{
    /**
     * File uploadAndResize
     * @param mixed $file
     * @param mixed $folderName
     * @param mixed $resizeWidth
     * @param mixed $resizeHeight
     * @return bool|string
     */
    public static function uploadAndResize($file, $folderName, $resizeWidth = null, $resizeHeight = null)
    {
        $uploadDisk = env('FILESYSTEM_DISK', 'local');
        $fileName   = $file->hashName();
        $uploadPath = AssetsFolderEnum::UPLOAD_ROOT_DIR->value . "/" . $folderName;
        $imagePath  = Storage::disk($uploadDisk)->putFileAs($uploadPath, $file, $fileName);

        if ($resizeWidth && $resizeHeight) {
            $image = ImageIntervention::make(Storage::disk($uploadDisk)->path($imagePath));
            $image->fit($resizeWidth, $resizeHeight);
            $image->save();
        }

        return $imagePath;
    }

    /**
     * File Only Upload
     * @param mixed $file
     * @param mixed $folderName
     * @param mixed $resizeWidth
     * @param mixed $resizeHeight
     * @return bool|string
     */
    public static function upload($file, $folderName, $oldFile = null)
    {
        if(empty($file) && empty($oldFile)){
            return null;
        }
        elseif(empty($file) && !empty($oldFile)){
            return $oldFile;
        }
        elseif(!empty($file) && !empty($oldFile)){
            delete_file('public/'.$oldFile);
        }


        $uploadDisk = env('FILESYSTEM_DISK', 'local');
        $fileName   = $file->hashName();
        $uploadPath = AssetsFolderEnum::UPLOAD_ROOT_DIR->value . "/" . $folderName;
        $imagePath  = Storage::disk($uploadDisk)->putFileAs($uploadPath, $file, $fileName);

        if(!empty($imagePath)){
            $imagePath = str_replace('public/', '', $imagePath);
        }

        return $imagePath;
    }


}
