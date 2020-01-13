<?php

declare(strict_types=1);

namespace app\Controllers;

abstract class Controller
{
    /** @var array */
    public $data = [];

    /**
     * @param mixed $params
     * @return mixed
     */
    abstract function process($params);

    /**
     * @param string $url
     * @return void
     */
    public function redirect(string $url): void
    {
        header("Location: /$url");
    }
}
