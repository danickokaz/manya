<?php
session_start();
require '../../settings/db.php';

if(isset($_POST['matricule'],$_POST['motdepasse']) and !empty($_POST['matricule']) and !empty($_POST['motdepasse'])){

    $matricule = htmlspecialchars($_POST['matricule']);
    $motdepasse = htmlspecialchars($_POST['motdepasse']);

    $req = database()->prepare("SELECT * FROM utilisateur WHERE matricule=? AND motdepasse=?");
    $req->execute([$matricule,sha1($motdepasse)]);

    if($req->rowCount()==1){
        $data = $req->fetch();
        $token = $data->token;
        $_SESSION['jgm'] = $token;

        echo "Success";
    }else{
        echo "Incorrectes";
    }

}else{
    echo "Veuillez saisir tous les champs";
}