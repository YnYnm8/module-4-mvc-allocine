<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Allocine</title>
</head>

<body>
    <H1>Welcome to AlloCine!</H1>
    <div>
        <?php foreach ($films as $film): ?>
            <p>Titre: <?= $film->getNom(); ?></p>
            <p>Date: <?= $film->getDate_sortie(); ?></p>
            <p>Genre: <?= $film->getGenre(); ?> </p>
            <p>Auteur: <?= $film->getAuteur(); ?> </p>
            <img src="<?= $film->getCover(); ?>" alt="">

        <?php endforeach; ?>
    </div>


</body>

</html>