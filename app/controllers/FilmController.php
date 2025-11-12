<?php
require_once(__DIR__ . "/../models/FilmModel.php");
require_once(__DIR__ . "/../models/DiffusionModel.php");
// Remplacez Name par le nom du controller
class FilmController
{
    public function view(string $method, array $params = [])
    {
        if (empty($method)) {
            $method = "detail";
        }
        try {
            call_user_func([$this, $method], $params);
        } catch (Error $e) {
            require_once(__DIR__ . '/../views/404.php');
            // ou bien la méthode par défaut...
        }
    }
    public function meiko($params = [])
    {
        echo "AUtre route";
    }
    public function detail($params = [])
    {
        console($params);
        $filmModel = new FilmModel();

        // ✅ $params[0] に ID が入っている想定
        $id = isset($params[0]) ? (int)$params[0] : null;
        // console($id);
        if (!$id) {
            echo "映画IDが指定されていません。";
            return;
        }

        $film = $filmModel->get($id);

        $diffusionModel = new DiffusionModel();
        $diffusion = $diffusionModel->get($film->getId());
        console($diffusion);
        

        require_once(__DIR__ . "/../views/detail.php");
    }
    // public function delete(){
    //     echo"Delete";
    // }
}
