

//This destroys the current session and logs the player out
function logoutButton() {
    ajax_All(37,"none","x");
}

function blink() {
    $('.navButtonFlash').fadeOut(500).fadeIn(500, blink);
}

function homePage() {
    window.location.href = "/index.php";
}