<?php

class Core
{
    public function MakeRoutes($routes) : void
    {
        $url = '/';
        $isRouter = false;

        if (isset($_GET["url"])) 
        {
            $url .= $_GET["url"];
        }

        foreach ($routes as $path => $controller) 
        {
            $pattern = '#^' . preg_replace('/{id}/', '(\w+)', $path) . '$#';

            if (preg_match($pattern, $url, $matches)) {
                array_shift($matches);
                $isRouter = true;
                list($currentController, $action) = explode('@', $controller);

                $controllerFile = "controller/$currentController.php";
                require_once $controllerFile;

                $newController = new $currentController();
                $newController->$action($matches);
            }
        }

        if (!$isRouter)
        {
            require_once __DIR__ . '/../controller/NotFoundController.php';
            $notFoundController = new NotFoundController();
            $notFoundController->Index();
        }
    }
}
?>
