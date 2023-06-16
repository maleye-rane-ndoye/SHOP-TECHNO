<?php ob_start() ?>
  <div class="row">
    <div class="col-6">
        <img src="public/images/<?=$livre->getImage();?>" alt="">
    </div>
    <div class="col-6">
        <p>Titre du livre: <?= $livre->getTitre();?></p>
        <p>Nombre de pages: <?= $livre->getNbPage();?>/p>
    </div>
  </div>
<?php
$content = ob_get_clean();
$titre = $livre->getTitre();
require 'template.php';
?>

