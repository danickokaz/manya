<?php 
session_start();
require '../settings/db.php';

if(isset($_SESSION['jgm']) and !empty($_SESSION['jgm'])){
    $session_utilisateur = $_SESSION['jgm'];

    $req = database()->prepare("SELECT * FROM utilisateur WHERE token=?");
    $req->execute([$session_utilisateur]);

    if($req->rowCount()==1){

        $data = $req->fetch();


        $requeteClasse  = database()->prepare("SELECT * FROM classe");
        $requeteClasse->execute();
        if($requeteClasse->rowCount()>0){
            $classes = $requeteClasse->fetchAll();
        }


        

        $requeteAnneAcademique  = database()->prepare("SELECT * FROM annee_academique");
        $requeteAnneAcademique->execute();
        if($requeteAnneAcademique->rowCount()>0){
            $anneesAcademique = $requeteAnneAcademique->fetchAll();
        }


        $requeteInscriptions  = database()->prepare("SELECT * FROM inscription ORDER BY id DESC");
        $requeteInscriptions->execute();
        if($requeteInscriptions->rowCount()>0){
            $inscriptions = $requeteInscriptions->fetchAll();
        }



    }else{
        header("location:connexion");
    }

}else{
    header("location:connexion");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MANYA</title>
    <link rel="shortcut icon" href="../images/logo-eifi.png" />
    <link rel="stylesheet" href="DataTables/datatables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="../css/style.css">


    <!-- Data table -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css"> -->
</head>
<style>
    .require {
        color: red;
    }
</style>

<body>
    <div class="container-scroller">

        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <?php require 'menu/sidebar.php' ?>


            <!-- partial -->
            <div class="main-panel">
                <div class="modal fade" id="modal_affectation" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Affecter un(e) étudiant(e)</h5>

                            </div>
                            <div class="modal-body">
                                <form method="POST" id="formulaireAffecter" enctype="multipart/form-data"
                                    method="post">
                                    
                                    <div class="form-group">
                                        <label for="fichier">Classe</label>
                                        <select name="classe" id="classe" class="form-control">
                                            <option value="">Veuillez choisir une classe</option>
                                            <?php foreach($classes as $classe): ?>
                                                <option value="<?= $classe->id ?>"><?= $classe->libelle_classe ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <input type="hidden" name="matricule_pour_affectation" id="matricule_pour_affectation">
                                    </div>
                                    <div class="form-group">
                                        <label for="fichier">Salle</label>
                                        <select name="salle" id="salle" class="form-control">
                                            <option value="">Veuillez choisir une salle</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="fichier">Année académique</label>
                                        <select name="annee_academique" id="annee_academique" class="form-control">
                                            <?php foreach($anneesAcademique as $anneeAcademique): ?>
                                                <option value="<?= $anneeAcademique->id ?>"><?= $anneeAcademique->libelle_annee_acedemique ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" id="annuler" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Fermer</button>
                                        <button type="submit" id="confirmAction" class="btn btn-primary">Affecter</button>
                                    </div>
                                    <div class="progress mt-3" style="display: none;" id="progressContainer">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated"
                                            role="progressbar" style="width: 0%;" id="progressBar">
                                            0%
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="container">
                    <h3 class="mt-5 mb-5">Liste de tous les étudiants à affecter</h3>

                    <div class="col-md-3 mt-5">
                                <div class="form-group">
                                    <label class="form-label" for="inscription">Inscription</label><span class="require">*</span>
                                    <select name="inscription" id="inscription" class="form-control">
                                        <option value="">Veuillez sélectionner l'inscription</option>
                                        <?php foreach($inscriptions as $inscription): ?>
                                        <option value="<?= $inscription->id ?>"><?= $inscription->libelle_inscription ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>

                                </div>
                            </div>
                    

                    <div class="container">
                        <div id="tableau"></div>
                    </div>

                </div>
                <!-- <div class="content-wrapper">
                  
                </div> -->
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright ©
                            <?= date('Y') ?></span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Application conçue par
                            l' <a href="https://eifi-rdc.net/test/" target="_blank">École Informatique des Finances</a>
                        </span>
                    </div>
                </footer>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->



    <!-- base:js -->
    <!-- jQuery doit être chargé en premier -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap & autres dépendances -->
    <script src="../vendors/base/vendor.bundle.base.js"></script>

    <!-- DataTables doit être chargé après jQuery -->
    <script src="DataTables/datatables.min.js"></script>

    <!-- Plugins spécifiques -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Scripts personnalisés -->
    <script src="../js/template.js"></script>


    <!-- Data table -->
    <!-- <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
     <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
     <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script> -->

    <!-- End custom js for this page-->
    <script>
        $(document).ready(() => {

            $("#inscription").change(()=>{
                var id = $("#inscription").val()
                if(id!=""){
                    $.ajax({
                    url: 'traitement/tableau_etudiant_affecter_dans_salle.php',
                    data: {id:id},
                    method: 'POST',
                    dataType: 'html',
                    error: (xhr,status,error)=>{
                        document.getElementById("tableau").innerHTML = "<p>Erreur...Recharger la page <i class='fa fa-refresh'></i></p>";
                    },
                    timeout: 8000,
                    success: (reponse_serveur)=>{
                        document.getElementById("tableau").innerHTML = reponse_serveur

                    }
                    })
                }
            })

            // recupererEtudiants()

            // function recupererEtudiants() {
            //     $.ajax({
            //         url: 'traitement/tableau_etudiant_affecter_dans_salle.php',
            //         method: 'POST',
            //         dataType: 'html',
            //         error: () => {
            //             document.getElementById("tableau").innerHTML =
            //                 "<p>Erreur...Recharger la page <i class='fa fa-refresh'></i></p>";
            //         },
            //         timeout: 8000,
            //         success: (reponse_serveur) => {
            //             document.getElementById("tableau").innerHTML = reponse_serveur

            //         }
            //     })
            // }
            $("#annuler").click(function () {
                $("#modal_fichier").modal('hide')
            })

            $(document).on('click', '.affecter', function () {
                event.preventDefault()
                var id = $(this).attr('id')
                $("#matricule_pour_affectation").val(id)

                $("#modal_affectation").modal('show')

            })

            $("#formulaireEnvoyerFichier").submit(function () {
                event.preventDefault()
                let formData = new FormData(this);

               

                // Afficher la barre de progression
                $("#progressContainer").show();
                $("#progressBar").css("width", "0%").text("0%");

                $.ajax({
                    url: "traitement/upload_dossier_etudiant.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    xhr: function() {
                        let xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(event) {
                            if (event.lengthComputable) {
                                let percent = Math.round((event.loaded / event.total) * 100);
                                $("#progressBar").css("width", percent + "%").text(percent + "%");
                            }
                        }, false);
                        return xhr;
                    },
                    success: function(response) {
                        $("#progressBar").css("width", "100%").text("100%");
                        setTimeout(function() {
                            $("#progressContainer").fadeOut(); // Cache la barre après succès
                        }, 1000);
                        if(response=="Success"){
                            $("#fichier").val('')
                            setTimeout(function(){
                                $("#modal_fichier").modal('hide')
                            },2000)
                        }else{
                            console.log('Erreur1'+response)
                        }
                    },
                    error: function() {
                        $("#response").html("Erreur lors de l'envoi.");
                    }
                });
            })


            $(document).on('click','.voirdossier', function(){
                var id_dossier = $(this).attr('id')
                location.href = 'dossiers/'+id_dossier
            })

            $(document).on('change','#classe', function(){
                var id_classe = $(this).val()
                $.ajax({
                    url: 'traitement/select_recuperer_salle_par_classe.php',
                    method: 'POST',
                    data: {id_classe:id_classe},
                    dataType: 'html',
                    error: function(error){
                        console.log(error)
                    },
                    success: function(reponse){
                        $("#salle").html(reponse)
                    }
                })
            })



            // Désactiver le menu contextuel par défaut
            $(document).on('contextmenu', function (e) {
                e.preventDefault();
            });

            // Fonction pour obtenir les éléments sélectionnés
            function getSelectedItems() {
                const selected = [];
                $('.row-checkbox:checked').each(function () {
                selected.push($(this).val());
                });
                return selected;
            }

            // Gérer le clic droit pour ouvrir le modal
            $(document).on('mousedown', function (e) {
                if (e.which === 3) { // Vérifie si le clic droit est effectué
                var selectedItems = getSelectedItems();
                if (selectedItems.length > 0) {
                    // Ouvrir le modal
                    $('#modal_affectation').modal('show');
                } else {
                    Swal.fire({
                    title: "Erreur!",
                    text: "Veuillez sélectionner au moins un(e) étudiant(e) avant de continuer",
                    icon: "error"
                    });

                }
                }
            });

            // Gérer la soumission à partir du bouton dans le modal
            $('#confirmAction').on('click', function () {
                event.preventDefault()
                $("#confirmAction").text('Chargement...')
                // Récupérer les valeurs des cases cochées
                var selectedIds = getSelectedItems();
                var salle = $("#salle").val(); // Récupérer la salle
                var classe = $("#classe").val() // Récuperer la classe
                var annee_academique = $("#annee_academique").val() //Année académique

                // Vérifier si au moins une case est cochée
                if (selectedIds.length === 0) {
                Swal.fire({
                    title: "Erreur!",
                    text: "Veuillez sélectionner au moins un centre de perception",
                    icon: "error"
                });
                return;
                }

                // Envoi des données via Ajax
                $.ajax({
                url: 'traitement/affecter_etudiant_premiere_annee.php', // URL du script PHP
                method: 'POST', // Méthode HTTP
                data: {
                    ids: selectedIds,
                    salle: salle,
                    classe: classe,
                    annee_academique:annee_academique
                }, // Données envoyées
                success: function (response) {
                    console.log('Réponse brute du serveur:', response); // Affichez la réponse brute
                    try {
                    const jsonResponse = JSON.parse(response); // Tentez de parser en JSON
                    if (jsonResponse.status === 'success') {
                        // Message de succès
                        Swal.fire({
                        title: "Operation reussie!",
                        text: "Étudiant(e)s ajouté(e)s avec succès",
                        icon: "success"
                        });

                    } else {
                        // Message d'erreur
                        Swal.fire({
                        title: "Erreur!",
                        text: "Une erreur est survennue1",
                        icon: "error"
                        });
                    }
                    } catch (e) {
                    Swal.fire({
                        title: "Erreur!",
                        text: "Une erreur est survennue2",
                        icon: "error"
                    });
                    }
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                    title: "Erreur!",
                    text: "Une erreur est survennue3",
                    icon: "error"
                    });
                },
                complete: function(){
                    $("#confirmAction").text('Affecter')
                }
                });
            });

            $("#annuler").click(function(){
                var salle = $("#salle").val(''); // Récupérer la salle
                var classe = $("#classe").val('') // Récuperer la classe
                var annee_academique = $("#annee_academique").val('') //Année académique

                $('#modal_affectation').modal('hide');


            })


        })
    </script>
</body>

</html>