<?php
namespace App\Vue;
use App\Utilitaire\Vue_Composant;
use function App\Fonctions\genereChampHiddenCSRF;
use function App\Fonctions\genereVarHrefCSRF;
class Vue_Connexion_Formulaire_client extends Vue_Composant
{
    private string $msgErreur;
    public function __construct(string $msgErreur ="")
    {
        $this->msgErreur=$msgErreur;
    }

    function donneTexte(): string
    {
        $str= "
<h1>Café : Connexion</h1>
<div  style='    width: 50%;    display: block;    margin: auto;'>  
  <form action='index.php' method='post'>
  
                <h1>Connexion</h1>
                
                <label><b>Compte</b></label>
                <input type='text' placeholder='identifiant du compte' name='compte' required>

                <label><b>Mot de passe</b></label>
                <input type='password' placeholder='mot de passe' name='password' required>
                
                <button type='submit' id='submit' name='action' value='Se connecter' >
                    Se connecter
                </button>                
                " ;
        if($this->msgErreur != "")
        {
            $str .=  " <label><b>Erreur : $this->msgErreur</b></label>";
        }

        $str .=  "


".genereChampHiddenCSRF()."
</form>
<form>

<h1>Mot de passe perdu ?</h1>

<button type='submit' id='submit' name='action' value='reinitmdp'> 
    Réinitialiser le mdp
</button>
";

        $str .= "

".genereChampHiddenCSRF()."
</form>
</div>
    ";


        return $str ;
    }
}