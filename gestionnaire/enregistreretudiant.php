<?php 
session_start();
require '../settings/db.php';

if(isset($_SESSION['jgm']) and !empty($_SESSION['jgm'])){
    $session_utilisateur = $_SESSION['jgm'];

    $req = database()->prepare("SELECT * FROM utilisateur WHERE token=?");
    $req->execute([$session_utilisateur]);

    if($req->rowCount()==1){

        $data = $req->fetch();


        $requeteEtatCivil  = database()->prepare("SELECT * FROM etat_civil");
        $requeteEtatCivil->execute();
        if($requeteEtatCivil->rowCount()>0){
            $etatscivil = $requeteEtatCivil->fetchAll();
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
                    <h3 class="mt-5 mb-5">Enregistrer étudiant(e)</h3>
                    <form id="formulaireAjouterEtudiant" method="POST">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label" for="prenom">Prénom</label><span class="require">*</span>
                                    <input type="text" name="prenom" id="prenom" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label" for="nom">Nom</label><span class="require">*</span>
                                    <input type="text" name="nom" id="nom" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label" for="postnom">Post-nom</label>
                                    <input type="text" name="postnom" id="postnom" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label" for="sexe">Sexe</label><span class="require">*</span>
                                    <select name="sexe" id="sexe" class="form-control">
                                        <option value="">Veuillez sélectionner le sexe</option>
                                        <option value="1">F</option>
                                        <option value="2">M</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label" for="etatcivil">Etat civil</label><span class="require">*</span>
                                    <select name="etatcivil" id="etatcivil" class="form-control">
                                        <option value="">Veuillez sélectionner l'état civil</option>
                                        <?php foreach($etatscivil as $etatcivil): ?>
                                        <option value="<?= $etatcivil->id ?>"><?= $etatcivil->libelle_etat_civil ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label" for="nationalite">Nationalité</label><span class="require">*</span>
                                    <select name="nationalite" id="nationalite" class="form-control">
                                        <option value="">Veuillez sélectionner la nationalité</option>
                                        <?php foreach($nationalites as $nationalite): ?>
                                        <option value="<?= $nationalite->id ?>"><?= $nationalite->libelle_nationalite ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label" for="typeinscription">Type inscription</label><span class="require">*</span>
                                    <select name="typeinscription" id="typeinscription"
                                        class="form-control">
                                        <option value="">Veuillez sélectionner le type d'inscription</option>
                                        <?php foreach($typesinscription as $typeinsctiption): ?>
                                        <option value="<?= $typeinsctiption->id ?>"><?= $typeinsctiption->libelle_type_inscription ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label" for="adresse_physique">Adresse physique</label><span class="require">*</span>
                                    <input type="text" name="adresse_physique" id="adresse_physique"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label" for="date_naissance">Date de naissance</label><span class="require">*</span>
                                    <input type="date" name="date_naissance" id="date_naissance" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label" for="lieu_naissance">Lieu de naissance</label><span class="require">*</span>
                                    <input type="text" name="lieu_naissance" id="lieu_naissance" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label" for="telephone">Téléphone</label><span class="require">*</span>
                                    <input type="phone" name="telephone" id="telephone" class="form-control">
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-primary" id="btnEnregistrerEtudiant" type="submit">Enregistrer</button>

                        <button class="btn btn-info" id="btnAnnulerEnregistrement" type="reset">Annuler</button>


                    </form>
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
        $(document).ready(()=>{

            recupererEtudiants()

            function recupererEtudiants(){
                $.ajax({
                    url: 'traitement/tableau_etudiant.php',
                    method: 'POST',
                    dataType: 'html',
                    error: ()=>{
                        document.getElementById("tableau").innerHTML = "<p>Erreur...Recharger la page <i class='fa fa-refresh'></i></p>";
                    },
                    timeout: 8000,
                    success: (reponse_serveur)=>{
                        document.getElementById("tableau").innerHTML = reponse_serveur
                        
                        new DataTable('#etudiants');

                        

                    }
                })
            }

            $("#formulaireAjouterEtudiant").submit(()=>{
                event.preventDefault()
                $("#btnEnregistrerEtudiant").text('Chargement...')

                $.ajax({
                    url: 'traitement/enregistrer_etudiant.php',
                    method: 'POST',
                    dataType: 'text',
                    data: $("#formulaireAjouterEtudiant").serialize(),
                    timeout: 8000,
                    error: (xhr,status, error)=>{
                        console.log(xhr)
                        console.log(status)
                        console.log(error)
                    },
                    success: (reponse_serveur)=>{
                        console.log(reponse_serveur)
                        if(reponse_serveur=="Success"){
                            Swal.fire({
                                title: "Opération réussie",
                                text: "Étudiant(e) ajouté(e)",
                                icon: "success"
                            });
                            $("#prenom").val('')
                            $("#nom").val('')
                            $("#postnom").val('')
                            $("#sexe").val('')
                            $("#etatcivil").val('')
                            $("#nationalite").val('')
                            $("#typeinscription").val('')
                            $("#adresse_physique").val('')
                            $("#date_naissance").val('')
                            $("#lieu_naissance").val('')
                            $("#telephone").val('')

                            recupererEtudiants()

                        }else if(reponse_serveur=="Champs"){
                            Swal.fire({
                                title: "Important",
                                text: "Veuillez saisir tous les champs",
                                icon: "error"
                            });
                        }else if(reponse_serveur=="Déjà"){
                            Swal.fire({
                                title: "Important",
                                text: "L'étudiant(e) existe déjà",
                                icon: "error"
                            });
                        }else{
                            console.log(reponse_serveur)
                        }
                        
                    },
                    complete: ()=>{
                        $("#btnEnregistrerEtudiant").text('Enregistrer')
                    }

                })

            })
        })
     </script>
</body>

</html>