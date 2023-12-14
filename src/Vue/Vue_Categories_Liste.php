<?php
namespace App\Vue;
use App\Utilitaire\Vue_Composant;
use function App\Fonctions\genereChampHiddenCSRF;
use function App\Fonctions\genereVarHrefCSRF;
class Vue_Categories_Liste extends Vue_Composant
{
    private array $listeCategorie;
    private bool $utilisateur=true;
    public function __construct(array $listeCategorie, bool $utilisateur=true)
    {
        $this->listeCategorie=$listeCategorie;
        $this->utilisateur=$utilisateur;
    }

    function donneTexte(): string
    {
        $str="";
        $i=0;
        $str .= "<nav id='categorie'>
                <ul id='menu-closed'>
                ";
        if ($this->utilisateur) {
            $str .= "<form style='display: contents'> 
            
                <li>
                    <input type='hidden' name='case' value='Gerer_catalogue'>
                    
                    <button type='submit' name='action' value='AjouterCategorie'>+</button> </li>
                ".genereChampHiddenCSRF()."
".genereChampHiddenCSRF()."
</form>";
        }


        while ($i < count($this->listeCategorie)) {
            $iemeCategorie=$this->listeCategorie[$i];
            if ($iemeCategorie["desactiverCategorie"] == 0) {
                $str .= "
                   <li>
                        <form style='display: contents'> 
                            
                            <input type='hidden' name='case' value='Gerer_catalogue'>
                            <input type='hidden' name='idCategorie' value='$iemeCategorie[idCategorie]'>
                            <button type='submit' value='boutonCategorie' name='action'>
                                $iemeCategorie[libelle]
                            </button>
                        ".genereChampHiddenCSRF()."
".genereChampHiddenCSRF()."
</form>
                   </li> 
                   ";
            }
            $i++;
        }
        $str .= "
                <form style='display: contents'> 
                    
                    <li><input type='text' name='recherche' placeholder='Rechercher'> </li>
                        <input type='hidden' name='case' value='Gerer_catalogue'>
                    <li>
                                <button type='submit' value='okRechercher' name='action'>OK</button>
                     </li>
                ".genereChampHiddenCSRF()."
".genereChampHiddenCSRF()."
</form>";

        $str .= "
            </ul>
            </nav>";

        return $str;
    }
}