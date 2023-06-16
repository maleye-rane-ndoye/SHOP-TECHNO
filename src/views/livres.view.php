
<?php ob_start() ;

if(!empty($_SESSION['alert'])): ?>
<div class="alert alert-<?= $_SESSION['alert']["type"]?>" role="alert">
                        <?= $_SESSION['alert']["msg"]?>;
</div>
<?php
unset($_SESSION['alert']);
endif
?>
<table class="table text-center">
       <tr class="table-dark">
           <th>Images</th>
           <th>Titre</th>
           <th>Nombre de pages</th>
           <th colspan="2">Actions</th>
       </tr>
           <?php 
           for($i=0; $i < count($livres); $i++):?>
       <tr>
           <td class="align-middle"><img src="public/images/<?= $livres[$i]->getImage();?>" alt="" width="60px"></td>
           <td class="align-middle"><a href="<?= URL ?>livres/l/<?= $livres[$i]->getId();?>"><?= $livres[$i]->getTitre();?></a></td>
           <td class="align-middle"><?= $livres[$i]->getNbPage();?></td>
           <td class="align-middle"><a href="<?= URL ?>livres/m/<?= $livres[$i]->getId();?>" class="btn btn-warning">Modifier</a></td>
           <td class="align-middle">
            <form method="POST" action="<?= URL ?>livres/s/<?= $livres[$i]->getId();?>" onsubmit="return confirm('voulez vous vraiment supprimer le livre ?')";>
                  <button type="submit" class="btn btn-danger">Supprimer</button>
            </form>
           </td>
       </tr>
           <?php endfor; ?>

</table>
<a href="<?= URL?>livres/a" class="btn btn-success d-block">Ajouter un livre</a>


<?php
$content = ob_get_clean();
$titre = "la page des livres";
require 'template.php';

?>