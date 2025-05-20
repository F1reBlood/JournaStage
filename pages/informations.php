<?php
session_start();
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
    <header>
    <div class="content header-content">
        <div class="navlogo-container">
            <a href="accueil.php" class="navlogo">
            <img src="../assets/img/logo.png" alt="logo" />
            <span>JournaStage</span>
            </a>
            <p>|</p>

            <?php
            if ($_SESSION['type'] == 1){
            ?>
            <p>Espace étudiant</p>
            <?php
            }
            elseif($_SESSION['type'] == 2){
            ?>
            <p>Espace professeur</p>
            <?php
            }
            ?>

        </div>
        <nav>
            <a href="#" class="navlink active">Mes informations</a>
            <form action="../index.php" id="none" method="post" class="inlineform">
            <a><button type="submit" class="navlink" name="deconnexion" id="buttonNavNone">Déconnexion</button></a>
            </form>
        </nav>
    </div>
</header>
    <main>
      <div class="content">
        <div class="main-content">
          <h1>Mon profil</h1>
          <div class="profil-container">
            <div class="picture">
              <img src="../assets/img/student.png" alt="profil" />
            </div>
            <h2> <?php echo $_SESSION['nom'], " ", $_SESSION['prenom'] ?> </h2>
            <button class="medium">
              <a href="informationsEdit.php" class="selection-item center">
                <p>Éditer mes informations</p>
              </a>
            </button>
            <button class="medium">
              <a href="changePassword.php" class="selection-item center">
                <p>Changer mon mot de passe</p>
              </a>
            </button>
          </div>
          <a href="contact.html" class="link">Besoin d'aide ?</a>
        </div>
      </div>
    </main>
    <?php
    include_once "header-footer/footer.php";
    ?>
  </body>
</html>
