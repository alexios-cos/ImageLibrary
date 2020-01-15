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

    /** @var array|null */
    private $imageCollection = [];

    /** @var int|null */
    private $totalPages;

    /** @var array|null */
    private $visiblePages = [];

    /** @var int */
    private $currentPage = 1;

    /** @var int */
    private $currentPerPage = 20;

    /** @var array */
    private $perPageSet = [20, 50, 100, 200];

    /** @var string */
    private $currentSizeOperator = '=';

    /** @var string */
    private $currentViewsOperator = '=';

    /** @var array */
    private $operatorSet = [
        '=',
//        '>',
//        '<'
    ];

    /** @var array */
    private $filters = [];

    /**
     * HomeView constructor.
     * @param int $page
     * @param int $currentPerPage
     * @param int|null $newPerPage
     * @param array|null $filters
     */
    public function __construct(?int $page, ?int $currentPerPage, ?int $newPerPage, ?array $filters)
    {
        if ($page) {
            $this->currentPage = $page;
        }

        if ($currentPerPage) {
            $this->currentPerPage = $currentPerPage;
        }

        if ($newPerPage) {
            if ($this->currentPerPage !== $newPerPage) {
                $this->currentPage = 1;
            }
            $this->currentPerPage = $newPerPage;
        }

        if ($filters) {
            $this->filters = $filters;
        }

        $this->imageProvider = new ImageProvider();
        $this->imageCollection = $this->imageProvider->getCollection(
            (string)$this->currentPage, (string)$this->currentPerPage, $this->filters
        );
        $this->totalPages = (int)\ceil($this->imageCollection['count'] / $this->currentPerPage);
        unset($this->imageCollection['count']);
    }

    /**
     * @return void
     */
    public function ajaxSendView(): void
    {
        include('resources/templates/home.php');
    }

    /**
     * @return array|null
     */
    public function getImageCollection(): ?array
    {
        return $this->imageCollection;
    }

    /**
     * @return int|null
     */
    public function getTotalPages(): ?int
    {
        return $this->totalPages;
    }

    /**
     * @return int
     */
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * @return int
     */
    public function getCurrentPerPage(): int
    {
        return $this->currentPerPage;
    }

    /**
     * @return array
     */
    public function getPerPageSet(): array
    {
        return $this->perPageSet;
    }

    /**
     * @return array|null
     */
    public function getVisiblePages(): ?array
    {
        if (empty($this->visiblePages)) {
            $this->loadVisiblePages();
        }

        return $this->visiblePages;
    }

    /**
     * @return string
     */
    public function getCurrentSizeOperator(): string
    {
        return $this->currentSizeOperator;
    }

    /**
     * @return string
     */
    public function getCurrentViewsOperator(): string
    {
        return $this->currentViewsOperator;
    }

    /**
     * @return array
     */
    public function getOperatorSet(): array
    {
        return $this->operatorSet;
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * @return void
     */
    private function loadVisiblePages(): void
    {
        $pages = [];

        if ($this->currentPage < 7) {
            $totalPages = $this->getTotalPages() < 9 ? $this->getTotalPages() : 9;
            for ($page = 1; $page <= $totalPages; $page++) {
                $pages[] = $page;
            }
        } else {
            for ($page = $this->currentPage - 2; $page <= $this->currentPage + 7; $page++) {
                $pages[] = $page;
            }
        }

        $this->visiblePages = $pages;
    }
}
