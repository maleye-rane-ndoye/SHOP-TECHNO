<?php ob_start() ?>
<div>
    <p>cette page contienne des produits qui qont supprimer</p>
</div>
<?php
$content = ob_get_clean();
$titre = "here we delete the book";
require 'template.php';
?>