<?php

declare(strict_types=1);

namespace app\Views;


class NotFoundView extends ViewModel
{
    /** @var array */
    protected $head = [
        'title' => 'Not found',
        'description' => 'Not found page'
    ];

    /** @var array */
    protected $layout = [
        'root' => 'root',
        'root-content' => 'not-found'
    ];
}
