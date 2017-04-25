<?php
/*
 *
 */
include_once "../app/core.php";
$app = Application::getInstance();
$app->setTemplate('news');
$app->showHeader();
echo "<h1>";
$app->showProperty("h1");
echo "</h1>";
$app->showFooter();
$app->includeComponent();
//echo '<pre>'.print_r(spl_classes(),true).'</pre>';
?>