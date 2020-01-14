<?php

declare(strict_types=1);

namespace app\Views;

use app\Models\ImageProvider;

class HomeView extends ViewModel
{
    /** @var array */
    protected $head = [
        'title' => 'Home',
        'description' => 'Home page'
    ];

    /** @var array */
    protected $layout = [
        'root' => 'root',
        'root-content' => 'home'
    ];

    /** @var ImageProvider */
    private $imageProvider;

    /** @var array */
    private $imageCollection = [];

    /** @var int */
    private $imagePages;

    /** @var int */
    private $offset = 0;

    /** @var int */
    private $limit = 50;

    /**
     * HomeView constructor.
     * @param int|null $offset
     * @param int|null $limit
     */
    public function __construct(?int $offset, ?int $limit)
    {
        if ($offset) {
            $this->offset = $offset;
        }

        if ($limit) {
            $this->limit = $limit;
        }

        $this->imageProvider = new ImageProvider();
    }

    /**
     * @return array
     */
    public function getImageCollection(): array
    {
        if (!$this->imageCollection) {
            $this->loadImageCollection();
        }

        return $this->imageCollection;
    }

    /**
     * @return int
     */
    public function getImagePages(): int
    {
        if (!$this->imagePages) {
            $this->loadImagePages();
        }

        return $this->imagePages;
    }

    /**
     * @return void
     */
    private function loadImageCollection(): void
    {
        $this->imageCollection = $this->imageProvider->getCollection($this->offset, $this->limit);
    }

    /**
     * @return void
     */
    private function loadImagePages(): void
    {
        $this->imagePages = $this->imageProvider->getImagePages($this->limit);
    }
}
