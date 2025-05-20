<?php
session_start();
include "../config/_config.php";

$dateCR = $_POST['dateCR'];
$titreCR = $_POST['titreCR'];
$contenuCR = $_POST['contenuCR'];
$idCR = $_POST['idCR'];
$erreur = "";

if ($_SESSION['type'] == 2)
{
    $id_eleve = $_SESSION['id_eleve'];
    $nom_eleve = $_SESSION['nom_eleve'];
    $prenom_eleve = $_SESSION['prenom_eleve'];
}


if (isset($_POST['confirmCR']))
{
  $titreCR = $_POST['title'];
  $contenuCR = $_POST['journal-content'];


  if ($dateCR != $_POST['date'])
  {
    $modif_dateCR = $_POST['date'];

    if($connexion = mysqli_connect($serveur, $user, $bdd_password, $BDD_name)){
      $requête = "SELECT id_compte_rendu FROM journastage_compte_rendu WHERE id_etudiant = $_SESSION[id] AND date = '$modif_dateCR'";
      $resultat = mysqli_query($connexion, $requête);
      if ($resultat) {
        while ($donnees = mysqli_fetch_assoc($resultat)) {
          $id_doublon = $donnees['id_compte_rendu'];
        }
      }
    }

    if (isset($id_doublon))
    {
      $erreur = "Un compte rendu existe déjà pour cette date.";
    }
    else
    {
      if ($connexion = mysqli_connect($serveur, $user, $bdd_password, $BDD_name))
      {
        $requête = "UPDATE journastage_compte_rendu SET titre='$titreCR', contenu='$contenuCR', date='$modif_dateCR' 
        WHERE id_compte_rendu='$idCR'";
        mysqli_query($connexion, $requête);
        mysqli_close($connexion);
      }
    }
  }
  else
  {
    $dateCR = $_POST['date'];
    if ($connexion = mysqli_connect($serveur, $user, $bdd_password, $BDD_name))
    {
      $requête = "UPDATE journastage_compte_rendu SET titre='$titreCR', contenu='$contenuCR', date='$dateCR' WHERE id_compte_rendu='$idCR'";
      mysqli_query($connexion, $requête);
      mysqli_close($connexion);
    }
  }





  if ($connexion = mysqli_connect($serveur, $user, $bdd_password, $BDD_name))
  {
    $requête = "UPDATE journastage_compte_rendu SET titre='$titreCR', contenu='$contenuCR', date='$dateCR' WHERE id_compte_rendu='$idCR'";
    mysqli_query($connexion, $requête);
    mysqli_close($connexion);
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
    <title>JournaStage - Compte rendu du <?php echo $dateCR; ?></title>
  </head>
  <body>
    <?php
    include_once "header-footer/header.php";
    ?>
    <main>
      <div class="content">
        <div class="main-content">
          <?php
          if (isset($_POST['confirmCR']) && $erreur == "")
          {
            ?>
            <div class="success">
              Le compte rendu a été créé avec succès.
            </div>
            <?php
          }
          elseif (isset($_POST['confirmCR']) && $erreur != "")
          {
            ?>
            <div class="erreur">
              <?php echo $erreur; ?>
            </div>
            <?php
          }
          ?>
          <div class="title-with-btn">
            <div class="spacer">
              <button class="medium-round">
                <a href="journalHistory.php"><i class="fa-solid fa-arrow-left"></i></a>
              </button>
            </div>
            <h1>Compte-rendu</h1>
            <div class="spacer"></div>
          </div>
          <?php
            if ($_SESSION['type'] == 1)
            {
              ?>
              
              <?php
            }
            elseif ($_SESSION['type'] == 2)
            {
              ?>
                <p class="description">
                Voici le compte-rendu de <i><?php echo "$nom_eleve $prenom_eleve"; ?></i> pour le 
                <i><?php echo "$dateCR"; ?></i>. Vous pouvez le consulter ci-dessous.
                </p>
              <?php
            }
          ?>
          
          <form action="consultJournal.php" method="post" class="newJournal">
            <div class="field-container">
              <label class="without-icon" for="title">Titre</label>
              <div class="textarea-container">
                <?php
                if (isset($_POST['editCR']))
                {
                  ?>
                  <textarea name="title" class="field xlarge" id="title" type="text" maxlength="200" required><?php echo "$titreCR"; ?></textarea
                  ><?php
                }
                else
                {
                  ?>
                  <textarea name="title" class="field xlarge" id="title" type="text" maxlength="200" readonly><?php echo "$titreCR"; ?></textarea
                  ><?php
                }
                ?>
                
              </div>
            </div>
            <div class="field-container">
              <label class="without-icon" for="date">Date</label>
              <?php
                if (isset($_POST['editCR']))
                {
                  ?>
                  <input name="date" class="field small" id="date" type="date" value='<?php echo $dateCR; ?>' required />
                  <?php
                }
                else
                {
                  ?>
                  <input name="date" class="field small" id="date" type="date" value='<?php echo $dateCR; ?>' readonly />
                  <?php
                }
                ?>
            </div>
            <div class="field-container">
              <label class="without-icon" for="journal-content">Contenu</label>
              <div class="textarea-container">
                <?php
                if (isset($_POST['editCR']))
                {
                  ?>
                  <textarea
                  name="journal-content"
                  class="field xxlarge"
                  id="journal-content"
                  type="text"
                  maxlength="2000"
                  required
                ><?php echo $contenuCR; ?></textarea><?php
                }
                else
                {
                  ?>
                  <textarea
                  name="journal-content"
                  class="field xxlarge"
                  id="journal-content"
                  type="text"
                  maxlength="2000"
                  readonly
                ><?php echo $contenuCR; ?></textarea><?php
                }
                ?>
              </div>
            </div>
            <input type="hidden" name="dateCR" value="<?php echo $dateCR; ?>">
            <input type="hidden" name="titreCR" value="<?php echo $titreCR; ?>">
            <input type="hidden" name="contenuCR" value="<?php echo $contenuCR; ?>">
            <input type="hidden" name="idCR" value="<?php echo $idCR; ?>">
            <?php
            if ($_SESSION['type'] == 1)
            {
              if (isset($_POST['editCR']))
              {
                ?>
                <button class="small" type="submit" name="confirmCR">
                <p>Confirmer</p>
                </button>
                <?php
              }
              else{
                ?>
                <button class="small" type="submit" name="editCR">
                <p>Modifier</p>
                </button>
                <?php
              }
            }
            ?>
          </form>

        </div>
      </div>
    </main>
    <?php
    include_once "header-footer/footer.php";
    ?>
  </body>
</html>
