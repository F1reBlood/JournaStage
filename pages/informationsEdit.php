<?php
session_start();
include "../config/_config.php";

if (isset($_POST['infos_change'])){
  $new_nom = $_POST['modif_nom'];
  $new_prenom = $_POST['modif_prenom'];
  $new_login = $_POST['modif_email'];
  $new_dateN = $_POST['modif_dateN'];
  $login = $_SESSION['login'];
  $password = $_SESSION['password'];

  $mysqli = new mysqli($serveur, $user, $bdd_password, $BDD_name);
  mysqli_query($mysqli, "update journastage_utilisateur set nom='$new_nom', prenom='$new_prenom', 
  email='$new_login', date_naissance='$new_dateN' where email='$login' and mot_de_passe='$password';");
}

?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../assets/styles/styles.css" />
    <script src="https://kit.fontawesome.com/b0d8e23d7e.js" crossorigin="anonymous" defer></script>
    <title>JournaStage - Mes informations</title>
  </head>
  <body>
    <?php
    include_once "header-footer/header.php";
    ?>
    <main>
      <div class="content">
        <div class="main-content">
            <h1>Éditer mes informations</h1>
            <?php
            if (isset($_POST['infos_change'])){
              ?>
              <p class="description">
                  Vos informations ont été modifiées avec succès
              </p>
              <?php
            }
            else{
            ?>
            <form action="#" method="post">

                <div class="field-container">
                    <div class="field medium center">
                    <label class="with-icon" for="modif_nom"><i class="fa-solid fa-user"></i></label>
                    <input name="modif_nom" id="modif_nom" type="text" value="<?php echo $_SESSION['nom'] ?>" placeholder="Nom" required />
                    </div>
                </div>
                <div class="field-container">
                    <div class="field medium center">
                    <label class="with-icon" for="modif_prenom"><i class="fa-solid fa-user"></i></label>
                    <input name="modif_prenom" id="modif_prenom" type="text" value="<?php echo $_SESSION['prenom'] ?>" placeholder="Prénom" required />
                    </div>
                </div>
                <div class="field-container">
                    <div class="field medium center">
                    <label class="with-icon" for="modif_email"><i class="fa-solid fa-user"></i></label>
                    <input name="modif_email" id="modif_email" type="text" value="<?php echo $_SESSION['login'] ?>" placeholder="email/login" required />
                    </div>
                </div>
                <div class="field-container">
                    <div class="field medium center">
                    <label class="with-icon" for="modif_dateN"><i class="fa-solid fa-user"></i></label>
                    <input name="modif_dateN" id="modif_dateN" type="date" value="<?php echo $_SESSION['date_naissance'] ?>" required />
                    </div>
                </div>
                

                <button class="small" type="submit" name="infos_change">Modifier</button>
            </form>
            <?php
            }
            ?>
        </div>
      </div>
    </main>
    <?php
    include_once "header-footer/footer.php";
    ?>
  </body>
</html>
