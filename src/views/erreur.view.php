<?php ob_start() ?>

 <?= $msg?>;

<?php
$content = ob_get_clean();
$titre = "ERREUR";
require 'template.php';
?>