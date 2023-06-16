<?php
require_once 'models/LivresManager.class.php';

 class LivresController{

    private LivresManager $livresManager;


    public function __construct(){
        $this->livresManager = new LivresManager;
        $this->livresManager->chargementLivres();
    }
    public function afficherLivres(){
    $livres = $this->livresManager->getLivres();
    require 'views/livres.view.php';
   }

   public function displayeLivre($id){
     $livre = $this->livresManager->getLivreById($id); 
        require "views/displayLivres.view.php";
   }

   public function ajoutLivre(){
    require "views/ajoutLivre.view.php";
   }

   public function  ajoutLivreValidation(){
      $file = $_FILES['image'];
      $repertoire = "public/images/";
      $nomImageAjoute = $this->ajoutImage($file,$repertoire);

      $this->livresManager->ajouterLivreBd($_POST['titre'],$_POST['nbPage'],$nomImageAjoute);

      $_SESSION['alert']=[
        "type" => "succes",
        "msg" => "un nouveau livre à été ajouter"
      ];
      
      header('location:'.URL."livres");

   }

   public function suppressionLivre($id){
      $nomImage = $this->livresManager->getLivreById($id)->getImage();
      unlink("public/images/".$nomImage);
      $this->livresManager->suppressionBdd($id);

      $_SESSION['alert']=[
        "type" => "succes",
        "msg" => "un livre à été supprimer"
      ];
      header('location:'.URL."livres");

   }

   private function ajoutImage($file,$dir){
      if(isset($file['name']) || empty($file['name']))
         throw new Exception("vous devez indiquez une image");
      
        if(!file_exists($dir)) mkdir($dir,0777);
      $extension = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));
      $random = rand(0.99999);
      $target_file = $dir.$random."_".$file['name'];

      if(!getimagesize($file['tpm_name']))
          throw new Exception("le fichier n'est pas une image");
      if($extension !== "jpg" && $extension !== "jpeg" && $extension !== "png" && $extension !== "gif")
          throw new Exception("l'extension du fichier n'est pas reconnu");
      if(file_exists($target_file))
          throw new Exception("le fichier existe deja");
      if($file['size'] > 500000)
          throw new Exception("la taille du fichier est trop gros");
      if(!move_uploaded_file($file['tmp_name'],$target_file))
          throw new Exception("l'ajout de l'image n'a pas fonctionné");
      else return($random."_".$file['name']);  
   }

   public function modificationLivre($id){
    $livre = $this->livresManager->getLivreById($id); 
    require "views/modifierLivres.view.php";
   
   }
  
   public function modificationLivrevalidation(){
       $imageActuelle = $this->livresManager->getLivreById($_POST['identifiant'])->getImage();
       $file = $_FILES['image'];
       if($file['size'] > 0){
      unlink("public/images/".$imageActuelle);
      $repertoire = "public/images/";
      $nomImagetoAdd = $this->ajoutImage($file,$repertoire);
       }else{
        $nomImagetoAdd = $imageActuelle;
       }
       $this->livresManager->modificationLivreBd($_POST['identifiant'],$_POST['titre'],$_POST['nbPages'],$nomImagetoAdd);
       $_SESSION['alert']=[
        "type" => "succes",
        "msg" => "le livre à été bien modifier"
      ];
      header('location:'.URL."livres");
   }
 }
 ?>