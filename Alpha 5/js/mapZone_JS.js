////// MAP + ZONE PAGE ////////

function generalUpdateMap(response){
    updateMapImage(response);
    updateItems(response.itemsView);
    zoneActions(response.logs);
}

function updateMapImage(response){
    mapcreate(response.mapZones);
    getDirection(response.zone.coordinateX, response.zone.coordinateY, (Math.sqrt(response.mapZones.length)));
    playerVision(response.itemsView.avatarLoc);
    zoneInformation(response.zone);
    $("#infobox").hide();
    if (response.zone.isSpecialZone !== false){
        $("#backpackwrap").hide();
        $("#zoneActionsWrap").hide();
        $("#grounditems").hide();
    } else {
        $("#backpackwrap").show();
        $("#zoneActionsWrap").show();
        $("#grounditems").show();

    }
}

//This function creates the basic map using the PlayerMapController Class
function mapcreate(zones) {
    $("#start").empty();
    for (var i = -1; i < (Math.sqrt(zones.length))+1; i++) {
        $("#start").prepend("<div class='mapRowsDiv' id='zoneRow" + i + "'></div>");
        if (i == -1 || i == Math.sqrt(zones.length)) {
            for (var x = -1;x<(Math.sqrt(zones.length))+1;x++){
                if (x == -1 || x == (Math.sqrt(zones.length))){
                    $("#zoneRow" + i).append("<div id='axisHorizontal" + x + "' class='zoneAxisCorner'></div>")
                } else {
                    $("#zoneRow" + i).append("<div id='axisHorizontal" + x + "' class='zoneAxis'>" + x + "</div>")
                }
            }
        } else {
            for (var x = 0; x < (zones.length)+1; x++) {
                if (x == zones.length) {
                    $("#zoneRow" + i).append("<div id='axisVertical" + x + "' class='zoneAxis'>"+i+"</div>")
                } else {
                    if (zones[x].coordinateY == i) {
                        //This if statement defines the image (background) depending on zone environment variable
                        var environ = zones[x].biomeType;
                        var colour = getZoneColour(environ);
                        //This creates a unique identifier for each HTML div
                        var ident = (zones[x].zoneName);
                        var ident2 = "zoneLocation" + zones[x].coordinateX + "T" + zones[x].coordinateY;
                        var identPrev = "zoneLocation" + (parseInt(zones[x].coordinateX) - 1) + "T" + zones[x].coordinateY;
                        if (zones[x].coordinateX == 0) {
                            $("#zoneRow" + i).append("<div id='axisVertical" + x + "' class='zoneAxis'>" + i + "</div><div id='" +
                                ""+ident2 + "'><div id='" + ident + "' class='zone'>" +
                                "<img src='/images/depleted.png' id='depleted" + x + "' class='mapimages'>" +
                                "<img src='/images/unexplored5.png' id='unexplored" + x + "' class='mapimages'>" +
                                "</div></div>");
                        } else {
                            $("#" + identPrev).after("<div id='" + ident2 + "'><div id='" + ident + "' class='zone'>" +
                                "<img src='/images/depleted.png' id='depleted" + x + "' class='mapimages'>" +
                                "<img src='/images/unexplored5.png' id='unexplored" + x + "' class='mapimages'>" +
                                "</div></div>");

                        }
                        if (zones[x].isSpecialZone !== false){
                            $("#" + ident).append("<img src='/images/pixelIdol.png' id='shrine" + x + "' class='mapimages'>");
                            $("#shrine" + x).width("20px")
                                .height("20px");
                        }
                        if (zones[x].outpostBuilt === true) {
                            $("#" + ident).append("<img src='/images/outpostMarker.png' id='outpost" + x + "' class='mapimages'>");
                            $("#outpost" + x).width("20px")
                                .height("20px");
                        }
                        if (zones[x].firepitAlert === true) {
                            $("#" + ident).append("<img src='/images//buildings/firepit.png' id='firepitImage" + x + "' class='mapimages'>");
                            $("#outpost" + x).width("20px")
                                .height("20px");
                        }
                        $("#" + ident).css({"background": colour})
                            .hover(function () {
                                $(this).css("border-color", "blue");
                            }, function () {
                                $(this).css("border-color", "black")
                            })
                            .click(function () {
                                $("#zonesurround").remove();
                                $(this).append("<img src='/images/Surround.png' id='zonesurround' class='mapimages'>").css("z-index", "10");
                                selectZone(this.id);
                            });
                        if (zones[x].partyInZone === true) {
                            $("#unexplored" + x).attr("src", "/images/partyMember.png");
                        }
                        if (zones[x].biomeType === -1) {
                            $("#unexplored" + x).css("visibility", "hidden")
                        }
                        if (zones[x].findingChances > 0) {
                            $("#depleted" + x).css("visibility", "hidden");
                        }
                    }
                }
            }
        }
    }
}


//This activates and deactivates the directional buttons when the player moves to reduce the need for the map to refresh
function getDirection(CoordX,CoordY, width) {
    if (CoordX == 0){
        $("#butwest").attr("src","/images/arrowleftDisable.png")
            .prop('onclick',null).off('click');
    } else {
        $("#butwest").attr("src","/images/arrowleft.png")
            .removeAttr('onclick')
            .attr("onclick","movedirection('w');");
    }
    if (CoordY == 0){
        $("#butsouth").attr("src","/images/arrowdownDisable.png")
            .prop('onclick',null).off('click');
    } else {
        $("#butsouth").attr("src","/images/arrowdown.png")
            .removeAttr('onclick')
            .attr("onclick","movedirection('s');");
    }
    if (CoordX == (width-1)){
        $("#buteast").attr("src","/images/arrowrightDisable.png")
            .prop('onclick',null).off('click');
    } else {
        $("#buteast").attr("src","/images/arrowright.png")
            .removeAttr('onclick')
            .attr("onclick","movedirection('e');");
    }
    if (CoordY == (width-1)){
        $("#butnorth").attr("src","/images/arrowupDisable.png")
            .prop('onclick',null).off('click');
    } else {
        $("#butnorth").attr("src","/images/arrowup.png")
            .removeAttr('onclick')
            .attr("onclick","movedirection('n');");
    }
}


//This updates the map with the known locations
function playerVision(avatarLoc) {
    $("#"+avatarLoc).append("<img src='../images/playerlocation.png' id='playerimg' class='mapimages'>");
    var playerLoc = parseInt(avatarLoc.slice(9,13));
    $("#unexplored"+playerLoc).css("visibility", "hidden");
    $("#playerimg").css("z-index", "100");
    $("#loadingscreen").css("visibility", "hidden");
}

//This is used when the arrow direction arrows are pressed on the map screen
function movedirection(dir){
    ajax_All(20,dir,7);
}

//This is used when a zone is clicked on with the map
function selectZone(zoneID){
    ajax_All(24, zoneID,8);
}


//This function states what will go into the infobox to the upper right of the map once it has been clicked on
function infobox(zone) {
    $("#infobox").show();
    $("#zonelocation").empty();
    $("#players").empty();
    $("#mapItems").empty();
    $("#environment").empty();
    $("#zonelocation").append("<strong>[" + zone.coordinateX + " / " + zone.coordinateY + "]</strong>");
    if (zone.biomeType == "-1") {
        $("#zonelocation").append("<div><strong>Unexplored</strong></div>");
    }
    else {
        var players = "";
        if (zone.avatars.length === 0) {
            players = "Unknown";
        } else {
            for (var x = 0; x < zone.avatars.length; x++) {
                players += zone.avatars[x] + ", ";
            }
            players = players.slice(0, -2);
        }
        $("#zonelocation").append("<div><strong>"+zone.biomeValue+"</strong></div>");
        $("#players").append("<strong>Players: </strong>" + players);
        if (zone.zoneOwners != null) {
            $("#mapItems").append("<strong>Controlling Party: </strong>" + zone.zoneOwners);
        }
        $("#environment").append(zone.descriptionLong);
    }
}

function dropitem(id){
    ajax_All(44,id,9)
}

function updateItems(info){
    updateBackpack(info.backpack, info.backpackSize);
    updateGround(info.ground);
    if ("findingChance" in info) {
        if (info.findingChance === 0) {
            if ($("#depletedzone").length == 0) {
                $("#zonename").append("<div id='depletedzone'>(Depleted)</div>");
            }
        }
    }
    zoneActions(info.logs);
}

function updateBackpack(items,maxBackpack){
    $("#backpack").empty();
    for (var object in items){
        $("#backpack").append("<div class='imagediv'><image class='itemimage' src='/images/items/"+items[object].icon+"' id='"+items[object].itemID+"' onclick='dropitem(this.id)'><span class='imagetext'>"+items[object].identity+"<hr>"+items[object].description+"</span></div>")

    }
    var difference = maxBackpack - objectSize(items);
    for (x=0;x<difference;x++){
        $("#backpack").append("<div class='imagediv'><image class='itemimage' src='/images/items/Empty.png' id='empty+"+x+"'><span class='imagetext'>Empty</span></div>")
    }
}

function updateGround(items){
    $("#grounditems").empty();
    if (objectSize(items) === 0){
        $("#grounditems").append("The zone is empty");
    }
    for (var object in items){
            $("#grounditems").append("<div class='imagediv'><image class='itemimage' src='/images/items/"+items[object].icon+"' id='"+items[object].itemID+"' onclick='dropitem(this.id)'><span class='imagetext'>"+items[object].identity+"<hr>"+items[object].description+"</span></div>")
    }
}

function zoneInformation(info){
    var writing = getAvatars(info.avatars);
        $("#zoneinformation").empty()
            .append("<div id='zonename'><div>" + info.biomeValue + "</div></div>")
            .append("<div id='zoneinfowrite'>" + info.description + "</div>"+writing);
    if (info.findingChances == 0) {
        $("#zonename").append("<div id='depletedzone'>(Depleted)</div>");
    }
}

function searchZone(){
    ajax_All(22,"none",9);
}

function zoneActions(logs){
    $("#movementLogActions").empty();
    if (objectSize(logs) == 0){$("#movementLogActions").prepend("<div class='movementLogActionLog'><span class='movementLogText'>Nothing has happened today</span></div>")
    }
    else {
        for (var num in logs) {
            var message = logs[num].messageText;
            var time = logs[num].messageTime;
            message = message.replace("#name#", "<strong>" + logs[num].avatarID + "</strong>");
            if (logs[num].messageType === 8){
                $("#movementLogActions").prepend("<div class='movementLogActionLogRed'><div class='movementLogTimestamp'>" + time + "</div><span class='movementLogText'>" + message + "</span></div>")
            } else {
                $("#movementLogActions").prepend("<div class='movementLogActionLog'><div class='movementLogTimestamp'>" + time + "</div><span class='movementLogText'>" + message + "</span></div>")
            }
        }
    }
}


function getAvatars(avatarList){
    var writing = "";
    var length = objectSize(avatarList);
    if (length === 0){
            writing += "<span id='playersDont'>Looking around you can see you're alone in this zone</span>";
    } else {
        writing = "<span id='playersExist'>Looking around you spot ";
        for (var avatar in avatarList) {
            length--;
            writing += avatarList[avatar];
            if (length > 1) {
                writing += ", ";
            } else if (length == 1) {
                writing += " and ";
            } else {
                writing += " nearby</span>"
            }
        }
    }
    return writing
}

function destroyBiome(){
    ajax_All(23,"none",9);
}

function destroyResponse(response){
    if (response.foundItems > 1) {
        if (!alert('A huge explosion has destroyed the ' + response.biome + ' around but somehow ' + response.foundItems + ' items seem to have survived the blast')) {
            window.location.reload();
        }
    } else if (response.foundItems == 1){
        if (!alert('A huge explosion has destroyed the ' + response.biome + ' around but somehow ' + response.foundItems + ' item seems to have survived the blast')) {
            window.location.reload();
        }
    } else {
        if (!alert('A huge explosion has destroyed the ' + response.biome + ', nothing survived the blast')) {
            window.location.reload();
        }

    }
}

function getZoneColour(type){
    switch (type) {
        case 1:
            //DIRT
            var colour = "#BF842B";
            break;
        case 2:
            //SNOW
            var colour = "#78BA96";
            break;
        case 3:
            //SCRUB
            var colour = "#BFE874";
            break;
        case 4:
            //FOREST
            var colour = "#409127";
            break;
        case 5:
            //WATER
            var colour = "#003977";
            break;
        case 6:
            //ICE
            var colour = "#007A6C";
            break;
        case 100:
            //SPECIAL
            var colour = "#ffffff";
            break;
        default:
            var colour = "#000000"
    }
    return colour;

}