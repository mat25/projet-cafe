<?php
namespace App\Vue;
use App\Utilitaire\Vue_Composant;

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
                <li><a href='?case=Gerer_catalogue'>Catalogue</a></li>   
             <li><a href='?case=Gerer_entreprisesPartenaires'>Entreprises partenaires</a></li>
               <li><a href='?case=Gerer_Commande'>Commandes</a></li>
            
                <li><a href='?case=Gerer_monCompte'>Mon compte</a></li> 
               </ul>
            </nav> 
            ";

            case "administrateurLogiciel":

                return "
             <nav id='menu'>
              <ul id='menu-closed'> 
                <li><a href='?case=Gerer_utilisateur'>Utilisateurs</a></li>
                <li><a href='?case=Gerer_monCompte'>Mon compte</a></li> 
               </ul>
            </nav> 
            ";
        }
              
    }
}
