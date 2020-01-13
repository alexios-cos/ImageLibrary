<?php

declare(strict_types=1);

namespace app\Models;

use app\Models\Utils\DispersionUtility;

class ImageUploader
{
    private const IMAGE_DIRECTORY = 'storage/images/';

    public function uploadImage(string $fileName, string $fileExtension, string $tempName)
    {
        $dispersionUtility = new DispersionUtility();
        $dispersionUtility->makeDispersion($fileName);

        try {
            $this->saveImage($fileName, $fileExtension, $tempName);
        } catch (\Exception $exception) {
            //logging exceptions
        }
    }

    /**
     * @param string $fileName
     * @param string $fileExtension
     * @param string $tempName
     * @throws \Exception
     */
    private function saveImage(string $fileName, string $fileExtension, string $tempName)
    {
        if (!file_exists(self::IMAGE_DIRECTORY)) {
            if (!mkdir(self::IMAGE_DIRECTORY)) {
                throw new \Exception(sprintf('Could not create directory %s', self::IMAGE_DIRECTORY));
            }
        }
    }
}
