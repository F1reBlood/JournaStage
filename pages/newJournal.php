<?php
session_start();
include "../config/_config.php";

if (isset($_POST["CR_submit"])){
    $title = $_POST['title'];
    $date = $_POST['date'];
    $content = $_POST['journal-content'];
    $erreur = "";

    if($connexion = mysqli_connect($serveur, $user, $bdd_password, $BDD_name)){
      $requête = "SELECT id_compte_rendu FROM journastage_compte_rendu WHERE id_etudiant = $_SESSION[id] AND date = '$date'";
      $resultat = mysqli_query($connexion, $requête);
      if ($resultat) {
        while ($donnees = mysqli_fetch_assoc($resultat)) {
          $id_doublon = $donnees['id_compte_rendu'];
        }
      }
    }
    if (isset($id_doublon)){
      $erreur = "Un compte rendu existe déjà pour cette date.";
    }
    else{
      // Enregistrement du compte rendu dans la base de données
      if($connexion = mysqli_connect($serveur, $user, $bdd_password, $BDD_name)){
          $requête = "INSERT INTO journastage_compte_rendu (titre, contenu, date, id_etudiant) 
          VALUES ('$title', '$content', '$date', $_SESSION[id])";
          mysqli_query($connexion, $requête);
          mysqli_close($connexion);
      }
    }
    
}

?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../assets/styles/styles.css" />
    <script src="https://kit.fontawesome.com/b0d8e23d7e.js" crossorigin="anonymous" defer></script>
    <title>JournaStage - Nouveau compte rendu</title>
  </head>
  <body>
    <?php
    include_once "header-footer/header.php";
    ?>
    <main>
      <div class="content">
        <div class="main-content">
              <?php
              if (isset($_POST["CR_submit"]) && $erreur == ""){
                echo "<p class='success'>Le compte rendu a été créé avec succès !</p>";
              }
              elseif (isset($_POST["CR_submit"]) && $erreur != ""){
                echo "<p class='erreur'>$erreur</p>";
              }
              ?>
          <div class="title-with-btn">
            <div class="spacer">
              <button class="medium-round">
                <a href="accueil.php"><i class="fa-solid fa-arrow-left"></i></a>
              </button>
            </div>
            <h1>Saisir un nouveau compte rendu</h1>
            <div class="spacer"></div>
          </div>
          <p class="description">Veuillez remplir le formulaire ci-dessous pour créer un nouveau compte rendu.</p>
          <form action="newJournal.php" method="post" class="newJournal">
            <div class="field-container">
              <label class="without-icon" for="title">Titre</label>
              <div class="textarea-container">
                <textarea
                  name="title"
                  class="field xlarge no-return"
                  id="title"
                  type="text"
                  maxlength="200"
                  placeholder="Saisissez ici votre texte (200 caractères maximum)"
                  required
                ></textarea>
              </div>
            </div>
            <div class="field-container">
              <label class="without-icon" for="date">Date</label>
              <input name="date" class="field small" id="date" type="date" value="<?php echo date('Y-m-d'); ?>" required />
            </div>
            <div class="field-container">
              <label class="without-icon" for="journal-content">Contenu</label>
              <div class="textarea-container">
                <textarea
                  name="journal-content"
                  class="field xxlarge"
                  id="journal-content"
                  type="text"
                  placeholder="Saisissez ici votre texte (2000 caractères maximum)"
                  maxlength="2000"
                  required
                ></textarea>
              </div>
            </div>
            <button class="medium" type="submit" name="CR_submit">Créer le compte rendu</button>
          </form>
        </div>
      </div>
    </main>
    <?php
    include_once "header-footer/footer.php";
    ?>
  </body>
</html>
