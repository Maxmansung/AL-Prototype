function recoverPassword() {
    var pass1 = $("#forgottenPassword1").val();
    var pass2 = $("#forgottenPassword2").val();
    var check = true;
    if (pass1 == ""){
        $("#forgottenPassword1").addClass("is-invalid");
        check = false;
    }
    if (pass2 == ""){
        $("#forgottenPassword2").addClass("is-invalid");
        check = false;
    }
    if (check === true) {
        if (pass1 !== pass2) {
            $("#forgottenPassword1").addClass("is-invalid");
            $("#forgottenPassword1Error").empty().append("Passwords do not match");
            $("#forgottenPassword2").addClass("is-invalid");
            $("#forgottenPassword2Error").empty().append("Passwords do not match");
            check = false;
        }
        if (check === true){
            var username = $(".getDataClass").attr("id");
            var security = $(".getDataClass2").attr("id");
            ajax_All(183,0,pass1,security,username);
        }
    }
}

function getListenerPassword() {
    $("#forgottenPassword1").keyup(function(event){
        if(event.keyCode == 13){
            $("#forgottenPassword2").focus();
        }
    }).on("focus",function(){
        $(this).removeClass("is-invalid");
        $("#forgottenPassword1Error").empty().append("Please type a password");
    });
    $("#forgottenPassword2").keyup(function(event){
        if(event.keyCode == 13){
            $("#submitPasswordForgotten").click();
        }
    }).on("focus",function(){
        $(this).removeClass("is-invalid");
        $("#forgottenPassword2Error").empty().append("Please type a password");
    });

}