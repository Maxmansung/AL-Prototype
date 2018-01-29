//////ERROR RESPONSES///

//This function returns the error response depending on the error created by the PHP functions
function errors(id){
    switch (id) {
        case 0:
            alert("You don't have enough stamina");
            break;
        case 1:
            alert("You cannot enter this zone");
            break;
        case 2:
            alert("You shouldn't be able to move this far - (Please error report this message 'ERROR 2')");
            break;
        case 3:
            alert("This item is no longer located here");
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
            if (!alert("This map has already filled")) {
                window.location.reload();
            }
            break;
        case 15:
            if (!alert("You have already played this map")) {
                window.location.reload();
            }
            break;
        case 16:
            if (!alert("You are already in a game")) {
                window.location.reload();
            }
            break;
        case 17:
            if (!alert("This map does not exist or is not on day 1")) {
                window.location.reload();
            }
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
            alert("You do not have appropriate access to perform this action");
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
            if (!alert("This profile does not exist")) {
                window.location.href = "/index.php";
            }
            break;
        case 38:
            if (!alert("That map no longer exists")) {
                window.location.reload();
            }
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
            alert("Your title is longer than 50 chars");
            break;
        case 44:
            alert("Your title is less than 4 chars");
            break;
        case 45:
            if (!alert("The post has failed as you are trying to post into a thread that you dont have access to (Shouldn't be possible without hacking, please error report this)")) {
                window.location.reload();
            }
            break;
        case 46:
            alert("Your post is less than 10 chars, please add more");
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
            if (!alert("You do not have access to this map")) {
                window.location.reload();
            }
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
            if (!alert("You have been logged out")){
                window.location.reload();
            }
            break;
        case 59:
            alert("This region makes you feel uneasy, its probably best not to disturb it too much - This Error shouldnt be seen, please bug report");
            break;
        case 60:
            alert("You dont have the required sacrifice");
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
            loginScreen();
            _("usernameSigninError").innerHTML = "Nothing written in fields";
            break;
        case 102:
            loginScreen();
            _("usernameSigninError").innerHTML = "That username does not exist";
            break;
        case 103:
            loginScreen();
            _("usernameSigninError").innerHTML = " The username and password do not match our records";
            break;
        case 104:
            loginScreen();
            _("usernameSigninError").innerHTML = " This profile has not yet been activated";
            break;
        case 105:
            _("usernameSignupError").innerHTML = "You have not filled all of the boxes";
            break;
        case 106:
            _("usernameSignupError").innerHTML = "This username has been taken";
            break;
        case 107:
            _("emailSignupError").innerHTML = "An account is already linked to this email";
            break;
        case 108:
            _("usernameSignupError").innerHTML = "Your username must be between 3 and 16 characters";
            break;
        case 109:
            _("usernameSignupError").innerHTML = "Your username cannot begin with a number";
            break;
        case 110:
            _("adminPasswordError").innerHTML = "Please get the correct password from Maxmansung";
            break;
        case 111:
            _("recoveryError").innerHTML = "Unable to find that username";
            break;
        case 112:
            _("recoveryError").innerHTML = "Unable to find that email address";
            break;
        case 113:
            _("recoveryError").innerHTML = "Please wait at least 5 minutes between recovery requests";
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
        case 1:
            if(!alert(data)){window.location.reload();}
            break;
        case 2:
            getRecipeList(data);
            break;
        case 3:
            var text = data.researchName;
            if(!alert("You have researched a "+text)){window.location.reload();}
            break;
        case 4:
            alert("No firepit has been built currently");
            break;
        case 5:
            var text;
            if (data === true){
                text = "now waiting for the day to end."
            } else {
                text = "not ready for the day to end any more"
            }
            if(!alert("You are "+text)){window.location.reload();}
            break;
        case 6:
            destroyResponse(data);
            break;
        case 7:
            if (!alert("You have joined the map: "+data)){window.location.reload();}
            break;
        case 8:
            if (!alert("You have deleted map: "+data)){window.location.reload();}
            break;
        case 9:
            if(!alert("The '"+data+"' has been completed")){window.location.reload();}
            break;
        case 10:
            alert("You have sent a message to ".data);
            messageSent();
            break
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