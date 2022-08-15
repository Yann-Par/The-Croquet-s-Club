
//on récupere dans une variable l'ID search, qui se trouve sur l'input de recherche dans adminPage.phtml
let input = document.getElementById("search");

//a cette variable, on ajoute un écouteurs d'évenement 'input' en 1er parametre et la fonction recupList en 2nd parametre 
input.addEventListener('input', recupList);


function recupList(){
    
        //grace a l'écouteur d'evenement 'input' on recupere le champ et on lui assign une nouvelle route avec 2 clés : SearchArticles et str ou il recupere la valeur de l'input
        fetch("index.php?route=searchUsers&str="+input.value)
        
            //ensuite la réponse au fetch sur la valeur récuperer dans l'input on le recupere dans la method text()
            .then(response => response.text())
            
            //ensuite le résultat on l'envoie dans la pertie adminPage.phtml dans la div avec l'id "target"
            .then(resultat => {
                
                let target = document.getElementById("target");
                target.innerHTML = resultat;
            })
        
    
    
}