<?php

/**
 * 1. Complétez les requêtes SQL (...TODO...) selon votre table.
 * 2. Les méthodes add et edit doivent être adaptées pour gérer les colonnes spécifiques à votre modèle.
 */

class FilmModel
{
    private PDO $bdd;
    private PDOStatement $addFilm;
    private PDOStatement $delFilm;
    private PDOStatement $getFilm;
    private PDOStatement $getFilms;
    private PDOStatement $editFilm;

    function __construct()
    {
        $this->bdd = new PDO("mysql:host=bdd;dbname=allocine", "root", "root");

        // Adaptez cette requête à votre table Film
        $this->addFilm = $this->bdd->prepare("INSERT INTO `Film` (nom, date_sortie, genre, auteur, cover) VALUES (:nom, :date_sortie, :genre, :auteur,:cover)");

        $this->delFilm = $this->bdd->prepare("DELETE FROM `Film` WHERE `id` = :id;");

        $this->getFilm = $this->bdd->prepare("SELECT * FROM `Film` WHERE `id` = :id;");

        // Adaptez cette requête à votre table Film
        $this->editFilm = $this->bdd->prepare("UPDATE `Film` SET ...TODO... WHERE `id` = :id");

        $this->getFilms = $this->bdd->prepare("SELECT * FROM `Film` LIMIT :limit");
    }
    // Éditez les paramètres de la méthode add en fonction de votre table Film
    public function add(): void
    {
        // $this->addFilm->bindValue("...", $columnValue);
        $this->addFilm->execute();
    }

    public function del(int $id): void
    {
        $this->delFilm->bindValue("id", $id);
        $this->delFilm->execute();
    }
    public function get($id): FilmEntity | NULL
    {
        $this->getFilm->bindValue("id", $id, PDO::PARAM_INT);
        $this->getFilm->execute();
        $rawFilm = $this->getFilm->fetch();

        // Si le produit n'existe pas, je renvoie NULL
        if (!$rawFilm) {
            return NULL;
        }
        return new FilmEntity(
            $rawFilm["id"],
            $rawFilm["nom"],
            $rawFilm["date_sortie"],
            $rawFilm["genre"],
            $rawFilm["auteur"],
            $rawFilm["cover"]
        );
    }

    public function getAll(int $limit = 50): array
    {
        $this->getFilms->bindValue("limit", $limit, PDO::PARAM_INT);
        $this->getFilms->execute();
        $rawFilms = $this->getFilms->fetchAll();

        $FilmsEntity = [];
        foreach ($rawFilms as $rawFilm) {
            $FilmsEntity[] = new FilmEntity(
                $rawFilm["id"],
                $rawFilm["nom"],
                $rawFilm["date_sortie"],
                $rawFilm["genre"],
                $rawFilm["auteur"],
                $rawFilm["cover"]
            );
        }

        return $FilmsEntity;
    }

    // À part l'id, les paramètres de la méthode edit sont optionnels.
    // Nous ne voulons pas forcer le développeur à modifier tous les champs
    public function edit(int $id): FilmEntity | NULL
    {
        $originalFilmEntity = $this->get($id);

        // Si le produit n'existe pas, je renvoie NULL
        if (!$originalFilmEntity) {
            return NULL;
        }

        // On utilise un opérateur ternaire ? : ;
        // Il permet en une ligne de renvoyer le nom original du 
        // produit si le paramètre est NULL.
        // En effet, si le paramètre est NULL, cela veut dire que 
        // l'utilisateur ne souhaite pas le modifier.
        // Le même résultat est possible avec des if else
        // Je précise PDO::PARAM_INT car id est un INT
        $this->editFilm->bindValue("id", $id, PDO::PARAM_INT);

        // $this->editFilm->bindValue($columnName,
        //  $columnName ? $columnName : $originalFilmEntity->getColumnName() );

        $this->editFilm->execute();

        // Une fois modifié, je renvoie le Film en utilisant ma
        // propre méthode public FilmModel::get().
        return $this->get($id);
    }
}

class FilmEntity
{
    private int $id;
    private string $nom;
    private string $date_sortie;
    private string $genre;
    private string $auteur;
    private string $cover;
    // private $columnName;
    function __construct(int $id, string $nom, string $date_sortie, string $genre, string $auteur, string $cover)
    {
        // $this->setColumnName($columnName);
        $this->id = $id;
        $this->setNom($nom);
        $this->setDate_sortie($date_sortie);
        $this->setGenre($genre);
        $this->setAuteur($auteur);
        $this->setCover($cover);
    }

    public function setNom(string $nom)
    {
        return $this->nom = $nom;
    }

    public function setDate_sortie(string $date_sortie)
    {
        return $this->date_sortie = $date_sortie;
    }
    public function setGenre(string $genre)
    {
        return $this->genre = $genre;
    }
    public function setAuteur(string $auteur)
    {
        return $this->auteur = $auteur;
    }
        public function setCover(string $cover)
    {
        return $this->cover = $cover;
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getNom(): string
    {
        return $this->nom;
    }
    public function getDate_sortie(): string
    {
        return $this->date_sortie;
    }
    public function getGenre(): string
    {
        return $this->genre;
    }
    public function getAuteur(): string
    {
        return $this->auteur;
    }
       public function getCover(): string
    {
        return $this->cover;
    }
}
