<?php

namespace Controllers;

class PersonalPageController
{
    public function displayAccueilPersonel()
    {
        // on efface les message d'erreur s'il y en as
        unset($_SESSION['err_art']);
        
        
        //si on est connecter avec un utilisateurs lambda, on stock ses infos dans une variables pour pouvoir les afficher
        if (isset($_SESSION['connect']))
        {
            $id = $_SESSION['connect']['id_users'];
            $user = $_SESSION['connect'];
        }
        //si c'est un admin, ca redirige vers son tableau de bord
        if(isset($_SESSION['admin']))
        {
            //si c'est l'admin, on le redirige vers son tableau de bord
            header("Location: index.php?route=tableau_de_bord");
            exit();
        }
        
        
        
        //on récupere les animaux de l'utilisateur par son id
        $model = new \Models\Animals();
        $animals = $model->selectAnimalsByUserId($id);
        
        
        
        //on récupere les articles de l'utilisateur par son id
        $model = new \Models\Articles();
        $articles = $model->getUserArticles($id);
        
    
        $view = 'personalPage.phtml';
        include_once 'views/layout.phtml';
    }
    
    
    
}