<?php
session_start();
include "../../config/_config.php";
if (isset($_POST['classe']) || isset($_SESSION['classe'])) {
    if (isset($_POST['classe']))
    {
        $classe = $_POST['classe'];
        $_SESSION['classe'] = $classe;
    }
    elseif (isset($_SESSION['classe']))
    {
        $classe = $_SESSION['classe'];
    }
    

?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../../assets/styles/styles.css" />
    <script src="https://kit.fontawesome.com/b0d8e23d7e.js" crossorigin="anonymous" defer></script>
    <title>JournaStage - Classe</title>
  </head>
  <body>
    <header>
      <div class="content header-content">
        <div class="navlogo-container">
          <a href="home.html" class="navlogo">
            <img src="../../assets/img/logo.png" alt="logo" />
            <span>JournaStage</span>
          </a>
          <p>|</p>
          <p>Espace professeur</p>
        </div>
        <nav>
          <a href="../informations.php" class="navlink">Mes informations</a>
          <form action="../.." id="none" method="post" class="inlineform">
          <a><button type="submit" class="navlink" name="deconnexion" id="buttonNavNone">Déconnexion</button></a>
          </form>
        </nav>
      </div>
    </header>
    <main>
      <div class="content">
        <div class="main-content">
          <div class="title-with-btn">
            <div class="spacer">
              <button class="medium-round">
                <a href="../accueil.php"><i class="fa-solid fa-arrow-left"></i></a>
              </button>
            </div>
            <h1><?php echo "$classe" ?></h1>
            <div class="spacer"></div>
          </div>
          <p class="description">
            Voici la liste des étudiants de la classe <i><?php echo "$classe" ?></i>. Sélectionnez un étudiant pour
            consulter ses comptes-rendus.
          </p>
          <h2>Quel étudiant souhaitez-vous consulter ?</h2>

          <?php
          if($connexion = mysqli_connect($serveur, $user, $bdd_password, $BDD_name)){
            $requête = "Select journastage_utilisateur.nom, journastage_utilisateur.prenom, journastage_utilisateur.id_utilisateur
            from journastage_utilisateur where type=1 and id_classe=(Select id_classe from journastage_classe where nom='$classe')";
            $resultat = mysqli_query($connexion, $requête);
            if ($resultat) {
                while ($donnees = mysqli_fetch_assoc($resultat)) {
                ?>
                <form method="post" action="../journalHistory.php" class="button-perso">
                    <input type="hidden" name="id_eleve" value="<?php echo"$donnees[id_utilisateur]" ?>">
                    <input type="hidden" name="prenom_eleve" value="<?php echo"$donnees[prenom]" ?>">
                    <input type="hidden" name="nom_eleve" value="<?php echo"$donnees[nom]" ?>">
                    <input type="hidden" name="connexion_prof" value="1">
                    <button class='medium button-perso' type="submit">
                        <i class='fa-solid fa-book'></i>
                        <p> <?php echo"$donnees[nom]" ?> </p>
                    </button>
                </form>
                <?php
                }
                mysqli_close($connexion);
			      }
          }
          ?>
        </div>
      </div>
    </main>
    <footer>
      <div class="content footer-content">
        <p>JournaStage © 2025. Tous droits réservés.</p>
        <p><a href="../contact.html">Besoin d'aide ?</a></p>
      </div>
    </footer>
  </body>
</html>
<?php
}
?>


