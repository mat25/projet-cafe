<?php


require_once "./vendor/autoload.php";

use App\Modele\Modele_Jeton;
use function App\Fonctions\genererToken;


$token = genererToken();
Modele_Jeton::Ajouter_jeton($token,19);

$jeton = Modele_Jeton::Jeton_Select_ParToken($token);

if(isset($jeton["valeur"])) {
    echo "Test Réussie";
} else {
    echo "Erreur !!!";
}

