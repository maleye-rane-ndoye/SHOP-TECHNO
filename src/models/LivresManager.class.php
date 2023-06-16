<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'Model.class.php';
require_once 'Livre.class.php';

class LivresManager extends Model{

private $livres;

public function ajoutLivre($livre){
     $this->livres[] = $livre;
}

public function getLivres(){
    return $this->livres;
}


public function chargementLivres(){
    $req = $this->getBdd()->prepare("SELECT * FROM `livres`");
    $req->execute();
    $meslivres = $req->fetchAll(PDO::FETCH_ASSOC);

    foreach($meslivres as $livre){
        $book = new Livres($livre['id'],$livre['titre'],$livre['nbPage'],$livre['image']);
        $this->ajoutLivre($book);
    }  
}

public function getLivreById(int $id): object { 
    $livre = null;
    for($i=0; $i < count($this->livres);$i++){

        if($this->livres[$i]->id === $id){
            $livre = $this->livres[$i];
            return $livre;
        }
    }
    throw new Exception("le livre n'existe pas!");
}

public function ajouterLivreBd($titre,$nbPage,$image){
    $req = "INSERT  INTO livres(titre,nbPage,image)values(:titre, :nbPage, :image)";
    $stmt = $this->getBdd()->prepare($req);
    $stmt->bindValue(":titre",$titre,PDO::PARAM_STR);
    $stmt->bindValue(":nbPage",$nbPage,PDO::PARAM_INT);
    $stmt->bindValue(":image",$image,PDO::PARAM_STR);
    $resultat = $stmt->execute();

    if($resultat > 0){
        $livre = new Livres($this->getBdd()->lastInsertId(), $titre, $nbPage, $image);
        $this->ajoutLivre($livre);
    }
   }

   public function suppressionBdd($id){
    $req = "DELETE FROM livres WHERE id = :idLivre";
    $stmt = $this->getBdd()->prepare($req);
    $stmt->bindValue(":idLivre",$id,PDO::PARAM_STR);
    $resultat = $stmt->execute();
    if($resultat > 0){
        $livre = $this->getLivreById($id);
        unset($livre);
    }
   }

   public function modificationLivreBd($id,$titre,$nbPage,$image){
    $req = "update livres set titre = :titre, nbPage = :nbPage, image = :image where id = :id";
    $stmt = $this->getBdd()->prepare($req);
    $stmt->bindValue(":id",$id,PDO::PARAM_INT);
    $stmt->bindValue(":titre",$titre,PDO::PARAM_STR);
    $stmt->bindValue(":nbPage",$nbPage,PDO::PARAM_INT);
    $stmt->bindValue(":image",$image,PDO::PARAM_STR);
    $resultat = $stmt->execute();

    if($resultat > 0){
        $this->getLivreById($id)->setTitre($titre);
        $this->getLivreById($id)->setNbPage($nbPage);
        $this->getLivreById($id)->setImage($image);

    }

    echo "id => $id; titre => $titre; nbPage => $nbPage; image => $image";
   }
}

?>