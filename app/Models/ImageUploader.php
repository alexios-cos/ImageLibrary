<?php

declare(strict_types=1);

namespace app\Models;

use app\Models\Utils\DatabaseUtility;
use app\Models\Utils\DispersionUtility;
use app\Models\Utils\FileSaveUtility;

class ImageUploader
{
    private const IMAGE_DIRECTORY = 'storage/images/';

    /**
     * @param string $origFileName
     * @param string $fileExtension
     * @param string $fileType
     * @param string $tempName
     * @return bool
     */
    public function uploadImage(string $origFileName, string $fileExtension, string $fileType, string $tempName): bool
    {
        $storedFileName = FileSaveUtility::makeStoredFileName($origFileName);
        $dispersion = DispersionUtility::makeDispersion($storedFileName);
        $dir = self::IMAGE_DIRECTORY . $dispersion . '/';
        $imagePath = $dir . $storedFileName . '.' . $fileExtension;

        try {
            FileSaveUtility::validateSavingFile($dir, $imagePath);
        } catch (\Exception $exception) {
            // logging exceptions
            return false;
        }

        $savingStatus = \move_uploaded_file($tempName, $imagePath);

        if (!$savingStatus) {
            return false;
        }

        $resourceImage = null;

        switch ($fileType) {
            case 'jpeg':
                $resourceImage = \imagecreatefromjpeg($imagePath);
                break;
            case 'png':
                $resourceImage = \imagecreatefrompng($imagePath);
                break;
            case 'gif':
                $resourceImage = \imagecreatefromgif($imagePath);
                break;
            case 'bmp':
                $resourceImage = \imagecreatefrombmp($imagePath);
                break;
        }

        $previewMaker = new PreviewMaker();

        try {
            $previewPath = $previewMaker->makePreview(
                $storedFileName, $fileExtension, $dispersion, $imagePath, $resourceImage
            );
        } catch (\Exception $exception) {
            // logging exceptions
            \unlink($imagePath);
            return false;
        }

        if (!$previewPath) {
            return false;
        }

        [$width, $height] = \imageresolution($resourceImage);
        $imageResolution = "{$width}x{$height}";
        $imageSize = \filesize($imagePath) / 1000;

        try {
            $status = $this->storeImageInfo(
                $origFileName, $imagePath, $previewPath, $imageResolution, (string)$imageSize
            );
        } catch (\Exception $exception) {
            // logging exceptions
            \unlink($imagePath);
            \unlink($previewPath);
            return false;
        }

        return true;
    }

    /**
     * @param string $origFileName
     * @param string $imagePath
     * @param string $previewPath
     * @param string $imageResolution
     * @param string $imageSize
     * @return bool
     * @throws \Exception
     */
    private function storeImageInfo(
        string $origFileName,
        string $imagePath,
        string $previewPath,
        string $imageResolution,
        string $imageSize
    ) {
        $date = new \DateTime('now');
        $attrs = [
            'image_path' => $imagePath,
            'preview_path' => $previewPath,
            'image_resolution' => $imageResolution,
            'image_size' => $imageSize,
            'views' => 0,
            'created_at' => $date->format('Y.m.d H:i:s')
        ];

        DatabaseUtility::beginTransaction();

        try {
            DatabaseUtility::insert('
                INSERT INTO image(name)
                VALUES (?)
                ', [$origFileName]
            );
        } catch (\Exception $exception) {
            DatabaseUtility::rollBackTransaction();
            throw new \Exception($exception->getMessage());
        }

        $imageId = DatabaseUtility::getLastInsertedId();

        foreach ($attrs as $attr => $val) {
            try {
                DatabaseUtility::insert('
                    INSERT INTO attribute(image_id, attr, val)
                    VALUES (?, ?, ?)
                    ', [$imageId, $attr, $val]
                );
            } catch (\Exception $exception) {
                DatabaseUtility::rollBackTransaction();
                throw new \Exception($exception->getMessage());
            }
        }

        DatabaseUtility::commitTransaction();
        return true;
    }
}
