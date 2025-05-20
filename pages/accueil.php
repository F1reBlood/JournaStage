<?php 
session_start();
include "../config/_config.php";
if (isset($_SESSION['login'])){
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../assets/styles/styles.css" />
    <script src="https://kit.fontawesome.com/b0d8e23d7e.js" crossorigin="anonymous" defer></script>
    <title>JournaStage - Accueil</title>
  </head>
  <body>
    <?php
    include_once "header-footer/header.php";
    ?>
    <main>
      <div class="content">
        <div class="main-content">
          <h1>Bonjour <?php echo $_SESSION['prenom']; ?> !</h1>
          <?php
          if ($_SESSION['type'] == 1){
            ?>
            <p class="description">
              Bienvenue sur JournaStage, votre carnet quotidien pour suivre votre expérience en entreprise.
            </p>
            <h2>Que souhaitez-vous faire ?</h2>
            <button class="large">
              <a href="newJournal.php" class="selection-item">
                <i class="fa-solid fa-add"></i>
                <p>Saisir un nouveau compte rendu</p>
              </a>
            </button>
            <button class="large">
              <a href="journalHistory.php" class="selection-item">
                <i class="fa-solid fa-newspaper"></i>
                <p>Consulter mes comptes rendus</p>
              </a>
            </button>
          <?php
          }
		  elseif($_SESSION['type'] == 2){
			?>
			<p class="description">
            Bienvenue sur JournaStage, votre espace dédié pour suivre et encadrer le parcours de vos élèves en
            entreprise.
          </p>
          <h2>Quelle classe souhaitez-vous suivre ?</h2>
          
				<?php 
				if($connexion = mysqli_connect($serveur, $user, $bdd_password, $BDD_name)){
				$requête = "Select journastage_classe.nom from journastage_classe join journastage_enseigner on
				journastage_classe.id_classe=journastage_enseigner.id_classe where id_professeur=$_SESSION[id]";
				$resultat = mysqli_query($connexion, $requête);
				if ($resultat) {
					while ($donnees = mysqli_fetch_assoc($resultat)) {
						?>
						<form method="post" action="professeur/studentList.php" class="button-perso">
							<input type="hidden" name="classe" value="<?php echo"$donnees[nom]" ?>">
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
			</p>
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

<?php
}
else{
  echo "La connexion est perdue, veuillez revenir à la <a href='index.php'>page d'index</a> pour vous reconnecter.";
}
