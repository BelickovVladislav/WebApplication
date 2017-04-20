<?php
function onProlog()
{
    ob_start();
}

function onEpilog()
{
    Application::getInstance()->setPageProperty('h1', 'NEWS');
    Application::getInstance()->setPageProperty('title', 'News');
}