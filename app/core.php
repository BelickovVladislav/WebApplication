<?php

/*
 *
 */

final class Application
{
    private static $app = null;
    private $property = array();
    private $template = "";

    public static function getInstance()
    {
        if (self::$app == null)
            self::$app = new static();
        return self::$app;
    }


    private function __construct()
    {
        $this->includeFile($_SERVER['DOCUMENT_ROOT'] . '/app/init.php');
    }

    public function setTemplate($template)
    {
        if (empty($this->template)) {
            $this->template = $template;
        }
    }

    private function __clone()
    {

    }

    private function __sleep()
    {
    }

    private function __wakeup()
    {
    }

    private function __invoke()
    {
    }

    public function includeComponent()
    {
        $component = new Component("name", $this->template, array("value1", "value2"));

    }

    public function restartBuffer()
    {
        ob_clean();
    }

    public function setPageProperty($id, $value)
    {
        $this->property[$id] = $value;
    }

    public function getPageProperty($id)
    {
        $id = (string)$id;

        return $this->property[$id];
    }

    private function includeFile($path)
    {
        if (is_file($path)) {
            include_once($path);
        }
        return false;
    }

    public function handler($event)
    {
        if (function_exists($event)) {
            call_user_func($event);
        }
    }


    public function showProperty($id)
    {
        echo $this->getMacros($id);
    }

    public function getTemplate()
    {
        return $this->template;
    }

    public function getTemplatePath()
    {
        return $_SERVER['DOCUMENT_ROOT'] . "/app/templates/" . $this->template;
    }

    public function showHeader()
    {
        $this->handler('onProlog');
        $this->includeFile($this->getTemplatePath() . "/header.php");
    }

    private function getMacros($macros)
    {
        return "#PAGE_PROPERTY_" . $macros . "#";
    }

    private function getPropertyKeys()
    {
        $keys = array();

        foreach (array_keys($this->property) as $key)
            $keys[] = $this->getMacros($key);
        return $keys;
    }

    public function showFooter()
    {
        $this->includeFile($this->getTemplatePath() . "/footer.php");
        $this->handler('onEpilog');
        $content = ob_get_contents();
        $content = str_replace($this->getPropertyKeys(), $this->property, $content);
        ob_clean();
        echo $content;
        ob_end_flush();
    }
}

class Component
{
    private $name = "";
    private $template = "";
    private $params = array();

    public function __construct($name, $template, $params = array())
    {
        $this->name = $name;
        $this->template = $template;
        $this->params = $params;
    }

    public function includeTemplate()
    {
        $path = $_SERVER['DOCUMENT_ROOT'] . '/app/components/' . $this->name . '/' . $this->template . '/template.php';
        if (file_exists($path))
            include_once($path);
    }
}