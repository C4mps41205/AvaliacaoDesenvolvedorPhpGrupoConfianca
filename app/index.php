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

    $indexController = new IndexController();

    switch($url)
    {
        case '/':
            $indexController->Index();
            break; 
        case '/index/select':
            $indexController->SelectClient();
            break;
        case '/index/delete':
            $indexController->Delete();
            break;
        case '/index/update':
            $indexController->Update();
            break;
        case '/index/create':
            $indexController->Create();
            break;
    }
?>