function initializeNavBar() {
    resizeNavBar();
    window.onresize = function (event) {
        resizeNavBar();
    }
}

/* Set the width of the side navigation to 250px and the left margin of the page content to 250px */
function openNav(user) {
    document.getElementById("sidebar").style.width = "200px";
    document.getElementById("main").style.marginLeft = "206px"
    document.getElementById("navaction").innerHTML = "&times;";
    document.getElementById("logo").style.marginTop = "0px";
    document.getElementById("sidebar").classList.remove("smallerLinks");
    document.getElementById('navaction').onclick = function () {
        closeNav(true);
    };
    
    if (user)
        document.getElementById("sidebar").classList.add("user");
}

/* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
function closeNav(user) {
    document.getElementById("sidebar").style.width = "80px";
    document.getElementById("main").style.marginLeft = "86px"
    document.getElementById("sidebar").classList.add("smallerLinks");
    document.getElementById("logo").style.marginTop = "40px";
    document.getElementById("navaction").innerHTML = "►►";
    document.getElementById('navaction').onclick = function () {
        openNav(true);
    };
    if (user)
        document.getElementById("sidebar").classList.add("user");
}

/* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
function resizeNavBar() {
    /* equivalents to @media(width) and @media(height) of css */
    var device_width = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
    var device_height = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);

    if (device_width < 600 && !document.getElementById("sidebar").classList.contains("user")) {
        closeNav(false);
    } /* if the navigation bar was closed programatically, not by user, reopen it since the window seems to be big enough */
    else if (!document.getElementById("sidebar").classList.contains("user"))
        openNav(false);
}