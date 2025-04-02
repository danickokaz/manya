<?php 
session_start();
require '../settings/db.php';

if(isset($_SESSION['jgm']) and !empty($_SESSION['jgm'])){
    $session_utilisateur = $_SESSION['jgm'];

    $req = database()->prepare("SELECT * FROM utilisateur WHERE token=?");
    $req->execute([$session_utilisateur]);

    if($req->rowCount()==1){

        $data = $req->fetch();


        



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
                <div class="modal fade" id="modal_fichier" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>

                            </div>
                            <div class="modal-body">
                                <form method="POST" id="formulaireEnvoyerFichier" enctype="multipart/form-data"
                                    method="post">
                                    
                                    <div class="form-group">
                                        <label for="fichier">Fichier</label>
                                        <input type="file" name="fichier" id="fichier" class="form-control">
                                        <input type="hidden" name="id_pour_fichier" id="id_pour_fichier">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" id="annuler" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Annuler</button>
                                        <button type="submit" class="btn btn-primary">Enregistrer</button>
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
                    <h3 class="mt-5 mb-5">Liste de tous les étudiants enregistrés</h3>

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

            recupererEtudiants()

            function recupererEtudiants() {
                $.ajax({
                    url: 'traitement/tableau_etudiant_archiver_dossier.php',
                    method: 'POST',
                    dataType: 'html',
                    error: () => {
                        document.getElementById("tableau").innerHTML =
                            "<p>Erreur...Recharger la page <i class='fa fa-refresh'></i></p>";
                    },
                    timeout: 8000,
                    success: (reponse_serveur) => {
                        document.getElementById("tableau").innerHTML = reponse_serveur

                        new DataTable('#etudiants');



                    }
                })
            }
            $("#annuler").click(function () {
                $("#modal_fichier").modal('hide')
            })

            $(document).on('click', '.upload', function () {
                event.preventDefault()
                var id = $(this).attr('id')
                $("#id_pour_fichier").val(id)

                $("#modal_fichier").modal('show')

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


        })
    </script>
</body>

</html>