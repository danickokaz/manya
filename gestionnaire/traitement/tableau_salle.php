<?php 
session_start();
require '../../settings/db.php';
if(isset($_POST['id_classe']) and !empty($_POST['id_classe'])){
    $id_classe = htmlspecialchars($_POST['id_classe']);


    $req = database()->prepare("SELECT * FROM salle WHERE id_classe=? ORDER BY libelle_salle ASC");
    $req->execute([$id_classe]);

$sortie = "
   <ul>

";

if($req->rowCount()>0){
    $donnees = $req->fetchAll();


    foreach($donnees as $donnee){
        $sortie .= '
            <li>
                '.$donnee->libelle_salle.'
            </li>
        
        ';
    }
    $sortie .= '
        </ul>
    ';
    echo $sortie;
}else{
    $sortie .= '
        <h1>Aucune salle</h1>
    ';
    echo $sortie;
}
}

