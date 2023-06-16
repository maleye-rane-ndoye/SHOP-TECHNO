<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define("URL",str_replace("index.php","",(isset($_SERVER['HTTPS'])? "https" 
: "http")."://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));
require_once 'controllers/Livres.controller.php';
$livresController = new LivresController;
  try{
    if(empty($_GET['page'])){
        require_once 'views/accueil.view.php';
    }else{
        $url = explode("/",filter_var($_GET['page']),FILTER_SANITIZE_URL);
        switch($url[0]){
            case "accueil": require_once 'views/accueil.view.php';
                break;
               
            case "livres": 
                if(empty($url[1])){
                    $livresController->afficherLivres();
                }else if($url[1]==="l"){
                    $livresController->displayeLivre($url[2]);
                }else if($url[1]==="a"){
                    $livresController->ajoutLivre();
                }else if($url[1]==="m"){
                    $livresController->modificationLivre($url[2]);
                }else if($url[1]==="s"){
                    $livresController->suppressionLivre($url[2]);
                }else if($url[1]==="av"){
                            $livresController->ajoutLivreValidation();
                }else if($url[1]==="mv"){
                            $livresController->modificationLivrevalidation($url[2]);
                }else{
                    throw new Exception("la page n'existe pas!") ;
                }
            break;
            default:   throw new Exception("la page n'existe pas!") ;
        }
    }
}catch(Exception $e){
    $msg =  $e->getMessage();
    require "views/erreur.view.php";
}

