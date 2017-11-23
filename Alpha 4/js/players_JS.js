///////////PLAYERS TAB JAVASCRIPT///////////

//This function updates all of the players page
function updatePlayerPage(response){
    inGameList(response.avatars);
    inGroupList(response.avatars);
    inGroupInvites(response.avatars);
    inGroupKicks(response.avatars);
    inZonePlayers(response.avatars);
    partyActions(response.logs);
}


//This shows all the people in the game and shows if you know them or not
function inGameList(response){
    $("#playerbox2").empty();
    for (var player in response) {
        $("#playerbox2").append("<div class='playerdiv' id='playerdiv" + player + "'></div>");
        if (response[player].avatarAlive === true){
            response[player].location = response[player].avatarX+"/"+response[player].avatarY;
            if (response[player].avatarName == null){
                $("#playerdiv" + player).append("<div class='playerdivname'><strong>Unknown</strong></div>")
                    .append("<div class='playerdivgroup'><strong>Group: </strong>Unknown</div>");
            } else {
                response[player].location = response[player].avatarX + "/" + response[player].avatarY;
                $("#playerdiv" + player).append("<div class='playerdivname'><a class='usernamelink' href='/user.php?u=" + response[player].avatarName + "'><strong>" + response[player].avatarName + "</strong></a></div>")
                    .append("<div class='playerdivgroup'><strong>Group: </strong>" + response[player].avatarParty + "</div>");
            }
            if (response[player].readyStat == true) {
                $("#playerdiv" + player).css("background-color", "lightgreen");
            }
        } else {
            $("#playerdiv" + player).append("<div class='playerdivname'><strong><del><a class='usernamelink' href='/user.php?u=" + response[player].avatarName + "'>" + response[player].avatarName + "</a></del></strong></div>")
                .append("<div class='playerdivgroup'><strong>DEAD</strong></div>")
                .css("background-color", "lightblue");
        }
    }
}

//This shows the players in your group and allows you to kick them from the group
function inGroupList(players){
    $("#groupbox").empty();
    var count = objectSizeVariable(players,"inParty",true);
    for (var single in players) {
        if (players[single].inParty === true) {
            $("#groupbox").append("<div class='playerdiv' id='classdiv" + players[single].avatarID + "'></div>");
            $("#classdiv" + players[single].avatarID).append("<div class='playerdivname'><a class='usernamelink' href='/user.php?u=" + players[single].avatarName + "'><strong>" + players[single].avatarName + "</strong></a></div>");
            if (players[single].isPlayer === true) {
                if (count === 1){
                    $("#groupbox").prepend("<div id='groupBoxTitle'><strong>Party: "+players[single].avatarParty+"</strong><div class='editTextDiv' id='"+players[single].avatarParty+"' onclick='editGroupName(this.id)'><img src='/images/edit_text.png' id='editTextImage'><span id='editTextSpan'>Edit party name</span></div></div>");
                }
                if (count > 1) {
                    $("#groupbox").prepend("<div id='groupBoxTitle'><strong>Party: "+players[single].avatarParty+"</strong></div>");
                    $("#classdiv" + players[single].avatarID).append("<button class='invitegroup' onclick='leaveGroup()'>Leave</button>")
                }
            }else {
                if (count > 2) {
                    if (players[single].kickingPlayer === true) {
                        $("#classdiv" + players[single].avatarID).append("<div class='invitegroup'><strong>Voting to kick</strong></div>")
                    } else {
                        $("#classdiv" + players[single].avatarID).append("<button class='invitegroup' id='kick" + players[single].avatarID + "' onclick='kickFromGroup(this.id)'>Kick</button>")
                    }
                }
            }
        }
    }
}



function inGroupInvites(players) {
    var count = objectSizeVariable(players,"invitingPlayer",true);
    $("#playerinvites").empty()
        .append("<strong>Invites to group</strong>")
        .show();
    if (count > 0) {
        for (var single in players) {
            if (players[single].invitingPlayer === true) {
                var votingOn = players[single].avatarID;
                $("#playerinvites").append("<div class='inviteddiv' id='inviteddiv" + players[single].avatarID + "'><strong>" + players[single].avatarName + "</strong></div>");
                $("#inviteddiv" + players[single].avatarID).append("<div class='groupopinion' id='checkinginvited" + players[single].avatarID + "'></div>");
                $("#checkinginvited" + players[single].avatarID).append("<div id='writing" + players[single].avatarID + "'><p style='text-align:center;'><span style='float:left;'>Accepted</span>Undecided<span style='float:right;'>Rejected</span></p></div>");
                for (var inside in players) {
                    if (players[inside].inParty === true) {
                        switch (players[inside].votingChoice[votingOn]) {
                            case 0:
                                if (players[inside].isPlayer === true) {
                                    $("#checkinginvited" + votingOn).append("<div class='groupplayercenter'><button id='playera" + votingOn + "' onclick='playerAccept(this.id)'>Accept</button>" + players[inside].avatarName + "<button id='playerr" + votingOn + "' onclick='playerReject(this.id)'>Reject</button></div>");
                                    break;
                                } else {
                                    $("#checkinginvited" + votingOn).append("<div class='groupplayercenter'>" + players[inside].avatarName + "</div>");
                                    break;
                                }
                            case 1:
                                $("#checkinginvited" + votingOn).append("<div class='groupplayerleft'>" + players[inside].avatarName + "</div>");
                                break;
                            case 2:
                                $("#checkinginvited" + votingOn).append("<div class='groupplayerright'>" + players[inside].avatarName + "</div>");
                                break;
                            default:
                                console.log("ERROR with agree invite variable for player " + players[inside].avatarName + ". Array = " + players[inside].votingChoice[votingOn]+". Inside = "+inside);
                                break;
                        }
                    }
                }
            }
        }
    } else {
        $("#playerinvites").hide();
    }
}

function inGroupKicks(players) {
    var count = objectSizeVariable(players,"kickingPlayer",true);
    $("#playerkicks").empty()
        .append("<strong>Kicks from group</strong>")
        .show();
    if (count > 0) {
        for (var single in players) {
            if (players[single].kickingPlayer == true) {
                $("#playerkicks").append("<div class='inviteddiv' id='inviteddiv" + players[single].avatarID + "'><strong>" + players[single].avatarName + "</strong></div>");
                $("#inviteddiv" + players[single].avatarID).append("<div class='groupopinion' id='checkinginvited" + players[single].avatarID + "'></div>");
                $("#checkinginvited" + players[single].avatarID).append("<div id='writing" + players[single].avatarID + "'><p style='text-align:center;'><span style='float:left;'>Kick</span>Undecided<span style='float:right;'>Keep</span></p></div>");
            }
        }
        for (var inside in players) {
            if (players[inside].inParty === true) {
                for (var playerVote in players[inside].votingChoice) {
                    var playerID;
                    for (var getID in players){
                        if (players[getID].avatarID === playerVote){
                            playerID = getID;
                        }
                    }
                    if (players[playerID].kickingPlayer === true) {
                        switch (players[inside].votingChoice[playerVote]) {
                            case 0:
                                if (players[inside].isPlayer === true) {
                                    $("#checkinginvited" + players[playerID].avatarID).append("<div class='groupplayercenter'><button id='playera" + players[playerID].avatarID + "' onclick='playerAccept(this.id)'>Accept</button>" + players[inside].avatarName + "<button id='playerr" + players[playerID].avatarID + "' onclick='playerReject(this.id)'>Reject</button></div>");
                                    break;
                                } else {
                                    $("#checkinginvited" + players[playerID].avatarID).append("<div class='groupplayercenter'>" + players[inside].avatarName + "</div>");
                                    break;
                                }
                            case 1:
                                $("#checkinginvited" + players[playerID].avatarID).append("<div class='groupplayerleft'>" + players[inside].avatarName + "</div>");
                                break;
                            case 2:
                                $("#checkinginvited" + players[playerID].avatarID).append("<div class='groupplayerright'>" + players[inside].avatarName + "</div>");
                                break;
                            default:
                                console.log("ERROR with agree invite variable for player " + players[inside].avatarName + ". Array = " + players[inside].votingChoice[playerVote]);
                                break;
                        }
                    }
                }
            }
        }
    }else {
        $("#playerkicks").hide();
    }
}

//This shows the players in your zone allows you to invite them into your group
function inZonePlayers(players){
    var count = objectSizeVariable(players,"inPlayerZone",true);
    var countGroup = objectSizeVariable(players,"inParty",true);
    $("#zoneplayersbox").empty().show();
    for (single in players){
        if (players[single].inPlayerZone === true) {
            if (players[single].isPlayer === false) {
                    $("#zoneplayersbox").append("<div class='playerdiv' id='zonediv" + players[single].avatarID + "'></div>");
                    $("#zonediv" + players[single].avatarID).append("<div class='playerdivname'><a class='usernamelink' href='/user.php?u=" + players[single].avatarName + "'><strong>" + players[single].avatarName + "</strong></a></div><div class='imagediv'><img class='teachResearchImg' src='/images/teaching.png' id='teach"+ players[single].avatarID +"' onclick='teachPlayer(this.id)'><span class='imagetext'>Teach "+players[single].avatarName+"<br><div class='explanationText'>Costs 2 stamina</div></class></span></div>");
                    if (players[single].inParty === false) {
                        if (countGroup < 2 || players[single].pendingRequest) {
                            if (players[single].awaitingInvite === false) {
                                $("#zonediv" + players[single].avatarID).append("<div class='invitegroup'> Join group: <strong>" + players[single].avatarParty + " - </strong><button class='joinbutton' id='join" + players[single].avatarID + "' onclick='joinGroup(this.id)'>+</button></div>");
                            } else {
                                $("#zonediv" + players[single].avatarID).append("<div class='invitegroup'>Cancel request: <strong>" + players[single].avatarParty + " - </strong><button class='cancelJoinButton' id='cancel" + players[single].avatarID + "' onclick='cancelJoin(this.id)'>-</button></div>");
                            }
                        } else {
                            $("#zonediv" + players[single].avatarID).append("<div class='invitegroup'>-</div>");
                        }
                    } else {
                        $("#zonediv" + players[single].avatarID).append("<div class='invitegroup'>-</div>");
                    }
                } else {
                $("#zoneplayersbox").prepend("<strong>Players in zone ["+ players[single].avatarX+" / "+players[single].avatarY+"]</strong>");
            }
        }

    }
    if (count < 2){
        $("#zoneplayersbox").hide();
    }
}

function createTeachingList(response){
    var teachingArray = response.research;
    var id = response.player;
    console.log(id);
    if (objectSize(teachingArray)>0){
        $(".teachResearchWrap").remove();
        var div = $("#teach"+id);
        var location = div.position();
        $("body").append("<div class='teachResearchWrap'><div id='teachResearchHorizontalWrap'></div><div id='closeTeachResearch' onclick='closeTeachWindow()'><div>x</div></div></div>");
            $(".teachResearchWrap").css({top:(location.top+5)+"px",left:(location.left+15)+"px"});
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
    ajax_All(26,"none");
}

function kickFromGroup(ID){
    playerID = ID.replace("kick","");
    ajax_All(27,playerID);
}

function joinGroup(ID){
    playerID = ID.replace("join","");
    ajax_All(30,playerID);
}

function cancelJoin(ID){
    playerID = ID.replace("cancel","");
    ajax_All(32,playerID);
}

function playerAccept(ID){
    playerID = ID.replace("playera","");
    ajax_All(28,playerID);
}

function playerReject(ID){
    playerID = ID.replace("playerr","");
    ajax_All(29,playerID);
}

function editGroupName(text){
    $("#groupBoxTitle").empty()
        .append("<form onsubmit='return false;'><input id='editPartyNameField' type='text' name='groupName' value='"+text+"'><button id='editPartyNameSubmit' onclick='changeNameChecker(editPartyNameField.value)'>Update</button></form>")
}

function changeNameChecker(name){
    if(/^[a-zA-Z0-9- ()?]*$/.test(name) == false) {
        alert("Please don't use special characters in the name");
    }
    else{
        ajax_All(31, name);
    }
}

function teachPlayer(ID){
    playerID = ID.replace("teach","");
    ajax_All(33,playerID);
}

function teachPlayerResearch(ID){
    var count = ID.indexOf("?!");
    var building = ID.slice(0,count);
    var player = ID.slice(count+2,ID.length);
    var string = building+"&other="+player;
    ajax_All(34,string);
}

function closeTeachWindow(){
    $(".teachResearchWrap").remove();
}