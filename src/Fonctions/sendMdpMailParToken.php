<?php
namespace App\Fonctions;
require_once "vendor/autoload.php";
use App\Modele\Modele_Utilisateur;
use PHPMailer\PHPMailer\PHPMailer;

function sendMdpMailToken($token)
{
    $mail = $_REQUEST["email"];
    $utilisateurMail=$mail;
    $mail= new PHPMailer;
    $mail->isSMTP();
    $mail->CharSet = "UTF-8";
    $mail->Host = '127.0.0.1';
    $mail->Port = 1025; //Port non crypté
    $mail->SMTPAuth = false; //Pas d’authentification
    $mail->SMTPAutoTLS = false; //Pas de certificat TLS
    $mail->setFrom('test@labruleriecomtoise.fr', 'admin');
    $mail->addAddress($utilisateurMail, 'client');
    if ($mail->addReplyTo('test@labruleriecomtoise.fr', 'admin')) {
        $mail->Subject = 'Réinitialisation mot de passe';
        $mail->isHTML(true);
        $mail->Body = "Bonjour, Le lien de rénitialisation est :  <a href='http://localhost:8080/index.php?action=token&token=$token'>Lien</a>";

        if (!$mail->send()) {
            $msg = 'Désolé, quelque chose a mal tourné. Veuillez réessayer plus tard.';
            return false;
        } else {
            $user=Modele_Utilisateur::Utilisateur_Select_ParLogin($utilisateurMail);
            $activation=Modele_Utilisateur::Utilisateur_Modifier_MdpAactiver($user["idUtilisateur"],1);
            \App\Modele\Modele_Jeton::Ajouter_jeton($token,$user["idUtilisateur"]);
            $_SESSION["token"] = $token;
            $_SESSION["idUtilisateur"] = $user["idUtilisateur"];
            $msg = 'Message envoyé ! Merci de nous avoir contactés.';
            return true;
        }
    } else {
        $msg = "il s'agirait de renseigner un bon email";
        return false;
    }

}