<?php

/*
 *
 */

class Application
{
    private static $app = null;

    public static function getInstance()
    {
        if (self::$app == null)
            self::$app = new Application();
        return self::$app;
    }

    private $property;

    private function __construct()
    {
        $this->property = array(
            "h1" => "news"
        );
        ob_start();
    }

    public function restartBuffer()
    {
        ob_end_clean();
        ob_start();
    }

    public function setPageProperty(srting $id, string $value)
    {
        $this->property[$id] = $value;
    }

    public function getPageProperty($id)
    {
        $id = (string)$id;

        return $this->property[$id];
    }

    public function showProperty($id)
    {
        ob_flush();
        ob_clean();
        $id = (string)$id;
        echo $this->getPageProperty($id);
        ob_flush();
    }

    public function showHeader($template_id)
    {
        ob_clean();
        include_once("../app/templates/$template_id/header.php");
        ob_flush();
    }

    public function showFooter($template_id)
    {
        ob_flush();
        ob_clean();
        include_once("../app/templates/$template_id/footer.php");
        ob_flush();
    }
}