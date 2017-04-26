<?php

/*
 *
 */

final class Application
{
    private static $app = null;
    private $property = array();
    private $template = "";
    private $__components = array();

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

    public function includeComponent($name, $tempalte, $params = array())
    {
        if (empty($this->__components[$name])) {
            $firstCount = count(get_declared_classes());
            include_once($_SERVER['DOCUMENT_ROOT'] . '/app/components/' . $name . '/class.php');
            $classes = get_declared_classes();
            for ($i = $firstCount - 1; $i < count($classes); $i++) {
                if (is_subclass_of($classes[$i], 'Component')) {
                    $this->__components[$name] = $classes[$i];
                    break;
                }

            }
        }
        $component = new $this->__components[$name]($name, $tempalte, $params);
        $component->executeComponent();
//        echo '<pre>' . print_r($this->__components, true) . '</pre>';
    }

    private function getPropertyKeys()
    {
        $keys = array();
        foreach (array_keys($this->property) as $key)
            $keys[] = $this->getMacros($key);
        return $keys;
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


abstract class Component
{
    private $name = "";
    private $template = "";
    protected $params = array();
    protected $arrResult = array();

    public function __construct($name, $template, $params = array())
    {
        $this->name = $name;
        $this->template = $template;
        $this->params = $params;
    }

    protected function prepareParams()
    {
        if (empty($this->params['count']))
            $this->params['count'] = 3;
        if (empty($this->params['show_pic']))
            $this->params['show_pic'] = 'Y';
        if (empty($this->params['data']))
            $this->params['data'] = 'xml.xml';
    }

    protected function getPageNumber()
    {
        $page = 1;
        if (isset($_GET['PAGE']) && /*is_int($_GET['PAGE']) &&*/
            (int)$_GET['PAGE'] > 0
        )
            $page = (int)($_GET['PAGE']);
        return $page;
    }


    public final function includeTemplate()
    {
        $path = $_SERVER['DOCUMENT_ROOT'] . '/app/components/' . $this->name . '/' . $this->template . '/template.php';
        if (file_exists($path))
            include_once($path);
        /*
         * Добавить вывод по шаблону
         */

        showNews($this->arrResult, $this->params);
//        echo '<pre>' . print_r($this->params, true) . '</pre>';
//        echo '<pre>' . print_r($this->arrResult, true) . '</pre>';
    }

    public abstract function executeComponent();
}