<?php

namespace Models;

class articles extends DataBase
{
    
    
    
    //récuperer tous les articles
    public function getAllArticles()
    {
        $query= $this->getDb()->prepare("
            
            SELECT *
            FROM articles
        
        ");
        $query->execute();
        return $query->fetchAll();
    }
    
    
    
    //recuperation des articles par l'id des utilisateurs
    public function getUserArticles($id)
    {
        $query = $this->getDb()->prepare("
        SELECT articles.id_articles, articles.title, articles.info_rubrique, articles.contenu_rubrique, articles.title , users.id_users 
        FROM articles
        INNER JOIN users ON users.id_users = articles.users_id
        WHERE users.id_users = ?
        ");
        $query->execute([$id]);
        return $query->fetchAll();
    }
    
    
    
    
    //ajouter un article
    public function addArticle($title, $info_rubrique, $contenu_rubrique, $id_user, $id_category)
    {
        $query = $this->getDb()->prepare("
            INSERT INTO articles (title, info_rubrique, contenu_rubrique, users_id, category_id) 
            value (?,?,?,?,?)");
        $query->execute([$title, $info_rubrique, $contenu_rubrique, $id_user, $id_category]);
    }
    
    
    
    //recuperer un article par son id et sa catégorie
    public function getArticlesById($id)
    {
        $query = $this->getDb()->prepare("
        SELECT articles.id_articles, articles.title, articles.info_rubrique, articles.contenu_rubrique, articles.title,articles.category_id, category.category_name , articles.users_id
        FROM articles
        INNER JOIN category ON category.id_category = articles.category_id
        WHERE articles.id_articles = ?
        ");
        $query->execute([$id]);
        return $query->fetch();
    }
    
    
    
    //modifier un article
    public function updateArticle($title, $info_rubrique, $contenu_rubrique,$id_category, $idArticles)
    {
        $query = $this->getDb()->prepare("
            
            UPDATE articles 
            SET title = ?, info_rubrique = ?, contenu_rubrique = ?, category_id = ?
            WHERE id_articles = ?");
        
        
        $query->execute([$title, $info_rubrique, $contenu_rubrique, $id_category, $idArticles]);
    }
    
    
    
    //supprimer un article
    public function deleteArticle($id)
    {
        $query = $this->getDb()->prepare("
            DELETE FROM articles
            WHERE id_articles = ?
        
        ");
        $query->execute([$id]);
    }
    
    
    
    //requette ajax pour rechercher, peu importe le placement du mot dans la présentations de l'articles pour faciliter les recherches
    public function searchArticlesByTitle($infos)
    {
        $query = $this->getDb()->prepare("
            SELECT *
            FROM articles
            WHERE info_rubrique
            LIKE ?
            ORDER BY title ASC
                    ");
        $query->execute(["%$infos%"]);
        return $query->fetchAll();
    }
    
}