<?php

spl_autoload_register(function($className) 
{
    $classFileModel = __DIR__ . "/model/" . $className . ".php";
    $classFileSettings = __DIR__ . "/settings/" . $className . ".php";

    if (file_exists($classFileModel)) 
    {
        include $classFileModel;
    }
    
    elseif (file_exists($classFileSettings))
    {
        include $classFileSettings;
    }
});

?>
