<?php 

$commandName = $argv[1] ?? null;    // make-controller ou make-model
$controllerName = $argv[2] ?? null; // Le nom du controller à créer, par exemple Admin ou Home
$modelName = $argv[2] ?? null;

if($commandName == null){
    echo "Vous devez préciser une commande\n";
    exit;
}

switch ($commandName) {
    case 'make-controller':
        echo "Création du controller : $controllerName\n";
        createController($controllerName);
        break;

    case 'make-model':
        echo "Création du model : $modelName\n";
        createModel($modelName);
        break;

    default:
        echo "Commande inconnue\n";
        break;
}

function createController(string $controllerName){
   // 1. Récupérer le code source du template
    $template = file_get_contents(__DIR__.'/TemplateController.php');
    // 2. Remplacer le texte [CONTROLLER_NAME] par le nom du controller
    $template = str_replace('[CONTROLLER_NAME]', $controllerName, $template);
    // 3. Créer le fichier controller dans app/controllers
    file_put_contents(__DIR__."/../app/controllers/$controllerName"."Controller.php", $template);
} 


function createModel(string $modelName){
  // 1. Récupérer le code source du template
  
    $template = file_get_contents(__DIR__.'/TemplateModel.php');
    // 2. Remplacer le texte [CONTROLLER_NAME] par le nom du controller
    $template = str_replace('[MODEL_NAME]', $modelName, $template);
    // 3. Créer le fichier controller dans app/controllers
    file_put_contents(__DIR__."/../app/models/$modelName"."Model.php", $template);
}   
