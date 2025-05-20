<?php
if (isset($_POST['deconnexion'])){
  session_start();
  session_destroy();
}
//Quand on appuie "se connecter", on regarde si le couple mdp/log est dans la bdd, si oui on envoie sur
//la page d'accueil avec les bonnes infos, sinon on reste sur cette page et on met un message mdp incorrect
if (isset($_POST['validation'])){
  include "config/_config.php";

  $login = $_POST['login'];
  $password = $_POST['password'];
  $password = md5($password);
  
  if($connexion = mysqli_connect($serveur, $user, $bdd_password, $BDD_name)){
      $requete="Select * from journastage_utilisateur where email='$login' and mot_de_passe='$password'";
      $resultat = mysqli_query($connexion, $requete);
      session_start();
  
      while($donnees = mysqli_fetch_assoc($resultat)){
          $_SESSION['id'] = $donnees['id_utilisateur'];
          $_SESSION['login']= $donnees['email'];
          $_SESSION['password'] = $donnees['mot_de_passe'];
          $_SESSION['type'] = $donnees['type'];
          $_SESSION['prenom'] = $donnees['prenom'];
          $_SESSION['nom'] = $donnees['nom'];
          $_SESSION['date_naissance'] = $donnees['date_naissance'];
  
  
          $erreur="";
          mysqli_close($connexion);

          ?><form action='pages/accueil.php' id="accueil"></form>
          <script type='text/javascript'>
          document.getElementById('accueil').submit();
          </script>
          <?php
      }



  
  }
  else{
     echo 'Erreur de connexion à la base de données';
  }

}

?>
  <!DOCTYPE html>
  <html lang="fr">
    <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <link rel="stylesheet" href="assets/styles/styles.css" />
      <script src="https://kit.fontawesome.com/b0d8e23d7e.js" crossorigin="anonymous" defer></script>
      <title>JournaStage - Connexion</title>
    </head>
    <body>
      <header>
        <div class="content header-content">
          <a href="#" class="navlogo">
            <img src="assets/img/logo.png" alt="logo" />
            <span>JournaStage</span>
          </a>
          <nav>
            <a href="pages/accountRequest.html" class="navlink">Vous n'avez pas de compte ?</a>
          </nav>
        </div>
      </header>
      <main>
        <div class="content">
          <div class="main-content">
            <h1>Bienvenue !</h1>
            <h2>Veuillez vous connecter</h2>
  
            <form action="#" method="post" class="login">
            <?php
              if (isset($_POST['validation'])){
                ?>
                <div class="erreur">Le mot de passe ou le login est incorrect</div>
                <?php
              }            
              ?>
  
              <div class="field-container">
                <div class="field medium center">
                  <label class="with-icon" for="login"><i class="fa-solid fa-user"></i></label>
                  <input name="login" id="login" type="text" placeholder="Nom d'utilisateur" required />
                </div>
              </div>
              <div class="field-container">
                <div class="field medium center">
                  <label class="with-icon" for="password"><i class="fa-solid fa-lock"></i></label>
                  <input name="password" id="password" type="password" placeholder="Mot de passe" required />
                </div>
              </div>
              <a href="pages/lostPassword.php" class="link">Mot de passe oublié ?</a>
              <button class="medium" type="submit" name="validation">Se connecter</button>
            </form>
  
          </div>
        </div>
      </main>
      <footer>
        <div class="content footer-content">
          <p>JournaStage © 2025. Tous droits réservés.</p>
          <p><a href="pages/contact.php">Besoin d'aide ?</a></p>
        </div>
      </footer>
    </body>
  </html>
<?php
