<?php

declare(strict_types=1);

namespace app\Controllers;

use app\Models\ImageUploader;

class UploadImageController extends Controller
{
    /**
     * @inheritDoc
     */
    public function process($params)
    {
        if (!$_FILES['uploadImage']['name']) {
            return;
        }

        $filePath = \pathinfo($_FILES['uploadImage']['name']);
        $fileName = $filePath['filename'];
        $fileExtension = $filePath['extension'];
        $tempName = $_FILES['uploadImage']['tmp_name'];

        $imageUploader = new ImageUploader();
        return $imageUploader->uploadImage($fileName, $fileExtension, $tempName);

    }
}
