<?php 
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
require '../settings/db.php';
require '../vendor/autoload.php';
// require_once __DIR__ . '/vendor/autoload.php';


if(isset($_SESSION['jgm']) and !empty($_SESSION['jgm'])){
    $session_utilisateur = $_SESSION['jgm'];

    if(isset($_GET['classe'],$_GET['salle'],$_GET['annee_academique']) and !empty($_GET['classe']) and !empty($_GET['salle']) and !empty($_GET['annee_academique'])){
        $classe = htmlspecialchars($_GET['classe']);
        $salle = htmlspecialchars($_GET['salle']);
        $annee_academique = htmlspecialchars($_GET['annee_academique']);

        $reqClasse = database()->prepare("SELECT * FROM classe WHERE id=?");
        $reqClasse->execute([$classe]);
        $data = $reqClasse->fetch();
        $libelle_classe = $data->libelle_classe;


        $reqSalle = database()->prepare("SELECT * FROM salle WHERE id=?");
        $reqSalle->execute([$salle]);
        $data = $reqSalle->fetch();
        $libelle_salle = $data->libelle_salle;


        $reqAnneeAcademique = database()->prepare("SELECT * FROM annee_academique WHERE id=?");
        $reqAnneeAcademique->execute([$annee_academique]);
        $data = $reqAnneeAcademique->fetch();
        $libelle_annee_academique = $data->libelle_annee_acedemique;



        $req = database()->prepare("SELECT * FROM utilisateur WHERE token=?");
        $req->execute([$session_utilisateur]);

        if($req->rowCount()==1){

            $data = $req->fetch();

            $req = database()->prepare("SELECT 
                    e.id,
                    aff.id as id_affectation,
                    e.matricule,
                    ti.libelle_type_inscription,
                    e.telephone,
                    ti.libelle_type_inscription,
                    CONCAT(e.nom, ' ', e.postnom, ' ', e.prenom) AS nom_complet,
                    pf.matricule as matricule_pf,
                    pf.id_frais
                FROM etudiant e
                LEFT JOIN affectation_etudiant aff ON aff.matricule = e.matricule
                INNER JOIN type_inscription ti ON ti.id = e.id_type_inscription
                LEFT JOIN paiement_frais pf ON pf.matricule = e.matricule
                WHERE aff.id_classe = ?
                AND aff.id_salle = ?
                AND aff.id_annee_academique = ?
                AND (pf.id_frais IS NULL OR pf.id_frais=?)");
            $req->execute([$classe,$salle,$annee_academique,9]);

            if($req->rowCount()!=0){
                $mpdf = new \Mpdf\Mpdf();
                // Début de la construction du tableau HTML
                $html = '<p style="text-align:right;font-family:Verdana;">Kinshasa, le '.date('d/m/Y').'</p>';
                $html .= '<div style="text-align:center;"><img src="../images/logo-eifi.png" style="width:100px;height:100px;"></div>';
                $html .= '<h1 style="font-family:Verdana;text-align:center;">LISTE DES ÉTUDIANTS EN ORDRE AVEC LES FRAIS DE REINSCROPTION POUR L\'ANNÉE ACADÉMIQUE '.$libelle_annee_academique.'</h1>';
                $html .= '<h2 style="font-family:Verdana;text-align:center;">CLASSE : '.$libelle_classe.' '.$libelle_salle.'</h2>';
                $html .= '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
                $html .= '<thead>';
                $html .= '<tr>';
                $html .= '<th style="font-family:Verdana;">MATRICULE</th>';
                $html .= '<th style="font-family:Verdana;">NOM COMPLET</th>';
                $html .= '<th style="font-family:Verdana;">TYPE INSCRIT(E)</th>';
                $html .= '</tr>';
                $html .= '</thead>';
                $html .= '<tbody>';
                $donnees = $req->fetchAll();

                foreach ($donnees as $etudiant) {
                    $html .= '<tr>';
                    $html .= '<td style="font-family:Verdana;">' . $etudiant->matricule . '</td>';
                    $html .= '<td style="font-family:Verdana;">' . $etudiant->nom_complet . '</td>';
                    $html .= '<td style="font-family:Verdana;text-align:center;">' . $etudiant->libelle_type_inscription . '</td>';

                    $html .= '</tr>';
                }

                $html .= '</tbody>';
                $html .= '</table>';

                // Ecrire le HTML dans le PDF
                $mpdf->WriteHTML($html);

                // Générer le PDF
                $mpdf->Output();
            }else{
                echo "Aucun étudiant";
            }


            
            


        }else{
            header("location:connexion");
        }

    }

    

}else{
    header("location:connexion");
}

?>