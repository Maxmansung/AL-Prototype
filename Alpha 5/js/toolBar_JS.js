

//This destroys the current session and logs the player out
function logoutButton() {
    ajax_All(37,"none","x");
}

function forumPage(){
    window.location.href = "/forum.php";
}

function profilePage(profile){
    window.location.href = "/user.php?u="+profile;
}

function diaryPage(){
    window.location.href = "/ingame.php";

}

function mapPage(){
    window.location.href = "/ingame.php?p=m";

}

function constructPage(){
    window.location.href = "/ingame.php?p=c";

}

function playersPage(){
    window.location.href = "/ingame.php?p=p";

}

function joinGame(){
    window.location.href = "/joingame.php";

}

function blink() {
    $('.navButtonFlash').fadeOut(500).fadeIn(500, blink);
}