<?php
/*
 *
 */
include_once "../app/core.php";
$app = Application::getInstance();
$app->setTemplate('news');
$app->showHeader();
?> <h1><?php $app->showProperty("h1");?> </h1><?php

$app->includeComponent('news.list','news');
$app->showFooter();
//echo '<pre>'.print_r(spl_classes(),true).'</pre>';
?>