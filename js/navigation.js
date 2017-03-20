/* Set the width of the side navigation to 250px and the left margin of the page content to 250px */
function openNav() {
    document.getElementById("sidebar").style.width = "200px";
    document.getElementById("main").style.marginLeft = "206px"
    document.getElementById("navaction").innerHTML = "&times;";
    document.getElementById("logo").style.marginTop = "0px";
    document.getElementById("sidebar").classList.remove("smallerLinks");
    document.getElementById('navaction').onclick = function () {
        closeNav();
    };
}

/* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
function closeNav() {
    document.getElementById("sidebar").style.width = "80px";
    document.getElementById("main").style.marginLeft = "86px"
    document.getElementById("sidebar").classList.add("smallerLinks");
    document.getElementById("logo").style.marginTop = "40px";
    document.getElementById("navaction").innerHTML = "►►";
    document.getElementById('navaction').onclick = function () {
        openNav();
    };
}