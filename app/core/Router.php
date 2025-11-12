<?php

require_once(__DIR__ . "/../controllers/HomeController.php");
require_once(__DIR__ . "/../controllers/NotFoundController.php");
require_once(__DIR__ . "/../controllers/FilmController.php");


class Router
{
    public static function getController(string $controllerName)
    {
        switch ($controllerName) {

            // Route : /
            case '':
                return new HomeController();
                break;

            case 'film':
                 return new FilmController();
                 break;
                

            default:
                // Si aucune route de match
                return new NotFoundController();
                break;
        }
    }
}
