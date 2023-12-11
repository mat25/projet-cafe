<?php

namespace App\Modele;

use App\Utilitaire\Singleton_ConnexionPDO;
use Cassandra\Date;
use PDO;

class Modele_Jeton {
    /**
     * @param $connexionPDO : connexion à la base de données
     * @return mixed : le tableau des Jeton ou null (something went wrong...)
     */
    static function Jeton_Select()
    {
        $connexionPDO = Singleton_ConnexionPDO::getInstance();
        $requetePreparee = $connexionPDO->prepare('select * from token');
        $reponse = $requetePreparee->execute(); //$reponse boolean sur l'état de la requête
        $tableauReponse = $requetePreparee->fetchAll(PDO::FETCH_ASSOC);
        return $tableauReponse;
    }

    /**
     * @param $connexionPDO : connexion à la base de données
     * @param $jeton
     * @return mixed
     */
    static function Jeton_Select_ParToken($jeton)
    {
        $connexionPDO = Singleton_ConnexionPDO::getInstance();
        $requetePreparee = $connexionPDO->prepare('
        select * from token where valeur = :paramValeur');
        $requetePreparee->bindParam('paramValeur', $jeton);
        $reponse = $requetePreparee->execute(); //$reponse boolean sur l'état de la requête
        $token = $requetePreparee->fetch(PDO::FETCH_ASSOC);
        return $token;
    }

    /**
     * @param $connexionPDO : connexion à la base de données
     * @param $jeton
     * @return mixed
     */
    static function Ajouter_jeton($jeton,$idUtilisateur)
    {
        $date = ((new \DateTime())->modify("+3 days"))->format("Y-m-d-H-i-s");
        $connexionPDO = Singleton_ConnexionPDO::getInstance();
        $requetePreparee = $connexionPDO->prepare('
        INSERT INTO token (valeur,codeAction,idUtilisateur,dateFin) VALUES  (:paramValeur,0,:paramUtilisateur,:paramDateFin)');
        $requetePreparee->bindParam('paramValeur', $jeton);
        $requetePreparee->bindParam('paramUtilisateur', $idUtilisateur);
        $requetePreparee->bindParam('paramDateFin', $date);
        $reponse = $requetePreparee->execute(); //$reponse boolean sur l'état de la requête
        $token = $requetePreparee->fetch(PDO::FETCH_ASSOC);
        return $token;
    }



}