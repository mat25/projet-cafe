<?php
namespace App\Vue;
use App\Utilitaire\Vue_Composant;

class Vue_Mail_Confirme extends Vue_Composant
{
    private string $msg;
    public function __construct(string $msg)
    {
        $this->msg = $msg;
    }

    function donneTexte(): string
    {
        $str= "<H1>" . $this->msg ."</H1> ";

        return $str;
    }

}