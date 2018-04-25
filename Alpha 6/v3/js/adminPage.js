var allNews = [];
var edited = 0;

function selectPage(id){
    window.location.href = "/?page=admin&a="+id;
}

function postNews(visibiility){
    var title = $("#newNewsPost #newsTitle").val();
    var text = $("#newNewsPost .postBoxTextbox").val();
    if (title.length < 3){
        errors(128);
    } else if (title.length > 30){
        errors(129);
    } else if (text.length < 10){
        errors(130);
    } else {
        ajax_All(205, 0, title, text, visibiility);
    }
}

function editNews(visibiility){
    var title = $("#oldNewsPost #newsTitle").val();
    var text = $("#oldNewsPost .postBoxTextbox").val();
    if (title.length < 3){
        errors(128);
    } else if (title.length > 30){
        errors(129);
    } else if (text.length < 10){
        errors(130);
    } else {
        ajax_All(207, 0, title, text, visibiility,edited);
    }
}

function getAllNewsEdit(){
    ajax_All(206,6);
}

function getAllMapEdit(){
    ajax_All(210,7)
}

function createNewsEditPage(data){
    allNews = data;
    $("#oldNewsPostWrapper").empty();
    for (var x in allNews){
        if (allNews[x].visible == 1){
            singleNewsLine(allNews[x],"Live")
        } else {
            singleNewsLine(allNews[x],"Draft")
        }
    }
}

function singleNewsLine(data,background){
    $("#oldNewsPostWrapper").append('<div class="row newsLink'+background+' mt-2 py-2">' +
        '<div class="col">' +
        '<span class="font-size-2x font-weight-bold">'+data.title +'</span><span class="darkGrayColour pl-2">('+background+')</span>'+
        '</div>' +
        '<div class="col-auto d-flex flex-row justify-content-around align-items-center">' +
        '<button class="btn btn-dark btn-sm mx-2" id="'+data.newsID+'+!edit" onclick="editNewsPost(this.id)">Edit</button>' +
        '<button class="btn btn-danger btn-sm mx-2" id="'+data.newsID+'+!delete" onclick="deleteNewsPost(this.id)">Delete</button> ' +
        '</div></div>')
}

function editNewsPost(id){
    var count = id.indexOf("+!");
    edited = id.slice(0,count);
    var final = 0;
    for (var test in allNews){
        if (allNews[test].newsID === edited){
            final = test;
        }
    }
    $("#oldNewsPost").collapse();
    $("#oldNewsPost #newsTitle").empty().val(allNews[final].title);
    $("#oldNewsPost .postBoxTextbox").empty().val(allNews[final].postText);
}

function deleteNewsPost(id){
    var count = id.indexOf("+!");
    edited = id.slice(0,count);
    createAlertBox(4,1,"Are you sure you want to delete this post?",2,"deletePostFinal");
}

function deletePostFinal(){
    ajax_All(208,0,edited);
}

function createNewMap(){
    $("#createMapName").removeClass("is-invalid");
    $("#createMapPlayers").removeClass("is-invalid");
    $("#createMapEdge").removeClass("is-invalid");
    $("#createMapType").removeClass("is-invalid");
    var style = 2;
    if ($("#createMapType").length){
        style = $("#createMapType").val();
    }
    var title = $("#createMapName").val();
    var players = $("#createMapPlayers").val();
    var size = $("#createMapEdge").val();
    var type = $('input[name=createMapType]:checked').val();
    var titleClean = title.replace(/[^a-zA-Z0-9 -]/g, "");
    if (players == 0){
        var playersClean = 0;
    } else {
        var playersClean = parseInt(players);
    }
    if (size == 0){
        var sizeClean = 0;
    } else {
        var sizeClean = parseInt(size);
    }
    var posting = true;
    if (title !== titleClean){
        posting = false;
        $("#mapNameError").empty().append("Please dont use special characters");
        $("#createMapName").addClass("is-invalid");
    } else if (titleClean.length > 20){
        posting = false;
        $("#mapNameError").empty().append("Titles need to be less than 20 characters");
        $("#createMapName").addClass("is-invalid");
    }
    if (playersClean > 40 || playersClean <1){
        posting = false;
        $("#playerCountError").empty().append("Players must be 1-40");
        $("#createMapPlayers").addClass("is-invalid");
    }
    if (sizeClean > 30 || sizeClean < 3){
        posting = false;
        $("#edgeSizeError").empty().append("Size must be 3-30");
        $("#createMapEdge").addClass("is-   invalid");
    }
    if (type !== "full" && type !== "check"){
        posting = false;
        $("#gameTypeError").empty().append("Please select one of the options");
        $("#createMapType").addClass("is-invalid");
    }
    if (posting === true){
        ajax_All(209,0,titleClean,playersClean,sizeClean,type,style);
    }
}

function createEditMapAdmin(data){
    $("#mapListWrapper").empty();
    for(var x in data){
        var day = "Full game";
        if (data[x].dayDuration === "check"){
            day = "Speed game"
        }
        var type = "Main";
        switch (data[x].gameType){
            case 2:
                type = "Custom";
                break;
            case 3:
                type = "Practice";
                break;
            case 4:
                type = "Tutorial";
                break;
            case 5:
                type = "Testing";
                break;
        }
        var avatarCount = objectSize(data[x].avatars);
        $("#mapListWrapper").append('<div class="row singleMapWrapperAdmin justify-content-between p-1 mb-3">' +
            '<div class="col-sm-4 col-6 d-flex flex-row flex-wrap align-items-center justify-content-start p-1">' +
            '<div class="font-weight-bold mr-2">'+data[x].name+'</div> ' +
            '<div class="darkGrayColour font-weight-bold font-size-2 mr-2">('+day+')</div>' +
            '<div class="darkGrayColour font-size-2">('+type+')</div>' +
            '</div>' +
            '<div class="col-sm-4 col-6 d-flex flex-row flex-wrap justify-content-center align-items-center p-1 font-size-2 darkGrayColour">' +
            '<div class="m-1"><b>Players:</b> '+avatarCount+'/'+data[x].maxPlayerCount+'</div>' +
            '<div class="m-1"><b>Day:</b> '+data[x].currentDay +'</div>' +
            '<div class="m-1"><b>Night Temp:</b> '+data[x].baseNightTemperature +'</div>' +
            '<div class="m-1"><b>Size:</b> '+data[x].edgeSize+'x'+data[x].edgeSize+'</div>' +
            '</div>' +
            '<div class="col-sm-4 col-12 d-flex flex-row flex-wrap justify-content-sm-end justify-content-around align-items-center p-1">' +
            '<button class="btn btn-dark m-2" id="'+data[x].mapID+'+!?Detail" onclick="moreDetailMapAdmin(this.id)">More Details</button>' +
            '<button class="btn btn-danger m-2" id="'+data[x].mapID+'+!?Delete" onclick="deleteMapAdmin(this.id)">Delete</button>' +
            '</div>' +
            '</div>')
    }
}

function createMapDetails(data,map){
    $("#mapDetailsAdminWrapper").empty();
    $("#mapDetailsAdminWrapper").append('<div class="row justify-content-sm-between justify-content-center font-size-2 align-items-center p-2 mb-2"><div class="col-sm-4 col-12 font-weight-bold">'+map.name+'</div>' +
        '<div class="col-sm-2 col-lg-1 col-12 d-flex flex-column justify-content-around align-items-center p-1">' +
        '<div>Players:</div><input class="form-control form-control-sm col-6 col-sm-12" type="number" value="' + map.maxPlayerCount+ '" id="editMapPlayercount">' +
        '</div>' +
        '<div class="col-sm-2 col-lg-1 col-12 d-flex flex-column justify-content-around align-items-center p-1">' +
        '<div>Night Temp:</div><input class="form-control form-control-sm col-6 col-sm-12 " type="number" value="' + map.baseNightTemperature+ '" id="editMapNightTemperature">' +
        '</div>' +
        '<button class="btn btn-dark m-1 btn-sm col-sm-auto col-6" id="'+map.mapID+'" onclick="editMapDetails(this.id)">Edit</button>' +
        '</div>');
    var size = objectSize(data);
    if (size !== 0) {
        for (var x in data) {
            $("#mapDetailsAdminWrapper").append('<div class="row justify-content-between font-size-2 align-items-center p-2 mb-2 adminPlayerDetailsWrapper" id="playerWrapper'+data[x].avatarID+'"> ' +
                '<div class="col-8 d-flex flex-md-row flex-column align-items-md-center align-items-start justify-content-between row"> ' +
                '<div class="col-md-4 col-12 font-weight-bold">' + data[x].profileID + '</div> ' +
                '<div class="col-md-4 col-12 d-flex flex-row justify-content-around align-items-center p-1"><div>Stamina: </div><input class="form-control form-control-sm col-4 col-md-5 col-lg-4 col-xl-3 staminaInputPlayer" type="number" value="' + data[x].stamina + '"></div> ' +
                '<div class="col-md-4 col-12 d-flex flex-row justify-content-around align-items-center p-1"><div>Heat: </div><input class="form-control form-control-sm col-4 col-md-5 col-lg-4 col-xl-3 heatInputPlayer" type="number" value="' + data[x].avatarSurvivableTemp
                + '"></div> ' +
                '</div> ' +
                '<div class="col-4"> ' +
                '<div class="row align-items-end align-items-md-center justify-content-end"> ' +
                '<button class="btn btn-dark m-1 btn-sm" id="'+data[x].avatarID+'" onclick="editMapPlayer(this.id)">Edit</button> ' +
                '<button class="btn btn-danger m-1 btn-sm" id="'+data[x].avatarID+'" onclick="killMapPlayer(this.id)">Kill Player</button> ' +
                '</div> ' +
                '</div>')
        }
    }
    else {
        $("#mapDetailsAdminWrapper").append("<div class='font-weight-bold' align='center'>This map is currently empty</div>")
    }
}

function createDeadPlayerDeatils(data){
    var size = objectSize(data);
    if (size !== 0) {
        $("#mapDetailsDeadAdminWrapper").append('<div class="row font-size-2 p-2 deadPlayerWrapper">' +
            '<div class="col-12 font-weight-bold" align="center">Dead Players</div>' +
            '</div>');
        for (var x in data) {
            $(".deadPlayerWrapper").append('<div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-2" align="left" >' + data[x] + '</div>')
        }
    }
}

function createEditPlayerAdmin(data){
    $("#adminEditMapTitle").empty().append(data.mapVars.name);
    createMapDetails(data.avatarsAlive,data.mapVars);
    createDeadPlayerDeatils(data.avatarsDead);
}

function deleteMapAdmin(id){
    var count = id.indexOf("+!?");
    edited = id.slice(0,count);
    createAlertBox(4,1,"<div>Are you sure you want to delete this map?</div><div class='font-size-2 darkGrayColour'>Password required to delete</div>",3,"confirmDeleteAdmin");
}

function confirmDeleteAdmin(){
    var password = $("#passwordRequiredModal").val();
    $("#alertBox").modal('toggle');
    ajax_All(212,0,edited,password);
}

function moreDetailMapAdmin(id){
    var count = id.indexOf("+!?");
    edited = id.slice(0,count);
    ajax_All(211,8,edited);
}

function reportCreatedMap(id){
    $("#reportCreatedMapBox .modal-footer").empty().append("<button class='btn btn-dark' data-dismiss='modal' aria-label='Close'>Cancel</button><button class='btn btn-danger' id='"+id+"' onclick='mapReport(this.id)'>Report Post</button>");
    $('#reportCreatedMapBox').modal({
        backdrop: 'static',
        keyboard: false
    });
}

function editMapPlayer(id){
    var stamina = $("#playerWrapper"+id+" .staminaInputPlayer").val();
    var temp = $("#playerWrapper"+id+" .heatInputPlayer").val();
    var tempClean = parseInt(temp);
    var staminaClean = parseInt(stamina);
    if (temp != tempClean || stamina != staminaClean){
        alert("You have not used the correct values for these boxes");
    } else {
        ajax_All(215,0,id,staminaClean,tempClean);
    }
}

function killMapPlayer(id){
    ajax_All(216,0,id);
}

function editMapDetails(id){
    var nightTemp = $("#editMapNightTemperature").val();
    var maxPlayers = $("#editMapPlayercount").val();
    var nightTempClean = parseInt(nightTemp);
    var maxPlayersClean = parseInt(maxPlayers);
    ajax_All(217,0,id,maxPlayersClean,nightTempClean);
}

function mapReport(id){
    var text = _("message-text-report").value;
    var text2 = _("selectComplaint").value;
    textchange = text.replace(/[^a-zA-Z0-9!?"' .,;:()]/g, "");
    if (textchange != text){
        $("#message-text-report").addClass("is-invalid");
        $("#report-error").empty().append("Please avoid special characters");
    } else {
        if (textchange.length > 500){
            $("#message-text-report").addClass("is-invalid");
            $("#report-error").empty().append("Please use 500 char or less");

        } else {
            if (textchange.length < 4){
                $("#message-text-report").addClass("is-invalid");
                $("#report-error").empty().append("Please give some detail");
            } else {
                $('#reportCreatedMapBox').modal("hide");
                var finalReport = text2 + ":- " + text;
                ajax_All(214, 0, id, finalReport);
            }
        }
    }
}

function getReportsPage(){
    ajax_All(218,10);
}

function makeReportsPage(data){
    makeForumReports(data.forum);
    makeMapReports(data.map);
}

function makeForumReports(data){
    $("#forumReports").empty();
    var length = objectSize(data);
    if (length > 0) {
        for (var x in data) {
            $("#forumReports").append('<div class="row justify-content-center py-1 px-2">' +
                '<div class="col-11 d-flex flex-column lightGrayBackground">' +
                '<div class="row d-flex flex-row justify-content-start align-items-center">' +
                '<div class="p-2 font-weight-bold font-size-2 col-4 col-sm-3 col-md-2">' + data[x].reporter + '</div>' +
                '<div class="p-2 font-size-2 col-5 col-sm-7 col-md-8">' + data[x].details + '</div>' +
                '<div class="font-size-1 col-3 col-sm-2 grayColour" align="right">' + data[x].timestampCreated + '</div>' +
                '</div>' +
                '</div>' +
                '<div class="col-11 d-flex flex-row justify-content-center lightGrayBackground">' +
                '<button class="btn btn-dark m-2">Go To</button>' +
                '<button class="btn btn-danger m-2" id="report+!' + data[x].reportID + '" onclick="createReportModal(this.id)">Solved</button>' +
                '</div>' +
                '</div>')
        }
    } else {
        $("#forumReports").append('<div class="row justify-content-center py-1 px-2">' +
            '<div class="col-11 grayColour" align="center">No forum reports currently</div>' +
            '</div>');
    }
}

function makeMapReports(data){
    $("#mapReports").empty();
    var length = objectSize(data);
    if (length > 0) {
        for (var x in data) {
            $("#mapReports").append('<div class="row justify-content-center py-1 px-2">' +
                '<div class="col-11 d-flex flex-column lightGrayBackground">' +
                '<div class="row d-flex flex-row justify-content-start align-items-center">' +
                '<div class="p-2 font-weight-bold font-size-2 col-4 col-sm-3 col-md-2">' + data[x].reporter + '</div>' +
                '<div class="p-2 font-size-2 col-5 col-sm-7 col-md-8">' + data[x].details + '</div>' +
                '<div class="font-size-1 col-3 col-sm-2 grayColour" align="right">' + data[x].timestampCreated + '</div>' +
                '</div>' +
                '</div>' +
                '<div class="col-11 d-flex flex-row justify-content-center lightGrayBackground">' +
                '<button class="btn btn-dark m-2" onclick="goToPage(\'admin&a=snowman\')">Go To</button>' +
                '<button class="btn btn-danger m-2" id="report+!' + data[x].reportID + '" onclick="createReportModal(this.id)">Solved</button>' +
                '</div>' +
                '</div>')
        }
    } else {
        $("#mapReports").append('<div class="row justify-content-center py-1 px-2">' +
            '<div class="col-11 grayColour" align="center">No forum reports currently</div>' +
            '</div>');
    }
}

function markReportAsSolved(id){
    var reportID = id.slice(10);
    var text = $("#message-text-report").val();
    if (text.length < 1){
        $("#message-text-report").addClass("is-invalid");
    } else {
        $("#message-text-report").removeClass("is-invalid");
        $('#reportPosResponse').modal("hide");
        ajax_All(219,0,reportID,text);
    }
}

function createReportModal(id){
    $("#reportPosResponse .modal-header").empty().append("Closing Report");
    $("#reportPosResponse .modal-footer").empty().append("<button class='btn btn-dark' data-dismiss='modal' aria-label='Close'>Cancel</button><button class='btn btn-danger' id='ex"+id+"' onclick='markReportAsSolved(this.id)'>Close Report</button>");
    $("#message-text-report").empty();
    $('#reportPosResponse').modal({
        backdrop: 'static',
        keyboard: false
    });
}

function findSpiritAdmin(){
    var username = $("#adminPageSearchSpirit").val();
    ajax_All(220,11,username);
}

function createEditUserItem(data){
    $("#adminUsersWrapper").empty();
    for(var x in data){
        $("#adminUsersWrapper").append('<div class="row my-1 p-1 adminUserEditWrapper">' +
            '<div class="col-2 col-xl-1 d-none d-md-flex flex-column align-items-end justify-content-center">' +
            '<img class="searchAdminAvatarImage" src="/avatarimages/'+data[x].profileImage+'">' +
            '</div>' +
            '<div class="col-12 col-sm-4 col-md-3 d-flex flex-sm-column flex-row justify-content-center justify-content-sm-start align-items-end align-items-sm-start"> ' +
            '<div class="font-weight-bold">'+data[x].profile+'</div>' +
            '<div class="font-size-2 grayColour px-2 px-sm-0">'+data[x].login+'</div>' +
            '<div class="font-size-2 grayColour">Type: '+data[x].accountType+'</div>' +
            '</div>' +
            '<div class="col-12 col-sm-4 col-md-3 d-flex flex-sm-column flex-row justify-content-center font-size-2 ">' +
            '<div class="d-flex flex-sm-row flex-column justify-content-center align-items-center px-2"><div class="pr-sm-2">Points against</div><div>'+data[x].warningPoints+'</div></div>' +
            '<div class="d-flex flex-sm-row flex-column justify-content-center align-items-center px-2"><div class="pr-sm-2">Warnings </div><div>'+data[x].lifeTimeWarnings+'</div></div>' +
            '</div>' +
            '<div class="col-12 col-sm-4 col-xl-5 d-flex flex-row flex-sm-column justify-content-center align-items-end">' +
            '<div class="p-1"><button class="btn btn-dark" onclick="createRankModal(this.id)" id="'+data[x].accountType+'rank+!'+data[x].profileID+'">Edit</button></div>' +
            '<div class="p-1"><button class="btn btn-danger" onclick="createWarningModal(this.id)" id="warning1+!'+data[x].profileID+'">Warning</button></div>' +
            '</div>' +
            '</div>')
    }
}

function createWarningModal(id){
    $("#adminUserWarning .modal-footer").empty().append("<button class='btn btn-dark' data-dismiss='modal' aria-label='Close'>Cancel</button><button class='btn btn-danger' id='ex"+id+"' onclick='giveUserWarning(this.id)'>Give Warning</button>");
    $('#adminUserWarning').modal({
        backdrop: 'static',
        keyboard: false
    });
}

function createRankModal(id){
    var rank = id.slice(0,1);
    $("#adminUserRank").val(rank).change();
    changeRankText();
    $("#adminUserRank .modal-footer").empty().append("<button class='btn btn-dark' data-dismiss='modal' aria-label='Close'>Cancel</button><button class='btn btn-danger' id='ex"+id+"' onclick='changeUserRank(this.id)'>Change Rank</button>");
    $('#adminUserRank').modal({
        backdrop: 'static',
        keyboard: false
    });
}

function changeRankText(){
    var valueRank = $("#selectRank").val();
    valueRank = valueRank.slice(0,1);
    var text = "";
    console.log(valueRank);
    switch (valueRank) {
        case 0:
            text = "You cannot change players rank";
            break;
        case 1:
            text = "This is the top developer rank, this can only be given and lost through direct database manipulation";
            break;
        case 2:
            text = "Admin rank, due to the high level of powers this has, only a developer can give and remove of this";
            break;
        case 3:
            text = "Moderators have the ability to support the forums and give warnings, this rank can only be changed by an Admin or above";
            break;
        case 4:
            text = "The superior unused rank is currently a blank rank in preperation for advanced skills later in the game";
            break;
        case 5:
            text = "The superior rank allows player to make their own maps. This will likely become a paid option in the future and manipulation of this should be avoided";
            break;
        case 6:
            text = "Regular is the most common rank that all players will get after completing enough tutorial and practice games";
            break;
        case 7:
            text = "Small spirits have only just begun with the game, their account is active but they cannot join main games yet";
            break;
        case 8:
            text = "New spirits have not activated their accounts with their emails";
            break;
        case 9:
            text = "Lost spirits have been disabled either through innactivity or warnings. These may need bringing back to life";
            break;
    }
    $("#rankExplanation").empty().append(text);
}

function changeUserRank(id){
    var valueRank = $("#selectRank").val();
    if (valueRank.length > 1){
        createAlertBox(5,1,"You cannot use this rank");
    } else {
        var idNew = id.slice(9);
        $('#adminUserRank').modal("hide");
        ajax_All(222,0,idNew,valueRank);
    }
}

function giveUserWarning(id){
    var profileID = id.slice(12);
    var warning = $("#selectWarning").val();
    var reason = $("#message-text-report").val();
    if (reason.length < 1){
        $("#message-text-report").addClass("is-invalid");
    } else {
        $("#message-text-report").removeClass("is-invalid");
        $('#adminUserWarning').modal("hide");
        ajax_All(221, 0, profileID, warning, reason);
    }
}

function adminUserPageLoad(){
    adminSearchButtonListener();
}


function adminSearchButtonListener() {
    $("#adminPageSearchSpirit").keyup(function (event) {
        if (event.keyCode == 13) {
            $("#adminPageSearchSpiritButton").click();
        }
    });
}