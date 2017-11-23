////////THIS PAGE RUNS THE FUNCTIONS TO CREATE THE HUD AT THE PAGE SIDE//////////


function ajax_GetHUD(){
    var hr = new XMLHttpRequest();
    hr.open("POST", "/MVC/ajax_php/HUD_ajax.php", true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function () {
        if (hr.readyState == 4 && hr.status == 200) {
            var response = JSON.parse(hr.responseText);
            console.log(response);
            if ("ERROR" in response){
                console.log(response.ERROR);
                errors(response.ERROR);
            } else{
                updateHUD(response);
            }
        }
    };
    hr.send();
}

function updateHUD(response){
    if (response.dayEnding <=0){
        ajax_All(8,"none");
    }else {
        updateStamina(response.playerStamina, response.playerMaxStamina);
        updateTemperature(response);
        updateDateTime(response);
        updateReadiness(response.readyStatus);
    }
}

//This updates the stamina image
function updateStamina(current,max){
    var staminaWidth = Math.ceil(max/5);
    var staminaHeight = 5;
    if (staminaWidth>40){
        staminaWidth = 40;
        staminaHeight = Math.ceil(max/40);
    } else if (staminaWidth === 1){
        staminaHeight = max;
    }
    staminaHeight = staminaHeight*10;
    staminaWidth = staminaWidth*10;
    $("#staminawrapper").empty()
        .width(staminaWidth+"px")
        .height(staminaHeight+"px");
    current = parseInt(current);
    for (x=0;x<(current);x++){
        $("#staminawrapper").append("<img src='/images/stamina2.png' id='stamina"+x+"' class='staminaimage'>");
    }
    var leftover = (max - current);
    for (x=0;x<leftover;x++){
        $("#staminawrapper").append("<img src='/images/staminaempty.png' class='staminaimage'>");
    }
}

function updateTemperature(response){
    $("#tempdatawrite").empty()
        .append("<div class='temperatureSpan'><span id='tempwrite'>Night Temp: </span><br>"+(parseInt(response.nightTemp)*-1)+"&degC</div><div class='temperatureSpan'><span id='tempwrite'>Survivable Temp: </span><br>"+(parseInt(response.calcSurvTemp)*-1)+"&degC</div>")
}

function updateDateTime(response) {
    $("#daynumber").empty()
        .append("<span>DAY " + response.currentDay + "</span>");
    $("#mapNameHUD").empty()
        .append("<span>"+response.mapName+"</span>");
    var time = msToTime(response.dayEnding);
    $("#hudtimer").empty()
        .append("<span id='gameClock'>"+response.clock+"</span><span id='gameCountdown'>Nightfall in:<br><strong>"+time+"</strong></span>");
}

function updateReadiness(status){
    if (status == true){
        $("#readywrap").empty()
            .append( "<img id='readyimage' src='/images/buttonready2.png' onclick='setReady()'>");
    }else {
        $("#readywrap").empty()
            .append( "<img id='readyimage' src='/images/buttonready1.png' onclick='setReady()'>");
    }
}

function dayEnding(){
    ajax_All(203,"none")
}

function setReady(){
    ajax_All(6,"none");
}