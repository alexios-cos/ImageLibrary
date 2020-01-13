<?php

declare(strict_types=1);

namespace app\Views;

class ViewModel
{
    /** @var mixed|null */
    protected $data;

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
     * ViewModel constructor.
     * @param mixed|null $data
     */
    public function __construct($data = null)
    {
        $this->data = $data;
        $this->construct();
    }

    /**
     * @param string $alias
     * @return void
     */
    public function renderView(string $alias = 'root'): void
    {
        require('resources/templates/' . $this->getTemplateByAlias($alias) . '.php');
    }

    /**
     * @param mixed|null $data
     * @return void
     */
    public function setData($data): void
    {
        $this->data = $data;
    }

    /**
     * @return mixed|null
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return void
     */
    protected function construct(): void
    {
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
