//This ajax function is used for all of the data collection within the map screen
function ajax_All(type, data){
    $("#loadingscreen").css("visibility", "visible");
    var hr = new XMLHttpRequest();
    hr.open("POST", "/MVC/ajax_php/ajax_MVC.php", true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function () {
        if (hr.readyState == 4 && hr.status == 200) {
            var response = JSON.parse(hr.responseText);
            console.log(response);
            if ("ERROR" in response){
                errors(response.ERROR);
            } else if ("ALERT" in response){
                alerts(response.ALERT,response.DATA)
            } else {
                switchArray(type,response);
            }
            $("#loadingscreen").css("visibility", "hidden");
        }
    };
    hr.send("type="+type+"&data="+data);
}


function switchArray(type,response){
    console.log("Type: "+type);
    type = parseInt(type);
    switch(type){
        case 0:
        case 1:
        case 2:
        case 3:
            updateAvatar(response.view);
            updateHUD(response.HUD);
            break;
        case 4:
        case 5:
            buildingstab(response.view);
            updateHUD(response.HUD);
            break;
        case 9:
            displayDeathPage(response.view);
            break;
        case 10:
        case 11:
            firepitScreen(response.view);
            updateHUD(response.HUD);
            break;
        case 12:
            zoneActionsView(response.view);
            updateHUD(response.HUD);
            break;
        case 13:
        case 14:
            createOverview(response.view);
            updateHUD(response.HUD);
            break;
        case 15:
        case 16:
        case 17:
        case 18:
            updateStorageOverall(response.view);
            updateHUD(response.HUD);
            break;
        case 19:
        case 20:
            generalUpdateMap(response.view);
            updateHUD(response.HUD);
            break;
        case 21:
        case 22:
            updateItems(response.view);
            updateHUD(response.HUD);
            break;
        case 24:
            infobox(response.view);
            break;
        case 25:
        case 34:
            updatePlayerPage(response.view);
            updateHUD(response.HUD);
            break;
        case 26:
        case 27:
        case 28:
        case 29:
        case 30:
        case 31:
        case 32:
            updatePlayerPage(response.view);
            break;
        case 33:
            createTeachingList(response.view);
            break;
        case 35:
            viewPlayerProfile(response.view);
            break;
        case 36:
            updateEdit(response.view);
            break;
        case 38:
            displayUsersSetup(response.view);
            break;
        case 39:
            playerCustomise(response.view);
            break;
        default:
            break;
    }
}