<?php
namespace Digiwin\Fastchat\Controllers;

use Digiwin\Fastchat\Views\View;

abstract class Controller
{
    const VIEW_DIRECTORY = ROOT . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR;

    protected function render($viewName, $data = [])
    {
        $viewPath = self::VIEW_DIRECTORY . $viewName . '.phtml';
        $view = new View($viewPath, $data);
        $this->renderLayout($view);
    }

    private function renderLayout($view)
    {
        $layoutPath = self::VIEW_DIRECTORY . 'layout.phtml';
        ob_start();
        include $layoutPath;
        echo ob_get_clean();
    }

    protected function renderJson($data)
    {
        echo json_encode($data);
    }

    protected function redirect($route)
    {
        header('Location: ' . $route);
        exit();
    }
}