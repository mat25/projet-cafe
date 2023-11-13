<?php
require_once "vendor/autoload.php";
use App\Modele\Modele_Entreprise;
use App\Modele\Modele_Salarie;
use App\Modele\Modele_Utilisateur;
use App\Vue\Vue_Connexion_Formulaire_client;
use App\Vue\Vue_Mail_Confirme;
use App\Vue\Vue_Mail_ReinitMdp;
use App\Vue\Vue_Menu_Administration;
use App\Vue\Vue_Structure_BasDePage;
use App\Vue\Vue_Structure_Entete;


use PHPMailer\PHPMailer\PHPMailer;
//Ce contrôleur gère le formulaire de connexion pour les visiteurs
$Vue->setEntete(new Vue_Structure_Entete());

switch ($action) {
    case "reinitmdpconfirm":
       $utilisateurMail=$_REQUEST["email"];
       $newMdp=\App\Fonctions\passgen1(10);
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
            } else {
                $user=Modele_Utilisateur::Utilisateur_Select_ParLogin($utilisateurMail);
                $requete=Modele_Utilisateur::Utilisateur_Modifier_motDePasse($user["idUtilisateur"],$newMdp);
                $activation=Modele_Utilisateur::Utilisateur_Modifier_MdpAactiver($user["idUtilisateur"],1);

                $msg = 'Message envoyé ! Merci de nous avoir contactés.';
            }
        } else {
            $msg = "'il s'agirait de renseigner un bon email";
        }
        echo $msg;

        $Vue->addToCorps(new Vue_Mail_Confirme());

        break;
    case "reinitmdp":


        $Vue->addToCorps(new Vue_Mail_ReinitMdp());

        break;
    case "choixmdp":

        if ($_REQUEST["mdp1"]==$_REQUEST["mdp2"]) {

            $nbBits=App\Fonctions\CalculComplexiteMdp($_REQUEST["mdp2"]);
            if ($nbBits>90){
                Modele_Utilisateur::Utilisateur_Modifier_MdpDesactiver($_SESSION["idUtilisateur"],0);
                Modele_Utilisateur::Utilisateur_Modifier_motDePasse($_SESSION["idUtilisateur"],$_REQUEST["mdp1"]);
                $Vue->addToCorps(new Vue_Connexion_Formulaire_client());
            }else{
                $msg="Le mot de passe n'est pas assez complexe";
                $Vue->addToCorps(new \App\Vue\Vue_Mail_ChoisirNouveauMdp("",$msg));
            }
        }else{
            $msg="Mots de passe non identiques";
            $Vue->addToCorps(new \App\Vue\Vue_Mail_ChoisirNouveauMdp("",$msg));
        }
        break;
    case "Se connecter" :
        if (isset($_REQUEST["compte"]) and isset($_REQUEST["password"])) {
            //Si tous les paramètres du formulaire sont bons


            $utilisateur = Modele_Utilisateur::Utilisateur_Select_ParLogin($_REQUEST["compte"]);

            if ($utilisateur != null) {
                //error_log("utilisateur : " . $utilisateur["idUtilisateur"]);
                if ($utilisateur["desactiver"] == 0) {
                    if ($_REQUEST["password"] == $utilisateur["motDePasse"]) {
                        $_SESSION["idUtilisateur"] = $utilisateur["idUtilisateur"];
                        //error_log("idUtilisateur : " . $_SESSION["idUtilisateur"]);
                        $_SESSION["acceptationRGPD"]=$utilisateur["aAccepterRGPD"];
                        $_SESSION["idCategorie_utilisateur"] = $utilisateur["idCategorie_utilisateur"];
                        switch ($utilisateur["MdpAmodifier"]){
                            case 0:
                                //error_log("idCategorie_utilisateur : " . $_SESSION["idCategorie_utilisateur"]);
                                switch ($utilisateur["idCategorie_utilisateur"]) {
                                    case 1:
                                        $_SESSION["typeConnexionBack"] = "administrateurLogiciel"; //Champ inutile, mais bien pour voir ce qu'il se passe avec des étudiants !

                                        $Vue->setMenu(new Vue_Menu_Administration($_SESSION["typeConnexionBack"]));
                                        break;
                                    case 2:

                                        $_SESSION["typeConnexionBack"] = "utilisateurCafe";
                                        if ($_SESSION["acceptationRGPD"]==0){
                                            include "Controleur_Gestion_RGPD.php";
                                        }else{
                                            $Vue->setMenu(new Vue_Menu_Administration($_SESSION["typeConnexionBack"]));

                                        }
                                        break;
                                    case 3:
                                        $_SESSION["typeConnexionBack"] = "entrepriseCliente";
                                        //error_log("idUtilisateur : " . $_SESSION["idUtilisateur"]);
                                        $_SESSION["idEntreprise"] = Modele_Entreprise::Entreprise_Select_Par_IdUtilisateur($_SESSION["idUtilisateur"])["idEntreprise"];
                                        include "./Controleur/Controleur_Gerer_Entreprise.php";
                                        break;
                                    case 4:
                                        $_SESSION["typeConnexionBack"] = "salarieEntrepriseCliente";
                                        $_SESSION["idSalarie"] = $utilisateur["idUtilisateur"];
                                        $_SESSION["idEntreprise"] = Modele_Salarie::Salarie_Select_byId($_SESSION["idUtilisateur"])["idEntreprise"];
                                        if ($_SESSION["acceptationRGPD"]==0){
                                            include "Controleur_Gestion_RGPD.php";
                                        }else{
                                            include "./Controleur/Controleur_Catalogue_client.php";
                                        }

                                        break;
                                }
                                break;
                            case 1:
                                $Vue->addToCorps(new \App\Vue\Vue_Mail_ChoisirNouveauMdp("",""));
                                break;
                        }



                    } else {//mot de passe pas bon
                        $msgError = "Mot de passe erroné";

                        $Vue->addToCorps(new Vue_Connexion_Formulaire_client($msgError));

                    }
                } else {
                    $msgError = "Compte désactivé";

                    $Vue->addToCorps(new Vue_Connexion_Formulaire_client($msgError));

                }
            } else {
                $msgError = "Identification invalide";

                $Vue->addToCorps(new Vue_Connexion_Formulaire_client($msgError));
            }
        } else {
            $msgError = "Identification incomplete";

            $Vue->addToCorps(new Vue_Connexion_Formulaire_client($msgError));
        }
    break;
    default:

        $Vue->addToCorps(new Vue_Connexion_Formulaire_client());

        break;
}


$Vue->setBasDePage(new Vue_Structure_BasDePage());