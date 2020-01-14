<?php

declare(strict_types=1);

namespace app\Models\Utils;

class DispersionUtility
{
    /** @var int */
    private static $dirs = 3;

    /** @var int */
    private static $charsPerDir = 1;

    /**
     * DispersionUtility constructor.
     * @param int $dirs
     * @param int $charsPerDir
     */
    public function __construct(int $dirs = 3, int $charsPerDir = 1)
    {
        self::$dirs = $dirs;
        self::$charsPerDir = $charsPerDir;
    }

    /**
     * @param string $fileName
     * @return string|null
     */
    public static function makeDispersion(string $fileName): ?string
    {
        if (!$fileName) {
            return null;
        }

        $parts = [];

        for ($i = 0, $position = 0; $i < self::$dirs; $i++, $position += self::$charsPerDir) {
            $parts[] = \substr($fileName, $position, self::$charsPerDir);
        }

        return \implode('/', $parts);
    }
}
