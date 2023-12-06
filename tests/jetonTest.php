<?php


namespace App\tests;

use App\Modele\Modele_Jeton;
use PHPUnit\Framework\TestCase;
use function App\Fonctions\CalculComplexiteMdp;
use function App\Fonctions\genererToken;

class jetonTest extends TestCase {

    /**
     * @test
     */
    public function AjouterJeton_SiValeursCorrecte_JetonAjouter() {
        $token = genererToken();
        Modele_Jeton::Ajouter_jeton($token,19);

        $jeton = Modele_Jeton::Jeton_Select_ParToken($token);
        $this->assertEquals();
    }
}
