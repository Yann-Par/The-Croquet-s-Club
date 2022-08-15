<?php

namespace Controllers;

class AnimalsController
{
    
    
    // fonction pour la page de l'animal
    public function displayAnimalPage()
    {
        
        
        // si c'est un utilisateurs lambda qui se connect, on l'assigne a la variable $id et $users
        if (isset($_SESSION['connect']))
        {
            $id = $_SESSION['connect']['id_users'];
            $user = $_SESSION['connect'];
        }
        
        
        
        // si c'est un administrateur qui se connect, alorsla variable $id et $users sera remplacer par les valeurs de l'admin
        if(isset($_SESSION['admin']))
        {
            $id = $_SESSION['admin']['id_users'];
            $user = $_SESSION['admin'];
        }
        
        
        
        
        $id = $_GET['id'];
        
        $model = new \Models\Animals();
        $animal = $model->selectOneAnimalById($id);
        
        
        //on recupere la date de naissance de l'animal de la bdd
        $date = $animal['birthdate'];
        //on la converti en chaine de charactere
        $time = strtotime($date);
        //on le converti pour afficher les element dans le bon ordres
        $animalDate = date("d:m:Y",$time);
        
        
        
        //récupération de la requette qui va sécuriser le code en dessous
        $animals = $model->selectAnimalById($id);
        
        
         //redirection si l'utilisateur essaye de changer l'id de l'url pour eviter d'aller sur le contenu des autres utilisateur s
         //mis dans la session connect pour laisser l'acces a l'admin
        if(isset($_SESSION['connect']))
        {
            //si l'id de l'utilisateur connecté ne correspond pas a l'id de l'utilisateur qui a ajouté l'animal, alors il sera renvoyer sur sa page personel
            if($user['id_users'] !== $animals['users_id'])
            {
                header( 'Location: index.php?route=personalPage' );
                exit();
            }
        }
       
    
        
        $view = 'animalPage.phtml';
        include_once 'views/layout.phtml';
    
    }
    
    
    public function displayAnimalForm()
    {
        // si c'est une sessions utilisateur lambda, la variable $user prend ses informations a lui
        if($_SESSION['connect'])
        {
            $user = $_SESSION['connect'];
        }
        //sinon il prendra les informations de l'administrateur
        elseif($_SESSION['admin'])
        {
            $user = $_SESSION['admin'];
        }
        
        
        
        
        // on va stocker dans une variable une ternaire vraie ou fausse sur une route que l'on va créer pour l'url
        $editMode = $_GET['mode'] === 'edit' ? true : false;
        
        
        // si on est en mode edit, alors on va récuperer les informations de l'animal via l'id de l'animal qui est déjà créer pour en récuperer les valeurs dans le formulaire.
        if( $editMode )
        {
            $model = new \Models\Animals();
            $ModifyAnimal = $model->selectAnimalById($_GET['id']);
        }
        
        
        $view = 'newAnimalForm.phtml';
        include_once 'views/layout.phtml';
    }
    
    
    
    
    public function submitNewAnimal()
    {
        
        
        $animalModel = new \Models\Animals();
        
        
        //on recupere les données du formulaire dans des variables et on les sécurises avec htmlspecialchars, comme cela nous pourrons réutiliser les variables plus facilement et de maniere sécurisé :
        
        $name = htmlspecialchars($_POST['name']);
        
        
        // on creer la route pour recevoir les photo qui seront stocker sur le server
        $destination_photo = 'public/img/avatar/';
        //on recupere le nom temporaire du fichier
        $tmp_name_file = $_FILES['photo']['tmp_name'];
        //on récupere le nom donnée a la photo
        $file     = $_FILES['photo']['name'];
        // on récupere la taille du fichier
        $file_size= $_FILES['photo']['size'];
        
        
        //on stock le chemin et le nom de la photo dans une variable
        $photo = $destination_photo . $_FILES['photo']['name'];
        
        
        
        //on récupere tous les autres éléments du formulaire
        $birthdate = htmlspecialchars($_POST['birthdate']);
        $colories = htmlspecialchars($_POST['colories']);
        $species = htmlspecialchars($_POST['species']);
        $race = htmlspecialchars($_POST['race']);
        $steril = htmlspecialchars($_POST['steril']);
        $descriptions = htmlspecialchars($_POST['descriptions']);
        $users_id = htmlspecialchars($_POST['users_id']);
    
        
        
        //en bdd le vraie ou faux est interpreter par 1 ou 0, nous faisons donc une petite liaison de connexion entre la valeurs recuperer dans le formulaire et la bdd
        if($steril === 'true')
        {
            $dbSteril = 1;
        }
        elseif($steril === 'false')
        {
            $dbSteril = 0;
        }
        
        
        
        //on verifie que les champs ne sont pas vide, bien définit et avec un controle de nombre de caractere
        if(     !empty($name) && isset($name) && strlen($name) <= 30
                && !empty($photo) && isset($photo) && strlen($photo) <= 255
                && !empty($birthdate) && isset($birthdate)
                && !empty($colories) && isset($colories) && strlen($colories) <= 30
                && !empty($race) && isset($race) && strlen($race) <= 30
                && !empty($steril) && isset($steril)
                && !empty($descriptions) && isset($descriptions)
                && strlen($descriptions) <= 500
                )
        {
            
            $tmp_name_file;
            $name_file = $file;
            $destination_photo;
            
            
            //si le fichier n'existe pas, nous ajoutons le fichier au répertoire choisi dans le serveur
            if (!file_exists($destination_photo))
            {
                mkdir($destination_photo);
            }
            
            //si il existe dejà, on le remplace
            move_uploaded_file($tmp_name_file, $destination_photo.$name_file);
            
            
            //si toute les conditions sont respecter, alors nous pouvons utiliser la methode addNewAnimal et enregistrer un nouvel animal en bdd
            $animalModel->addNewAnimal($name, $photo, $birthdate, $colories, $species, $race, $dbSteril, $descriptions, $users_id);
            
            //si l'operation est un succes, je supprime le msg d'erreur si il y en a eu un
            unset($_SESSION['message-animal-form']);
            
            //je suis rediriger vers la page personnelle où figurerera mon animal enregistrer
            header("Location: index.php?route=personalPage" );
            exit();
        }else{
            
            //si les conditions ne sont pas remplit, j'affiche un message d'erreur
            $_SESSION['message-animal-form'] ="merci de bien vouloir remplir tout les champs";
            
            //et je suis rediriger sur la page en cour, pour eviter la page blanche, où je pourrais voir mon meassage
            header('Location: '.$_SERVER['HTTP_REFERER']);
            exit();
            
        }
        
        
        
                
    }
    
    
    
    
    
    //fonction pour modifier les informations de son animal
    public function submitModifyAnimal()
    {
        
        //comme pour l'ajout, nous allons récuperer les donnée dans le formulaire
        $update = new \Models\Animals();
        
        
        $destination_photo = 'public/img/avatar/';
        
        $name = htmlspecialchars($_POST['name']);
        $photo = $destination_photo . $_FILES['photo']['name'];
        $birthdate = htmlspecialchars($_POST['birthdate']);
        $colories = htmlspecialchars($_POST['colories']);
        $species = htmlspecialchars($_POST['species']);
        $race = htmlspecialchars($_POST['race']);
        $steril = htmlspecialchars($_POST['steril']);
        $descriptions = htmlspecialchars($_POST['descriptions']);
        $id_animals = $_POST['id_animal'];
        $photo_Actuelle = $_POST['photo_actuelle'];
        
        
        
        if($steril === 'true')
        {
            $dbSteril = 1;
        }
        elseif($steril === 'false')
        {
            $dbSteril = 0;
        }
        
        //le message d'erreur 0 correspond a "pas d'erreur", il y a donc bien un fichier d'ajouter au formulaire
        if($_FILES['photo']['error'] === 0 && isset($_FILES['photo']))
        {
            //nous récuperons donc les informations du fichiers 
            $destination_photo  = 'public/img/avatar/';
            $tmp_name_file      = $_FILES['photo']['tmp_name'];
            $file               = $_FILES['photo']['name'];
            $file_size          = $_FILES['photo']['size'];
            $name_file          = $file;
            
            
            
            //on verifie qu'il n'existe pas alors on valide le chemin   
            if (!file_exists($destination_photo))
            {
                mkdir($destination_photo);
            }
            
            //si il n'existe pas, alors on le sauvegarde
            elseif(!file_exists($destination_photo.$file))
            {
                move_uploaded_file($tmp_name_file, $destination_photo.$name_file);
            }
           
            //on stock son chemin et son nom dans une variable
            $photo = $destination_photo . $_FILES['photo']['name'];
            
            unlink($photo_Actuelle);
            
        }
        //le message d'erreur 0 correspond a "aucun fichier", il n'ya donc pas de fichier ajouter dans le formulaire
        elseif($_FILES['photo']['error'] === 4)
        {
                //ce qui veut dire que nous gardons la photo déjà présente sur le serveur
                $photo = $photo_Actuelle;
                
            }
        
        
        //on envoie les nouvelles informations pour mettre à jour l'animal
        $updateAnimal = $update->updateAnimal($name, $photo, $birthdate, $colories, $species, $race, $dbSteril, $descriptions, $id_animals);
        
        
        
        
        
        header("Location: index.php?route=personalPage" );
        exit();
    }
    
    public function deleteAnimal()
    {
        
        
        $delete = new \Models\Animals();
       
        
        
        $animal = $delete->selectAnimalById($_GET['id']);
        
        
        unlink($animal['photo']);
        
       
       
       
        // on supprime l'animal par son id, ce qui evite de supprimer tous les animaux
        $delete->deleteAnimal($_GET['id']);
        
        header( 'Location: index.php?route=personalPage' );
        exit();
    }
    
    
    
    
}