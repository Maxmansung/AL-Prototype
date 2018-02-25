var currentPage = "login";

function displayPages(){
    switch (currentPage){
        case "login":
            $("#signupWindowScreen").hide();
            $("#loginWindowScreen").show();
            break;
        case "register":
            $("#signupWindowScreen").show();
            $("#loginWindowScreen").hide();
            break;
    }
}

function clickRegister(){
    currentPage = "register";
    displayPages()
}

function clickSignin() {
    currentPage = "login";
    displayPages()
}

//This sends the login information and awaits a response
function loginButton(){
    var u = _("username").value;
    var p = _("password").value;
    var c = _("someSwitchOptionPrimary").checked;
    if(u === ""){
        $("#username").addClass("is-invalid");
    } else {
        if ($("#username").hasClass("is-invalid")){
            $("#username").removeClass("is-invalid");
        }
    }
    if (p === ""){
        $("#password").addClass("is-invalid");
    } else {
        if ($("#password").hasClass("is-invalid")){
            $("#password").removeClass("is-invalid");
        }
    }
    if (p !== "" && u !== "") {
        ajax_All(198,0,u,p,c);
    }
}

var googleUser = {};
var startApp = function() {
    gapi.load('auth2', function(){
        // Retrieve the singleton for the GoogleAuth library and set up the client.
        auth2 = gapi.auth2.init({
            client_id: '134675946741-hst7s6r63ff8c5tt4pubanm01am8tb0i.apps.googleusercontent.com',
            cookiepolicy: 'single_host_origin',
            // Request scopes in addition to 'profile' and 'email'
            //scope: 'additional_scope'
        });
        attachSignin(document.getElementById('customBtn'));
    });
};

function attachSignin(element) {
    auth2.attachClickHandler(element, {},
        function(googleUser) {
            document.getElementById('name').innerText = "Signed in";
            console.log(googleUser);
        }, function(error) {
            alert(JSON.stringify(error, undefined, 2));
        });
}