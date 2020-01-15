<?php

declare(strict_types=1);

namespace app\Controllers;

use app\Views\NotFoundView;

class NotFoundController extends Controller
{
    /**
     * @inheritDoc
     */
    public function process($params)
    {
        $viewModel = new NotFoundView();
        $viewModel->renderView();
    }
}
