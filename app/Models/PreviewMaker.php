<?php

declare(strict_types=1);

namespace app\Models;

use app\Models\Utils\FileSaveUtility;

class PreviewMaker
{
    private const PREVIEW_DIRECTORY = 'storage/previews/';
    private const PREVIEW_WIDTH = 100;
    private const PREVIEW_HEIGHT = 70;

    /**
     * @param string $fileName
     * @param string $fileExtension
     * @param string $dispersion
     * @param string $imagePath
     * @param resource $resourceImage
     * @return string
     * @throws \Exception
     */
    public function makePreview(
        string $fileName,
        string $fileExtension,
        string $dispersion,
        string $imagePath,
        $resourceImage
    ): string {
        $dir = self::PREVIEW_DIRECTORY . $dispersion . '/';
        $previewPath = $dir . $fileName . '.' . $fileExtension;

        try {
            FileSaveUtility::validateSavingFile($dir, $previewPath);
        } catch (\Exception $exception) {
            throw new \Exception(\sprintf('Could not make preview: %s', $exception->getMessage()));
        }

        $resizedSource = $this->resizeImage($imagePath, $resourceImage);

        if (!$resizedSource) {
            throw new \Exception(\sprintf('Could not resize image'));
        }

        $status = \imagejpeg($resizedSource, $previewPath, 100);

        if (!$status) {
            throw new \Exception(\sprintf('Could not save preview'));
        }

        return $previewPath;
    }

    /**
     * @param string $imagePath
     * @param resource $resourceImage
     * @return resource
     */
    private function resizeImage(string $imagePath, $resourceImage)
    {
        [$width, $height] = \getimagesize($imagePath);
        $resizedSource = \imagecreatetruecolor(self::PREVIEW_WIDTH, self::PREVIEW_HEIGHT);
        \imagecopyresampled(
            $resizedSource, $resourceImage, 0, 0, 0, 0, self::PREVIEW_WIDTH, self::PREVIEW_HEIGHT, $width, $height
        );
        return $resizedSource;
    }
}
