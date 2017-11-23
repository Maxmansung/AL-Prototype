
//This prevents certain letters from being used when typing into the form
function restrict(elem){
    var tf = _(elem);
    var rx = new RegExp;
    if(elem == "email"){
        rx = /[' "]/gi;
    } else if(elem == "username"){
        rx = /[^a-z0-9]/gi;
    }
    tf.value = tf.value.replace(rx, "");
}
//This emptied whatever is in the HTML element x
function emptyElement(x){
    _(x).innerHTML = "";
}
//This shortens the usage of document.getelementbyid into just _
function _(x) {
    return document.getElementById(x);
}
//This compares the currently input text to anything on the detabase
function checkusername(){
    var u = _("username").value;
    if(u != ""){
        _("unamestatus").innerHTML = 'checking ...';
        var ajax = ajaxObj("POST", "signup.php");
        ajax.onreadystatechange = function() {
            if(ajaxReturn(ajax) == true) {
                _("unamestatus").innerHTML = ajax.responseText;
            }
        }
        ajax.send("usernamecheck="+u);
    }
}
//This sends the form
function signup(){
    var u = _("username").value;
    var e = _("email").value;
    var p1 = _("pass1").value;
    var p2 = _("pass2").value;
    var status = _("status");
    if(u == "" || e == "" || p1 == "" || p2 == ""){
        status.innerHTML = "Fill out all of the form data";
    } else if(p1 != p2){
        status.innerHTML = "Your password fields do not match";
    } else {
        _("signupbtn").style.display = "none";
        status.innerHTML = 'please wait ...';
        var ajax = ajaxObj("POST", "signup.php");
        ajax.onreadystatechange = function() {
            if(ajaxReturn(ajax) == true) {
                if(ajax.responseText != "signup_success"){
                    status.innerHTML = ajax.responseText;
                    _("signupbtn").style.display = "block";
                } else {
                    window.scrollTo(0,0);
                    _("signupform").innerHTML = "OK "+u+", check your email inbox and junk mail box at <u>"+e+"</u> in a moment to complete the sign up process by activating your account. You will not be able to do anything on the site until you successfully activate your account.";
                }
            }
        }
        ajax.send("u="+u+"&e="+e+"&p="+p1);
    }
}

function createmap(){
    var m = _("mapname").value;
    if(m == ""){
        _("status").innerHTML = "Please create a name";
    } else if (m.includes("(") == true) {
        _("status").innerHTML = "Please create a name";
    } else {
        _("status").innerHTML = "Good Job";
    }
}