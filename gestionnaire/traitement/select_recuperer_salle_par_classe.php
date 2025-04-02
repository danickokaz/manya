<?php 
session_start();
require '../../settings/db.php';

if(isset($_POST['id_classe']) and !empty($_POST['id_classe'])){
    $id_classe = htmlspecialchars($_POST['id_classe']);

    $req = database()->prepare("SELECT * FROM salle WHERE id_classe=? ORDER BY id ASC");
    $req->execute([$id_classe]);


    if($req->rowCount()>=1){
        $data = $req->fetchAll();
        foreach($data as $d){
            echo '<option value="'.$d->id.'">'.$d->libelle_salle.'</option>';
        }
    }else{
        echo "<option value=''>Aucune salle</option>";
    }
}