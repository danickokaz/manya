<?php 
session_start();
require '../../settings/db.php';

if(isset($_POST['libelle_salle'],$_POST['id_ajouter_salle']) and !empty($_POST['libelle_salle']) and !empty($_POST['id_ajouter_salle'])){
    $libelle_salle = htmlspecialchars($_POST['libelle_salle']);
    $id_ajouter_salle = htmlspecialchars($_POST['id_ajouter_salle']);
    

    $requete_verification = database()->prepare("SELECT * FROM salle WHERE libelle_salle=? AND id_classe=?");
    $requete_verification->execute([$libelle_salle,$id_ajouter_salle]);
    if($requete_verification->rowCount()==0){
        $req = database()->prepare("INSERT INTO salle (libelle_salle,id_classe)
        VALUES(?,?)");
        $req->execute([$libelle_salle,$id_ajouter_salle]);
        echo "Success";
    }else{
        echo "Déjà";
    }


}else{
    echo "Champs";
}