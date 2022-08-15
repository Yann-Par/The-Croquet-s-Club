// code pour verifier en temps réel le mot de passe lors de l'inscription de l'utilisateurs.


//on récupere l'id sur le champs input type password
let mdp     = document.getElementById('mdp');


// on récupere les textes pour vérifier au moins 1 chiffre, une majuscule, 8 lettres
let maj     = document.getElementById('maj');
let chi     = document.getElementById('chi');
let car     = document.getElementById('car');




//on place un écouteur d'évenement sur l'input, sur la saisie de l'utilisateur en temps reel sans avoir besoin d'un rechargement de la page
mdp.addEventListener('input', function()
{

    //si les condition sont remplit le texte passe au vert
    //si la condition n'est pas remplit le texte apparait en rouge 

    //on verifie le nombre de caractere
    if (mdp.value.length >= 8 )
    {
        car.style.color = 'green';
    }else{
        car.style.color = 'red';
    }
    
    
    //on verifie qu'il y a bien un chiffre
    if (mdp.value.match( /[0-9]/g) )
    {
        chi.style.color = 'green';
        
    }else{
        chi.style.color = 'red';
    }
    
    
    
    //on verifie s'il y a bien une majuscule
    if (mdp.value.match( /[A-Z]/g))
    {
        maj.style.color = 'green';
        
    }else{
        maj.style.color = 'red';
    }
    
       
}) 

