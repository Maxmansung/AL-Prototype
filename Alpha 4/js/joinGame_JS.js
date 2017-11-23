//THIS IS THE JAVASCRIPT USED TO SHOW THE "JOIN GAME" SCREEN

function createMapLog(maps){
    var counterPlay = 0;
    var counterAdmin = 0;
    for (var map in maps){
        if (maps[map].mapName != "KEEP") {
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
                "<strong>Day Length:</strong> " + maps[map].dayLength + " hours" +
                "</div>" +
                "<div class='moreDetailsItem'>" +
                "<strong>Game Type:</strong> " + maps[map].gameType +
                "</div>" +
                "</div>" +
                "</div>";
            if (maps[map].playAble === true) {
                counterPlay++;
                $("#joinMaps").append(mapTab);
                $("#details" + map).append("<button class='joinGameButton' id='" + maps[map].mapID + "' onclick='joinGame(this.id)'>Join</button>");
            } else {
                counterAdmin++;
                $("#adminMaps").append(mapTab);
                $("#details" + map).append("<div class='moreDetailsItem'><strong>Players Dead:</strong> " +
                    (parseInt(maps[map].currentPlayersCount)-parseInt(maps[map].alivePlayers)) + "</div>" +
                    "<div class='moreDetailsItem'><strong>Other Details:</strong> " +
                    "</div>" +
                    "<button class='joinGameButton' id='" + maps[map].mapID + "' onclick='deleteGame(this.id)'>Delete</button>")
            }
        }
    }
    $(".moreDetails").hide();
    if (counterAdmin<1){
        $("#adminMaps").hide();
    }
    if (counterPlay<1){
        $("#joinMaps").append("<span id='noMapsAvailable'>There are no maps available currently</span>")
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
    ajax_All(40,id);
}

function deleteGame(id){
    ajax_All(41,id);
}