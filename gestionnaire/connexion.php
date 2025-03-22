<?php
session_start();
require '../settings/db.php';
if(isset($_SESSION['jgm']) and !empty($_SESSION['jgm'])){
  $session_utilisateur = $_SESSION['jgm'];

  $req = database()->prepare("SELECT * FROM utilisateur WHERE token=?");
  $req->execute([$session_utilisateur]);

  if($req->rowCount()==1){
    header("location:accueil");
  }

}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Connexion MANYA</title>
  <!-- base:css -->
  <link rel="stylesheet" href="../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../vendors/feather/feather.css">
  <link rel="stylesheet" href="../vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../images/logo-eifi.png" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo text-center">
                <img src="../images/logo-eifi.png" alt="logo">
              </div>
              <h4>Bienvennue sur l'application MANYA</h4>
              <h6 class="font-weight-light">Connectez-vous pour continuer.</h6>
              <form method="POST" id="formulaireConnexion" class="pt-3">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="matricule" name="matricule" placeholder="Matricule">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="motdepasse" name="motdepasse" placeholder="Mot de passe">
                </div>
                <div class="mt-3">
                  <button type="submit" id="btnSubmit" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" href="../index.html">Se connecter</button>
                </div>
                <div class="text-center mt-2">
                  
                  <a href="#" class="text-center text-black">Mot de passe oublié?</a>
                </div>
                
                
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- base:js -->
  <script src="../vendors/base/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="../js/off-canvas.js"></script>
  <script src="../js/hoverable-collapse.js"></script>
  <script src="../js/template.js"></script>
  <!-- endinject -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    $(document).ready(function(){
      $("#formulaireConnexion").submit(function(){
        event.preventDefault()
        
        $.ajax({
          url: 'traitement/connexion.php',
          method: 'POST',
          dataType: 'text',
          data: $("#formulaireConnexion").serialize(),
          timeout: 8000,
          beforeSend: function(){
            $("#btnSubmit").text('Chargement...')
          },
          error: function(xhr,status,error){
            if(status=='timeout'){
              Swal.fire({
                title: "Erreur",
                text: "Le temps de la requête a expiré. Réessayez plus tard",
                icon: "error"
              });
            }else{
              console.log("Erreur"+ error)
            }
          },
          success: function(reponse){
            if(reponse=="Success"){
              location.href = "accueil"
            }else if(reponse=="Veuillez saisir tous les champs"){
              Swal.fire({
                title: "Important",
                text: "Veuillez saisir tous les champs",
                icon: "error"
              });
            }else if(reponse=="Incorrectes"){
              Swal.fire({
                title: "Important",
                text: "Informations incorrectes",
                icon: "error"
              });
            }
          },
          complete: function(){
            $("#btnSubmit").text('Se connecter')
          }

        })

      })
    })
  </script>
</body>

</html>
