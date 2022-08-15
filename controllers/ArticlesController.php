<?php 
namespace Controllers;

use \Models\Articles;

class ArticlesController
{
    
    
    
    public function displayArticleForm()
    {
        //on attribut a la variable $user les information en fonction si c'est un admin ou pas
        if($_SESSION['connect'])
        {
            $user = $_SESSION['connect'];
        }
        elseif($_SESSION['admin'])
        {
            $user = $_SESSION['admin'];
        }
        
        $categoryModel = new \Models\Category();
        $categories =  $categoryModel->getCategory();
        
        //on creer un editmode pour la modificaton des articles 
        $editMode = $_GET['mode'] === 'edit' ? true : false;
        
        
        //si on est en editmode, on recupere les articles par leurs id
        if( $editMode )
        {
            $model = new Articles();
            $updateArticles = $model->getArticlesById($_GET['id']);
        }

        
        
        $view = 'articleForm.phtml';
        include_once 'views/layout.phtml';
        
    }
    
    public function submitArticle()
    {
        $articleModel = new \Models\Articles(); 
        
        
        //on récupere toutes les valeurs du formulaie que l'on sécurise dans htmlspecialchars
        $title = htmlspecialchars($_POST['title']);
        $info_rubrique = htmlspecialchars($_POST['info_rubrique']);
        $contenu_rubrique = htmlspecialchars($_POST['contenu_rubrique']);
        $id_user = htmlspecialchars($_POST['users_id']);
        $id_category = htmlspecialchars($_POST['category_id']);
        
        
        //on ajoute des conditions pour valider l'ajout de nouvel article
        if( isset($title) && !empty($title) && strlen($title) <= 100 &&
            isset($info_rubrique) && !empty($info_rubrique) && strlen($info_rubrique) <= 255 &&
            isset($contenu_rubrique) && !empty($contenu_rubrique) )
        {
            
            
            //si c'est bon, on ajoute l'articles
            $articleModel->addArticle($title, $info_rubrique, $contenu_rubrique, $id_user, $id_category) ;
            
            
            
            header("Location: index.php?route=personalPage" );
            exit();
        }
        else
        {
            
        //sinon on met un message d'erreur
          $message = 'merci de remplir tout les champs';
          $_SESSION['err_art']= $message;
    
          
          header('Location: '.$_SERVER['HTTP_REFERER']);
          exit();
        }
    }
    
    
    
    
    
    
    
    public function displayArticlePage(){
        
        
        
        //on verifie les sessions de connection
        if (isset($_SESSION['connect']))
        {
            $id = $_SESSION['connect']['id_users'];
            $user = $_SESSION['connect'];
        }
        
        if(isset($_SESSION['admin']))
        {
            $id = $_SESSION['admin']['id_users'];
            $user = $_SESSION['admin'];
        }
        
        
        // je recupere l'id de l'url de l'article
        $idArticle = $_GET['id'];
        
        $model = new \Models\Articles();
        $articles = $model->getArticlesById($idArticle);
        
        
       //redirection si l'utilisateur essaye de changer l'id de l'url pour eviter d'aller sur le coontenu des autres utilistauer 
      
      if(isset($_SESSION['connect']))
        {
            //si l'id de l'utilisateur ne correspond pas a l'id du créateur de l'article, alors il est renvoyer sur son profil
          if($user['id_users'] !== $articles['users_id'] )
            {
                header( 'Location: index.php?route=personalPage' );
                exit();
            }
        }
        
        $view = 'articlePage.phtml';
        include_once 'views/layout.phtml';
    }
    
    
    
    public function updateArticle()
    {
        $articleModel = new \Models\Articles(); 
        
        $title = htmlspecialchars($_POST['title']);
        $info_rubrique = htmlspecialchars($_POST['info_rubrique']);
        $contenu_rubrique = htmlspecialchars($_POST['contenu_rubrique']);
        $id_user = htmlspecialchars($_POST['users_id']);
        $id_category = htmlspecialchars($_POST['category_id']);
        $idArticles = $_POST['id_article'];
        
        if( isset($title) && !empty($title) && strlen($title) <= 100 &&
            isset($info_rubrique) && !empty($info_rubrique) && strlen($info_rubrique) <= 255 &&
            isset($contenu_rubrique) && !empty($contenu_rubrique))
        {
            $articleModel->updateArticle($title, $info_rubrique, $contenu_rubrique, $id_category, $idArticles) ;
            
            // var_dump($articleModel);
            header("Location: index.php?route=personalPage" );
            exit();
        }
        else
        {
          $message = 'merci de remplir tout les champs';
          $_SESSION['err_art']= $message;
    
          
          header('Location: '.$_SERVER['HTTP_REFERER']);
          exit();
        }
    }
    
    
    public function deleteArticle()
    {
        $delete = new \Models\Articles();
        
        $delete->deleteArticle($_GET['id']);
        
        header( 'Location: index.php?route=personalPage' );
        exit();
    }
    
    
    
    
    
    
     // Fonction qui va permettre la recherche ajax dans la zone communautaire, ou l'on retrouvera tous les articles de tous les adhérents. 
    
    public function searchArticles()
    {
        //récupération du mot clé "str" qui est introduit dans le fichier "searcharticles.js" avec la fonction recupList dans la fonction js fetch.
        //$title va permettre avec la clé str de récupérer les valeurs dans le champs de recherche que l'on écrit en direct
        $title = $_GET['str'];
        
        
        //on récupere le models Articles
        $articleModel = new \Models\Articles();
        //on donne à la variable $articles la methode qui permettra la recherche dans la base de données des titres
        $articles = $articleModel->searchArticlesByTitle($title);
        
        //et on inclut le fichier searchArticles.phtml qui regroupe la boucle pour tous les articles.
        include 'views/searchArticles.phtml';
    }
}