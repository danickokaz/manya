<?php
session_start();
require '../../settings/db.php';

if (isset($_POST['classe'],$_POST['salle'],$_POST['annee_academique'], $_POST['ids']) && !empty($_POST['classe']) && !empty($_POST['salle']) && !empty($_POST['annee_academique']) && !empty($_POST['ids'])) {
    $classe = htmlspecialchars($_POST['classe']);
    $salle = htmlspecialchars($_POST['salle']);
    $annee_academique = htmlspecialchars($_POST['annee_academique']);
    $ids = $_POST['ids']; 

    try {
        $req = database()->prepare("INSERT INTO affectation_etudiant (matricule,id_classe,id_salle,id_annee_academique) VALUES(?,?,?,?)");

        foreach ($ids as $id) {
            $req->execute([htmlspecialchars($id), $classe,$salle,$annee_academique]);
        }

        echo json_encode([
            'status' => 'success',
            'message' => 'Centres mis à jour avec succès.'
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Erreur lors de la mise à jour : ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Données manquantes ou invalides.'
    ]);
}