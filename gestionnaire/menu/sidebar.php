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
                <li class="nav-item"> <a class="nav-link" href="../pages/ui-features/typography.html">Archiver dossiers</a></li>
                <li class="nav-item"> <a class="nav-link" href="../pages/ui-features/typography.html">Affecter dans une classe</a></li>
                <li class="nav-item"> <a class="nav-link" href="../pages/ui-features/typography.html">Imprimer la carte</a></li>


              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pages/forms/basic_elements.html">
              <i class="icon-file menu-icon"></i>
              <span class="menu-title">Form elements</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../pages/charts/chartjs.html">
              <i class="icon-pie-graph menu-icon"></i>
              <span class="menu-title">Charts</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../pages/tables/basic-table.html">
              <i class="icon-command menu-icon"></i>
              <span class="menu-title">Tables</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../pages/icons/feather-icons.html">
              <i class="icon-help menu-icon"></i>
              <span class="menu-title">Icons</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
              <i class="icon-head menu-icon"></i>
              <span class="menu-title">User Pages</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="pages/samples/login.html"> Login </a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/samples/login-2.html"> Login 2 </a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/samples/register.html"> Register </a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/samples/register-2.html"> Register 2 </a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/samples/lock-screen.html"> Lockscreen </a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="docs/documentation.html">
              <i class="icon-book menu-icon"></i>
              <span class="menu-title">Documentation</span>
            </a>
          </li>
        </ul>
      </nav>