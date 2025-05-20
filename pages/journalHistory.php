<?php
session_start();
include "../config/_config.php";
//connexion_prof
//connexion_eleve

if (isset($_POST['connexion_prof']))
{
    $_SESSION['nom_eleve'] = $_POST['nom_eleve'];
    $_SESSION['prenom_eleve'] = $_POST['prenom_eleve'];
    $_SESSION['id_eleve'] = $_POST['id_eleve'];
}
if ($_SESSION['type'] == 2)
{
    $id_eleve = $_SESSION['id_eleve'];
    $nom_eleve = $_SESSION['nom_eleve'];
    $prenom_eleve = $_SESSION['prenom_eleve'];
}


if (isset($_POST['deleteCR']))
{
    $idCR = $_POST['idCR'];

    if ($connexion = mysqli_connect($serveur, $user, $bdd_password, $BDD_name))
    {
        $requête = "DELETE FROM journastage_compte_rendu WHERE id_compte_rendu='$idCR'";
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
    
    <?php if ($_SESSION['type'] == 2)
    {
      ?>
      <title>JournaStage - Comptes rendus de <?php echo $nom_eleve; ?></title>
      <?php
    } 
    elseif ($_SESSION['type'] == 1)
    {
      ?>
      <title>JournaStage - Mes comptes rendus</title>
      <?php
    }
    ?>
  </head>
  <body>
    <?php
    include_once "header-footer/header.php";
    ?>
    <main>
      <div class="content">
        <div class="main-content">
          <?php
          if (isset($_POST['deleteCR']))
          {
            ?>
            <div class="success">
              <p>Le compte rendu a été supprimé avec succès.</p>
            </div>
            <?php
          }
          ?>
          <div class="title-with-btn">
            <div class="spacer">
              <button class="medium-round" name="classe">
                <?php if ($_SESSION['type'] == 2)
                {
                  ?>
                  <a href="professeur/studentList.php">
                  <?php
                } 
                elseif ($_SESSION['type'] == 1)
                {
                  ?>
                  <a href="accueil.php">
                  <?php
                }
                ?>
                <i class="fa-solid fa-arrow-left"></i></a>
              </button>
            </div>
              <?php if ($_SESSION['type'] == 2)
                { ?>
                  <h1> <?php echo "$nom_eleve $prenom_eleve"; ?> </h1>
                  <div class="spacer"></div>
                  </div>
                  <?php
                } 
                elseif ($_SESSION['type'] == 1)
                { ?>
                  <h1>Mes comptes rendus</h1>
                  <div class="spacer"></div>
                  </div>
                  <p class="description">
                    Voici l'historique de vos comptes rendus. Vous pouvez consulter, modifier ou supprimer vos comptes rendus en
                    cliquant sur les boutons correspondants.
                  </p>
                  <?php
                }
                ?>  
          <div class="journalItems">
                <?php
                if($connexion = mysqli_connect($serveur, $user, $bdd_password, $BDD_name)){
                    if ($_SESSION['type'] == 2)
                    {
                      $requête = "Select * from journastage_compte_rendu where id_etudiant=$id_eleve order by date desc";
                    }
                    elseif($_SESSION['type'] == 1)
                    {
                      $requête = "Select * from journastage_compte_rendu where id_etudiant=$_SESSION[id] order by date desc";
                    }
                    $resultat = mysqli_query($connexion, $requête);
                    if ($resultat) {
                        while ($donnees = mysqli_fetch_assoc($resultat)) {
                        ?>
                        <div class="journalItem">
                            <div class="date">
                                <p><?php echo $donnees['date']; ?></p>
                            </div>
                            <div class="title">
                                <p><?php echo $donnees['titre']; ?></p>
                                <div class="file"></div>
                            </div>

                            <div class="actions">
                                <form method="post" class="form-perso" action="consultJournal.php">
                                    <input type="hidden" name="dateCR" value="<?php echo $donnees['date']; ?>">
                                    <input type="hidden" name="titreCR" value="<?php echo $donnees['titre']; ?>">
                                    <input type="hidden" name="contenuCR" value="<?php echo $donnees['contenu']; ?>">
                                    <input type="hidden" name="idCR" value="<?php echo $donnees['id_compte_rendu']; ?>">

                                    <button class="small-round view" type="submit" name="consultCR">
                                    <i class="fa-solid fa-eye"></i></a>
                                    </button>
                                </form>
                                <?php
                                if ($_SESSION['type'] == 1){
                                  ?>
                                  <form method="post" class="form-perso" action="journalHistory.php">
                                    <input type="hidden" name="idCR" value="<?php echo $donnees['id_compte_rendu']; ?>">

                                    <button class="small-round delete" type="submit" name="deleteCR">
                                    <i class="fa-solid fa-trash"></i></a>
                                    </button>
                                  </form>
                                  <?php
                                }
                                ?>
                                
                            </div>
                        </div>
                        <?php
                        }
                        mysqli_close($connexion);
                    }
                }
                ?>
          </div>
        </div>
      </div>
    </main>
    <?php
    include_once "header-footer/footer.php";
    ?>
  </body>
</html>
