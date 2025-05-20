<?php
if (isset($_POST['send_mail']))
{
  $erreur = "";
  $name = $_POST['name'];
  $firstname = $_POST['firstname'];
  $email = $_POST['email'];
  $title = $_POST['title'];
  $content = $_POST['journal-content'];
  $to = "journastage.adm@gmail.com";
  $subject = "Contact de $firstname $name";
  $message = "Nom : $name\nPrénom : $firstname\nEmail : $email\nObjet : $title\nContenu : $content";
  $headers = "From: $email\r\n";

  if (mail($to, $subject, $message, $headers))
  {
    $erreur = "";
  } 
  else 
  {
    $erreur = "Une erreur s'est produite lors de l'envoi de l'e-mail.";
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
    <title>JournaStage - Contact</title>
  </head>
  <body>
    <header>
      <div class="content header-content">
        <div class="navlogo-container">
          <a href=".." class="navlogo">
            <img src="../assets/img/logo.png" alt="logo" />
            <span>JournaStage</span>
          </a>
        </div>
        <nav></nav>
      </div>
    </header>
    <main>
      <div class="content">
        <div class="main-content">
          <?php
          if (isset($_POST['send_mail']) && $erreur == "")
          {
            ?>
            <div class="success">Votre message a été envoyé avec succès !</div>
            <?php
          }
          elseif (isset($_POST['send_mail']) && $erreur != "")
          {
            ?>
            <div class="erreur"><?php echo "$erreur"; ?></div>
            <?php
          }
          ?>
          <h1>Formulaire de contact</h1>
          <p class="description">
            Veuillez remplir le formulaire ci-dessous pour nous contacter. Nous vous répondrons dans les plus brefs
            délais.
          </p>
          <form action="contact.php" method="post" class="newJournal">
            <div class="field-container">
              <label class="without-icon" for="name">Nom</label>
              <input
                name="name"
                class="field large"
                id="name"
                type="text"
                placeholder="Saisissez ici votre nom"
                required
              />
            </div>
            <div class="field-container">
              <label class="without-icon" for="firstname">Prénom</label>
              <input
                name="firstname"
                class="field large"
                id="firstname"
                type="text"
                placeholder="Saisissez ici votre nom"
                required
              />
            </div>
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
            <div class="field-container">
              <label class="without-icon" for="title">Objet</label>
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
            <button class="medium" type="submit" name="send_mail">Envoyer le message</button>
          </form>
        </div>
      </div>
    </main>
    <?php
    include_once "header-footer/footer.php";
    ?>
  </body>
</html>
