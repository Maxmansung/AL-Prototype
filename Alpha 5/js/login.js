//This prevents certain letters from being used when typing into the form
function restrict(elem){
    var tf = _(elem);
    var rx = new RegExp;
    if(elem == "email"){
        rx = /[' "]/gi;
    } else if(elem == "username"){
        rx = /[^a-z0-9]/gi;
    } else if(elem == "maxplayers"){
        rx = /[^0-9]/gi;
    }
    tf.value = tf.value.replace(rx, "");
}

//This shortens the usage of document.getelementbyid into just _
function _(x) {
    return document.getElementById(x);
}


//This empties a form section
function emptyElement(x){
    _(x).innerHTML = "";
}

//This function counts the length of an object
function objectSize(obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
}

//This function counts the number of items within an object that match a specific example
function objectSizeVariable(obj,variable,comparison) {
    var size = 0;
    for (var key in obj) {
        if (obj[key][variable] === comparison){
            size++;
        }
    }
    return size;
}



function loginScreen(){
    $("#loginWrapperHidden").show();
    $("#loginScreen").click(function(loginScreenClose){
        loginScreenClose.stopPropagation()
        })
}

//This is the generic ajax code for the profile
function profile_ajax(type,u,p,e,security){
    var hr = new XMLHttpRequest();
    hr.open("POST", "/MVC/ajax_php/profile_ajax.php", true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function () {
        if (hr.readyState == 4 && hr.status == 200) {
            var response = JSON.parse(hr.responseText);
            console.log(response);
            if ("ERROR" in response) {
                errors(response.ERROR);
            } else{
                if (type === "signup"){
                    if(!alert("An activation email has been sent to your email address")){window.location.href = "/index.php";}
                } else if (type === "login") {
                    window.location.href = "/joingame.php";
                } else if (type === "newPass"){
                    if (!alert("A recovery email has been sent")) {
                        window.location.href="/index.php";
                    }
                }  else if (type === "recovery"){
                    if (!alert("Your password has been changed, please login with the new details")) {
                        window.location.href="/index.php";
                    }
                } else {
                    window.location.reload();
                }
            }
        }
    };
    hr.send("type="+type+"&u="+u+"&p="+p+"&e="+e+"&sec="+security);
}


function loginScreenClose(){
    $("#loginWrapperHidden").hide()
}

//This sends the login information and awaits a response
function loginButton(){
    var u = _("signinUsername").value;
    var p = _("signinPassword").value;
    var c = _("signinCookie").checked;
    if(u === ""){
        _("usernameSigninError").innerHTML = "Please input username";
    } else if (p === ""){
        _("passwordSigninError").innerHTML = "Please input password";
    } else {
        profile_ajax("login",u,p,"none",c);
    }
}

//This sends the signup information and awaits a response
function signupButton(){
    var u = _("signupUsername").value;
    var e = _("signupEmail").value;
    var p = _("signupPassword").value;
    var p2 = _("signupPasswordConfrm").value;
    var security = _("adminSecurePassword").value;
    if(u === ""){
        _("usernameSignupError").innerHTML = "Please input username";
    } else if (e === ""){
        _("emailSignupError").innerHTML = "Please input an email";
    } else if (p === ""){
        _("passwordSignupError").innerHTML = "Please input password";
    } else if (p2 === ""){
        _("passwordSignupError2").innerHTML = "Please input password";
    } else if(p !== p2){
        _("passwordSignupError2").innerHTML = "The passwords do not match";
    } else if(security === ""){
        _("adminPasswordError").innerHTML = "Please input the administrator password";
    } else {
        profile_ajax("signup",u,p,e,security)
    }
}


//This is used to listen to the enter key being pressed
function loginListener(){
    $("#signinPassword").keyup(function(event){
        if(event.keyCode == 13){
            $("#signinSubmit").click();
        }
    });
    $("#adminSecurePassword").keyup(function(event){
        if(event.keyCode == 13){
            $("#signupSubmit").click();
        }
    });
}

//This is used to recover the passwords for players
function submitPasswordChange(){
    var pR = $("#passwordRecovery").text();
    var u = $("#username").text();
    var p = $("#newPassword").val();
    var p2 = $("#newPassword2").val();
    if (p !== p2){
        alert("The passwords don't match")
    } else {
        profile_ajax("recovery",u,p,"none",pR);
    }
}

function testingScript(){
    var check = $("#passwordRecovery").text();
    if ( check !== "") {
        $("#passwordRecoveryWindow").append("<div class='loginTitle'>New Password</div><div class='signinInputBox'>New Password:<input type='password' id='newPassword' name='password1'></input></div><div class='signinInputBox'>Confirm Password:<input type='password' id='newPassword2' name='password2'></input></div><div id='recoveryError' class='errorBox'></div><button id='submitNewPassword' class='loginBoxSubmit' onclick='submitPasswordChange()'>Submit</button>")
    }
}

function submitForgottenRequest(){
    var u = $("#playerUsername").val();
    var e = $("#playerEmail").val();
    profile_ajax("newPass",u,"none",e,"none");
}

function blink(){
    $('#forumPostLink').fadeOut(500).fadeIn(500, blink);
}
