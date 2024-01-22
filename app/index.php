<?php
include 'core/core.php';
include 'core/routes.php';
include 'autoload.php';

$autoload = new Core();
$autoload->MakeRoutes($routes);
?>