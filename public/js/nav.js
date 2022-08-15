let sidenav = document.getElementById("mySideNav");
let openBtn = document.getElementById("openBtn");
let closeBtn = document.getElementById("closeBtn");

let closeOverlay = document.querySelector('main');


openBtn.addEventListener('click', openNav);

closeBtn.addEventListener('click', closeNav);





function openNav()
{
    sidenav.classList.add("active");
}

function closeNav()
{
    sidenav.classList.remove("active");
}



if (sidenav === openNav)
{
    closeOverlay.addEventListener('click', closeNav);
}
