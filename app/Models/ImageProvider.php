<?php

declare(strict_types=1);

namespace app\Models;

use app\Models\Utils\DatabaseUtility;

class ImageProvider
{
    /**
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public function getCollection(int $offset, int $limit): array
    {
        $images = DatabaseUtility::queryAllAssoc("
            SELECT * FROM image LIMIT $limit OFFSET $offset
        ");

        if (empty($images)) {
            return null;
        }

        $ids = [];

        foreach ($images as $image) {
            $ids[] = $image['id'];
        }

        $in = \join(', ', \array_fill(0, \count($ids), '?'));
        $attributes = DatabaseUtility::queryAllAssoc("
            SELECT * FROM attribute 
            WHERE image_id IN ($in)
            ", $ids
        );

        foreach ($images as &$image) {
            foreach ($attributes as $attribute) {
                if ($image['id'] === $attribute['image_id']) {
                    $image[$attribute['attr']] = $attribute['val'];
                    if (8 === \count($image)) {
                        continue 2;
                    }
                }
            }
        }

        return $images;
    }

    /**
     * @param int $limit
     * @return int
     */
    public function getImagePages(int $limit): int
    {
        return (int)\ceil($this->getImagesCount() / $limit);
    }

    /**
     * @return int
     */
    private function getImagesCount(): int
    {
        return DatabaseUtility::count('SELECT * FROM image');
    }
}
