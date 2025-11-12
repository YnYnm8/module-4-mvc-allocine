<?php

/**
 * 1. Complétez les requêtes SQL (...TODO...) selon votre table.
 * 2. Les méthodes add et edit doivent être adaptées pour gérer les colonnes spécifiques à votre modèle.
 */

class diffusionModel
{
    private PDO $bdd;
    private PDOStatement $adddiffusion;
    private PDOStatement $deldiffusion;
    private PDOStatement $getdiffusion;
    private PDOStatement $getdiffusions;
    private PDOStatement $editdiffusion;

    function __construct()
    {
        $this->bdd = new PDO("mysql:host=bdd;dbname=allocine", "root", "root");

        // Adaptez cette requête à votre table diffusion
        $this->adddiffusion = $this->bdd->prepare("INSERT INTO  `Film`(film_id, date_diffusion) VALUES(:film_id , :date_diffusion)");

        $this->deldiffusion = $this->bdd->prepare("DELETE FROM `diffusion` WHERE `id` = :id;");

        $this->getdiffusion = $this->bdd->prepare("SELECT * FROM `diffusion` WHERE `film_id` = :film_id;");

        // Adaptez cette requête à votre table diffusion
        $this->editdiffusion = $this->bdd->prepare("UPDATE `diffusion` SET ...TODO... WHERE `id` = :id");

        $this->getdiffusions = $this->bdd->prepare("SELECT * FROM `diffusion` LIMIT :limit");
    }
    // Éditez les paramètres de la méthode add en fonction de votre table diffusion
    public function add(): void
    {
        // $this->adddiffusion->bindValue("...", $columnValue);
        $this->adddiffusion->execute();
    }

    public function del(int $id): void
    {
        $this->deldiffusion->bindValue("id", $id);
        $this->deldiffusion->execute();
    }
    public function get($film_id): diffusionEntity | array
    {
        $this->getdiffusion->bindValue("film_id", $film_id, PDO::PARAM_INT);
        $this->getdiffusion->execute();
        $rawdiffusions = $this->getdiffusion->fetchAll();

        // // Si le produit n'existe pas, je renvoie NULL
        // if (!$rawdiffusions) {
        //     return NULL;
        // }
        $diffusionsEntity = [];
        foreach ($rawdiffusions as $rawdiffusion) {
            $diffusionsEntity[] = new diffusionEntity(
                $rawdiffusion["id"],
                $rawdiffusion["film_id"],
                $rawdiffusion["date_diffusion"]

            );
        }
        return $diffusionsEntity;
    }

    public function getAll(int $limit = 50): array
    {
        $this->getdiffusions->bindValue("limit", $limit, PDO::PARAM_INT);
        $this->getdiffusions->execute();
        $rawdiffusions = $this->getdiffusions->fetchAll();

        $diffusionsEntity = [];
        foreach ($rawdiffusions as $rawdiffusion) {
            $diffusionsEntity[] = new diffusionEntity(
                $rawdiffusion["id"],
                $rawdiffusion["film_id"],
                $rawdiffusion["date_diffusion"]

            );
        }

        return $diffusionsEntity;
    }

    // À part l'id, les paramètres de la méthode edit sont optionnels.
    // Nous ne voulons pas forcer le développeur à modifier tous les champs
    public function edit(int $id,): diffusionEntity | NULL
    {
        $originaldiffusionEntity = $this->get($id);

        // Si le produit n'existe pas, je renvoie NULL
        if (!$originaldiffusionEntity) {
            return NULL;
        }

        // On utilise un opérateur ternaire ? : ;
        // Il permet en une ligne de renvoyer le nom original du 
        // produit si le paramètre est NULL.
        // En effet, si le paramètre est NULL, cela veut dire que 
        // l'utilisateur ne souhaite pas le modifier.
        // Le même résultat est possible avec des if else
        // Je précise PDO::PARAM_INT car id est un INT
        $this->editdiffusion->bindValue("id", $id, PDO::PARAM_INT);

        // $this->editdiffusion->bindValue($columnName,
        //  $columnName ? $columnName : $originaldiffusionEntity->getColumnName() );

        $this->editdiffusion->execute();

        // Une fois modifié, je renvoie le diffusion en utilisant ma
        // propre méthode public diffusionModel::get().
        return $this->get($id);
    }
}

class DiffusionEntity
{

    private int $id;
    private int $film_id;
    private string $date_diffusion;
    // private $columnName;

    function __construct(int $id, int $film_id, string $date_diffusion)
    {
        // $this->setColumnName($columnName);
        $this->id = $id;
        $this->setFilm_id($film_id);
        $this->setDate_diffusion($date_diffusion);
    }
    public function setFilm_id(int $film_id)
    {
        return $this->film_id = $film_id;
    }

    public function setDate_diffusion(string $date_diffusion)
    {
        return $this->date_diffusion = $date_diffusion;
    }


    // public function setColumnName($columnValue){
    //     $this->columnName = $columnValue;
    // }

    // public function getColumnName(){
    //     return $this->columnName;
    // } 

    public function getId(): int
    {
        return $this->id;
    }
    public function getFilm_id(): int
    {
        return $this->film_id;
    }
    public function getDate_diffusion(): string
    {
        return $this->date_diffusion;
    }
}
