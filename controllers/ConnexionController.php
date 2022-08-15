<?php

namespace Controllers;

class ConnexionController
{
    
    
    
    
    public function submitConnexion()
    {
        //appel du model pour la connexion
        $model = new \Models\Connect();
        
        
        //appel de la methode pour les requettes de connexion, on récupere les mail
        $connect = $model->getConnect($_POST['mail']);
        
        
        //condition si mauvais identifiants
        if(!$connect)
        {
            //on met un message d'erreur
            $_SESSION['message'] = 'Identifiant incorrect';
            
            
            //retour sur la meme page
            header('Location: '.$_SERVER['HTTP_REFERER']);
            exit();
        }
        else
        {
            //verifier le mot de passe avec celui de la bdd
            if(password_verify($_POST['password'], $connect['password']))
            {
                
                
                //on supprime les msg d'erreur s'il y en a eu un
                unset($_SESSION['message']);
                
                
                // si le role est un admin, alors on le redirige vers son tableau de bord
                if($connect['role'] === 'admin')
                {
                    $_SESSION['admin'] = $connect;
                    header('Location: index.php?route=tableau_de_bord');
                    exit();
                }else{
                  $_SESSION['connect'] = $connect;  
                }
                //sinon on redirige l'utilisateur vers sa page personnelle
                header('Location: index.php?route=personalPage');
                exit();
            }
            else
            {
                //sinon on affiche une erreur dans le formulaire
                $_SESSION['message'] = "Mot de passe incorrect";
                header('Location: '.$_SERVER['HTTP_REFERER']);
                exit();
            }
        }
    }
    
    
    public function deconnexion()
    {
        //on detruit la session pour se deconnecter, et on redirige vers l'accueil du site
        session_destroy();
        header('Location: index.php?route=accueil');
        exit();
    }
}