<?php

declare(strict_types=1);

namespace app\Models\Utils;

class DispersionUtility
{
    /** @var int */
    private $dirs = 3;

    /** @var int */
    private $charsPerDir = 1;

    /**
     * DispersionUtility constructor.
     * @param int $dirs
     * @param int $charsPerDir
     */
    public function __construct(int $dirs = 3, int $charsPerDir = 1)
    {
        $this->dirs = $dirs;
        $this->charsPerDir = $charsPerDir;
    }

    /**
     * @param string $fileName
     * @return string|null
     */
    public function makeDispersion(string $fileName): ?string
    {
        if (!$fileName) {
            return null;
        }

        $parts = [];

        for ($i = 0, $position = 0; $i < $this->dirs; $i++, $position += $this->charsPerDir) {
            $parts[] = \substr($fileName, $position, $this->charsPerDir);
        }

        return \implode('/', $parts);
    }
}
