////////THIS PAGE RUNS THE FUNCTIONS TO CREATE THE HUD AT THE PAGE SIDE//////////


function updateHUD(response) {
    updateStamina(response.playerStamina, response.playerMaxStamina);
    updateTemperature(response);
    updateDateTime(response);
    updateReadiness(response.readyStatus, response.mapType);
    updateStatus(response.statusArray);
}

//This updates the stamina image
function updateStamina(current,max){
    $("#staminawrapper").empty().append("<span>"+current+" / "+max+"</span>")
}

function updateTemperature(response){
    var moreDetail = writeTempBonuses(response);
    $("#nightTempNumber").empty().append("<span>"+(parseInt(response.nightTemp)*-1)+"&degC</span>");
    $("#surviveTempNumber").empty().append("<span>"+(parseInt(response.calcSurvTemp)*-1)+"&degC</span>");
    $("#tempOverviewHidden").empty().append(moreDetail);
    $("#tempDataWarning").empty();
    if (response.nightTemp>response.calcSurvTemp){
        $("#tempDataWrapper").css("background","rgba(255,0,0,0.5");
        $("#tempDataWarning").append("You will DIE tonight");
    } else {
        $("#tempDataWrapper").css("background","rgba(0,255,0,0.5");
        $("#tempDataWarning").append("You will LIVE tonight");
    }
}

function writeTempBonuses(response){
    var returnText = "<div class='tempDetailTitle'>Bonuses</div>";
    if (response.tempBaseSurvival !== 0) {
        returnText += "<div class='tempDetailItem'>Personal: " + response.tempBaseSurvival + "</div>";
    }
    if (response.tempZoneMod !== 0) {
        returnText += "<div class='tempDetailItem'>Zone: " + response.tempZoneMod + "</div>";
    }
    if (response.tempFirepit !== 0) {
        returnText += "<div class='tempDetailItem'>Firepit: " + response.tempFirepit + "</div>";
    }
    if (response.tempBuildings-response.tempFirepit !== 0) {
        var totalTemp = response.tempBuildings-response.tempFirepit;
        returnText += "<div class='tempDetailItem'>Other Buildings: " + totalTemp + "</div>";
    }
    if (response.tempItemsBonus !== 0) {
        returnText += "<div class='tempDetailItem'>Items: " + response.tempItemsBonus + "</div>";
    }
    if (response.tempBlessings !== 0) {
        returnText += "<div class='tempDetailItem'>Blessings: " + response.tempBlessings + "</div>";
    }
    return returnText;
}

function updateDateTime(response) {
    $("#daynumber").empty()
        .append("<span>DAY " + response.currentDay + "</span>");
    $("#mapNameHUD").empty()
        .append("<span>"+response.mapName+"</span>");
    var time = msToTime(response.dayEnding);
    $("#gameClock").empty()
        .append(response.clock);
    if (response.mapType === "full") {
        $("#gameCountdown").empty()
            .append("Nightfall: <strong> "+time+" </strong>");
    }
}

function updateReadiness(status,type){
    if (type === "full"){
        $("#readywrap").hide();
    } else {
        if (status == true) {
            $("#readywrap").empty().show()
                .append("<img id='readyimage' src='/images/buttonready2.png' onclick='setReady()'><span class='readyButtonInfo'>This will end the day if all players on the map are marked as ready</span>");
        } else {
            $("#readywrap").empty().show()
                .append("<img id='readyimage' src='/images/buttonready3.png' onclick='setReady()'><span class='readyButtonInfo'>This will end the day if all players on the map are marked as ready</span>");
        }
    }
}

function updateStatus(statuses){
    var eyes = "eyesBasic.png";
    var nose = "noseBasic.png";
    var mouth = "mouthBasic.png";
    if(statuses["Hungry"] != null){
        mouth = statuses["Hungry"].image;
    }
    if(statuses["Starving"] != null){
        mouth = statuses["Starving"].image;
    }
    if(statuses["Frostbite"] != null){
        nose = statuses["Frostbite"].image;
    }
    if(statuses["Hallucinating"] != null){
        eyes = statuses["Hallucinating"].image;
    }
    $("#playerStatusView").empty()
        .append("<div class='statusImage'><img src='/images/playerFace/faceBackBasic.png'></div>")
        .append("<div class='statusImage'><img src='/images/playerFace/"+eyes+"'></div>")
        .append("<div class='statusImage'><img src='/images/playerFace/"+nose+"'></div>")
        .append("<div class='statusImage'><img src='/images/playerFace/"+mouth+"'></div>")
        .append("<div id='playerStatusInfo'><strong>Statuses</strong></div><hr>");
    for (var status in statuses){
        $("#playerStatusInfo").append("<span class='statusDetail'>"+status+"</span>");
    }
}

function displayGameHUD(){
    var check = $("#timeAndTemp").is(":visible");
    if (check === false){
        $("#timeAndTemp").show();
        $("#pageCenter").css("padding-left","100px");
    } else {
        $("#timeAndTemp").hide();
        $("#pageCenter").css("padding-left","0");
    }
}

function dayEnding(){
    ajax_All(203,"none","x")
}

function setReady(){
    ajax_All(6,"none","x");
}