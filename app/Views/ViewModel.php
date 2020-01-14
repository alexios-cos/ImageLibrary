<?php

declare(strict_types=1);

namespace app\Views;

class ViewModel
{
    /** @var array */
    protected $head = [
        'title' => '',
        'description' => ''
    ];

    /** @var array */
    protected $layout = [
        'root' => '',
        'root-content' => ''
    ];

    /**
     * @param string $alias
     * @return void
     */
    public function renderView(string $alias = 'root'): void
    {
        require('resources/templates/' . $this->getTemplateByAlias($alias) . '.php');
    }

    /**
     * @param string $alias
     * @return string
     */
    protected function getTemplateByAlias(string $alias): string
    {
        return $this->layout[$alias];
    }
}
