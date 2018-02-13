////// MAP + ZONE PAGE ////////

var visionCurrent = 1;
var selectedZone = false;
var currentZone = false;

function generalUpdateMap(response){
    updateMapImage(response);
    updateItems(response);
    zoneActions(response.logs);
}

function updateItems(info){
    playerScreenMap(info.zone);
    updateBackpack(info.itemsView.backpack, info.itemsView.backpackSize);
    updateGround(info.itemsView.ground);
    zoneActions(info.itemsView.logs);
}

function updateMapImage(response){
    currentZone = response.zone.zoneNumber;
    mapcreate(response.mapZones);
    getDirection(response.zone.coordinateX, response.zone.coordinateY, (Math.sqrt(response.mapZones.length)));
    playerVision(response.itemsView.avatarLoc);
    createMiniMap(response.mapZones,response.zone.zoneNumber);
    if (selectedZone != false){
        for (var zone in response.mapZones){
            if (response.mapZones[zone].zoneName == selectedZone){
                infobox(response.mapZones[zone]);
            }
        }
    } else {
        infobox(response.zone);
    }
    if (visionCurrent === 1){
        $("#infobox").hide();
    } else {
        $("#infobox").show();
    }
    $("#mapWrapperHider").hide();
    if (response.zone.isSpecialZone !== false){
        $(".itemContainerWrap").hide();
        $("#mapActionsWrapper").hide();
        $("#zoneActionsWrap").hide();
        $("#specialZoneWriting").empty().append("SHRINE")
    } else {
        $(".itemContainerWrap").show();
        $("#mapActionsWrapper").show();
        $("#zoneActionsWrap").show();
        $("#specialZoneWriting").empty().append("CONSTRUCT")
    }
}

//This function creates the basic map using the PlayerMapController Class
function mapcreate(zones) {
    $("#mapwrapper").click(function(e) {
        e.stopPropagation();
    });
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
                        if (selectedZone != false) {
                            if (ident == selectedZone) {
                                $("#" + ident).append("<img src='/images/Surround.png' id='zonesurround' class='mapimages'>").css("z-index", "10");
                            }
                        } else {
                            if (zones[x].zoneNumber == currentZone){
                                $("#" + ident).append("<img src='/images/Surround.png' id='zonesurround' class='mapimages'>").css("z-index", "10")
                            }
                        }
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

//This creates a minimap on the 3rd person view screen
function createMiniMap(zones,current){
    $("#miniMapWrapper").empty();
    var currentX = zones[current].coordinateX;
    var currentY = zones[current].coordinateY;
    var zone1 = [-1,1,false];
    var zone2 = [0,1,false];
    var zone3 = [1,1,false];
    var zone4 = [-1,-0,false];
    var zone5 = [0,0,false];
    var zone6 = [1,0,false];
    var zone7 = [-1,-1,false];
    var zone8 = [0,-1,false];
    var zone9 = [1,-1,false];
    var zoneList = [zone1,zone2,zone3,zone4,zone5,zone6,zone7,zone8,zone9];
    for (var zoneTest in zones){
        for (check in zoneList){
            if (zones[zoneTest].coordinateX === (currentX + zoneList[check][0])){
                if (zones[zoneTest].coordinateY === (currentY + zoneList[check][1])){
                    zoneList[check][2] = zoneTest;
                }
            }
        }
    }
    for (var y = 1; y>-2;y--) {
        $("#miniMapWrapper").append("<div class='miniMapRow' id='wrapZone" + y + "'></div>");
        for (var x = -1; x < 2; x++) {
            for (check in zoneList){
                if (zoneList[check][1] === y){
                    if (zoneList[check][0] === x){
                        var colour = "#000000"
                        if (zoneList[check][2] !== false) {
                            colour = getZoneColour(zones[zoneList[check][2]].biomeType);
                            if (x === 0 && y === 0) {
                                $("#wrapZone" + y).append("<div class='miniMapZone' id='miniMap" + check + "'>X</div>");

                            } else {
                                $("#wrapZone" + y).append("<div class='miniMapZone' id='miniMap" + check + "'></div>");
                            }
                            $("#miniMap" + check).css({"background": colour})
                        } else {
                            $("#wrapZone" + y).append("<div class='miniMapZone2' id='miniMap" + check + "'></div>");
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

//This creates the new visual map window
function playerScreenMap(info){
    if (info.biomeType<99) {
        if (info.findingChances == 0) {
            $("#zoneInfoWrapper").css("background-image", "url('/images/biomeTitles/deplete" + info.biomeImage+"BiomeBackground.png");
            $("#actionSearchButton").empty().show().append('<img src="/images/searchButtonDisable.png" id="destroyBiomeImage""><span class="imagetext"><strong>Search zone </strong><br>Zone Depleted</span>');
            if ($("#actionExplosionButton").length){
                $("#actionExplosionButton").empty().show().append('<img src="/images/explosionButtonDisable.png" id="destroyBiomeImage""><span class="imagetext"><strong>Destroy zone</strong><br>Zone Depleted</span>');
            }
            $("#actionShrineButton").empty().hide();
        } else {
            $("#zoneInfoWrapper").css("background-image", "url('/images/biomeTitles/" + info.biomeImage+"BiomeBackground.png");
            $("#actionSearchButton").empty().show().append('<img src="/images/searchButton.png" id="destroyBiomeImage" onclick="searchZone()"><span class="imagetext"><strong>Search zone</strong><br>Costs 1 stamina</span>');
            if ($("#actionExplosionButton").length) {
                $("#actionExplosionButton").empty().show().append('<img src="/images/explosionButton.png" id="destroyBiomeImage" onclick="destroyBiome()"><span class="imagetext"><strong>Destroy zone</strong><br>Costs 5 stamina</span>');
            }
            $("#actionShrineButton").empty().hide();
        }
    } else {
        $("#zoneInfoWrapper").css("background-image", "url('/images/biomeTitles/" + info.biomeImage+"BiomeBackground.png");
        $("#actionSearchButton").empty().hide();
        $("#actionExplosionButton").empty().hide();
        $("#actionShrineButton").empty().show().append('<img src="/images/teaching.png" id="destroyBiomeImage" onclick="goToShrine()"><span class="imagetext"><strong>Worship Spirit</strong><br>Different spirits have different costs and rewards</span>');
    }
    $("#zonePlayersWrapper").empty().append('<div class="mapPlayerImageWrap" id="playerImageSelf"><img src="/images/mapImages/playerGreen.png" class="mapPlayerImage"></div>');
    var avatarCount = objectSize(info.avatars);
    if (avatarCount > 0) {
        var counter = 0;
        var width = 246/avatarCount;
        for (var avatar in info.avatars){
            var height = Math.floor(Math.random()*74);
            $("#zonePlayersWrapper").append('<div class="mapPlayerImageWrap" id="player'+avatar+'"><img src="/images/mapImages/playerBrown.png" class="mapPlayerImage"><span class="playerImageText"><strong>'+info.avatars[avatar]+'</strong></span></div>');
            $("#player"+avatar).css({"top":height+"px","left":width*counter+"px"});
            counter ++;
        }
    }
    $("#mapCoordinates").empty().append("[ "+info.coordinateX+" / "+info.coordinateY+" ]");
    setVision();
}



//This picks if the map or the zone will be shown
function setVision(){
    if (visionCurrent === 0){
        $("#zoneInfoWrapper").hide();
        $("#infobox").show();
        $("#mapwrapper").show();
    } else {
        $("#zoneInfoWrapper").show();
        $("#infobox").hide();
        $("#mapwrapper").hide();
    }
}


//This updates the map with the known locations
function playerVision(avatarLoc) {
    $("#"+avatarLoc).append("<img src='../images/playerlocation.png' id='playerimg' class='mapimages'>");
    $("#unexplored"+avatarLoc).css("visibility", "hidden");
    $("#playerimg").css("z-index", "100");
    $("#loadingscreen").css("visibility", "hidden");
}


//This function states what will go into the infobox to the upper right of the map once it has been clicked on
function infobox(zone) {
    $("#zonelocation").empty().append("<strong>[" + zone.coordinateX + " / " + zone.coordinateY + "]</strong>");
    if (selectedZone != false) {
        if (zone.biomeType == "-1"){
            $("#infobox").css("background-image", "url('/images/biomeTitles/unknownBiomeTitle.png");
        } else {
            $("#infobox").css("background-image", "url('/images/biomeTitles/" + zone.biomeImage+"BiomeTitle.png");
        }
    } else {
        $("#infobox").css("background-image", "url('/images/biomeTitles/" + zone.biomeImage+"BiomeTitle.png");
    }
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
            writing += "<div id='playersDont'>Looking around you can see you're alone in this zone</div>";
    } else {
        writing = "<div id='playersExist'>Looking around you spot ";
        for (var avatar in avatarList) {
            length--;
            writing += avatarList[avatar];
            if (length > 1) {
                writing += ", ";
            } else if (length == 1) {
                writing += " and ";
            } else {
                writing += " nearby</div>"
            }
        }
    }
    return writing
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

function goToShrine(){
    window.location.href = "ingame.php?p=s";
}

function openMapImage(){
    visionCurrent = 0;
    setVision();
}

function hideMapWrapper(){
    visionCurrent = 1;
    setVision();
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

function searchZone(){
    ajax_All(22,"none",9);
}

function destroyBiome(){
    ajax_All(23,"none",9);
}

function dropitem(id){
    console.log(id);
    ajax_All(44,id,9)
}

//This is used when the arrow direction arrows are pressed on the map screen
function movedirection(dir){
    ajax_All(20,dir,7);
}

//This is used when a zone is clicked on with the map
function selectZone(zoneID){
    selectedZone = zoneID;
    ajax_All(24, zoneID,8);
}