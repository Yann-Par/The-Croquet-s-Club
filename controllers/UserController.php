<?php

namespace Controllers;

class UserController
{
    public function displayFormNewUser()
    {
        //on supprime les message d'erreur s'il y en a
        unset($_SESSION['message']);
        
        $view = 'formNewUser.phtml';
        include_once 'views/layout.phtml';
    }
    
    
    
    public function addNewUserform()
    {
        $userModel = new \Models\Users();
        $model = new \Models\Connect();
        
        
        //on recupere les données du formulaire dans des variables et on les sécurises avec htmlspecialchars :
        
        $lastname = $_POST['lastname'];
        $firstname = $_POST['firstname'];
        $mail = htmlspecialchars($_POST['mail']);
        $password = htmlspecialchars($_POST['password']);

        //on recupere la liste des mail dans la base de données
        
        $already_exist_mail = $model->getConnect($mail);
        
        
        //on verifie que les champs du formulaires sont bien défini; pas vide, et inferieur a 10 charactere.
        //on filtre l'email pour etre sure que ca soit bien une adresse mail de renseigner
        if(!empty($lastname) && isset($lastname) && strlen($lastname) <= 10 
        && !empty($firstname) && isset($firstname) && strlen($firstname) <= 10 
        && !empty($mail) && isset($mail) && filter_var($mail, FILTER_VALIDATE_EMAIL) 
        && !empty($password) && isset($password) )
        {
            
            //on verifie que le mot de passe possede bien au minimum 8haracteres, 1majuscule et 1 chiffre
            if(strlen($password) >= 8 && preg_match('@[A-Z]@',$password) && preg_match('@[a-z]@',$password) && preg_match('@[0-9]@',$password))
            {
                 //on vérifie que le mail n'existe pas
               if( !$already_exist_mail )
               {
               
               //on envoie les informations a la requette sql
               $userModel->addNewUser($lastname, $firstname, $mail, password_hash($password, PASSWORD_BCRYPT) );
                              
                //commande pour se connecter aussitot après l'inscription
                $connect = $model->getConnect($mail);
                $_SESSION['connect'] = $connect;
                $user = $_SESSION['connect'];
                
                
                //on retire le msg d'erreur si c'est ok
                unset($_SESSION['erreur']);
                unset($_SESSION['message']);
                
                //on redirige vers la page personnel utilisateur
                header("Location: index.php?route=personalPage");
                exit();
                
               }
               else
               {
                   
                   //si le mail existe déjà, alors on met un msg d'erreur 
                    $err_msg = 'Email déjà renseigné, Merci de le modifier';
                    $_SESSION['erreur'] =  $err_msg;
                    
                    header('Location: '.$_SERVER['HTTP_REFERER']);
                    exit();
               }
            }else{
                //si le mot de passe n'est pas conforme, afficher un message d'erreur
                $err_msg = 'Le mot de passe n\'est pas conforme aux regle de sécurité';
                $_SESSION['erreur'] =  $err_msg;
                
                header('Location: '.$_SERVER['HTTP_REFERER']);
                exit();
                
            }
            
               
               
        }
        else
        {
            //si les champs sont mal renseigné, alors on met un msg d'erreur 
            $err_msg = 'Merci de remplir tous les champs';
            $_SESSION['erreur'] =  $err_msg;
            
            //on redirige sur la page précedente du serveur (la ou on était, pour evité la page blanche)
            header('Location: '.$_SERVER['HTTP_REFERER']);
            exit();
        }
        
        
          
        
        
    }
    
    public function displayMonCompte()
    {
        $user = $_SESSION['connect'];
        
        $view = 'monCompte.phtml';
        include_once 'views/layout.phtml';
    }
    
    
    
    public function deleteOneUser(){
        $id = $_SESSION['connect']['id_users'];
        
        $AnimalModel = new \Models\Animals();
        $userAnimals = $AnimalModel->selectAnimalsByUserId($id);
        
        
        //pour chaque utilisateurs supprimer, on supprime les photos qu'il avait ajouter avec ses animaux
        foreach ( $userAnimals as $userAnimal )
        {
            unlink($userAnimal['photo']);
        }
        
        $model = new \Models\Users();
        $model->deleteOneUserById($id);
        
        
        //on le deconnect en meme temps et on le renvoie a l'accueil
        session_destroy();
        
        header("Location: index.php?route=accueil");
        exit();
        
    }
    
    
    
    
    
}