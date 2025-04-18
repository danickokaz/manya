<?php 
session_start();
require '../settings/db.php';

if(isset($_SESSION['jgm']) and !empty($_SESSION['jgm'])){
    $session_utilisateur = $_SESSION['jgm'];

    $req = database()->prepare("SELECT * FROM utilisateur WHERE token=?");
    $req->execute([$session_utilisateur]);

    if($req->rowCount()==1){

        $data = $req->fetch();


        $requeteInscriptions  = database()->prepare("SELECT * FROM inscription ORDER BY id DESC");
        $requeteInscriptions->execute();
        if($requeteInscriptions->rowCount()>0){
            $inscriptions = $requeteInscriptions->fetchAll();
        }


        $requeteNationalite  = database()->prepare("SELECT * FROM nationalite");
        $requeteNationalite->execute();
        if($requeteNationalite->rowCount()>0){
            $nationalites = $requeteNationalite->fetchAll();
        }

        $requeteTypeInscription  = database()->prepare("SELECT * FROM type_inscription");
        $requeteTypeInscription->execute();
        if($requeteTypeInscription->rowCount()>0){
            $typesinscription = $requeteTypeInscription->fetchAll();
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
    .require{
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
                <div class="container">
                        <div class="row">
                           
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
                            

                        </div>

                        

                        


                    
                </div>
                <div class="container">
                    <h3 class="mt-5 mb-5">Liste de tous les étudiants</h3>

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
        $(document).ready(()=>{


            $(document).on('click', '.valider', function() {
                var matricule = $(this).attr('id');
              
                $.ajax({
                    url: 'traitement/validation_etudiant_2.php',
                    method: 'POST',
                    dataType: 'text',
                    data: {matricule:matricule},
                    timeout: 8000,
                    error: function(xhr,status,error){
                        console.log(xhr)
                    },
                    success: function(reponse_serveur){
                        if(reponse_serveur=="Success"){
                            recupererEtudiants()
                        }
                    }
                })
            });

            $(document).on('click', '.invalider', function() {
                var matricule = $(this).attr('id');
              
                $.ajax({
                    url: 'traitement/invalidation_etudiant_1.php',
                    method: 'POST',
                    dataType: 'text',
                    data: {matricule:matricule},
                    timeout: 8000,
                    error: function(xhr,status,error){
                        console.log(xhr)
                    },
                    success: function(reponse_serveur){
                        if(reponse_serveur=="Success"){
                            recupererEtudiants()
                        }
                    }
                })
            });

            $("#inscription").change(()=>{
                var id = $("#inscription").val()
                if(id!=""){
                    $.ajax({
                    url: 'traitement/tableau_etudiant_pour_validation.php',
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

            function recupererEtudiants(){
                var id = $("#inscription").val()

                $.ajax({
                    url: 'traitement/tableau_etudiant_pour_validation.php',
                    method: 'POST',
                    data: {id:id},
                    dataType: 'html',
                    error: ()=>{
                        document.getElementById("tableau").innerHTML = "<p>Erreur...Recharger la page <i class='fa fa-refresh'></i></p>";
                    },
                    timeout: 8000,
                    success: (reponse_serveur)=>{
                        document.getElementById("tableau").innerHTML = reponse_serveur

                    }
                })
            }

            

            
        })
     </script>
</body>

</html>