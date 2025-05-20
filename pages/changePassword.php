<?php
session_start();
include "../config/_config.php";

if (isset($_POST['mdp_change'])){
    $old_mdp = md5($_POST['old_mdp']);
    $new_mdp = md5($_POST['new_mdp']);
    $conf_mdp = md5($_POST['conf_mdp']);
    $login = $_SESSION['login'];
    $password = $_SESSION['password'];

    $erreur = "";

    if($connexion = mysqli_connect($serveur, $user, $bdd_password, $BDD_name)){
        $requete="Select * from journastage_utilisateur where email='$login' and mot_de_passe='$password'";
        $resultat = mysqli_query($connexion, $requete);
    
        while($donnees = mysqli_fetch_assoc($resultat)){
            $old_mdp_bdd = $donnees['mot_de_passe'];

            mysqli_close($connexion);
        }
  
        if ($old_mdp != $old_mdp_bdd){
            $erreur = "old_mdp_wrong";
        }
        elseif ($new_mdp != $conf_mdp){
            $erreur = "mdp_diff";
        }
        elseif ($new_mdp == $old_mdp_bdd){
            $erreur = "mdp_existe_deja";
        }
        else{
            $erreur = "";
            $mysqli = new mysqli($serveur, $user, $bdd_password, $BDD_name);
            mysqli_query($mysqli, "update journastage_utilisateur set mot_de_passe='$new_mdp' where email='$login';");
            $_SESSION['password'] = $new_mdp;
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
    <link rel="stylesheet" href="../assets/styles/styles.css" />
    <script src="https://kit.fontawesome.com/b0d8e23d7e.js" crossorigin="anonymous" defer></script>
    <title>journastage - Mes informations</title>
  </head>
  <body>
    <?php
    include_once "header-footer/header.php";
    ?>
    <main>
      <div class="content">
        <div class="main-content">
          <h1>Changer mon mot de passe</h1>
          <div class="profil-container">
            <?php
            // Si on a changé le mdp sans erreur
            if (isset($_POST['mdp_change']) && $erreur==""){
                ?>
                <p class="description">
                  Votre mot de passe a été changé avec succès
                </p>
                <button class="small">
                    <a href="informations.php" class="selection-item center">
                    <p>Retour</p>
                    </a>
                </button>
                <?php
            }
            // Si on a pas changé de mot de passe ou qu'on a une erreur
            else{
                ?>

            <form action="#" method="post">
                
                <?php
                // Si l'erreur est que l'ancien mdp ne correspond pas
                if (isset($_POST['mdp_change']) && ($erreur == "old_mdp_wrong")){
                ?>
                    <div class="erreur">L'ancien mot de passe ne correspond pas</div>
                <?php
                }?>

                <div class="field-container">
                    <div class="field medium center">
                    <label class="with-icon" for="old_mdp"><i class="fa-solid fa-lock"></i></label>
                    <input name="old_mdp" id="old_mdp" type="password" placeholder="Ancien mot de passe" required />
                    </div>
                </div>
                <br>

                <?php
                // Si l'erreur est que le mdp et le mdp de confirmation sont différents
                if (isset($_POST['mdp_change']) && ($erreur == "mdp_diff")){
                ?>
                    <div class="erreur">Les mots de passes sont différents</div>
                <?php
                }
                // Si l'erreur est que le mdp changé existe déjà (= l'ancien mot de passe)
                elseif (isset($_POST['mdp_change']) && ($erreur == "mdp_existe_deja")){
                ?>
                    <div class="erreur">Le mot de passe existe déjà</div>
                <?php
                }?>

                <div class="field-container">
                    <div class="field medium center">
                    <label class="with-icon" for="new_mdp"><i class="fa-solid fa-lock"></i></label>
                    <input name="new_mdp" id="new_mdp" type="password" placeholder="Nouveau mot de passe" required />
                    </div>
                </div>
                <div class="field-container">
                    <div class="field medium center">
                    <label class="with-icon" for="conf_mdp"><i class="fa-solid fa-lock"></i></label>
                    <input name="conf_mdp" id="conf_mdp" type="password" placeholder="Confirmer mot de passe" required />
                    </div>
                </div>
                
                
                <button class="small" type="submit" name="mdp_change">Confirmer</button>
            </form>
            <?php
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
