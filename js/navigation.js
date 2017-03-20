/* Set the width of the side navigation to 250px and the left margin of the page content to 250px */
function openNav() {
    document.getElementById("sidebar").style.width = "200px";
    document.getElementById("main").style.marginLeft = "200px";
    document.getElementById("navaction").innerHTML ="&times;";
    document.getElementById('navaction').onclick = function(){ closeNav(); } ;
}

/* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
function closeNav() {
    document.getElementById("sidebar").style.width = "50px";
    document.getElementById("main").style.marginLeft = "50px";
    document.getElementById("navaction").innerHTML ="►►";
    document.getElementById('navaction').onclick = function(){ openNav(); } ;
}