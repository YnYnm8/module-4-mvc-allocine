<?php

require_once(DIR . "/../controllers/HomeController.php");
require_once(DIR . "/../controllers/NotFoundController.php");


class Router
{
    public static function getController(string $controllerName)
    {
        switch ($controllerName) {

            // Route : /
            case '':
                return new HomeController();
                break;


            default:
                // Si aucune route de match
                return new NotFoundController();
                break;
        }
    }
}