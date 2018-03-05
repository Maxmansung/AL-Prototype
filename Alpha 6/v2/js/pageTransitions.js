var currentPage = "login";

function loadLoginPage(){
    loginListener();
    displayPages();
    ajax_All(49,1);
}


function displayPages(){
    switch (currentPage){
        case "login":
            $("#signupWindowScreen").hide();
            $("#loginWindowScreen").show();
            $("#forgottenPasswordScreen").hide();
            $("#username").focus();
            break;
        case "register":
            $("#signupWindowScreen").show();
            $("#loginWindowScreen").hide();
            $("#forgottenPasswordScreen").hide();
            $("#usernameSign").focus();
            break;
        case "forgot":
            $("#signupWindowScreen").hide();
            $("#loginWindowScreen").hide();
            $("#forgottenPasswordScreen").show();
            $("#emailForgot").focus();

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

function clickForgotten(){
    currentPage = "forgot";
    displayPages()
}

//This sends the login information and awaits a response
function loginButton(){
    var u = _("username").value;
    var p = _("password").value;
    var c = _("rememberMe").checked;
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

//This sends the signup information and awaits a response
function signupButton(){
    var u = _("usernameSign").value;
    var u2 = u;
    var p = _("password1").value;
    var p2 = _("password2").value;
    var e = _("email").value;
    var complete = true;
    if(u === ""){
        $("#usernameSign").addClass("is-invalid");
        complete = false;
    } else {
        u2 = u.replace(/[^a-zA-Z0-9]/g, "");
        if ($("#usernameSign").hasClass("is-invalid")){
            $("#usernameSign").removeClass("is-invalid");
        }
    }
    if (u2 !== u){
        $("#usernameSign").addClass("is-invalid");
        $("#usernameSignError").empty().append("Please avoid special characters");
        complete = false;
    }
    if(p === ""){
        $("#password1").addClass("is-invalid");
        complete = false;
    } else {
        if ($("#password1").hasClass("is-invalid")){
            $("#password1").removeClass("is-invalid");
        }
    }
    if(p2 === ""){
        $("#password2").addClass("is-invalid");
        complete = false;
    } else {
        if ($("#password2").hasClass("is-invalid")){
            $("#password2").removeClass("is-invalid");
        }
    }
    if(e === ""){
        $("#email").addClass("is-invalid");
        complete = false;
    } else {
        if ($("#email").hasClass("is-invalid")){
            $("#email").removeClass("is-invalid");
        }
    }
    if (p !== p2 && p2 !== "" && p !== ""){
        $("#password2").addClass("is-invalid");
        $("#password2Error").empty().append("Passwords do not match");
        complete = false;
    }
    if (complete === true){
        ajax_All(197,0,u,e,p,"test");
    }
}

//This function makes the forgotten email system work
function forgottenPassword() {
    var e = _("emailForgot").value;
    var complete = true;
    if(e === ""){
        $("#emailForgot").addClass("is-invalid");
        complete = false;
    } else {
        if ($("#emailForgot").hasClass("is-invalid")){
            $("#emailForgot").removeClass("is-invalid");
        }
    }
    if (complete === true) {
        ajax_All(196,"none",e);
    }
}

function createNews(data){
    $("#newsStories").empty();
    for (var x in data){
        $("#newsStories").append("<div class='row d-flex flex-row align-items-center newsBar m-2 py-1' id='newsLink"+x+"'></div>");
        $("#newsLink"+x).append('<div class="col-1"></div><div class="newsDate d-flex flex-column align-items-center"><div><strong>'+data[x].month+'</strong></div><div>'+data[x].day+'</div></div><div class="mr-md-auto mr-0 ml-auto ml-md-4"><div class="h5">'+data[x].title+'<br><small class="text-muted">By '+data[x].author+'</small></div></div><div class="d-none d-md-block">Comments   <i class="far fa-comments"></i></div><div class="col-1"></div>')
    }
}

function loginListener(){
    $("#password").keyup(function(event){
        if(event.keyCode == 13){
            $("#loginButton").click();
        }
    }).on("focus",function(){
        $(this).removeClass("is-invalid");
        $("#passwordError").empty().append("Enter password");
    });

    $("#username").keyup(function(event){
        if(event.keyCode == 13){
            $("#password").focus();
        }
    }).on("focus",function(){
        $(this).removeClass("is-invalid");
        $("#usernameError").empty().append("Enter username");
    });

    $("#password2").keyup(function(event){
        if(event.keyCode == 13){
            $("#signupButton").click();
        }
    }).on("focus",function() {
        $(this).removeClass("is-invalid");
        $("#password2Error").empty().append("Enter password");
    });

    $("#usernameSign").keyup(function(event){
        if(event.keyCode == 13){
            $("#email").focus();
        }
    }).on("focus",function(){
        $(this).removeClass("is-invalid");
        $("#usernameSignError").empty().append("Enter username");
    });

    $("#password1").keyup(function(event){
        if(event.keyCode == 13){
            $("#password2").focus();
        }
    }).on("focus",function(){
        $(this).removeClass("is-invalid");
        $("#password1Error").empty().append("Enter password");
    });

    $("#email").keyup(function(event){
        if(event.keyCode == 13){
            $("#password1").focus();
        }
    }).on("focus",function(){
        $(this).removeClass("is-invalid");
        $("#emailError").empty().append("Enter email address");
    });

    $("#emailForgot").keyup(function(event){
        if(event.keyCode == 13){
            $("#reminderButton").click();
        }
    }).on("focus",function(){
        $(this).removeClass("is-invalid");
        $("#emailForgotAddress").empty().append("Enter email address");
    });
}