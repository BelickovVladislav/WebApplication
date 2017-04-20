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
    private function __invoke()
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
            /*return (*/
            include_once($path);
        }
        return false;
    }

    public function handler($event)
    {
        $this->includeFile($_SERVER['DOCUMENT_ROOT'] . '/app/init.php');
        if (call_user_func($event) != null) {
        }
    }


    public function showProperty($id)
    {
        echo "#PAGE_PROPERTY_$id#";
    }

    public function showHeader($template_id)
    {
        $this->handler('onProlog');
        $this->includeFile($_SERVER['DOCUMENT_ROOT'] . "/app/templates/$template_id/header.php");
    }

    private function getPropertyKeys()
    {
        $keys = array();

        foreach (array_keys($this->property) as $key)
            $keys[] = "#PAGE_PROPERTY_" . $key . "#";
        return $keys;
    }

    public function showFooter($template_id)
    {

        $this->handler('onEpilog');
        $content = ob_get_contents();
        $content = str_replace($this->getPropertyKeys(), $this->property, $content);
        ob_clean();
        echo $content;
        $this->includeFile($_SERVER['DOCUMENT_ROOT'] . "/app/templates/$template_id/footer.php");
        ob_end_flush();
    }
}