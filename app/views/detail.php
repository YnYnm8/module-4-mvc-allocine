
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>detail</title>
</head>

<body>
    <div>
        <?php if($film) :?>

             <h1>Detail de Cinema</h1>
            <img src="<?= $film->getCover(); ?>" alt="">
            <p>Titre: <?= $film->getNom(); ?></p>
            <p>Titre: <?= $film->getSynopsis(); ?></p> 
        <?php else: ?>
            <p><?=   "指定された映画が見つかりません。" ?></p>
        <?php endif;?>
       <h2>Séance</h2>
       

        <?php foreach ($diffusion as $dif): ?>
          
            <p><?= $dif->getDate_diffusion();?></p>
            <?php endforeach; ?>
            
    </div>
</body>

</html>