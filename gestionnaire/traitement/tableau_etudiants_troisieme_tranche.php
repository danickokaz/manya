<?php 
session_start();
require '../../settings/db.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_POST['annee_academique'],$_POST['classe'],$_POST['salle']) and !empty($_POST['annee_academique']) and !empty($_POST['classe']) and !empty($_POST['salle'])){
    $annee_academique = htmlspecialchars($_POST['annee_academique']);
    $classe = htmlspecialchars($_POST['classe']);
    $salle = htmlspecialchars($_POST['salle']);
    $req = database()->prepare("SELECT 
    e.id,
    aff.id as id_affectation,
    e.matricule,
    ti.libelle_type_inscription,
    e.telephone,
    CONCAT(e.nom, ' ', e.postnom, ' ', e.prenom) AS nom_complet,
    pf.matricule as matricule_pf,
    pf.id_frais
FROM etudiant e
LEFT JOIN affectation_etudiant aff ON aff.matricule = e.matricule
INNER JOIN type_inscription ti ON ti.id = e.id_type_inscription
LEFT JOIN paiement_frais pf ON pf.matricule = e.matricule AND pf.id_frais = ?
WHERE aff.id_classe = ?
AND aff.id_salle = ?
AND aff.id_annee_academique = ?");
$req->execute([4,$classe,$salle,$annee_academique]);

$sortie = "
    <table class='table table-striped table-bordered table-hover' style='padding: 10px;' id='etudiants'>
        <thead>
            <tr>
                <th>N</th>
                <th>Matricule</th>
                <th>Nom complet</th>
                <th>Téléphone</th>
                <th>Type inscrit(e)</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

";

if($req->rowCount()>0){
    $donnees = $req->fetchAll();

    $numero  = 1;

    foreach($donnees as $donnee){

        if($donnee->id_frais==NULL){
            $sortie .= '
            <tr>
                <td>'.$numero++.'</td>
                <td>'.$donnee->matricule.'</td>
                <td>'.$donnee->nom_complet.'</td>
                <td>'.$donnee->telephone.'</td>
                <td>'.$donnee->libelle_type_inscription.'</td>
                <td><i class="text-primary fa fa-check valider" id="'.$donnee->id_affectation.'" style="cursor:pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Valider l\'étudiant(e) pour la première tranche" ></i></td>

            </tr>
        
            ';
        }else{
            $sortie .= '
            <tr>
                <td>'.$numero++.'</td>
                <td>'.$donnee->matricule.'</td>
                <td>'.$donnee->nom_complet.'</td>
                <td>'.$donnee->telephone.'</td>
                <td>'.$donnee->libelle_type_inscription.'</td>
                <td>Payé</td>

            </tr>
        
            ';
        }



      
        
    }
    $sortie .= '
        </tbody>
        </table>
        <a href="estroisiemetranche/'.$classe.'/'.$salle.'/'.$annee_academique.'" class="btn btn-primary mt-2 mb-2"><i class="fa fa-print"></i>  Imprimer le tableau</a>

    ';
    echo $sortie;
}else{
    $sortie .= '
        <tr>
            <td colspan=8 align="center">Aucun étudiant</td>
        </tr>
        </tbody>
        </table>
    ';
    echo $sortie;
}
}

