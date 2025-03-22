<?php 
session_start();
require '../../settings/db.php';

if(isset($_POST['prenom'],$_POST['nom'],$_POST['sexe'],$_POST['etatcivil'],$_POST['nationalite'],$_POST['typeinscription'],$_POST['adresse_physique'],$_POST['date_naissance'],$_POST['lieu_naissance'],$_POST['telephone'])
and !empty($_POST['prenom']) and !empty($_POST['nom']) and !empty($_POST['sexe']) and !empty($_POST['etatcivil']) and !empty($_POST['nationalite']) and !empty($_POST['typeinscription']) and !empty($_POST['adresse_physique']) and !empty($_POST['date_naissance'])
and !empty($_POST['lieu_naissance']) and !empty($_POST['telephone'])){
    $prenom = htmlspecialchars($_POST['prenom']);
    $nom = htmlspecialchars($_POST['nom']);
    $sexe = htmlspecialchars($_POST['sexe']);
    $etat_civil = htmlspecialchars($_POST['etatcivil']);
    $nationalite = htmlspecialchars($_POST['nationalite']);
    $typeinscription = htmlspecialchars($_POST['typeinscription']);
    $adresse_physique = htmlspecialchars($_POST['adresse_physique']);
    $date_naissance = htmlspecialchars($_POST['date_naissance']);
    $lieu_naissance = htmlspecialchars($_POST['lieu_naissance']);
    $telephone = htmlspecialchars($_POST['telephone']);
    $postnom = isset($_POST['postnom'])?htmlspecialchars($_POST['postnom']):NULL;

    $requete_verification = database()->prepare("SELECT * FROM etudiant WHERE prenom=? AND nom=? AND postnom=? AND date_naissance=?");
    $requete_verification->execute([$prenom,$nom,$postnom,$date_naissance]);
    if($requete_verification->rowCount()==0){
        
        $requete = database()->prepare("SELECT MAX(id) AS dernier_id FROM etudiant");
        $requete->execute();
        $resultat = $requete->fetch();
        $dernier_id = $resultat->dernier_id ? $resultat->dernier_id + 1 : 1;

        $matricule = str_pad($dernier_id, 7, "0", STR_PAD_LEFT);
        $matricule = "JGM".$matricule;

        // recuperation de la dernière inscription disponible
        $req  = database()->prepare("SELECT * FROM inscription ORDER BY id DESC LIMIT 1");
        $req->execute();
        $data = $req->fetch();
        $inscription = $data->id;

        $req = database()->prepare("INSERT INTO etudiant (matricule,prenom,nom,postnom,genre,adresse_physique,date_naissance,lieu_naissance,telephone,id_type_inscription,id_etat_civile,id_nationalite,id_etat_etudiant,id_inscription)
        VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $req->execute([$matricule,$prenom,$nom,$postnom,$sexe,$adresse_physique,$date_naissance,$lieu_naissance,$telephone,$typeinscription,$etat_civil,$nationalite,1,$inscription]);
        echo "Success";
    }else{
        echo "Déjà";
    }


}else{
    echo "Champs";
}

