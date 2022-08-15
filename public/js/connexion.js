document.addEventListener('DOMContentLoaded', function(){
    
   // récupération de l'id sur la tete du chien pour la connexion dans le header 
   const link               = document.querySelector('#connexion'); 
   
   // récupération de la class modale dans le layout pour récuperer tout ce qui devra s'afficher
   const modale             = document.querySelector('.modale');
   
   
   //récupération du formulaire de connexion
   let modaleCentrale       = document.querySelector(".modaleForm");
   
   
   
   
   
   // quand on click sur la tete du  chien, la modale de connexion aura un nouveau display qui le fera apparaitre
   link.addEventListener("click", function()
   {
        modale.style.display ="flex";  
   })
   
   
   
   
   // tant que l'on clique sur le formulaire; celui ci restera activé
   modaleCentrale.addEventListener("click", function()
   {
        modale.style.display = "flex"; 
   }, true)
   
   
   
   
   // dès que l'on click en dehors du formulaire sur le reste de la page de la modale, celui ci se masquera grace au display none
   modale.addEventListener("click", function()
   {
        modale.style.display = "none";
   }, true)
})