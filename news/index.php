<?php
/*
 *
 */
include_once "../app/core.php";
Application::getInstance()->setTemplate('news');
Application::getInstance()->showHeader();
echo "<h1>";
Application::getInstance()->showProperty("h1");
echo "</h1>";
Application::getInstance()->showFooter();
?>