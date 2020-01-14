<?php

declare(strict_types=1);

namespace app\Models\Utils;

class FileSaveUtility
{
    /**
     * @param string $dir
     * @param string $filePath
     * @return bool
     * @throws \Exception
     */
    public static function validateSavingFile(string $dir, string $filePath): bool
    {
        if (!\file_exists($dir)) {
            if (!\mkdir($dir, 0777, true)) {
                throw new \Exception(\sprintf('Could not create directory %s.', $dir));
            }
        }

        if (\file_exists($filePath)) {
            if (!\is_writable($filePath)) {
                throw new \Exception(\sprintf('The file %s is not writable.', $filePath));
            }
        } else {
            if (!\touch($filePath)) {
                throw new \Exception(\sprintf('The file %s could not be created.', $filePath));
            }
        }

        return true;
    }

    /**
     * @param string $fileName
     * @return string
     */
    public static function makeStoredFileName(string $fileName): string
    {
        $fileName = \str_replace(['.', '/'], '_', $fileName);
        return $fileName . '-' . \uniqid();
    }
}
