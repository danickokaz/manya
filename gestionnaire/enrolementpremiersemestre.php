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

        $requeteClasse  = database()->prepare("SELECT * FROM classe");
        $requeteClasse->execute();
        if($requeteClasse->rowCount()>0){
            $classes = $requeteClasse->fetchAll();
        }


        // $requeteInscriptions  = database()->prepare("SELECT * FROM inscription ORDER BY id DESC");
        // $requeteInscriptions->execute();
        // if($requeteInscriptions->rowCount()>0){
        //     $inscriptions = $requeteInscriptions->fetchAll();
        // }



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
                                <form method="POST" id="formulaireValiderEtudiant" method="post">
                                    <div class="modal-footer">
                                        <button type="button" id="annuler" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Fermer</button>
                                        <button type="submit" id="confirmAction"
                                            class="btn btn-primary">Affecter</button>
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
                    <h3 class="mt-5 mb-5">Liste de tous les étudiants</h3>

                    <div class="row">

                        <div class="col-md-3 mt-5">
                            <div class="form-group">
                                <label class="form-label" for="annee_academique">Année académique</label><span
                                    class="require">*</span>
                                <select name="annee_academique" id="annee_academique" class="form-control">
                                    <option value="">Veuillez sélectionner l'année académique</option>
                                    <?php foreach($anneesAcademique as $anneeAcademique): ?>
                                    <option value="<?= $anneeAcademique->id ?>">
                                        <?= $anneeAcademique->libelle_annee_acedemique ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>

                            </div>
                        </div>

                        <div class="col-md-3 mt-5">
                            <div class="form-group">
                                <label class="form-label" for="classe">Classe</label><span
                                    class="require">*</span>
                                <select name="classe" id="classe" class="form-control">
                                    <option value="">Veuillez sélectionner la classe</option>
                                    <?php foreach($classes as $classe): ?>
                                    <option value="<?= $classe->id ?>">
                                        <?= $classe->libelle_classe ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>

                            </div>
                        </div>


                        <div class="col-md-3 mt-5">
                            <div class="form-group">
                                <label class="form-label" for="salle">Salle</label><span
                                    class="require">*</span>
                                <select name="salle" id="salle" class="form-control">
                                    <option value="">Veuillez sélectionner la salle</option>
                                    
                                </select>

                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="container mb-5">
                        <button class="btn btn-primary" id="btnVoirEtudiants">Voir la liste</button>

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


            $("#btnVoirEtudiants").click(function(){
                var annee_academique = $("#annee_academique").val()
                var classe = $("#classe").val()
                var salle = $("#salle").val()
                event.preventDefault()
                $("#btnVoirEtudiants").text('Chargement...')
                $.ajax({
                    url: 'traitement/tableau_etudiants_enrolement_premier_semestre.php',
                    method:'POST',
                    data:{
                        annee_academique: annee_academique,
                        classe:classe,
                        salle:salle
                    },
                    error: function(error){
                        console.log(error)
                    },
                    success: function(reponse_serveur){
                        document.getElementById("tableau").innerHTML = reponse_serveur
                    },
                    complete: function(){
                        $("#btnVoirEtudiants").text('Voir la liste')

                    }
                    
                    
                    
                    
                })
            })


            function recupererEtudiants(){
                var annee_academique = $("#annee_academique").val()
                var classe = $("#classe").val()
                var salle = $("#salle").val()
         
                $.ajax({
                    url: 'traitement/tableau_etudiants_enrolement_premier_semestre.php',
                    method:'POST',
                    data:{
                        annee_academique: annee_academique,
                        classe:classe,
                        salle:salle
                    },
                    error: function(error){
                        console.log(error)
                    },
                    success: function(reponse_serveur){
                        document.getElementById("tableau").innerHTML = reponse_serveur
                    },
                    
                    
                })
            }

            $(document).on('click','.valider',function(){
                event.preventDefault()
                var id = $(this).attr('id')
                $.ajax({
                    url: 'traitement/valider_pour_enrolement_premier_semestre.php',
                    method: 'POST',
                    data: {id:id},
                    dataType: 'text',
                    error: function(erro){
                        console.log(error)
                    },
                    success: function(reponse){
                        if(reponse=="Success"){
                            recupererEtudiants()
                        }
                    }
                })
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

            




            $(document).on('change', '#classe', function () {
                var id_classe = $(this).val()
                $.ajax({
                    url: 'traitement/select_recuperer_salle_par_classe.php',
                    method: 'POST',
                    data: {
                        id_classe: id_classe
                    },
                    dataType: 'html',
                    error: function (error) {
                        console.log(error)
                    },
                    success: function (reponse) {
                        $("#salle").html(reponse)
                    }
                })
            })



            

            $("#annuler").click(function () {
                var salle = $("#salle").val(''); // Récupérer la salle
                var classe = $("#classe").val('') // Récuperer la classe
                var annee_academique = $("#annee_academique").val('') //Année académique

                $('#modal_affectation').modal('hide');


            })


        })
    </script>
</body>

</html>