<?php

namespace Controllers;

class CategoriesController
{
    public function addCategory()
    {
        //on récupere la valeurs de la nouvelle categorie du formulaire d'ajout de categorie
        $category = htmlspecialchars($_POST['category']);
        
        
        //on ajoute la nouvelles catégorie
        $categoryModel = new \Models\Category();
        $categoryModel->addcategory($category);
        
        header('Location: '.$_SERVER['HTTP_REFERER']);
        exit();
    }
}