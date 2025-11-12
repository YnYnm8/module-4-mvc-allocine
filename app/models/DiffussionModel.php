<?php
/**
 * 1. Complétez les requêtes SQL (...TODO...) selon votre table.
 * 2. Les méthodes add et edit doivent être adaptées pour gérer les colonnes spécifiques à votre modèle.
 */

class DiffussionModel{
    private PDO $bdd;
    private PDOStatement $addDiffussion;
    private PDOStatement $delDiffussion;
    private PDOStatement $getDiffussion;
    private PDOStatement $getDiffussions;
    private PDOStatement $editDiffussion;

    function __construct()
    {
        $this->bdd = new PDO("mysql:host=bdd;dbname=allocine", "root", "root");

        // Adaptez cette requête à votre table Diffussion
        $this->addDiffussion = $this->bdd->prepare("INSERT INTO ...TODO... ");

        $this->delDiffussion = $this->bdd->prepare("DELETE FROM `Diffussion` WHERE `id` = :id;");

        $this->getDiffussion = $this->bdd->prepare("SELECT * FROM `Diffussion` WHERE `id` = :id;");

        // Adaptez cette requête à votre table Diffussion
        $this->editDiffussion = $this->bdd->prepare("UPDATE `Diffussion` SET ...TODO... WHERE `id` = :id");

        $this->getDiffussions = $this->bdd->prepare("SELECT * FROM `Diffussion` LIMIT :limit");
    }
    // Éditez les paramètres de la méthode add en fonction de votre table Diffussion
    public function add(...) : void
    {
        // $this->addDiffussion->bindValue("...", $columnValue);
        $this->addDiffussion->execute();
    }

    public function del(int $id) : void
    {
        $this->delDiffussion->bindValue("id", $id);
        $this->delDiffussion->execute();
    }
    public function get($id): DiffussionEntity | NULL
    {
        $this->getDiffussion->bindValue("id", $id, PDO::PARAM_INT);
        $this->getDiffussion->execute();
        $rawDiffussion = $this->getDiffussion->fetch();

        // Si le produit n'existe pas, je renvoie NULL
        if(!$rawDiffussion){
            return NULL;
        }
        return new DiffussionEntity(
            // $rawDiffussion["columnName"],
        );
    }

    public function getAll(int $limit = 50) : array
    {
        $this->getDiffussions->bindValue("limit", $limit, PDO::PARAM_INT);
        $this->getDiffussions->execute();
        $rawDiffussions = $this->getDiffussions->fetchAll();

        $DiffussionsEntity = [];
        foreach($rawDiffussions as $rawDiffussion){
            $DiffussionsEntity[] = new DiffussionEntity(
                $rawDiffussion["nom"],
                $rawDiffussion["date_sortie"],
                $rawDiffussion["genre"],
                $rawDiffussion["auteur"],
                $rawDiffussion["id"]
            );
        }

        return $DiffussionsEntity;
    }

    // À part l'id, les paramètres de la méthode edit sont optionnels.
    // Nous ne voulons pas forcer le développeur à modifier tous les champs
    public function edit(int $id, ...) : DiffussionEntity | NULL
    {
        $originalDiffussionEntity = $this->get($id);

        // Si le produit n'existe pas, je renvoie NULL
        if(!$originalDiffussionEntity){
            return NULL;
        }

        // On utilise un opérateur ternaire ? : ;
        // Il permet en une ligne de renvoyer le nom original du 
        // produit si le paramètre est NULL.
        // En effet, si le paramètre est NULL, cela veut dire que 
        // l'utilisateur ne souhaite pas le modifier.
        // Le même résultat est possible avec des if else
        // Je précise PDO::PARAM_INT car id est un INT
        $this->editDiffussion->bindValue("id", $id, PDO::PARAM_INT);

        // $this->editDiffussion->bindValue($columnName,
        //  $columnName ? $columnName : $originalDiffussionEntity->getColumnName() );

        $this->editDiffussion->execute();

        // Une fois modifié, je renvoie le Diffussion en utilisant ma
        // propre méthode public DiffussionModel::get().
        return $this->get($id);
    }
}

class DiffussionEntity{
    private $id;
    // private $columnName;
    function __construct($columnName, ..., int $id = NULL)
    {
        // $this->setColumnName($columnName);
        $this->id = $id;
    }

    // public function setColumnName($columnValue){
    //     $this->columnName = $columnValue;
    // }

    // public function getColumnName(){
    //     return $this->columnName;
    // }
    
    public function getId() : int{
        return $this->id;
    }
}