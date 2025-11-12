<?php
require_once(__DIR__."/../models/FilmModel.php");

class HomeController
{
    public function view(string $method, array $params = [])
    {
        try {
            call_user_func([$this, $method], $params);
        } catch (Error $e) {
            console($e->getMessage());
            try {
                call_user_func([$this, "home"], $params);
                // La route pour ce contrôleur est égale à "/"
                // Donc aucune method ne sera jamais trouvée
                // Donc par défaut on éxecute la methode home
                //  require_once(__DIR__ . '/../views/404.php');
                // ou bien la méthode par défaut...
            } catch (\Throwable $th) {
                //throw $th;
                console($th->getMessage());
            }
        }
    }

    public function home($params = [])
    {
        $filmModel = new FilmModel();
        $films = $filmModel->getAll();
        require_once(__DIR__ . "/../views/home.php");
    }


}
