<?php
include "../config/_config.php";
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../assets/styles/styles.css" />
    <script src="https://kit.fontawesome.com/b0d8e23d7e.js" crossorigin="anonymous" defer></script>
    <title>JournaStage - Contact</title>
  </head>
  <body>
    <header>
    <div class="content header-content">
        <div class="navlogo-container">
            <a href="accueil.php" class="navlogo">
            <img src="../assets/img/logo.png" alt="logo" />
            <span>JournaStage</span>
            </a>
        </div>
    </div>
</header>

    <main>
      <div class="content">
        <div class="main-content">
          

          <?php
          // Si on a cliqué sur "Envoyer" dans la page oubli de mot de passe : 
            if (isset($_POST['email'])){
              $email=$_POST['email'];
              if($connexion = mysqli_connect($serveur, $user, $bdd_password, $BDD_name)){
                $requete="Select * from journastage_utilisateur where email='$email'";
                $resultat = mysqli_query($connexion, $requete); 
                while($donnees = mysqli_fetch_assoc($resultat)){
                  $email_bdd = $donnees['email'];
                }
                // Si l'email est dans la BDD : on envoi le mail, on reset le mdp et on le hash 
                if ($email_bdd != null){
                  $new_mdp = rand(1000000000, 9999999999);
                  $new_mdp_hash = md5($new_mdp);
                  $mysqli = new mysqli($serveur, $user, $bdd_password, $BDD_name);
                  mysqli_query($mysqli, "update journastage_utilisateur set mot_de_passe='$new_mdp_hash' where email='$email';");
                  mail($email,"JournaStage - Mot de passe oublié", "Votre mot de passe a été réinitialisé.\n\n
                  Votre login : $email \n Votre nouveau mot de passe : $new_mdp ");
                  ?>
                <div class="title-with-btn">
                  <div class="spacer">
                    <button class="medium-round">
                      <a href="../index.php"><i class="fa-solid fa-arrow-left"></i></a>
                    </button>
                  </div>
                  <h1>Mot de passe oublié</h1>
                  <div class="spacer"></div>
                </div>
                <p class="description">
                  Votre mot de passe a été réinitialisé avec succès, vous pouvez consulter votre nouveau mot de passe dans votre boite mail : <?php echo $email; ?>
                </p>
                <?php
                }
                // Si l'email n'est pas dans la BDD : on affiche le msg "l'adresse mail n'est pas dans la bdd"
                else{
                  ?>
            <div class="title-with-btn">
              <div class="spacer">
                <button class="medium-round">
                  <a href="lostPassword.php"><i class="fa-solid fa-arrow-left"></i></a>
                </button>
              </div>
              <h1>Mot de passe oublié</h1>
              <div class="spacer"></div>
            </div>
                <p class="description">
                  L'adresse email <?php echo $email; ?> n'est pas enregistrée avec un compte existant
                </p>
                <?php
                }
              }

            ?>
            
          

          <?php
          }
          //Quand on arrive sur la page :
          else{
            ?>
          <div class="title-with-btn">
            <div class="spacer">
              <button class="medium-round">
                <a href="../index.php"><i class="fa-solid fa-arrow-left"></i></a>
              </button>
            </div>
            <h1>Mot de passe oublié</h1>
            <div class="spacer"></div>
          </div>
          <p class="description">
          Veuillez saisir votre adresse e-mail ci-dessous. Nous vous enverrons un lien pour réinitialiser votre mot de
          passe.
          </p>
          <form action="lostPassword.php" method="post" class="newJournal">
            <div class="field-container">
              <label class="without-icon" for="email">Adresse e-mail</label>
              <input
                name="email"
                class="field large"
                id="email"
                type="email"
                placeholder="Saisissez ici votre adresse e-mail"
                required
              />
            </div>
            <button class="medium" type="submit">Envoyer</button>
          </form>

    <?php } ?>

        </div>
      </div>
    </main>
    <?php
    include_once "header-footer/footer.php";
    ?>
  </body>
</html>