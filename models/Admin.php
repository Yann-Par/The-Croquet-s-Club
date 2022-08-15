<?php

namespace Models;

class Admin extends DataBase 
{
    
    
   
   //requette pour récuperer tous les utilisateurs par ordre d'inscription les plus récentes
    public function getAllUsers()
    {
        $query = $this->getDb()->prepare("
            SELECT *
            FROM users
            ORDER BY id_users DESC
                    ");
        $query->execute();
        return $query->fetchAll();
    }
    
    
    
    
    //requette pour rechercher les utilisateurs par leurs nom de famille
    //on met le % dans excute apres la variable pour recherche les nom qui commence par le lettre écrite
    public function searchUsersByName($name)
    {
        $query = $this->getDb()->prepare("
            SELECT *
            FROM users
            WHERE lastname
            LIKE ?
            ORDER BY id_users DESC
                    ");
        $query->execute(["$name%"]);
        return $query->fetchAll();
    }
    
    
    
    
    //récupération de tous les animaux
    public function getAllAnimals()
    {
        $query = $this->getDb()->prepare("
            SELECT *
            FROM Animals
            
                    ");
        $query->execute();
        return $query->fetchAll();
    }
    

    
}




?>