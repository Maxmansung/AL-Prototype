//This ajax function is used for all of the data collection within the map screen
function ajax_All(type, data, view){
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
    hr.send("type="+type+"&data="+data+"&view="+view);
}


function switchArray(type,response){
    console.log("Type: "+type);
    type = parseInt(type);
    switch(type){
        case 0:
        case 16:
        case 17:
        case 21:
            updateAllConstruction(response.view);
            updateHUD(response.HUD);
            break;
        case 1:
        case 2:
        case 11:
        case 45:
            personalUpgrade(response.view);
            updateHUD(response.HUD);
            break;
        case 3:
        case 5:
        case 14:
        case 18:
            constructionUpgrade(response.view);
            updateHUD(response.HUD);
            break;
        case 9:
            displayDeathPage(response.view);
            break;
        case 10:
            firepitScreen(response.view);
            updateHUD(response.HUD);
            break;
        case 12:
            zoneActionsView(response.view);
            updateHUD(response.HUD);
            break;
        case 19:
        case 20:
            generalUpdateMap(response.view);
            updateHUD(response.HUD);
            break;
        case 22:
        case 44:
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
        case 37:
            window.location.href = "/index.php";
            break;
        case 38:
            displayUsersSetup(response.view);
            break;
        case 39:
            playerCustomise(response.view);
            break;
        case 42:
        case 43:
            updateSpecialPage(response.view);
            updateHUD(response.HUD);
            break;
        case 46:
            messageSent();
            break;
        case 47:
            displayNight(response.view);
            break;
        default:
            break;
    }
}