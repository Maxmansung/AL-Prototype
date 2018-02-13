//THIS IS THE JAVASCRIPT USED TO SHOW THE "JOIN GAME" SCREEN

function createMapLog(maps){
    var counterMain = false;
    var counterTutorial = false;
    var counterTest = false;
    var counterAdmin = 0;
    for (var map in maps) {
        var mapTab = "<div class='mapTab'>" +
            "<div class='titleLine'>" +
            "<span class='mapName'>" +
            maps[map].mapName +
            "</span>" +
            "<img src='/images/downArrowMaps.png' class='mapTabDetails' id='click" + map + "' onclick='moreDetails(this.id)'>" +
            "<span class='mapPlayers'>" +
            "Current Players: " + maps[map].currentPlayersCount +
            "</span>" +
            "</div>" +
            "<div class='moreDetails' id='details" + map + "'>" +
            "<div class='moreDetailsItem'>" +
            "<strong>Map Size:</strong> " + maps[map].mapSize + "x" + maps[map].mapSize +
            "</div>" +
            "<div class='moreDetailsItem'>" +
            "<strong>Max Players:</strong> " + maps[map].maxPlayers +
            "</div>" +
            "<div class='moreDetailsItem'>" +
            "<strong>Starting Stamina:</strong> " + maps[map].maxStamina +
            "</div>" +
            "<div class='moreDetailsItem'>" +
            "<strong>Current Day:</strong> " + maps[map].currentDay +
            "</div>" +
            "<div class='moreDetailsItem'>" +
            "<strong>Ending Type:</strong> " + maps[map].dayLength +
            "</div>" +
            "<div class='moreDetailsItem'>" +
            "<strong>Game Type:</strong> " + maps[map].gameType +
            "</div>" +
            "</div>" +
            "</div>";
        if (maps[map].playAble === true) {
            if (maps[map].gameType === "Test") {
                $("#mapsWrapperTest .joinMaps").append(mapTab);
                $("#details" + map).append("<button class='joinGameButton' id='" + maps[map].mapID + "' onclick='joinGame(this.id)'>Join</button>");
                counterTest = true;
            } else if(maps[map].gameType === "Main"){
                $("#mapsWrapperMain .joinMaps").append(mapTab);
                $("#details" + map).append("<button class='joinGameButton' id='" + maps[map].mapID + "' onclick='joinGame(this.id)'>Join</button>");
                counterMain = true;
            }else if(maps[map].gameType === "Tutorial"){
                $("#mapsWrapperTutorial .joinMaps").append(mapTab);
                $("#details" + map).append("<button class='joinGameButton' id='" + maps[map].mapID + "' onclick='joinGame(this.id)'>Join</button>");
                counterTutorial = true;
            }
        } else {
            counterAdmin++;
            $("#adminMaps").append(mapTab);
            $("#details" + map).append("<div class='moreDetailsItem'><strong>Players Dead:</strong> " +
                (parseInt(maps[map].currentPlayersCount) - parseInt(maps[map].alivePlayers)) + "</div>" +
                "<div class='moreDetailsItem'><strong>Other Details:</strong> " +
                "</div>" +
                "<button class='joinGameButton' id='" + maps[map].mapID + "' onclick='deleteGame(this.id)'>Delete</button>")
        }
    }
    $(".moreDetails").hide();
    if (counterAdmin == false){
        $("#adminMaps").hide();
    }
    if (counterTest === false){
        $("#mapsWrapperTest .joinMaps").append("<span id='noMapsAvailable'>There are no test maps currently in progress</span>")
    }
    if (counterMain === false){
        $("#mapsWrapperMain .joinMaps").append("<span id='noMapsAvailable'>There are no main games currently available to you</span>")
    }
    if (counterTutorial === false){
        $("#mapsWrapperTutorial .joinMaps").append("<span id='noMapsAvailable'>There are no tutorial maps available</span>")
    }
}

function playerCustomise(response){
    createMapLog(response.maps);
    if (response.access === "admin"){

    } else {
        $("#adminWrapper").hide();
    }
}

function moreDetails(id){
    $(".moreDetails").hide();
    var detailsID = id.replace("click","details");
    $("#"+detailsID).show();
}

function joinGame(id){
    console.log(id);
    ajax_All(40,id,"x");
}

function deleteGame(id){
    ajax_All(41,id,"x");
}