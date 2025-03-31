<?php
session_start();
require '../../settings/db.php';



    // Vérifie si un fichier est envoyé
    if (isset($_FILES['fichier']) && $_FILES['fichier']['error'] === UPLOAD_ERR_OK) {
        
        $uploadDir = '../dossiers/';

        // Vérifie si le dossier d'upload existe, sinon le créer
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Sécurisation du fichier (génère un nom unique)
        $fileInfo = pathinfo($_FILES['fichier']['name']);
        $extension = strtolower($fileInfo['extension']);
        $allowedExtensions = ['pdf']; // Types autorisés

        if (!in_array($extension, $allowedExtensions)) {
            die("Erreur : Type de fichier non autorisé !");
        }

        // Nouveau nom du fichier avec timestamp pour éviter les doublons
        $newFileName = uniqid("fichier_", true) . "." . $extension;
        $uploadFile = $uploadDir . $newFileName;

        // Déplace le fichier vers le dossier d'upload
        if (move_uploaded_file($_FILES['fichier']['tmp_name'], $uploadFile)) {

            // Vérifie si l'ID de l'étudiant est envoyé
            if (isset($_POST['id_pour_fichier']) && !empty($_POST['id_pour_fichier'])) {
                $id_fichier = htmlspecialchars($_POST['id_pour_fichier']);

                // Mise à jour dans la base de données
                $req = database()->prepare("UPDATE etudiant SET dossier=? WHERE id=?");
                if ($req->execute([$newFileName, $id_fichier])) {
                    echo "Success";
                } else {
                    echo "Erreur SQL lors de la mise à jour.";
                }
            } else {
                echo "Erreur : ID de l'étudiant manquant.";
            }

        } else {
            echo "Erreur lors du transfert du fichier.";
        }
    } else {
        echo "Aucun fichier reçu ou erreur de transfert.";
    }

?>
