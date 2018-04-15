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
                type = "Tutorial";
                break;
            case 4:
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