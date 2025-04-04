<?php 
session_start();
require '../../settings/db.php';

if(isset($_POST['id']) and !empty($_POST['id'])){

    $id = htmlspecialchars($_POST['id']);
    $req = database()->prepare("SELECT e.matricule,CONCAT(e.nom,' ',e.postnom,' ', e.prenom) nomcomplet,e.id_etat_etudiant,g.libelle_genre,ec.libelle_etat_civil,e.telephone,ti.libelle_type_inscription FROM 
    etudiant e LEFT JOIN etat_civil ec ON ec.id = e.id_etat_civile INNER JOIN type_inscription ti ON ti.id = e.id_type_inscription
    LEFT JOIN genre g ON g.id = e.genre WHERE e.id_inscription=? ORDER BY nomcomplet ASC");
    $req->execute([$id]);

    $sortie = "
        <table class='table table-striped table-bordered table-hover' style='padding: 10px;' id='etudiants'>
            <thead>
                <tr>
                    <th>N</th>
                    <th>Matricule</th>
                    <th>Nom complet</th>
                    <th>Genre</th>
                    <th>État civil</th>
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
            //Non validé(e)
            if($donnee->id_etat_etudiant==1){

                $sortie .= '
                <tr>
                    <td>'.$numero++.'</td>
                    <td>'.$donnee->matricule.'</td>
                    <td>'.$donnee->nomcomplet.'</td>
                    <td>'.$donnee->libelle_genre.'</td>
                    <td>'.$donnee->libelle_etat_civil.'</td>
                    <td>'.$donnee->telephone.'</td>
                    <td>'.$donnee->libelle_type_inscription.'</td>
                    <td><i class="text-primary text-center fa fa-check valider" id="'.$donnee->matricule.'" style="cursor:pointer;text-align:center;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Valider l\'étudiant(e)" ></i></td>
                </tr>
            
            ';
            

            }
            //Validée
            else if($donnee->id_etat_etudiant==2){
                $sortie .= '
                <tr>
                    <td>'.$numero++.'</td>
                    <td>'.$donnee->matricule.'</td>
                    <td>'.$donnee->nomcomplet.'</td>
                    <td>'.$donnee->libelle_genre.'</td>
                    <td>'.$donnee->libelle_etat_civil.'</td>
                    <td>'.$donnee->telephone.'</td>
                    <td>'.$donnee->libelle_type_inscription.'</td>
                    <td><i class="text-primary fa fa-times invalider" id="'.$donnee->matricule.'" style="cursor:pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Invalider l\'étudiant(e)" ></i></td>
                </tr>
            
            ';
            }

            
            
        }
        $sortie .= '
            </tbody>
            </table>
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

