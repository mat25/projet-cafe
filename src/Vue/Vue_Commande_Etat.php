<?php
namespace App\Vue;
use App\Utilitaire\Vue_Composant;
use function App\Fonctions\genereChampHiddenCSRF;
use function App\Fonctions\genereVarHrefCSRF;
class Vue_Commande_Etat extends Vue_Composant
{
    private array $listeEtatCommande;
    public function __construct(array $listeEtatCommande)
    {
        $this->listeEtatCommande=$listeEtatCommande;
    }

    function donneTexte(): string
    {
        $str="";
        $i=0;
        $str .=  "<nav id='etatCommande'>
                <ul id='menu-closed'>
                ";

        $str .=  "
                <form style='display: contents'> 
                    
                    <input type='hidden' name='case' value='Gerer_Commande'>
                    
                    <li><button type='submit' name='action' value='Toute'>Toutes</button> </li>
                ".genereChampHiddenCSRF()."
".genereChampHiddenCSRF()."
</form>";

        while ($i < count($this->listeEtatCommande)) {
            $iemeEtatCommande=$this->listeEtatCommande[$i];

            $str .=  "
                   <li>
                        <form style='display: contents'> 
                            
                            <input type='hidden' name='case' value='Gerer_Commande'>
                            <input type='hidden' name='idEtatCommande' value='$iemeEtatCommande[idEtatCommande]'>
                            <button type='submit' name='action' value='boutonCategorie'> $iemeEtatCommande[libelle]</button>
                        ".genereChampHiddenCSRF()."
".genereChampHiddenCSRF()."
</form>
                   </li> 
                   ";

            $i++;
        }
        $str .=  "
                <form style='display: contents'> 
                    
                    <input type='hidden' name='case' value='Gerer_Commande'> 
                    <li><input type='text' name='recherche' placeholder='Rechercher'> </li>
                    <li><button type='submit' name='action' value='okRechercher'>OK</button> </li>
                ".genereChampHiddenCSRF()."
".genereChampHiddenCSRF()."
</form>";
        $str .=  "
            </ul>
            </nav>";
        return $str;
    }

}