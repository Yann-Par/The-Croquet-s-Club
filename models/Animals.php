<?php

namespace Models;

class Animals extends DataBase
{
    
    
    //requette pour ajouter un nouvel animal
    public function addNewAnimal($name, $photo, $birthdate, $colories, $species, $race, $dbsteril, $descriptions, $users_id)
    {
        $query = $this->getDb()->prepare("INSERT INTO animals (name, photo, birthdate, colories, species, race, steril, descriptions, users_id) value (?,?,?,?,?,?,?,?,?)");
        $query->execute([$name, $photo, $birthdate, $colories, $species, $race, $dbsteril, $descriptions, $users_id]);
    }
    
    
    
    //requette pour selectionner tout les animaux
    public function selectAllAnimals()
    {
        $query = $this->getDb()->prepare("
        SELECT *
        FROM animals
        ");
        $query->execute();
        return $query->fetchAll();
    }
    
    
    
    
    //requette pour selectionner les animaux par utilisateur avec jointure de table
    public function selectAnimalsByUserId($id)
    {
        $query = $this->getDb()->prepare("
        SELECT animals.id_animals, animals.name, animals.photo, animals.birthdate, animals.colories, animals.species, animals.race, animals.steril, animals.descriptions, users.id_users 
        FROM animals
        INNER JOIN users ON users.id_users = animals.users_id
        WHERE users.id_users = ?
        ");
        $query->execute([$id]);
        return $query->fetchAll();
    }
    
    
    
    
    //requette qui va permettre de sécurisé les profils des utilisateurs dans le controller "animalPage" pour eviter que les utilisateurs puissent changer l'id des animaux dans l'url
    
    //et qui va permettre de récuperer les données sur les animaux existant dans la modification du formulaire grace a l'id de l'animal 
    public function selectAnimalById($id)
    {
        $query = $this->getDb()->prepare("
        SELECT animals.id_animals, animals.name, animals.photo, animals.birthdate, animals.colories, animals.species, animals.race, animals.steril, animals.descriptions,animals.users_id, users.id_users 
        FROM animals
        INNER JOIN users ON users.id_users = users_id
        where id_animals = ?
        ");
        $query->execute([$id]);
        return $query->fetch();
    }
    
    
    
    
    //selectionner les animaux par leurs id
    public function selectOneAnimalById($id)
    {
        $query = $this->getDb()->prepare("
        SELECT id_animals, name, photo, birthdate, colories, species, race, steril, descriptions 
        FROM animals
        WHERE id_animals = ?
        ");
        $query->execute([$id]);
        return $query->fetch();
    }
    
    
    
    
    //mise a jour de l'animal dans la bdd
    public function updateAnimal($name, $photo, $birthdate, $colories, $species, $race, $dbSteril, $descriptions, $id_animals)
    {
        $query = $this->getDb()->prepare("
            
            UPDATE animals 
            SET name = ?, photo = ?, birthdate = ?, colories = ?, species = ?, race = ?, steril = ?, descriptions = ?
            WHERE id_animals = ?");
        
        
        $query->execute([$name, $photo, $birthdate, $colories, $species, $race, $dbSteril, $descriptions, $id_animals]);
    }
    
    
    
    
    
    //suppression de l'animal par son id
    public function deleteAnimal($id)
    {
        $query = $this->getDb()->prepare("
            DELETE FROM animals
            WHERE id_animals = ?
        
        ");
        $query->execute([$id]);
    }
    
    

    
    
}

?>