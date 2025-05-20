<?php
$role = $_POST['role'];
$nom = $_POST['name'];
$firstname = $_POST['firstname'];
$birthDate = $_POST['birthDate'];
$email = $_POST['email'];

$destinataire = 'journastage.adm@gmail.com';
$objet = 'Demande de création de compte';
$text = "role : '$role' nom : '$nom' prénom : '$firstname' date de naissance : '$birthDate' email : '$email'";
$header = "From: $email";


if (mail($destinataire, $objet, $text, $header)) {
    echo "Email envoyé avec succès. Vous recevrez un mail lorsque votre compte sera créé.";
} else {
    echo "Échec de l'envoi de l'email.";
}
?>