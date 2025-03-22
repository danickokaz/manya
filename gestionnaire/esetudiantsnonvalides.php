<?php 
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
require '../settings/db.php';
require '../vendor/autoload.php';
// require_once __DIR__ . '/vendor/autoload.php';


if(isset($_SESSION['jgm']) and !empty($_SESSION['jgm'])){
    $session_utilisateur = $_SESSION['jgm'];

    $req = database()->prepare("SELECT * FROM utilisateur WHERE token=?");
    $req->execute([$session_utilisateur]);

    if($req->rowCount()==1){

        $data = $req->fetch();

        $req = database()->prepare("SELECT e.matricule,CONCAT(e.nom,' ',e.postnom,' ', e.prenom) nomcomplet,g.libelle_genre,ec.libelle_etat_civil,e.telephone,ti.libelle_type_inscription FROM 
        etudiant e LEFT JOIN etat_civil ec ON ec.id = e.id_etat_civile INNER JOIN type_inscription ti ON ti.id = e.id_type_inscription
        LEFT JOIN genre g ON g.id = e.genre WHERE e.id_etat_etudiant=? ORDER BY e.nom,e.postnom,e.prenom ASC");

        $req->execute([1]);

        if($req->rowCount()!=0){
            $mpdf = new \Mpdf\Mpdf();
            // Début de la construction du tableau HTML
            $html = '<p style="text-align:right;font-family:Verdana;">Kinshasa, le '.date('d/m/Y').'</p>';
            $html .= '<div style="text-align:center;"><img src="../images/logo-eifi.png" style="width:100px;height:100px;"></div>';
            $html .= '<h1 style="font-family:Verdana;text-align:center;">LISTE DES ÉTUDIANTS NON VALIDÉS</h1>';
            $html .= '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 100%;">';
            $html .= '<thead>';
            $html .= '<tr>';
            $html .= '<th style="font-family:Verdana;">MATRICULE</th>';
            $html .= '<th style="font-family:Verdana;">NOM COMPLET</th>';
            $html .= '<th style="font-family:Verdana;">GENRE</th>';
            $html .= '<th style="font-family:Verdana;">TYPE INSCRIT(E)</th>';
            $html .= '<th style="font-family:Verdana;">DÉCISION</th>';
            $html .= '</tr>';
            $html .= '</thead>';
            $html .= '<tbody>';
            $donnees = $req->fetchAll();

            foreach ($donnees as $etudiant) {
                $html .= '<tr>';
                $html .= '<td style="font-family:Verdana;">' . $etudiant->matricule . '</td>';
                $html .= '<td style="font-family:Verdana;">' . $etudiant->nomcomplet . '</td>';
                $html .= '<td style="font-family:Verdana;text-align:center;">' . $etudiant->libelle_genre . '</td>';
                $html .= '<td style="font-family:Verdana;">' . $etudiant->libelle_type_inscription . '</td>';
                $html .= '<td style="font-family:Verdana;">  </td>';

                $html .= '</tr>';
            }

            $html .= '</tbody>';
            $html .= '</table>';

            // Ecrire le HTML dans le PDF
            $mpdf->WriteHTML($html);

            // Générer le PDF
            $mpdf->Output();
        }


        
        


    }else{
        header("location:connexion");
    }

}else{
    header("location:connexion");
}

?>