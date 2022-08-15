<?php


namespace Models;

class Category extends DataBase
{
    
    
    
    //recuperer une categorie
    public function getCategory()
    {
        $query = $this->getDB()->prepare(
            "
            SELECT *
            FROM category
            ORDER BY category_name ASC
            ");
        $query->execute();
        return $query->fetchAll();
            
    }
    
    
    
     //récuperer une catégory par son id
    public function getOneCategoryById($categoryId)
    {
        $query = $this->getDB()->prepare(
            "
            SELECT category_name
            FROM category
            INNER JOIN articles ON id_articles = id_category
            WHERE id_articles = ?
            
            ");
        $query->execute([$categoryId]);
        return $query->fetch();
            
    }
    
    
    
    
    
    //ajouter une nouvelle categorie
    public function addCategory($category)
    {
        $query = $this->getDb()->prepare("
            INSERT INTO category (category_name) 
            value (?)
            ");
        $query->execute([$category]);
    }
    
    
    
    
}