<?php

namespace App\tests;

use PHPUnit\Framework\TestCase;
use function App\Fonctions\CalculComplexiteMdp;

class fonctionsTest extends TestCase {
    /**
     * @test
     */
    public function CalculComplexiteMdp_SiMotDePasseEgalAubry_24() {
        $bits = CalculComplexiteMdp("aubry");
        $this->assertEquals($bits,24);
    }
    /**
     * @test
     */
    public function CalculComplexiteMdp_SiMotDePasseEgalGiroud_147() {
        $bits = CalculComplexiteMdp("Giroud-Président||2027");
        $this->assertEquals($bits,148);
    }
}