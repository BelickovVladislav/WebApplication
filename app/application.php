<?php

/*
 *
 */

final class Application
{
    private static $app = null;
    private $property;

    public static function getInstance()
    {
        if (self::$app == null)
            self::$app = new static();
        return self::$app;
    }


    private function __construct()
    {
        $this->property = array(
            "h1" => "news",
            "title" => "news"
        );
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
            return (include_once $path);
        }
        return false;
    }

    public function handler($event)
    {
//        $this->includeFile('init.php');
        include_once 'init.php';
        if ($event == 'onEpilog')
            call_user_func($event, $this->property);
        else
            call_user_func($event);
    }

    public function showProperty($id)
    {
        echo "#PAGE_PROPERTY_$id#";
    }

    public function showHeader($template_id)
    {
        $this->handler('onProlog');
        $this->includeFile("../app/templates/$template_id/header.php");
    }

    public function showFooter($template_id)
    {
        $this->handler('onEpilog');
        $this->includeFile("../app/templates/$template_id/footer.php");
        ob_end_flush();
    }
}