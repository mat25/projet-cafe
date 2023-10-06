<?php


use App\Modele\Modele_Commande;
use App\Vue\Vue_Connexion_Formulaire_client;
use App\Vue\Vue_Menu_Administration;
use App\Vue\Vue_Structure_BasDePage;
use App\Vue\Vue_Structure_Entete;

switch($action) {
    case "Se connecter":
        $Vue->setEntete(new Vue_Structure_Entete());
        $Vue->addToCorps(new \App\Vue\Vue_ConsentementRGPD($_SESSION["typeConnexionBack"]));
        break;
    case "AccepterRGPD":
        $Vue->setEntete(new Vue_Structure_Entete());
        \App\Modele\Modele_Utilisateur::utilisateur_modifier_rgpd($_SESSION["idUtilisateur"]);
        if ($typeConnexion == "utilisateurCafe") {
            $Vue->setMenu(new Vue_Menu_Administration($_SESSION["typeConnexionBack"]));
        } else {
            $quantiteMenu = Modele_Commande::Panier_Quantite($_SESSION["idEntreprise"]);
            $Vue->setMenu(new \App\Vue\Vue_Menu_Entreprise_Salarie($quantiteMenu));
        }
        break;
    case "SeDeconnecter":
        include "Controleur_Gerer_monCompte.php";
        break;
    default:
        break;
}

$Vue->setBasDePage(new Vue_Structure_BasDePage());

