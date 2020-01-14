<?php

declare(strict_types=1);

namespace app\Controllers;

use app\Views\HomeView;

class HomeController extends Controller
{
    /**
     * @inheritDoc
     */
    public function process($params)
    {
        $viewModel = new HomeView($params['offset'], $params['limit']);
        $viewModel->renderView();
    }
}
