<?php
namespace App\Vue;
use App\Utilitaire\Vue_Composant;
use function App\Fonctions\genereChampHiddenCSRF;
use function App\Fonctions\genereVarHrefCSRF;
class Vue_Menu_Entreprise_Salarie  extends Vue_Composant
{
    private int $quantiteMenu=0;

    public function __construct(int $quantiteMenu)
    {
        $this->quantiteMenu=$quantiteMenu;
    }

    function donneTexte(): string
    {

        $str="
<nav id='menu'>
  <ul id='menu-closed'>  
    <li><a href='?case=Gerer_catalogue".genereVarHrefCSRF()."'>Catalogue</a></li> 
    <li><a href='?case=Gerer_MonCompte_Salarie".genereVarHrefCSRF()."'>Mon compte</a></li> 
    <li><a href='?case=Gerer_Panier".genereVarHrefCSRF()."'>Panier";
        if ($this->quantiteMenu > 0) {
            $str .= " ($this->quantiteMenu) ";
        }
        $str .= "</a></li>
    <li><a href='?case=Gerer_CommandeClient".genereVarHrefCSRF()."'>Mes commandes</a></li> 
  </ul>
</nav> ";

        return $str;
    }

}