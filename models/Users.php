<?php

namespace Models;

class Users extends DataBase
{
    
    
    
    //requette pour ajouter un nouvel utilisateur quand il s'inscrit
    public function addNewUser(string $lastname, string $firstname, string $mail, string $password ): void
    {
        $query = $this->getDb()->prepare("INSERT INTO users (lastname, firstname, mail, password) value (?,?,?,?)");
        $query->execute([$lastname, $firstname, $mail, $password]);
        
    }
    
    
    
    //requette pour récuperer les utilisateurs
    public function getUser()
    {
        $query = $this->getDb()->prepare("
            SELECT *
            FROM users
            
                    ");
        $query->execute();
        return $query->fetch();
    }
    
    
    
    
    
    
    
    
    //requette pour supprimer un seul utilisateur par son id
    public function deleteOneUserById($id)
    {
        $query = $this->getDb()->prepare("
            DELETE FROM users
            WHERE id_users = ?
        
        ");
        $query->execute([$id]);
    }
    
}










?>