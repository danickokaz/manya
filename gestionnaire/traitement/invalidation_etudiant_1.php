<?php 
session_start();
require '../../settings/db.php';

if(isset($_POST['matricule']) and !empty($_POST['matricule'])){
    $matricule = htmlspecialchars($_POST['matricule']);

    $req = database()->prepare("UPDATE etudiant SET id_etat_etudiant=? WHERE matricule=?");
    $req->execute([1,$matricule]);
    echo "Success";
}