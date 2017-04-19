<?php

/*
 *
 */

class Application
{
    private static $app = null;

    public static function getInstance()
    {
        return self::$app == null ? new Application() : self::$app;
    }

    private $property;

    private function __construct()
    {
        $this->property = array(
            "id" => "h1"
        );
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

    public function getPageProperty(srting $id)
    {
        return $this->property[$id];
    }

    public function showProperty(string $id)
    {

    }

    public function showHeader($template_id)
    {
        ob_start();
        include_once("../app/templates/$template_id/header.php");
        ob_flush();
    }

    public function showFooter($template_id)
    {
        ob_start();
        include_once("../app/templates/$template_id/footer.php");
        ob_flush();
    }
}