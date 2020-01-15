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
        $viewModel = new HomeView(
            (int)$params['page'] ?? null,
            (int)$params['currentPerPage'] ?? null,
            isset($params['newPerPage']) ? (int)($params['newPerPage']) : null,
            isset($params['filters']) ? $params['filters'] : null
        );

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && \strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            $viewModel->ajaxSendView();
        } else {
            $viewModel->renderView();
        }
    }
}
