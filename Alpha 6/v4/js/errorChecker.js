//////ERROR RESPONSES///

//This function returns the error response depending on the error created by the PHP functions
function errors(id){
    var title = "";
    var text = "";
    var image = "";
    var onclickValue = "";
    switch (id) {
        case 0:
            createAlertBox(5,1,"You're too tired to do that, please wait until you have more energy");
            break;
        case 1:
            createAlertBox(5,1,"Something is preventing you from entering this zone, you'll have to go around");
            break;
        case 2:
            createAlertBox(5,1,"You cant move any further, it's even scarier out there!");
            break;
        case 3:
            createAlertBox(5,1,"This item no longer exists in that location");
            break;
        case 4:
            createAlertBox(3,1,"The zone has been stripped bare, there's nothing left to find");
            break;
        case 5:
            createAlertBox(5,1,"Your search found nothing, try harder!",1);
            break;
        case 6:
            createAlertBox(5,1,"Not enough room in your bag for that");
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
            createAlertBox(5,1,"You have died overnight",3,goToPage("death"));
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
        case 30:
            alert("The timer has not expired and the game cannot be ended yet - (Please error report this message 'ERROR 30')");
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
            createAlertBox(0,1,"You already know all of the available building designs");
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
            createAlertBox(2,1,"You finish examining your recent life and feel the cold pulling you back in again. You know you can do better next time",1);
            break;
        case 57:
            createAlertBox(2,1,"Your stamina has been refreshed for this test game",1);
            break;
        case 58:
            createAlertBox(1,1,"You have been logged out",1);
            break;
        case 59:
            createAlertBox(4,1,"This region makes you feel uneasy, its probably best not to disturb it too much");
            break;
        case 60:
            createAlertBox(4,1,"You don't have the required sacrifice required to please this god, come back when you're worthy");
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
        case 67:
            createAlertBox(3,1,"You sense an emptiness and realise that this god has abandoned you. There is no point in worshipping here");
            break;
        case 68:
            createAlertBox(4,1,"Your friends will be sad if you betray them for another party. Maybe you should commit to leaving first before you start trying to join other people");
            break;
        case 100:
            createAlertBox(5,1,"You do not have permission to perform this action",1);
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
            window.location.href="/?page=nightfall";
            break;
        case 29:
        case 31:
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
            } else if (data === "IP"){
                createAlertBox(0,1,"You have recently logged in from another IP address and so the page will refresh",1);
            } else  {
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
            createAlertBox(2,1,"You have deleted the post by <b>"+data+"</b>, please make sure the report has been closed and any warnings are given if required",1);
            break;
        case 4:
            createAlertBox(2,1,"Your comment has been posted",1);
            break;
        case 5:
            createAlertBox(2,1,"You have edited the post by <b>"+data+"</b>",1);
            break;
        case 6:
            createAlertBox(0,1,"Everyone is ready and the day has now ended, Good luck...",1);
            break;
        case 7:
            createAlertBox(2,1,"You have joined the map: "+data,1);
            break;
        case 8:
            var count = "items are";
            if (data.foundItems === 1){
                count = "item is";
            }
            createAlertBox(2,1,"You have completely destroyed this zone <nl>"+data.foundItems+" "+count+" left amongst the charred remains",1);
            break;
        case 9:
            createAlertBox(2,1,data,1);
            break;
        case 10:
            var name = "";
            var count = objectSize(data);
            var counter = 0;
            for (var x in data) {
                counter++;
                if (count-counter === 0) {
                    name += data[x].identity;
                } else if (count-counter === 1){
                    name += data[x].identity + "</b> and <b>";
                } else {
                    name += data[x].identity + ", ";
                }
            }
            createAlertBox(3,1,"This recipe requires the following items to be in your backpack: <b>"+name+"</b>");
            break;
        case 11:
            createAlertBox(3,1,data);
            break;
        case 12:
            createAlertBox(2,1,"You have worked out the designs for a "+data.researchName,1);
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
            createAlertBox(2,1,"It took a lot of effort but you finally showed <b>"+data.player+"</b> how to make '<b>"+data.building+"'</b>",1);
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
        case 29:
            createAlertBox(4,1,"You are already waiting to join the party: '<b>"+data.current+"</b>'<br><br>Do you want to cancel this request to join '<b>"+data.joining+"</b>'",4,"switchRequestParty",data.id);
            break;
        case 30:
            createAlertBox(2,1,"You have now left '"+data+"', let's hope you can survive better alone...",1);
            break;
        case 31:
            createAlertBox(0,1,data,1);
            break;
        case 32:
            createAlertBox(2,1,"You have created a <b>"+data+"</b>",1);
            break;
        case 33:
            createAlertBox(4,1,"Joining this party will cause you to lose favour with the <b>Cold Gods</b>.<br><br>Are you sure you still want to do it?",4,"confirmJoinParty","joinParty"+data);
            break;
        case 34:
            createAlertBox(4,1,"Leaving this party will cause them to lose favour with the <b>War Gods</b>.<br><br>Are you sure you still want to do it?",2,"leavePartyConfirm2");
            break;
        case 35:
            createAlertBox(4,1,"If you continue with this vote your party will lose favour with the <b>War Gods</b><br><br>Are you sure you still want to do this?",4,"voteOnPlayerConfirm","accept"+data);
            break;
        case 36:
            createAlertBox(4,1,"If you accept this person into your party you will lose favour with the <b>Cold Gods</b><br><br>Are you sure you want to do this?",4,"voteOnPlayerConfirm","accept"+data);
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



function createAlertBox(titleType,textType,data,buttontype,moreButton,moreButtonID){
    var title = "Error";
    var text = "Error";
    var buttons = '<button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeButtonAlert">Close</button>';
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
            buttons = '<button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="refreshPage()" id="closeButtonAlert">Close</button>';
            break;
        case 2:
            buttons = '<button type="button" class="btn btn-dark" data-dismiss="modal">No</button><button type="button" class="btn btn-danger" data-dismiss="modal" onclick="'+moreButton+'()">Yes</button>';
            break;
        case 3:
            buttons = '<input type="text" id="passwordRequiredModal" class="form-control mx-2" autofocus><button type="button" class="btn btn-dark" data-dismiss="modal">No</button><button type="button" class="btn btn-danger" onclick="'+moreButton+'()">Yes</button>';
            break;
        case 4:
            buttons = '<button type="button" class="btn btn-dark" data-dismiss="modal">No</button><button type="button" class="btn btn-danger" data-dismiss="modal" onclick="'+moreButton+'(this.id)" id="buttonID'+moreButtonID+'">Yes</button>';
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
    $("#alertBox").keyup(function (event) {
        if (event.keyCode == 13) {
            $("#closeButtonAlert").click();
        }
    });
}