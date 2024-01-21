<?php
    $controllerFiles = scandir("./controller");

    foreach ($controllerFiles as $file) 
    {
        if (is_file("./controller/" . $file)) 
        {
            include "./controller/" . $file;
        }
    }

    $url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

    switch($url)
    {
        case '/':
            $indexController = new IndexController();
            $indexController->Index();
            break; 
        case '/index/select':
            $indexController = new IndexController();
            $indexController->SelectClient();
            break;
        case '/index/delete':
            $indexController = new IndexController();
            $indexController->Delete();
            break;
    }
?>