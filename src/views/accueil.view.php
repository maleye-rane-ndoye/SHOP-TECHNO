<?php ob_start() ?>

le contenue de pages d'accuieil

<?php
$content = ob_get_clean();
$titre = "la page d'accueil";
require 'template.php';
?>