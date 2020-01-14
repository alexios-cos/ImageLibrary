<?php

declare(strict_types=1);

namespace app\Controllers;

use app\Models\ImageUploader;

class UploadImageController extends Controller
{
    /**
     * @inheritDoc
     */
    public function process($params): void
    {
        if (!$_FILES['uploadImage']['name']) {
            echo 'The image is corrupted please try another one.';
        }

        if ($_FILES['uploadImage']['error']) {
            echo 'The image is corrupted please try another one.';
        }

        $filePath = \pathinfo($_FILES['uploadImage']['name']);
        $fileName = $filePath['filename'];
        $fileExtension = $filePath['extension'];
        $tempName = $_FILES['uploadImage']['tmp_name'];
        $fileType = \str_replace('image/', '', $_FILES['uploadImage']['type']);

        $imageUploader = new ImageUploader();
        $status = $imageUploader->uploadImage($fileName, $fileExtension, $fileType, $tempName);

        $this->redirect('home');

        if ($status) {
            echo 'The image successfully uploaded.';
        } else {
            echo 'Could not upload image. Please try again.';
        }

    }
}
