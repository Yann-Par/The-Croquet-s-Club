<?php

namespace Controllers;

class AdminController
{
    
    
    //fonction pour l'affichage de le tableau de bord du site qui est réservé aux admininistrateur
    public function displayTableauDeBord()
    {
        
        // on récupere tous les models nécessaire pour avoir acces a tous les tables de la base de données
        $userModel = new \Models\Admin();
        $animalModel = new \Models\Animals();
        $articleModel = new \Models\Articles();
        
        
        // on récupere tous les utilisateur
        $AllUsers = $userModel->getAllUsers();
        
        // on créer un tableau d'utilisateur
        $users = [];
        
        // pour chaque utilisateur,
        foreach($AllUsers as $user)
        {
            // on stock les informations de l'utilisateur, de ses animaux et des articles propres a chacun d'eux 
            $users[] = [
               'userInfos' => $user,
               'userAnimals' => $animalModel->selectAnimalsByUserId( $user['id_users'] ),
               'userArticles' => $articleModel->getUserArticles( $user['id_users'] )
            ];
        }
        
        
        
        
        
        $view = 'adminPage.phtml';
        include_once 'views/layout.phtml';
        
    }
    
    
    
    
    
    
    
    
    // fonction qui permetra aux admin de supprimer des compte utilisateurs.
    public function deleteOneUserByAdmin()
    {
        $id = $_GET['id'];
        
        $AnimalModel = new \Models\Animals();
        $userAnimals = $AnimalModel->selectAnimalsByUserId($id);
        
        
        // cette boucle va permettre, lors de la suppression de l'utilisateur, de supprimer également les photos des animaux dans le serveur où les photos sont stocké.
        foreach ( $userAnimals as $userAnimal )
        {
            unlink($userAnimal['photo']);
        }
        
        $model = new \Models\Users();
        $model->deleteOneUserById($id);
        
        header('Location: '.$_SERVER['HTTP_REFERER']);
        exit();
    }
    
    
    
    //fonction requete ajax qui permet de rechercher les utilisateurs par leurs nom pour les admins
    public function searchUsers()
    {
        
        
        $name = $_GET['str'];
        
        
        $model = new \Models\Admin();
        // on cherche les utilisateurs par leurs noms (lastname)
        $usersInfos = $model->searchUsersByName($name);
        
        $animalModel = new \Models\Animals();
        $articleModel = new \Models\Articles();
        
        $users = [];
        
        
        // pour chaque utilisateur,
        foreach($usersInfos as $user)
        {
            
            // on stock les informations de l'utilisateur, de ses animaux et des articles propres a chacun d'eux 
            $users[] = [
               'userInfos'      => $user,
               'userAnimals'    => $animalModel->selectAnimalsByUserId( $user['id_users']),
              'userArticles'   => $articleModel->getUserArticles( $user['id_users'] )
            ];
        }
        
        
        include 'views/listUserForAdmin.phtml';
    }
}