//////ERROR RESPONSES///

//This function returns the error response depending on the error created by the PHP functions
function errors(id){
    var title = "";
    var text = "";
    var image = "";
    var onclickValue = "";
    switch (id) {
        case 0:
            title = "Tired";
            text = "You don't have enough stamina to perform that action. Your stamina will be replenished overnight or you can try to find something to eat that could help";
            image = "tired.png";
            onclickValue = 0;
            customAlertBox(title,text,image,onclickValue);
            //alert("You don't have enough stamina");
            break;
        case 1:
            title = "No Access";
            text = "Something is preventing you from entering this zone, you may have to go around";
            image = "direction.png";
            onclickValue = 0;
            customAlertBox(title,text,image,onclickValue);
            //alert("You cannot enter this zone");
            break;
        case 2:
            alert("You shouldn't be able to move this far - (Please error report this message 'ERROR 2')");
            break;
        case 3:
            title = "No Item";
            text = "This item seems to have disappeared, sorry";
            image = "shrug.png";
            onclickValue = 0;
            customAlertBox(title,text,image,onclickValue);
            //alert("This item is no longer located here");
            break;
        case 4:
            var depleted = $("#depletedzone").length;
            if (depleted < 1) {
                if (!alert('This zone has now been depleted')) {
                    window.location.reload();
                }
            } else {
                alert("There is nothing left to find here");
            }
            break;
        case 5:
            if (!alert("Nothing was found after searching")) {
                window.location.reload();
            }
            break;
        case 6:
            alert("There is no more room in your bag");
            break;
        case 7:
            alert("This building is already built");
            break;
        case 8:
            alert("There are not enough items in storage for this building - (Please error report this message 'ERROR 8')");
            break;
        case 9:
            alert("The parent building for this has not been built yet - (Please error report this message 'ERROR 9')");
            break;
        case 10:
            alert("Not enough room in the storage");
            break;
        case 11:
            if (!alert('The firepit has gone out!')) {
                window.location.reload();
            }
            break;
        case 12:
            if (!alert('The required zone or item no longer exists - (Please error report this message "ERROR 12"))')) {
                window.location.reload();
            }
            break;
        case 13:
            alert("You do not currently have the required items");
            break;
        case 14:
            createAlertBox(5,1,"This land is already full",1);
            break;
        case 15:
            createAlertBox(5,1,"You have already played this land and died",1);
            break;
        case 16:
            createAlertBox(5,1,"You cannot exist in two lands at once, finish your current life first",1);
            break;
        case 17:
            createAlertBox(5,1,"This land has moved on without you, get there earlier next time",1);
            break;
        case 18:
            alert("You cannot leave a group where you are the only member - (Please error report this message 'ERROR 18')");
            break;
        case 19:
            alert("The party your avatar is in does not recognise you as a member - (Please error report this message 'ERROR 19')");
            break;
        case 20:
            //This will alert if the $playerID is not a real ID
            alert("The players party you've requested to join does not exist - (Please error report this message 'ERROR 20')");
            break;
        case 21:
            alert("You're already waiting to join that party - (Please error report this message 'ERROR 21')");
            break;
        case 22:
            alert("The player you are voting on is unknown to you - (Please error report this message 'ERROR 22')");
            break;
        case 23:
            alert("The game is attempting to apply an incorrect vote - (Please error report this message 'ERROR 23')");
            break;
        case 24:
            alert("This player is not within your group currently - (Please error report this message 'ERROR 24')");
            break;
        case 25:
            alert("You must be the only member of a party to change its name");
            break;
        case 26:
            alert("The party name you have entered is already in use by another party");
            break;
        case 27:
            alert("The name must be less than 20 characters and more than 2 characters");
            break;
        case 28:
            createAlertBox(0,1,"You do not have appropriate access to perform this action");
            break;
        case 29:
            if (!alert("The day has now ended!")) {
                window.location.reload();
            }
            break;
        case 30:
            alert("The timer has not expired and the game cannot be ended yet - (Please error report this message 'ERROR 30')");
            break;
        case 31:
            if (!alert("The day has not ended as there are not enough players!")) {
                window.location.reload();
            }
            break;
        case 32:
            alert("You cannot upgrade the storage if you don't have access the zone - (Please error report this message 'ERROR 32')");
            break;
        case 33:
            alert("The building has not yet been completed - (Please error report this message 'ERROR 33')");
            break;
        case 34:
            alert("You cannot perform this action - (Please error report this message 'ERROR 34')");
            break;
        case 35:
            if (!alert("The lock has been destroyed!")) {
                window.location.reload();
            }
            break;
        case 36:
            alert("The lock is fully reinforced already");
            break;
        case 37:
            createAlertBox(5,1,"There has been an error with the profile used",1);
            break;
        case 38:
            createAlertBox(5,1,"This map no longer exists to join",1);
            break;
        case 39:
            alert("You do not have this building researched yet");
            break;
        case 40:
            alert("There is nothing left to research at the moment. Please wait for an update");
            break;
        case 41:
            alert("You do not have the correct items in your storage");
            break;
        case 42:
            alert("You do not have the correct items in your backpack");
            break;
        case 43:
            createAlertBox(0,1,"Your title is longer than 50 chars");
            break;
        case 44:
            createAlertBox(0,1,"Your title is less than 4 chars");
            break;
        case 45:
            if (!alert("The post has failed as you are trying to post into a thread that you dont have access to (Shouldn't be possible without hacking, please error report this)")) {
                window.location.reload();
            }
            break;
        case 46:
            createAlertBox(0,1,"Your post is too short, please add more");
            break;
        case 47:
            alert("You have nothing to teach this player");
            break;
        case 48:
            alert("The player you are trying teach does not exist - (Please error report this message 'ERROR 48')");
            break;
        case 49:
            alert("This player already knows the research you are trying to teach them - (Please error report this message 'ERROR 49')");
            break;
        case 50:
            alert("This building does not exist - (Please error report this message 'ERROR 50')");
            break;
        case 51:
            alert("The player does not know the parent building required to learn it - (Please error report this message 'ERROR 49')");
            break;
        case 52:
            createAlertBox(5,1,"You cannot access this land at your current level",1);
            break;
        case 53:
            if (!alert("Congratulations, you're now an active player and can join the larger test maps")) {
                window.location.href = "/index.php";
            }
            break;
        case 54:
            alert("You can only request to join one group at a time. Please cancel your other request");
            break;
        case 55:
            if (!alert("You have died!")) {
                window.location.reload();
            }
            break;
        case 56:
            if (!alert("Death has been confirmed, get back in there!")) {
                window.location.reload();
            }
            break;
        case 57:
            if (!alert("Stamina has been refreshed")) {
                window.location.reload();
            }
            break;
        case 58:
            createAlertBox(1,1,"You have been logged out",1);
            break;
        case 59:
            alert("This region makes you feel uneasy, its probably best not to disturb it too much - This Error shouldnt be seen, please bug report");
            break;
        case 60:
            title = "Gods Unhappy";
            text = "It seems you don't have the required sacrifice for this shrine.<br><br>Come back when you're ready to do what it takes";
            image = "shrug.png";
            onclickValue = 0;
            customAlertBox(title,text,image,onclickValue);
            //alert("You dont have the required sacrifice");
            break;
        case 61:
            alert("This region has been locked away, please join the controlling party or break the lock down");
            break;
        case 62:
            alert("Somehow an uncontrolled zone is protected. Please bug report this");
            break;
        case 63:
            alert("You're too full to eat anything so disgusting looking");
            break;
        case 64:
            alert("No way! You're already feeling sick enough!");
            break;
        case 65:
            alert("You cant build in this zone - (This error shouldn't be seen, please bug report)");
            break;
        case 66:
            alert("With the world already spinning it seems sensible to sleep it off before you try anything like that again");
            break;
        case 100:
            alert("This action does not work currently");
            break;
        case 101:
            $("#username").addClass("is-invalid");
            $("#password").addClass("is-invalid");
            break;
        case 102:
            $("#username").addClass("is-invalid");
            _("usernameError").innerHTML = "That username does not exist";
            break;
        case 103:
            $("#password").addClass("is-invalid");
            _("passwordError").innerHTML = " The username and password do not match our records";
            break;
        case 104:
            $("#username").addClass("is-invalid");
            _("usernameError").innerHTML = " This profile has not yet been activated";
            break;
        case 105:
            $("#usernameSign").addClass("is-invalid");
            _("usernameSignError").innerHTML = "Please complete all sections";
            break;
        case 106:
            $("#usernameSign").addClass("is-invalid");
            _("usernameSignError").innerHTML = "This username has been taken";
            break;
        case 107:
            $("#email").addClass("is-invalid");
            _("emailError").innerHTML = "An account is already linked to this email";
            break;
        case 108:
            $("#usernameSign").addClass("is-invalid");
            _("usernameSignError").innerHTML = "Your username must be between 3 and 16 characters";
            break;
        case 109:
            $("#usernameSign").addClass("is-invalid");
            _("usernameSignError").innerHTML = "Your username cannot begin with a number";
            break;
        case 110:
            alert("The signup system is currently disabled on this site");
            break;
        case 111:
        case 112:
            $("#emailForgot").addClass("is-invalid");
            _("emailForgotAddress").innerHTML = "Unable to find that email address";
            break;
        case 113:
            $("#emailForgot").addClass("is-invalid");
            _("emailForgotAddress").innerHTML = "Please wait at least 5 minutes between recovery requests";
            break;
        case 114:
            alert("The request has failed due to a posting error - Please send a bug report (Error ID = "+id+")");
            break;
        case 115:
        case 116:
            _("recoveryError").innerHTML = "The link used appears to be broken - Please send a bug report (Error ID = "+id+")";
            break;
        case 117:
            _("recoveryError").innerHTML = "This account is not awaiting a recovery request - Please send a bug report (Error ID = "+id+")";
            break;
        case 118:
            _("recoveryError").innerHTML = "This recovery link has now expired, please create a new one";
            break;
        case 119:
            $("#usernameSign").addClass("is-invalid");
            _("usernameSignError").innerHTML = "Please avoid special characters";
            break;
        case 120:
            $("#email").addClass("is-invalid");
            _("emailError").innerHTML = "This email address contains unusual characters";
            break;
        case 121:
            createAlertBox(0,1,"Please only use PNG, JPEG, GIF or JPG file types");
            break;
        case 122:
            createAlertBox(0,1,"Please upload a single file");
            break;
        case 123:
            createAlertBox(3,1,"The image file is too big");
            break;
        case 124:
            createAlertBox(3,1,"The image file is too small");
            break;
        case 125:
            createAlertBox(3,1,"You cannot change your avatar image more than once in 12 hours");
            break;
        case 126:
            createAlertBox(3,1,"You can only make an error report once every 30 minutes");
            break;
        case 127:
            createAlertBox(3,1,"You have already reported this post");
            break;
        case 128:
            createAlertBox(0,1,"The news title is too short");
            break;
        case 129:
            createAlertBox(0,1,"The news title is too long");
            break;
        case 130:
            createAlertBox(0,1,"The news body is too short");
            break;
        case 131:
            $("#mapNameError").empty().append("There is already a map with this name");
            $("#createMapName").addClass("is-invalid");
            break;
        case 132:
            $("#playerCountError").empty().append("Players must be 1-40");
            $("#createMapPlayers").addClass("is-invalid");
            break;
        case 133:
            $("#edgeSizeError").empty().append("Size must be 3-30");
            $("#createMapEdge").addClass("is-invalid");
            break;
        case 134:
            createAlertBox(5,1,"This map has already been reported, please wait for a response",1);
            break;
        case 135:
            createAlertBox(5,1,"You can only report maps that you have access to, please don't try to hack the system",1);
            break;
        case 136:
            createAlertBox(5,1,"You can only use to allowed formats, please don't try to hack the system",1);
            break;
        case 200:
            window.location.href="/nightfall.php";
            break;
        default:
            alert("UNKNOWN ERROR HAS OCCURED - Please send a bug report (Error ID = "+id+")");
            break;
    }
}

function alerts(response,data){
    response = parseInt(response);
    switch (response){
        case 0:
            if (data === true) {
                createAlertBox(1,1,"You are now logged in and a cookie has been created",1);
            } else {
                createAlertBox(1,1,"You are now logged in",1);
            }
            break;
        case 1:
            createAlertBox(2,1,"A warning has been given to <b>"+data['name']+"</b>, they now have <b>"+data['points']+"</b> points",1);
            break;
        case 2:
            createAlertBox(2,1,"You have changed the rank of <b>"+data['name']+ "</b> from <b>"+data['old']+"</b> to <b>"+data['new']+"</b>",1);
            break;
        case 3:
            break;
        case 4:
            break;
        case 5:
            break;
        case 6:
            break;
        case 7:
            createAlertBox(2,1,"You have joined the map: "+data,1);
            break;
        case 8:
            break;
        case 9:
            break;
        case 10:
            break;
        case 11:
            break;
        case 12:
            break;
        case 13:
            var writing = "An email has been sent to: "+data+"\n You have 5mins to respond";
            createAlertBox(0,1,writing,1);
            break;
        case 14:
            createAlertBox(2,1,"Your profile has been updated",1);
            break;
        case 15:
            createAlertBox(2,1,"Your message has been sent",1);
            break;
        case 16:
            createAlertBox(2,1,"Your thread has been created",1);
            break;
        case 17:
            break;
        case 18:
            createAlertBox(2,1,"Your report has been received, thank you",1);
            break;
        case 19:
            createAlertBox(2,1,"News story has been uploaded",1);
            break;
        case 20:
            createAlertBox(2,1,"News story has been deleted",1);
            break;
        case 21:
            createAlertBox(2,1,"The map: '"+data+"' has been deleted",1);
            break;
        case 22:
            createAlertBox(2,1,"An email has been sent to '"+data+"', please use this to activate your account",1);
            break;
        case 23:
            createAlertBox(2,1,"Welcome to your first game of Arctic Lands, explore the world and try to learn",1);
            break;
        case 24:
            createAlertBox(2,1,"A new map has been created called: "+data,1);
            break;
        case 25:
            createAlertBox(2,1,"You have updated the avatar for: "+data,1);
            break;
        case 26:
            createAlertBox(2,1,"You have just killed: "+data,1);
            break;
        case 27:
            createAlertBox(2,1,"You have updated the map for: "+data,1);
            break;
        case 28:
            createAlertBox(2,1,"The report has now been resolved and a message will be sent to the reporting player",1);
            break;
    }
}

function getArrayWriting(data){
    var returnText = "";
    var counter = 1;
    for (var text in data){
        if (counter==(data.length)){
            returnText += "'"+data[text]+"'";
        } else if (counter ==(data.length)-1){
            returnText += "'"+data[text]+"' and ";
        } else {
            returnText += "'" + data[text] + "', ";
        }
        counter++;
    }
    return returnText;
}

function getRecipeList(data){
    var arrayList = [];
    for(var num in data) {
        arrayList[num] = data[num].identity;
    }
    var text = getArrayWriting(arrayList);
    alert("This requires: "+text);
}



function createAlertBox(titleType,textType,data,buttontype,moreButton){
    var title = "Error";
    var text = "Error";
    var buttons = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
    switch (titleType){
        case 1:
            title = "";
            break;
        case 2:
            title = "Success";
            break;
        case 3:
            title = "Failed";
            break;
        case 4:
            title = "Warning";
            break;
        case 5:
            title = "Error";
            break;
        case 0:
        default:
            title = "Alert!";
            break;
    }
    switch (textType){
        case 1:
            text = data;
            break;
        default:
            text = "Something has gone wrong - Please bug report ERROR: "+data;
            break
    }
    switch (buttontype){
        case 1:
            buttons = '<button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="refreshPage()">Close</button>';
            break;
        case 2:
            buttons = '<button type="button" class="btn btn-dark" data-dismiss="modal">No</button><button type="button" class="btn btn-danger" data-dismiss="modal" onclick="'+moreButton+'()">Yes</button>';
            break;
        case 3:
            buttons = '<input type="text" id="passwordRequiredModal" class="form-control mx-2" autofocus><button type="button" class="btn btn-dark" data-dismiss="modal">No</button><button type="button" class="btn btn-danger" onclick="'+moreButton+'()">Yes</button>';
            break;
        default:
            break;
    }
    $("#alertBox .modal-title").empty().append(title);
    $("#alertBox .modal-body").empty().append(text);
    $("#alertBox .modal-footer").empty().append(buttons);
    $('#alertBox').modal({
        backdrop: 'static',
        keyboard: false
    });
}