<?php

declare(strict_types=1);

namespace app\Controllers;

class RouteController extends Controller
{
    /** @var Controller */
    private $controller;

    /**
     * @inheritDoc
     */
    public function process($params)
    {
        $parsedUrl = $this->parseUrl($params);

        if (!$parsedUrl) {
            $this->redirect('home');
            exit;
        }

        $data = null;
        $namePieces = \explode('-', $parsedUrl);

        foreach ($namePieces as &$namePiece) {
            $namePiece = \ucfirst($namePiece);
        }

        if ($_POST) {
            $data = $_POST;
        }

        $controllerNamespace = 'app\\Controllers\\' . \implode($namePieces) . 'Controller';

        if (\file_exists(\str_replace('\\', '/', $controllerNamespace) . '.php')) {
            $this->controller = new $controllerNamespace;
            $this->controller->process($data);
        } else {
            $this->redirect('not-found');
        }
    }

    /**
     * @param string $url
     * @return string
     */
    private function parseUrl(string $url): string
    {
        $parsedUrl = \parse_url($url);
        $parsedUrl["path"] = \ltrim($parsedUrl["path"], "/");
        $parsedUrl = \trim($parsedUrl["path"]);
        return $parsedUrl;
    }
}
