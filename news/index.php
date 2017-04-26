<?php
/*
 *
 */
include_once "../app/core.php";
$app = Application::getInstance();
$app->setTemplate('news');
$app->showHeader();
?> <h1><?php $app->showProperty("h1");?> </h1><?php
$app->showFooter();
$app->restartBuffer();
$app->includeComponent('news.list','news');
//echo '<pre>'.print_r(spl_classes(),true).'</pre>';
?>