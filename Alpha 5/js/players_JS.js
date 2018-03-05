///////////PLAYERS TAB JAVASCRIPT///////////

//This function updates all of the players page
function updatePlayerPage(response){
    inGameList(response.avatars);
    partyActions(response.logs);
}

function inGameList(response){
    var countGroup = objectSizeVariable(response,"inParty",true);
    $("#playersList").empty();
    var avatarPlayer = "";
    for (var player in response){
        if (response[player].isPlayer === true) {
            avatarPlayer = player;
        }
    }
    for (var player in response) {
        if (response[player].avatarAlive === false) {
            if ($("#deadList").length == 0) {
                $("#playersList").append("<div class='partyHolder' id='deadList'><div class='partyHolderTitle'>Dead Survivors</div></div>")
            }
            $("#deadList").append("<div class='playerDivName'><strong><del><a class='usernamelink' href='/user.php?u=" + response[player].avatarName + "'>" + response[player].avatarName + "</a></del></strong></div>")
        }
        else {
            if ($("#party" + response[player].avatarPartyID).length == 0) {
                var partyName = "Unknown";
                if (response[player].avatarParty !== null) {
                    partyName = response[player].avatarParty;
                }
                if (response[player].inParty === true) {
                    $("#playersList").prepend("<div class='partyHolderSelf''><div class='partyHolderTitle'>" + partyName + "</div><div class='verticalWrapWide'  id='party" + response[player].avatarPartyID + "'></div></div>");
                } else {
                    $("#playersList").append("<div class='partyHolder' id='party" + response[player].avatarPartyID + "'><div class='partyHolderTitle'>" + partyName + "</div></div>");
                }
            }
            if (response[player].avatarName !== null) {
                $("#party" + response[player].avatarPartyID).append("<div class='playerdiv' id='zonediv" + response[player].avatarID + "'></div>");
                $("#zonediv" + response[player].avatarID).append("<div class='playerdivname'><a class='usernamelink' href='/user.php?u=" + response[player].avatarName + "'><strong>" + response[player].avatarName + "</strong></a></div>");
                if (response[player].inPlayerZone === true) {
                    if (response[player].isPlayer === false) {
                        var nameCombo = response[player].avatarID+"?+!"+response[player].avatarName;
                        $("#zonediv" + response[player].avatarID).append("<div class='imagediv'><img class='teachResearchImg' src='/images/teaching.png' id='teach" + response[player].avatarID + "' onclick='teachPlayer(this.id)'><div class='imagetext'>Teach " + response[player].avatarName + "<br><div class='explanationText'>Costs 2 stamina</div></div></div>")
                            .append("<div class='imagediv' id='" + nameCombo + "' onclick='messagePlayer(this.id)'><img class='teachResearchImg' src='/images/messageIcon.png'><div class='imagetext'>Message " + response[player].avatarName + "<br><div class='explanationText'>Write a private message to this player</div></div></div>");
                        if (response[player].inParty === false) {
                            if (countGroup < 2 || response[player].pendingRequest) {
                                if (response[player].awaitingInvite === false) {
                                    $("#zonediv" + response[player].avatarID).append("<div class='imagediv' id='" + response[player].avatarID + "' onclick='joinGroup(this.id)'><img class='teachResearchImg' src='/images/joinTeam.png'><div class='imagetext'>Join " + response[player].avatarParty + "<br><div class='explanationText'>This will send a message requesting to join the party</div></div></div>");
                                } else {
                                    $("#zonediv" + response[player].avatarID).append("<div class='imagediv' id='" + response[player].avatarID + "' onclick='cancelJoin(this.id)'><img class='teachResearchImg' src='/images/joinTeamCancel.png'><div class='imagetext'>Cancel Request<br><div class='explanationText'>This will cancel the request to join the party</div></div></div>");
                                }
                            } else {
                                $("#zonediv" + response[player].avatarID).append("<div class='invitegroup'>-</div>");
                            }
                        } else {
                            if (countGroup > 2) {
                                if (response[player].kickingPlayer === true) {
                                    $("#zonediv" + response[player].avatarID).after("<div class='votingDivInfo' id='votingDiv" + response[player].avatarID + "'></div>");
                                    displayVotes(response, player, "kick");
                                } else {
                                    $("#zonediv" + response[player].avatarID).append("<div class='imagediv'><img class='teachResearchImg' src='/images/kickPlayerIcon.png' id='" + response[player].avatarID + "' onclick='kickFromGroup(this.id)'><div class='imagetext'>Kick Player<br><div class='explanationText'>This begins a vote to remove a player from the party</div></div></div>");
                                }
                            } else {
                                $("#zonediv" + response[player].avatarID).append("<div class='imagediv'><img class='teachResearchImg' src='/images/kickPlayerCancelIcon.png'><div class='imagetext'>Nothing<br><div class='explanationText'>You need more than two players to kick someone from the group. Why not just leave?</div></div></div>");
                            }
                        }
                    } else {
                        if (countGroup === 1) {
                            $(".partyHolderSelf .partyHolderTitle").append("<div class='imagediv' id='" + response[player].avatarParty + "' onclick='editGroupName(this.id)'><img class='teachResearchImg' src='/images/edit_text.png'><div class='imagetext'>Change Name<br><div class='explanationText'>As you own the party you can call it what you like</div></div></div>");
                        }
                        if (countGroup > 1) {
                            $("#zonediv" + response[player].avatarID).append("<div class='imagediv'><img class='teachResearchImg' src='/images/leavePartyIcon.png' onclick='leaveGroup()'><div class='imagetext'>Leave Party<br><div class='explanationText'>Click here to leave the party and go it alone. They may not want you back after this though...</div></div></div>");
                        }
                    }
                }
            } else {
                $("#party" + response[player].avatarPartyID).append("<div class='playerdiv'><div class='playerdivname'><strong>Unknown</strong></div></div>");
            }
        }
    }
    for (var player in response) {
        if (response[player].invitingPlayer === true) {
            if ($("#requestingPlayer").length == 0) {
                $(".partyHolderSelf").append("<div id='requestingPlayer'><div class='partyHolderTitle'>Requesting to join</div></div>");
            }
            $("#requestingPlayer").append("<div class='playerdiv' id='classdiv" + response[player].avatarID + "'><div class='imagediv'><img class='teachResearchImg' src='/images/downArrowMaps.png' id='" + response[player].avatarID + "' onclick='seePartyVotes(this.id)'><div class='imagetext'>More<br><div class='explanationText'>See the rest of the parties votes</div></div></div></div><div class='votingDivInfo' id='votingDiv" + response[player].avatarID + "'></div>");
            displayVotes(response,player,"join");
        }
    }
    $(".votingDivInfo").hide();
}


function displayVotes(response, votingOn, type){
    console.log(votingOn);
    var votingPlayer = response[votingOn].avatarID;
    for (var voter in response) {
        if (response[voter].isPlayer === true) {
            switch (response[voter].votingChoice[votingPlayer]) {
                case 0:
                    if (type === "kick") {
                        console.log("Kicking Player");
                        $("#zonediv" + response[votingOn].avatarID).append("<div class='imagediv'><img class='teachResearchImg' src='/images/acceptIcon.png'id='playera" + response[votingOn].avatarID + "' onclick='playerAccept(this.id)'><div class='imagetext'>Accept " + response[votingOn].avatarName + "<br><div class='explanationText'>Enough of the party must agree to kick this player out</div></div></div><div class='imagediv'><img class='teachResearchImg' src='/images/rejectIcon.png' <button id='playerr" + response[votingOn].avatarID + "' onclick='playerReject(this.id)'><div class='imagetext'>Reject " + response[votingOn].avatarName + "<br><div class='explanationText'>If enough people reject then the player will stay</div></div></div>");
                    }
                    if (type === "join") {
                        $("#classdiv" + response[votingOn].avatarID).prepend("<div class='playerdivname'><strong>" + response[votingOn].avatarName + "</strong></div>")
                            .append("<div class='selectionWrapper'><div class='imagediv'><img class='teachResearchImg' src='/images/acceptIcon.png' id='" + response[votingOn].avatarID + "' onclick='playerAccept(this.id)'><div class='imagetext'>Accept " + response[votingOn].avatarName + "<br><div class='explanationText'>Enough of the party must agree to accept a new player in</div></div></div><div class='imagediv'><img class='teachResearchImg' src='/images/rejectIcon.png' id='" + response[votingOn].avatarID + "' onclick='playerReject(this.id)'><div class='imagetext'>Reject " + response[votingOn].avatarName + "<br><div class='explanationText'>If enough people reject then the request will be cancelled</div></div></div></div>");
                    }
                    break;
                case 1:
                    if (type === "kick") {
                        $("#zonediv" + response[votingOn].avatarID).append("<div class='imagediv'><img class='teachResearchImg' src='/images/kickPlayerDetailsIcon.png' id='" + response[votingOn].avatarID + "' onclick='seePartyVotes(this.id)'><div class='imagetext' >More details<br><div class='explanationText'>Click to see the details of the kicked player</div></div></div>");
                    }
                    if (type === "join") {
                        $("#classdiv" + response[votingOn].avatarID).prepend("<div class='playerdivnameGreen'><strong>" + response[votingOn].avatarName + "</strong></div>")
                            .append("<div class='selectionWrapper'></div>");
                    }
                    break;
                case 2:
                    if (type === "kick") {
                        console.log("Kicking Player");
                        $("#zonediv" + response[votingOn].avatarID).append("<div class='imagediv'><img class='teachResearchImg' src='/images/kickPlayerDetailsIcon.png' id='" + response[votingOn].avatarID + "' onclick='seePartyVotes(this.id)'><div class='imagetext''>More details<br><div class='explanationText'>Click to see the details of the kicked player</div></div></div>");
                    }
                    if (type === "join") {
                        $("#classdiv" + response[votingOn].avatarID).prepend("<div class='playerdivnameRed'><strong>" + response[votingOn].avatarName + "</strong></div>")
                            .append("<div class='selectionWrapper'></div>");
                    }
                    break;
                default:
                    console.log("ERROR, Somehow you're vote for a player has become corrupted " + voter + " / " + votingOn);
            }
        }
        if (response[voter].inParty === true) {
            if (voter !== votingOn) {
                switch (response[voter].votingChoice[votingPlayer]) {
                    case 0:
                        $("#votingDiv" + response[votingOn].avatarID).append("<div class='playerVoteGrey'><strong>" + response[voter].avatarName + "</strong></div>");
                        break;
                    case 1:
                        $("#votingDiv" + response[votingOn].avatarID).append("<div class='playerVoteGreen'><strong>" + response[voter].avatarName + "</strong></div>");
                        break;
                    case 2:
                        $("#votingDiv" + response[votingOn].avatarID).append("<div class='playerVoteRed'><strong>" + response[voter].avatarName + "</strong></div>");
                        break;
                    default:
                        console.log("ERROR, Somehow you're vote for a player has become corrupted " + voter + " / " + votingOn);
                }
            }
        }
    }
}

function createTeachingList(response){
    var teachingArray = response.research;
    var id = response.player;
    console.log(id);
    if (objectSize(teachingArray)>0){
        $(".teachResearchWrap").remove();
        $("body").append("<div class='teachResearchWrap'><div id='teachResearchHorizontalWrap'></div><div id='closeTeachResearch' onclick='closeTeachWindow()'><div>x</div></div></div>");
        for (var building in teachingArray){
            $("#teachResearchHorizontalWrap").append("<div class='teachableResearchWrap'><img src='/images/buildings/"+teachingArray[building].icon+"' class='teachBuildingImage'><div class='teachBuildingName'>"+teachingArray[building].buildingName+"</div><button class='teachBuildingButton' id='"+building+"?!"+id+"' onclick='teachPlayerResearch(this.id)'>+</button></div>")
        }
    }
}

function partyActions(logs){
    $("#movementLogActions").empty();
    for (var num in logs) {
        var message = logs[num].messageText;
        var time = logs[num].messageTime;
        message = message.replace("#name#","<strong>"+logs[num].avatarID+"</strong>");
        $("#movementLogActions").prepend("<div class='movementLogActionLog'><div class='movementLogTimestamp'>"+time+"</div><span class='movementLogText'>"+message+"</span></div>")
    }
}

function leaveGroup(){
    ajax_All(26,"none",10);
}

function kickFromGroup(ID){
    playerID = ID.replace("kick","");
    ajax_All(27,playerID,10);
}

function joinGroup(ID){
    playerID = ID.replace("join","");
    ajax_All(30,playerID,10);
}

function cancelJoin(ID){
    playerID = ID.replace("cancel","");
    ajax_All(32,playerID,10);
}

function playerAccept(ID){
    playerID = ID.replace("playera","");
    ajax_All(28,playerID,10);
}

function playerReject(ID){
    playerID = ID.replace("playerr","");
    ajax_All(29,playerID,10);
}

function editGroupName(text){
    $(".partyHolderSelf .partyHolderTitle").empty()
        .append("<form onsubmit='return false;' class='horizontalWrap'><input id='editPartyNameField' type='text' name='groupName' value='"+text+"'><div class='imagediv'><img class='teachResearchImg' src='/images/acceptIcon.png' onclick='changeNameChecker(editPartyNameField.value)'><div class='imagetext'>Accept Name</div></div></div></form>")
}

function seePartyVotes(id){
    $(".votingDivInfo").hide();
    $("#votingDiv"+id).show();
}

function changeNameChecker(name){
    if(/^[a-zA-Z0-9- ()?]*$/.test(name) == false) {
        alert("Please don't use special characters in the name");
    }
    else{
        ajax_All(31, name,10);
    }
}

function teachPlayer(ID){
    playerID = ID.replace("teach","");
    ajax_All(33,playerID,11);
}

function teachPlayerResearch(ID){
    var count = ID.indexOf("?!");
    var building = ID.slice(0,count);
    var player = ID.slice(count+2,ID.length);
    var string = building+"&other="+player;
    $("#teachResearchWrap").remove();
    ajax_All(34,string,10);
}

function closeTeachWindow(){
    $(".teachResearchWrap").remove();
}

function hideWritingScreen(){
    $("#writeNewMessageWrap").css("visibility", 'hidden');
    $("#disableScreenWriting").css("visibility", 'hidden');
}


function messagePlayer(ID){
    var count = ID.indexOf("?+!");
    var avatarID = ID.slice(0,count);
    var avatarName = ID.slice(count+3);
    $("#messageMainText").val("");
    $("#messageTitleText").val("");
    $("#messagePlayerNameLocation").empty()
        .append("<div class='titleText'>To: </div> <div class='playerMessageID' id='"+avatarID+"'>"+avatarName+"</div>");
    $("#writeNewMessageWrap").css("visibility", 'visible');
    $("#disableScreenWriting").css("visibility", 'visible');
}

function sendMessagePlayer(){
    var title = $("#messageTitleText").val();
    var text = $("#messageMainText").val();
    var success = true;
    if (title.length > 30){
        alert("Title is too long, please shorten it to less than 30 chars");
        success = false;
    }
    if (title.length < 2){
        alert("Title is too short, please make it more than 2 chars");
        success = false;
    }
    if (success === true){
        if (text.length > 1000){
            alert("Text is too long, please shorten it to less than 1000 char");
            success = false;
        }
        if (text.length < 3) {
            alert("Text is too short, please make it more than 3 chars");
            success = false;
        }
        if (success === true){
            var data = $(".playerMessageID").attr("id");
            data += "&text="+text+"&title="+title;
            console.log(data);
            ajax_All(46,data,"x");
        }
    }
}

function messageSent(){
    $("#messageMainText").val("");
    $("#messageTitleText").val("");
    $("#messagePlayerNameLocation").empty();
    hideWritingScreen();
}