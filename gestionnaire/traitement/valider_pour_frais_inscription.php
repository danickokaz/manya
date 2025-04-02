<?php 
session_start();
require '../../settings/db.php';

if(isset($_POST['id']) and !empty($_POST['id'])){
    $id = htmlspecialchars($_POST['id']);
    $req = database()->prepare("SELECT * FROM affectation_etudiant WHERE id=?");
    $req->execute([$id]);

    if($req->rowCount()==1){
        $data = $req->fetch();
        $id_salle = $data->id_salle;
        $id_classe = $data->id_classe;
        $matricule = $data->matricule;
        $id_annee_academique = $data->id_annee_academique;

        $req = database()->prepare("INSERT INTO paiement_frais (matricule,id_classe,id_salle,id_annee_academique,id_frais) VALUES(?,?,?,?,?)");
        $req->execute([$matricule,$id_classe,$id_salle,$id_annee_academique,1]);

        echo "Success";
    }
}