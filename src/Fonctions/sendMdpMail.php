<?php
require_once "vendor/autoload.php";
use App\Modele\Modele_Utilisateur;
use PHPMailer\PHPMailer\PHPMailer;
use function App\Fonctions\passgen1;

function sendMdpMail(string $mail)
{
    $utilisateurMail=$mail;
    $newMdp=passgen1(10);
    $mail= new PHPMailer;
    $mail->isSMTP();
    $mail->Host = '127.0.0.1';
    $mail->Port = 1025; //Port non crypté
    $mail->SMTPAuth = false; //Pas d’authentification
    $mail->SMTPAutoTLS = false; //Pas de certificat TLS
    $mail->setFrom('test@labruleriecomtoise.fr', 'admin');
    $mail->addAddress($utilisateurMail, 'client');
    if ($mail->addReplyTo('test@labruleriecomtoise.fr', 'admin')) {
        $mail->Subject = 'Réinitialisation mot de passe';
        $mail->isHTML(false);
        $mail->Body = "Bonjour, suite à votre demande de réinitialisation de mot de passe nous vous adressons ci-dessous un lien de réinitialisation de mot de passe: ".$newMdp;

        if (!$mail->send()) {
            $msg = 'Désolé, quelque chose a mal tourné. Veuillez réessayer plus tard.';
            return false;
        } else {
            $user=Modele_Utilisateur::Utilisateur_Select_ParLogin($utilisateurMail);
            $requete=Modele_Utilisateur::Utilisateur_Modifier_motDePasse($user["idUtilisateur"],$newMdp);
            $activation=Modele_Utilisateur::Utilisateur_Modifier_MdpAactiver($user["idUtilisateur"],1);
            $msg = 'Message envoyé ! Merci de nous avoir contactés.';
            return true;
        }
    } else {
        $msg = "il s'agirait de renseigner un bon email";
        return false;
    }

}