<?php
function onProlog()
{
    ob_start();
}

function onEpilog(Array $array)
{
    $content = ob_get_contents();
    foreach (array_keys($array) as $key) {
        $content = str_replace("#PAGE_PROPERTY_" . $key . "#", $array[$key], $content);
    }
    ob_clean();
    echo $content;
}