<?php
namespace App\Fonctions;
    function Redirect_Self_URL():void{
        unset($_REQUEST);
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    }

function GenereMDP($nbChar) :string{

    return "secret";
}

function CalculComplexiteMdp($mdp) :int{
        $alphabetMin = "azertyuiopqsdfghjklmwxcvbn";
        $alphabetMaj = strtoupper($alphabetMin);
        $chiffre = "0123456789";
        $caractereSpeciaux1 = "!#$*%?";
        $caractereSpeciaux2 = "&[|]@^µ§:/;.,<>°²³";

        $boolMin = false;
        $boolMaj = false;
        $boolChiffre = false;
        $boolcaractereSpeciaux1 = false;
        $boolcaractereSpeciaux2 = false;

        $n = 0;
        foreach (str_split($mdp) as $lettre) {
            if (!$boolMin) {
                if (str_contains($alphabetMin, $lettre)){
                    $boolMin =true;
                    $n += strlen($alphabetMin);
                }
            }
            if (!$boolMaj) {
                if (str_contains($alphabetMaj, $lettre)){
                    $boolMaj =true;
                    $n += strlen($alphabetMaj);
                }
            }
            if (!$boolChiffre) {
                if (str_contains($chiffre, $lettre)){
                    $boolChiffre =true;
                    $n += strlen($chiffre);
                }
            }
            if (!$boolcaractereSpeciaux1) {
                if (str_contains($caractereSpeciaux1, $lettre)){
                    $boolcaractereSpeciaux1 =true;
                    $n += strlen($caractereSpeciaux1);
                }
            }
            if (!$boolcaractereSpeciaux2) {
                if (str_contains($caractereSpeciaux2, $lettre)){
                    $boolcaractereSpeciaux2 =true;
                    $n += strlen($caractereSpeciaux2);
                }
            }
        }
    $l = strlen($mdp);
    $numBinaire = log($n**$l)/log(2);

    return $numBinaire + 1;
}


function passgen1 ($nbChar)
{
    $chaine = "ABCDEFGHIJKLMONOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789&é\"'(-è_çà)=$^*ù!:;,~#{[|`\^@]}¤€";
    $pass = '';
    for ($i = 0; $i < $nbChar; $i++) {
        $pass .= $chaine[random_int(0,strlen($chaine)-1)];
    }
    return $pass;
}


function genererToken() : string {
    $octetsAleatoires = openssl_random_pseudo_bytes (256) ;
    $jeton = sodium_bin2base64($octetsAleatoires, SODIUM_BASE64_VARIANT_ORIGINAL);
    return $jeton;
}



