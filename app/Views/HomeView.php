<?php

declare(strict_types=1);

namespace app\Views;

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
}
