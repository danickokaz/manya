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

            <!-- Modal -->
            <div class="modal fade" id="modalSalle" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Ajouter une salle de classe</h5>
                            <i class="fa fa-times btn-close" data-bs-dismiss="modal" aria-label="Close"
                                style="cursor: pointer;"></i>
                        </div>
                        <div class="modal-body">
                            <form id="formulaireAjouterSalle" method="post">
                                <div class="form-group">
                                    <label for="libelle_salle">Salle</label><span class="require">*</span>
                                    <input type="text" name="libelle_salle" name="libelle_salle" class="form-control"
                                        placeholder="Ex: A">
                                    <input type="hidden" name="id_ajouter_salle" id="id_ajouter_salle"
                                        class="form-control">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Annuler</button>
                                    <button type="submit" id="btnAjouterSalle"
                                        class="btn btn-primary">Enregistrer</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>


            <div class="modal fade" id="modalVoirSalle" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content modal-sm">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Liste de salles</h5>
                            <i class="fa fa-times btn-close" data-bs-dismiss="modal" aria-label="Close"
                                style="cursor: pointer;"></i>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div id="liste">

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <!-- partial -->
            <div class="main-panel">
                <div class="container">
                    <h3 class="mt-5 mb-5">Ajouter une classe</h3>
                    <form id="formulaireAjouterClasse" method="POST">
                        <div class="row d-flex align-items-center">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label" for="libelle">Libellé</label><span
                                        class="require">*</span>
                                    <input type="text" name="libelle" id="libelle" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4 d-flex">
                                <button class="btn btn-primary" id="btnEnregistrerClasse"
                                    type="submit">Enregistrer</button>
                            </div>
                        </div>






                        <!-- <button class="btn btn-info" id="btnAnnulerEnregistrement" type="reset">Annuler</button> -->


                    </form>
                </div>
                <div class="container">
                    <h3 class="mt-5 mb-5">Liste de toutes les classes</h3>

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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
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

            recupererClasses()

            function recupererClasses() {
                $.ajax({
                    url: 'traitement/tableau_classe.php',
                    method: 'POST',
                    dataType: 'html',
                    error: () => {
                        document.getElementById("tableau").innerHTML =
                            "<p>Erreur...Recharger la page <i class='fa fa-refresh'></i></p>";
                    },
                    timeout: 8000,
                    success: (reponse_serveur) => {
                        document.getElementById("tableau").innerHTML = reponse_serveur

                        new DataTable('#classes');



                    }
                })
            }

            function recupererSalles() {
                var id_salle = $("#id_ajouter_salle").val()
                $.ajax({
                    url: 'traitement/tableau_salle.php',
                    method: 'POST',
                    dataType: 'html',
                    date: {id_salle:id_salle},
                    error: () => {
                        document.getElementById("liste").innerHTML =
                            "<p>Erreur...Recharger la page <i class='fa fa-refresh'></i></p>";
                    },
                    timeout: 8000,
                    success: (reponse_serveur) => {
                        document.getElementById("liste").innerHTML = reponse_serveur
                        console.log(reponse_serveur)

                        $("#modalVoirSalle").modal('show')


                    }
                })
            }

            $("#formulaireAjouterClasse").submit(() => {
                event.preventDefault()
                $("#btnEnregistrerClasse").text('Chargement...')

                $.ajax({
                    url: 'traitement/enregistrer_classe.php',
                    method: 'POST',
                    dataType: 'text',
                    data: $("#formulaireAjouterClasse").serialize(),
                    timeout: 8000,
                    error: (xhr, status, error) => {
                        console.log(xhr)
                        console.log(status)
                        console.log(error)
                    },
                    success: (reponse_serveur) => {
                        console.log(reponse_serveur)
                        if (reponse_serveur == "Success") {
                            Swal.fire({
                                title: "Opération réussie",
                                text: "Classe ajoutée",
                                icon: "success"
                            });
                            $("#libelle").val('')


                            recupererClasses()

                        } else if (reponse_serveur == "Champs") {
                            Swal.fire({
                                title: "Important",
                                text: "Veuillez saisir tous les champs",
                                icon: "error"
                            });
                        } else if (reponse_serveur == "Déjà") {
                            Swal.fire({
                                title: "Important",
                                text: "L'étudiant(e) existe déjà",
                                icon: "error"
                            });
                        } else {
                            console.log(reponse_serveur)
                        }

                    },
                    complete: () => {
                        $("#btnEnregistrerClasse").text('Enregistrer')
                    }

                })

            })

            $("#formulaireAjouterSalle").submit(() => {
                event.preventDefault()
                $("#btnAjouterSalle").text('Chargement...')
                $.ajax({
                    url: 'traitement/enregistrer_salle.php',
                    method: 'POST',
                    dataType: 'text',
                    data: $("#formulaireAjouterSalle").serialize(),
                    timeout: 8000,
                    error: (xhr, status, error) => {
                        console.log(xhr)
                        console.log(status)
                        console.log(error)
                    },
                    success: (reponse_serveur) => {
                        console.log(reponse_serveur)
                        if (reponse_serveur == "Success") {
                            Swal.fire({
                                title: "Opération réussie",
                                text: "Salle ajoutée",
                                icon: "success"
                            });
                            $("#libelle_salle").val('')



                        } else if (reponse_serveur == "Champs") {
                            Swal.fire({
                                title: "Important",
                                text: "Veuillez renseigner la salle",
                                icon: "error"
                            });
                        } else if (reponse_serveur == "Déjà") {
                            Swal.fire({
                                title: "Important",
                                text: "La salle existe déjà",
                                icon: "error"
                            });
                        } else {
                            console.log(reponse_serveur)
                        }

                    },
                    complete: () => {
                        $("#btnAjouterSalle").text('Enregistrer')
                    }

                })
            })

            $(document).on('click', '.ajoutersalle', function () {
                event.preventDefault()
                var id = $(this).attr('id');
                $("#id_ajouter_salle").val(id)
                $("#modalSalle").modal('show')
            })


            $(document).on('click', '.voirsalle', function () {
                event.preventDefault()
                var id_classe = $(this).attr('id')
                $.ajax({
                    url: 'traitement/tableau_salle.php',
                    method: 'POST',
                    dataType: 'html',
                    data: {id_classe:id_classe},
                    error: () => {
                        document.getElementById("liste").innerHTML =
                            "<p>Erreur...Recharger la page <i class='fa fa-refresh'></i></p>";
                    },
                    timeout: 8000,
                    success: (reponse_serveur) => {
                        document.getElementById("liste").innerHTML = reponse_serveur
                        console.log(reponse_serveur)

                        $("#modalVoirSalle").modal('show')


                    }
                })

            })

            





        })
    </script>
</body>

</html>