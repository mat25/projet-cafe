<?php
namespace App\Vue;
use App\Utilitaire\Vue_Composant;
use function App\Fonctions\genereChampHiddenCSRF;
use function App\Fonctions\genereVarHrefCSRF;
class Vue_Menu_Administration extends Vue_Composant
{
    private string $typeConnexion;
    public function __construct(string $typeConnexion = "utilisateurCafe" )
    {
        $this->typeConnexion = $typeConnexion;
    }
    function donneTexte(): string
    {
        switch ($this->typeConnexion) {
            case "utilisateurCafe" :
                return "
             <nav id='menu'>
              <ul id='menu-closed'> 
                <li><a href='?case=Gerer_catalogue".genereVarHrefCSRF()."'>Catalogue</a></li>   
             <li><a href='?case=Gerer_entreprisesPartenaires".genereVarHrefCSRF()."'>Entreprises partenaires</a></li>
               <li><a href='?case=Gerer_Commande".genereVarHrefCSRF()."'>Commandes</a></li>
            
                <li><a href='?case=Gerer_monCompte".genereVarHrefCSRF()."'>Mon compte</a></li> 
               </ul>
            </nav> 
            ";

            case "administrateurLogiciel":

                return "
             <nav id='menu'>
              <ul id='menu-closed'> 
                <li><a href='?case=Gerer_utilisateur".genereVarHrefCSRF()."'>Utilisateurs</a></li>
                <li><a href='?case=Gerer_monCompte".genereVarHrefCSRF()."'>Mon compte</a></li> 
               </ul>
            </nav> 
            ";
        }
              
    }
}
