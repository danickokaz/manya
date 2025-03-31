<?php 
session_start();
require '../../settings/db.php';

if(isset($_POST['libelle']) and !empty($_POST['libelle'])){
    $libelle = htmlspecialchars($_POST['libelle']);
    

    $requete_verification = database()->prepare("SELECT * FROM classe WHERE libelle_classe=?");
    $requete_verification->execute([$libelle]);
    if($requete_verification->rowCount()==0){
        $req = database()->prepare("INSERT INTO classe (libelle_classe)
        VALUES(?)");
        $req->execute([$libelle]);
        echo "Success";
    }else{
        echo "Déjà";
    }


}else{
    echo "Champs";
}

