<?php
namespace Digiwin\Fastchat\Views;

class View
{

    private $viewPath;

    private $data;

    private $render;

    private $scripts = [];

    private $stylesheets = [];

    /**
     * View constructor.
     * @param $viewPath
     * @param $data
     */
    public function __construct($viewPath, $data)
    {
        $this->viewPath = $viewPath;
        $this->data = $data;
        $this->data['view'] = $this;
        extract($this->data);
        ob_start();
        include $this->viewPath;
        $this->setRender(ob_get_clean());
    }


    /**
     * @return mixed
     */
    public function getViewPath()
    {
        return $this->viewPath;
    }

    /**
     * @return mixed
     */
    public function render()
    {
        return $this->render;
    }

    /**
     * @param mixed $render
     */
    public function setRender($render)
    {
        $this->render = $render;
    }

    /**
     * @return array
     */
    public function getScripts()
    {
        return $this->scripts;
    }

    /**
     * @param string $script
     */
    public function addScript($script)
    {
        $this->scripts[] = $script;
    }

    /**
     * @return array
     */
    public function getStylesheets()
    {
        return $this->stylesheets;
    }

    /**
     * @param string $stylesheet
     */
    public function addStylesheet($stylesheet)
    {
        $this->stylesheets[] = $stylesheet;
    }

}