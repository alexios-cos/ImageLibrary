<?php

declare(strict_types=1);

namespace app\Models;

use app\Models\Utils\DatabaseUtility;

class ImageUpdater
{
    /**
     * @param int $imageId
     * @return bool
     */
    public function updateViews(int $imageId): bool
    {
        try {
            DatabaseUtility::insert("
                UPDATE attribute
                SET val = val + 1
                WHERE attr = 'views'
                AND image_id = ?
            ", [$imageId]);
        } catch (\Exception $exception) {
            return false;
        }

        return true;
    }
}
