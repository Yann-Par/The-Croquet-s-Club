<?php

namespace Controllers;


class AccueilController
{
    
    
    //fonction pour l'affichage de la page d'accueil du site
    public function displayAccueilPage()
    {
        unset($_SESSION['erreur']);
        unset($_SESSION['message-animal-form']);
        
        
        $view = 'accueil.phtml';
        include_once 'views/layout.phtml';
    }
    
    
    
    
    
    
    //fonction pour l'affichage de la page Notre histoire du site
    public function displayHistory()
    {
        unset($_SESSION['erreur']);
        unset($_SESSION['message-animal-form']);
        unset($_SESSION['message']);
        
        $view = 'history.phtml';
        include_once 'views/layout.phtml';
        
    }
    
    
    
    
    
    
    //fonction pour l'affichage de la page Nos motivations du site
    public function displayMotivation()
    {
        unset($_SESSION['erreur']);
        unset($_SESSION['message-animal-form']);
        unset($_SESSION['message']);
        
        $view = 'motivation.phtml';
        include_once 'views/layout.phtml';
        
    }
    
    
    
    
    
    
    //fonction pour l'affichage de la zone communautaire du site
    public function displayZoneComunautaire()
    {
        unset($_SESSION['erreur']);
        unset($_SESSION['message-animal-form']);
        unset($_SESSION['message']);
        
        
        //méthodes qui recupere tous les articles de tous les adhérents.
        $model = new \Models\Articles();
        $articles = $model->getAllArticles();
        
        
        $view = 'zoneComunautaire.phtml';
        include 'views/layout.phtml';
        
    }
    
    
    
    public function displayNotFoundPage()
    {
        $view = 'notFoundPage.phtml';
        
        include 'views/layout.phtml';
    }
    
    
    
    
    
    
    
   
}