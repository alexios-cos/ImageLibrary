<?php

declare(strict_types=1);

namespace app\Models;

use app\Models\Utils\DatabaseUtility;

class ImageProvider
{
    /**
     * @param string $page
     * @param string $perPage
     * @param array $filters
     * @return array|null
     */
    public function getCollection(string $page, string $perPage, array $filters): ?array
    {
        $filterCount = \count($filters);
        $attrsCount = $this->getAttrsCount();
        $offset = ($page - 1) * $perPage * $attrsCount;
        $limit = $perPage * $attrsCount;
        $where = '';
        $values = [];

        if (!empty($filters)) {
            $constraints = [];
            foreach ($filters as $name => $features) {
                if (\preg_match('/[a-z]+Range$/u', $name)) {
                    $attrName = $min = $max = null;
                    foreach ($features as $alias => $feature) {
                        $attrName = $feature['name'];
                        if (\preg_match('/^min[a-zA-z]+/u', $alias)) {
                            $min = $feature['value'];
                        } elseif (\preg_match('/^max[a-zA-z]+/u', $alias)) {
                            $max = $feature['value'];
                        }
                    }
                    $constraints[] = "(attr = '$attrName' AND val >= ? AND val <= ?)";
                    \array_push($values, $min, $max);
                } else {
                    $constraints[] = "(attr = '{$features['name']}' AND val {$features['operator']} ?)";
                    $values[] = $features['value'];
                }
            }
            $where = 'WHERE ' . \implode(' OR ', $constraints);
        }

        $attributes = DatabaseUtility::queryAllAssoc("
            SELECT * FROM attribute a
            JOIN image i on a.image_id = i.id
            $where
            LIMIT $limit OFFSET $offset
        ", $values);

        if (empty($attributes)) {
            return null;
        }

        $totalAttributes = DatabaseUtility::queryAllAssoc("
            SELECT * FROM attribute a
            LEFT JOIN image i on a.image_id = i.id
            $where
        ", $values);

        $attributesCollection = $this->makeCollection($attributes);
        $totalAttributesCollection = $this->makeCollection($totalAttributes);

        if (!empty($filters)) {
            $images = $this->getFilteredCollection($attributesCollection, $filterCount);
            $images['count'] = \count($this->getFilteredCollection($totalAttributesCollection, $filterCount));
        } else {
            $images = $attributesCollection;
            $images['count'] = \count($totalAttributesCollection);
        }

        return $images;
    }

    /**
     * @return int
     */
    private function getAttrsCount(): int
    {
        return DatabaseUtility::count('
            SELECT attr FROM attribute WHERE EXISTS (SELECT * FROM image) GROUP BY attr
        ');
    }

    /**
     * @param array $attributes
     * @return array
     */
    private function makeCollection(array $attributes): array
    {
        $attributesCollection = [];
        foreach ($attributes as $attribute) {
            $attributesCollection[$attribute['image_id']]['image_id'] = $attribute['image_id'];
            $attributesCollection[$attribute['image_id']]['name'] = $attribute['name'];
            $attributesCollection[$attribute['image_id']][$attribute['attr']] = $attribute['val'];
        }
        return $attributesCollection;
    }

    /**
     * @param array $attributesCollection
     * @param int $filterCount
     * @return array|null
     */
    private function getFilteredCollection(array $attributesCollection, int $filterCount): ?array
    {
        $ids = [];

        foreach ($attributesCollection as $id => $imageAttrs) {
            if (\count($imageAttrs) - 2 < $filterCount) {
                unset($attributesCollection[$id]);
                continue;
            }

            if (!\in_array($id, $ids)) {
                $ids[] = $id;
            }
        }

        if (empty($ids)) {
            return null;
        }

        $in = \join(', ', \array_fill(0, \count($ids), '?'));
        $imagesAttributes = DatabaseUtility::queryAllAssoc("
            SELECT * FROM image i
            RIGHT JOIN attribute a on i.id = a.image_id
            WHERE id IN ($in)
        ", $ids);

        return $this->makeCollection($imagesAttributes);
    }
}
