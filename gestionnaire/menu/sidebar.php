<?php 
session_start();

if(isset($_SESSION['jgm']) and !empty($_SESSION['jgm'])){
    $session_utilisateur = $_SESSION['jgm'];

    $req = database()->prepare("SELECT u.id, u.pseudo,u.matricule,u.token,u.image_profile,roles.libelle_role FROM utilisateur as u INNER JOIN roles ON roles.id = u.id_role WHERE u.token=?");
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


<nav class="sidebar sidebar-offcanvas" id="sidebar">
        <div class="user-profile">
          <div class="user-image">
            <img src="../images/<?= $data->image_profile ?>">
          </div>
          <div class="user-name">
              <?= $data->pseudo ?>
          </div>
          <div class="user-designation">
              <?= $data->libelle_role ?>
          </div>
        </div>
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="accueil">
              <i class="fa fa-home menu-icon"></i>
              <span class="menu-title">Accueil</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#identification" aria-expanded="false" aria-controls="identification">
              
              <i class="fa-solid fa-user menu-icon"></i>
              <span class="menu-title">Identification</span>
              <i class="fa fa-arrow-circle-o-right"></i>
            </a>
            <div class="collapse" id="identification">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="enregistreretudiant">Enregistrer & modifier étudiant</a></li>
                <li class="nav-item"> <a class="nav-link" href="valideretudiant">Valider étudiant</a></li>
                <li class="nav-item"> <a class="nav-link" href="capture">Capturer étudiant</a></li>
                <li class="nav-item"> <a class="nav-link" href="archiverdossier">Archiver dossiers</a></li>
                <li class="nav-item"> <a class="nav-link" href="affecteretudiant">Affecter dans une classe</a></li>
                <li class="nav-item"> <a class="nav-link" href="../pages/ui-features/typography.html">Imprimer la carte</a></li>


              </ul>
            </div>
          </li>


          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#payement_frais" aria-expanded="false" aria-controls="payement_frais">
              
            <i class="fa-solid fa-money-bill-1-wave menu-icon"></i>
            <span class="menu-title">Paiment </span>
              <i class="fa fa-arrow-circle-o-right"></i>
            </a>
            <div class="collapse" id="payement_frais">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="fraisinscription">Frais d'inscription</a></li>
                <li class="nav-item"> <a class="nav-link" href="premierertranche">Première tranche</a></li>
                <li class="nav-item"> <a class="nav-link" href="deuxiemetranche">Deuxième tranche</a></li>
                <li class="nav-item"> <a class="nav-link" href="troisiemetranche">Troisième tranche</a></li>
                <li class="nav-item"> <a class="nav-link" href="enrolementpremiersemestre">Enrôlement premier semestre</a></li>
                <li class="nav-item"> <a class="nav-link" href="enrolementdeuxiemesemestre">Enrôlement deuxième semestre</a></li>
                <li class="nav-item"> <a class="nav-link" href="enrolementrattrapage">Enrôlement rattrapage</a></li>
                <li class="nav-item"> <a class="nav-link" href="paiementdettes">Paiement dettes</a></li>
                <li class="nav-item"> <a class="nav-link" href="reinscription">Paiement réinscription</a></li>



              </ul>
            </div>
          </li>
          
         
          
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
              <i class="fa fa-cogs menu-icon"></i>
              <span class="menu-title">Parametrage</span>
            </a>
            <div class="collapse" id="auth">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="ajouterclasse"> Ajouter classe </a></li>
                <li class="nav-item"> <a class="nav-link" href="ajouterenseignant">Ajouter enseignant </a></li>
                
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="deconnexion">
            <i class="fa-solid fa-right-from-bracket menu-icon"></i>
            <span class="menu-title">Deconnexion</span>
            </a>
          </li>
        </ul>
      </nav>