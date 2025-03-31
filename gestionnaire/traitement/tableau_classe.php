<?php 
session_start();
require '../../settings/db.php';

$req = database()->prepare("SELECT * FROM classe ORDER BY libelle_classe ASC");
$req->execute();

$sortie = "
    <table class='table table-striped table-bordered table-hover' style='padding: 10px;' id='classes'>
        <thead>
            <tr>
                <th>N</th>
                <th>Classe</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

";

if($req->rowCount()>0){
    $donnees = $req->fetchAll();

    $numero  = 1;

    foreach($donnees as $donnee){
        $sortie .= '
            <tr>
                <td>'.$numero++.'</td>
                <td>'.$donnee->libelle_classe.'</td>
                <td>
                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Voir plus
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Modifier</a></li>
                        <li><a class="dropdown-item ajoutersalle" id="'.$donnee->id.'" href="#">Ajouter une salle</a></li>
                        <li><a class="dropdown-item voirsalle" id="'.$donnee->id.'"  href="#">Voir les salles</a></li>
                        
                    </ul>
                </td>
            </tr>
        
        ';
    }
    $sortie .= '
        </tbody>
        </table>
    ';
    echo $sortie;
}else{
    $sortie .= '
        <tr>
            <td colspan=8 align="center">Aucune classe</td>
        </tr>
        </tbody>
        </table>
    ';
    echo $sortie;
}