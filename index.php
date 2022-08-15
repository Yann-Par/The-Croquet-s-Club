<?php
//fonction qui permet d'activé la superGlobale $_SESSION pour les connexion, et les message d'erreurs.
session_start();



//fonction qui va permettre de charger automatiquement les differents fichier dans le MVC
spl_autoload_register( function($class)
{
    //on récupere la premiere lettre de "Controller" que nous allons mettre en minuscule car le dossier sur le serveur s'écrit "controller", ensuite on va remplacer le \ par un / pour la lecture du chemin (on ecrit avec "\\" pour eviter que la lecture de php retirer le simple quote ' . on stock tout cela das la variable $class et on lui rajoute le type de fichier .php)
    require_once lcfirst( str_replace('\\', '/', $class)). '.php';
});

//on regarde que le mot clé route existe dans l'url grace à $_GET
if( array_key_exists( 'route', $_GET))
{
    //on fait un switch pour savoir quel cas utilisé en fonction de ce que l'url va récuperer
    switch( $_GET['route'])
    {
        //page d'accueil du site
        case 'accueil' :
            
            $controller = new Controllers\AccueilController();
            $controller->displayAccueilPage();
            break;
        
        
        
        
        
        //chemin pour aller sur la page de son compte    
        case 'monCompte' :
            $controller = new Controllers\UserController();
            $controller->displayMonCompte();
            break;
        
        
        
        //chemin pour aller sur la page d'inscription d'un nouvel utilisateur    
        case 'formNewUser' :
            $controller = new Controllers\UserController();
            $controller->displayFormNewUser();
            break;
        
        
        
        // requette pour creer un nouvel utilisateur en bdd
        case 'requestNewUser' :
            $controller = new Controllers\UserController();
            $controller->addNewUserform();
            break;
        
        
        //chemin pour aller sur la page "notre hstoire"   
        case 'history' :
            $controller = new Controllers\AccueilController();
            $controller->displayHistory();
            break;
            
            
        
        //chemin pour aller sur la page "nos momtivations"    
        case 'motivations' :
            $controller = new Controllers\AccueilController();
            $controller->displayMotivation();
            break;
        
        
        
        
        //chemin pour aller sur la pae communautaire
        case 'zoneComunautaire' :
            $controller = new Controllers\AccueilController();
            $controller->displayZoneComunautaire();
            break;
            
        
            
            /*======= Connexion / Deconnexion ======*/
        
        //nouvelle connexion, debut d'une session utilisateur ou admin   
        case 'submitConnexion' :
            $controller = new Controllers\ConnexionController();
            $controller->submitConnexion();
            break;
        
        
        //deconnexion, destruction de la session  
        case 'deconnect' :
            $controller = new Controllers\ConnexionController();
            $controller->deconnexion();
            break;
        
        
        
        
        
        /*======= route pour utilisateur/admin ======*/
        
        
        //route pour le tableau de bords pour l'admin
        case 'tableau_de_bord' :
            if(!isset($_SESSION['admin']))
            {
                header("Location: index.php?route=accueil");
                exit();
            }
            $controller = new Controllers\AdminController();
            $controller->displayTableauDeBord();
            break;
        
        
        //requette ajax pour rechercher les utilisateurs dans le tableau de bord de l'admin
        case 'searchUsers' :
            $controller = new Controllers\AdminController();
            $controller->searchUsers();
            break;
        
        
        //route pour aller sur la page personnel de l'utilisateur    
        case 'personalPage' :
            
            //Protection avec une condition si on est pas connecter en tant que utilisateur ou en administrateur, on nous renvoie sur la page d'accueil du site.
            if( !isset( $_SESSION['connect'] ) && !isset( $_SESSION['admin'] ))
            {
                header("Location: index.php?route=accueil");
                exit();
                
            }
                
                
                $controller = new Controllers\PersonalPageController();
                $controller->displayAccueilPersonel();
            
            
            break;
        
        
        
        
        //suppression de son compte par l'utilisateur
        case 'deleteUser' :
            $controller = new Controllers\UserController();
            $controller->deleteOneUser();
            break;
        
        
        
        
        //suppression du compte utilisateur par l'administrateurs si besoin    
        case 'deleteUserByAdmin' :
            $controller = new Controllers\AdminController();
            $controller->deleteOneUserByAdmin();
            break;
        
        
        
            
            /*======= route animaux ======*/
        
        
        //chemin pour la page de l'animal   
        case 'animalPage' :
            
            //protection, pour y acceder il faut etre connecter soit en utilisateur ou en admin, sinon on est renvoyer a l'accueil
            if( !isset( $_SESSION['connect'] ) && !isset( $_SESSION['admin'] ))
            {
                header("Location: index.php?route=accueil");
                exit();
            }
            $controller = new Controllers\AnimalsController();
            $controller->displayAnimalPage();
            break;
        
        
        
        
        
        //chemin pour le formulaire d'ajout d'animaux   
        case 'animalForm' :
            //protection, il faut etre connecter pour y acceder
            if( !isset( $_SESSION['connect'] )  )
            {
                header("Location: index.php?route=accueil");
                exit();
            }
            $controller = new Controllers\AnimalsController();
            $controller->displayAnimalForm();
            break;
        
        
        
        //validation du formulaire pour ajouter un animal
        case 'submitAnimal' :
            $controller = new Controllers\AnimalsController();
            $controller->submitNewAnimal();
            break;
        
        
        
        //chemin pour retourner sur le formulaire si on souhaite modifier les informations 
        case 'modifyAnimal' :
            $controller = new Controllers\AnimalsController();
            $controller->displayFormNewAnimal();
            break;
        
        
        
        //vaidation de la modification
        case 'submitModifyAnimal' :
            $controller = new Controllers\AnimalsController();
            $controller->submitModifyAnimal();
            break;
        
        
        
        //supprimer l'animal    
        case 'deleteAnimal' :
            $controller = new Controllers\AnimalsController();
            $controller->deleteAnimal();
            break;
            
            
            
            
            
            
            
            
            
            /*======= route articles ======*/
        
        
        
        //chemin vers le formulaire d'ajout d'articles    
        case 'articleForm' :
            
            //protection, pour y acceder il faut etre connecter soit en utilisateur ou en admin, sinon on est renvoyé à l'accueil
            if( !isset( $_SESSION['connect'] ) && !isset( $_SESSION['admin'] ) )
            {
                header("Location: index.php?route=accueil");
                exit();
            }
            $controller = new Controllers\ArticlesController();
            $controller->displayArticleForm();
            break;
        
        
        
        //valider d'ajout d'articles
        case 'submitArticle' :
            $controller = new Controllers\ArticlesController();
            $controller->submitArticle();
            break;
        
        
        
        //chemin vers la page articles    
        case 'articlePage' :
            $controller = new Controllers\ArticlesController();
            $controller->displayArticlePage();
            break;
        
        
        
        
        //mettre à jour, modifier l'article    
        case 'updateArticle':
            $controller = new Controllers\ArticlesController();
            $controller->updateArticle();
            break;
        
        
        
        
        //supprimer l'article    
        case 'deleteArticle' :
            $controller = new Controllers\ArticlesController();
            $controller->deleteArticle();
            break;
        
        
        
        //requette ajax pour rechercher les articles dans la zone communautaire    
        case 'searchArticles' :
            $controller = new Controllers\ArticlesController();
            $controller->searchArticles();
            break;
        
        /*======= route categories ======*/
        
        
        //ajouter une categorie d'article, dans le tableau de bord de l'admin 
        case 'addCategory' :
            $controller = new Controllers\CategoriesController();
            $controller->addCategory();
            break;
        
        
        
        default :
            $controller = new Controllers\AccueilController();
            $controller->displayNotFoundPage();
            break;
            
    }
}
else
{
    //redirection si aucune page n'est saisie vers l'accueil
    header('Location: index.php?route=accueil');
    exit();
}


?>