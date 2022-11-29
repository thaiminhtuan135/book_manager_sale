<?php

namespace App\Components;

use Exception;
use Illuminate\Support\Facades\Storage;

class CommonComponent
{
    public static function uploadFile($folder, $file, $fileName)
    {
        try {
//            $azure = Storage::disk('public');
//            $path = $azure->putFileAs($folder, $file, $fileName);
//
//            return Storage::disk('public')->url($path);
            $azure = Storage::disk('public');

            return $azure->putFileAs($folder, $file, $fileName);
        } catch (Exception $exception) {
            return false;
        }

        return true;
    }

    public static function uploadFileName($extension = '')
    {
        return sha1(time().rand(0, 9999999)).'.'.$extension;
    }

    public static function deleteFile($folder, $nameFile)
    {
        try {
            return Storage::disk('public')->delete($folder.'/'.$nameFile);
        } catch (Exception $exception) {
            return false;
        }

        return true;
    }
}
