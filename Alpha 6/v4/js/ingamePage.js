var dropLocation = 0;
var typeBuild = "ground";
var chestExist = true;
var typeView = 0;
var selectedZoneID = null;

function getItemTypes(num){
    switch (num){
        case 1:
            return "Boosters";
            break;
        case 2:
            return "Construction";
            break;
        case 3:
            return "Parts";
            break;
        case 4:
            return "Other";
            break;
        case 5:
            return "Warmth";
            break;
        default:
            return 5;
            break;

    }
}


function getGamePage(){
    ajax_All(9,14, typeBuild,typeView)
}

function buildGamePageHUD(data){
    if(data.dayEndStat === "ERROR"){
        $(".HUDDayEnd").empty();
        if (data.readyStat === 0){
            $(".HUDDayEnd").append('<button class="btn btn-danger">End Day</button>');
        } else {
            $(".HUDDayEnd").append('<button class="btn btn-success">Ready</button>');
        }
    } else {
        $(".HUDCurrentTime").empty().append(data.mapTimer);
        $(".HUDnightfall").empty().append(data.dayEndStat);
    }
    $(".HUDplayerTemp").empty().append((data.playerTemp*-1));
    $(".HUDLandTemp").empty().append((data.nightTemp*-1));
    $(".HUDMaxStamina").empty().append(data.staminaMax);
    $(".HUDCurrentStamina").empty().append(data.staminaCurrent);
    createThermometer(data.nightTemp);
    createStatusArray(data.playerStatus);
}

function buildGamePageMain(data){
    if (data.storageDetails === "Locked"){
        chestExist = "Locked";
    } else if (data.storageDetails.storageID === 0){
        chestExist = false;
    }
    createBackpack(data.itemBackpack, data.backpack);
    createGround(data.itemGround);
    createChestItems(data.itemChest,data.storageDetails);
    setupZoneImage(data);
    showItemLocation();
    createBuildLocationButtons();
    createZoneBuildings(data.zoneBuildings);
    createOtherAvatars(data.zonePlayers);
    if (typeView === 0){
        createEventsList(data.eventsList);
    }
    if (typeView === 1) {
        createBuildingsList(data.buildingList, data.biomeType);
    }
    if (typeView === 2){
        createPlayersWrap(data.partyPlayers,data.partyRequests,data.partyName);
    }
    if (typeView === 3){
        createGodsWrapper(data.shrineScores);
    }
    createPersonalAvatarPage(data);
    makeTypeView();
    activateTooltips();
    createMapImage(data.mapInformation);
}

function createPersonalAvatarPage(data){
    $(".zoneAvatarPlayerImage").attr("src","/avatarimages/avatarIngame/"+data.avatarImage+".png");
    createAvatarBackpackView(data.currentBackpack,data.backpackUp1,data.backpackUp2);
    createAvatarRecipes(data.recipeList);
    createAvatarUsable(data.itemBackpack);
    createAvatarResearch(data.researchCurrent,data.researchTotal,data.researchOptions);
}

function createOtherAvatarPage(data){
    $(".avatarPlayerName").empty().append(data.profileID);
    $(".avatarPlayerPartyName").empty().append(data.partyName);
    $(".zoneAvatarOtherImage").attr("src","/avatarimages/avatarIngame/"+data.avatarImage+".png");
    createResearchList(data.researchTeach,data.avatarID);
    createPartyActions(data);
    changeView(3);
    activateTooltips();
}

function createShrinePage(data){
    $(".zoneShrineGodType").empty().append(data.godClass);
    $(".zoneShrineGodName").empty().append(data.name);
    $(".zoneShrineImage").attr("src","/images/gamePage/shrines/"+data.icon+".png");
    $(".zoneShrineDetails").empty().append(data.message);
    $(".zoneShrineWorshipCost").empty().append(data.costMessage);
    $(".zoneShrineWorshipButton").empty().append('<button class="btn btn-primary" id="worshipButton'+data.shrineID+'" onclick="worshipAtShrine(this.id)">Sacrifice</button>');
    createTributesWrap(data.tributeCurrent,data.class);
    changeView(4);
}

function createMapPage(data){
    createMapImage(data.mapInformation);
    createMapZoneDetails(data.details);
    changeView(5);
}

function createThermometer(temp) {
    var src = "8";
    if (temp < 0){
        src = "1";
    } else if (temp <10){
        src = "2";
    } else if (temp <20){
        src = "3";
    } else if (temp <35){
        src = "4";
    } else if (temp <50){
        src = "5";
    } else if (temp <65){
        src = "6";
    } else if (temp <80){
        src = "7";
    }
    $(".thermometerImage").attr("src","/images/gamePage/Thermometer/thermometer"+src+".png");
}

function createStatusArray(data){
    $(".HUDstatuses").empty();
    for (var x in data){
        $(".HUDstatuses").append('<div class="HUDstatusImageWrapper d-flex flex-row justify-content-center align-items-center" data-toggle="popover" data-placement="top" title="'+data[x].statusName+'" data-content="'+data[x].statusDescription+'"><img class="HUDstatusImage" src="/images/gamePage/status/'+data[x].statusImage+'.png"></div>')
    }
}

function createBackpack(items,maxsize){
    $(".backpackWrapper").empty();
    var counter = 0;
    for (var x in items){
        $(".backpackWrapper").append('<div class="itemObject mr-1 mt-1 objectTooltip" data-toggle="popover" data-placement="top" title="'+items[x].identity+'" data-content="'+items[x].description+'" onclick="dropItem(this.id)" id="itembag'+items[x].itemTemplateID+'"><img src="/images/gamePage/items/'+items[x].icon+'.png" class="itemImage"></div>');
        counter++
    }
    var difference = maxsize-counter;
    for (x=0;x<difference;x++){
        $(".backpackWrapper").append('<div class="itemObject mr-1 mt-1"></div>');
    }
}

function createGround(items){
    $(".itemLocationBorder2").empty();
    var types = getItemTypes(0);
    var name = "";
    var found = false;
    for(var x=1;x<=types;x++){
        found = false;
        for (var y in items){
            if (items[y].itemType === x){
                found = true;
            }
        }
        if (found === true) {
            name = getItemTypes(x);
            $(".itemLocationBorder2").append('<div class="row p-1">' +
                '<div class="col-12 font-size-2 standardWrapperTitle font-weight-bold" align="left">' + name + '</div>' +
                '<div class="col-12 d-flex flex-row flex-wrap justify-content-start" id="groundWrapper' + x + '">' +
                '</div>' +
                '</div>');
        }
    }
    var counter = 0;
    for (x in items){
        counter++;
        if (!$("#floor"+items[x].itemTemplateID).length) {
            $("#groundWrapper" + items[x].itemType).append('<div class="itemObjectChest mr-1 mt-1 objectTooltip" data-toggle="popover" data-placement="top" title="'+items[x].identity+'" data-content="'+items[x].description+'" id="floor' + items[x].itemTemplateID + '" onclick="pickGroundItem(this.id)">' +
                '<img src="/images/gamePage/items/'+items[x].icon+'.png" class="itemImage">' +
                '<span class="font-size-1 itemObjectChestNumber font-weight-bold" id="1">1</span>' +
                '</div>');
        } else {
            var tempNum = $("#floor"+items[x].itemTemplateID+" .itemObjectChestNumber").attr("id");
            var newNum = parseInt(tempNum) + 1;
            $("#floor"+items[x].itemTemplateID+" .itemObjectChestNumber").empty().append(newNum).attr("id",newNum);
        }
    }
    if (counter === 0){
        $(".itemLocationBorder2").empty().append('<div class="row p-1 grayColour justify-content-center"><div>The ground is empty</div></div>');
    }
}

function showItemLocation(){
    if (dropLocation === 1){
        $(".itemLocationBorder1").removeClass("d-block d-none").addClass("d-block");
        $(".itemLocationBorder2").removeClass("d-block d-none").addClass("d-none");
        $(".itemLocationButtonGround").removeClass("lightGrayBackground");
        $(".itemLocationButtonChest").addClass("lightGrayBackground");
    } else {
        $(".itemLocationBorder2").removeClass("d-block d-none").addClass("d-block");
        $(".itemLocationBorder1").removeClass("d-block d-none").addClass("d-none");
        $(".itemLocationButtonChest").removeClass("lightGrayBackground");
        $(".itemLocationButtonGround").addClass("lightGrayBackground");
    }
}

function createChestItems(items,storage) {
    $(".itemLocationBorder1").empty();
    if (storage === "Locked"){
        $(".itemLocationBorder1").append('<div class="row p-1 grayColour justify-content-center"><div>CHEST IS LOCKED</div></div>');
    } else {
        if (storage.storageID == 0) {
            $(".itemLocationBorder1").append('<div class="row p-1 grayColour justify-content-center"><div>NO CHEST BUILT</div></div>');
        } else {
            var counter = 0;
            var types = getItemTypes(0);
            var name = "";
            var found = false;
            for (var x = 1; x <= types; x++) {
                found = false;
                for (var y in items) {
                    if (items[y].itemType === x) {
                        found = true;
                    }
                }
                if (found === true) {
                    name = getItemTypes(x);
                    $(".itemLocationBorder1").append('<div class="row p-1">' +
                        '<div class="col-12 font-size-2 standardWrapperTitle font-weight-bold" align="left">' + name + '</div>' +
                        '<div class="col-12 d-flex flex-row flex-wrap justify-content-start" id="chestWrapper' + x + '">' +
                        '</div>' +
                        '</div>');
                }
            }
            for (x in items) {
                counter++;
                if (!$("#chest" + items[x].itemTemplateID).length) {
                    $("#chestWrapper" + items[x].itemType).append('<div class="itemObjectChest mr-1 mt-1 objectTooltip" data-toggle="popover" data-placement="top" title="' + items[x].identity + '" data-content="' + items[x].description + '" id="chest' + items[x].itemTemplateID + '" onclick="pickChestItem(this.id)">' +
                        '<img src="/images/gamePage/items/' + items[x].icon + '.png" class="itemImage">' +
                        '<span class="font-size-1 itemObjectChestNumber font-weight-bold" id="1">1</span>' +
                        '</div>');
                } else {
                    var tempNum = $("#chest" + items[x].itemTemplateID + " .itemObjectChestNumber").attr("id");
                    var newNum = parseInt(tempNum) + 1;
                    $("#chest" + items[x].itemTemplateID + " .itemObjectChestNumber").empty().append(newNum).attr("id", newNum);
                }
            }
            if (counter === 0) {
                $(".itemLocationBorder1").append('<div class="row p-1 grayColour justify-content-center"><div>The chest is empty</div></div>');
            }
        }
    }
}

function createBuildLocationButtons(){
    switch (typeBuild){
        case "backpack":
            $("#buttonBuild-backpack").removeClass("btn-success disabled btn-outline-success").addClass("btn-success disabled");
            $("#buttonBuild-storage").removeClass("btn-success disabled btn-outline-success").addClass("btn-outline-success");
            $("#buttonBuild-ground").removeClass("btn-success disabled btn-outline-success").addClass("btn-outline-success");
            break;
        case "storage":
            if (chestExist === false || chestExist === "Locked") {
                $("#buttonBuild-backpack").removeClass("btn-success disabled btn-outline-success").addClass("btn-outline-success");
                $("#buttonBuild-storage").removeClass("btn-success disabled btn-outline-success").addClass("btn-outline-success");
                $("#buttonBuild-ground").removeClass("btn-success disabled btn-outline-success").addClass("btn-success disabled");
                typeBuild = "ground";
            } else {
                $("#buttonBuild-backpack").removeClass("btn-success disabled btn-outline-success").addClass("btn-outline-success");
                $("#buttonBuild-storage").removeClass("btn-success disabled btn-outline-success").addClass("btn-success disabled");
                $("#buttonBuild-ground").removeClass("btn-success disabled btn-outline-success").addClass("btn-outline-success");
            }
            break;
        case "ground":
            $("#buttonBuild-backpack").removeClass("btn-success disabled btn-outline-success").addClass("btn-outline-success");
            $("#buttonBuild-storage").removeClass("btn-success disabled btn-outline-success").addClass("btn-outline-success");
            $("#buttonBuild-ground").removeClass("btn-success disabled btn-outline-success").addClass("btn-success disabled");
            break;
    }
}

function createBuildingsList(buildings,zoneType){
    $(".totalBuildingWrapper").empty();
    if (zoneType === 100) {
        $(".totalBuildingWrapper").append("<div class='col-11 grayColour py-3' align='center'>It's too scary to build this close to a shrine</div>")
    }else {
        if (buildings === "Locked") {
            $(".totalBuildingWrapper").append("<div class='col-11 grayColour py-3' align='center'>The gate is locked, you can't build until it's open</div>")
        } else {
            for (var x in buildings) {
                if (!$(".buildingType" + buildings[x].buildingType).length) {
                    $(".totalBuildingWrapper").append('<div class="col-11 buildingListWrapper font-size-2 buildingType' + buildings[x].buildingType + '">' +
                        '<div class="row">' +
                        '<div class="col-12 standardWrapperTitle mt-2 mb-1 font-size-2x font-weight-bold">' + buildings[x].buildingType + '</div>' +
                        '</div>');
                }
            }
            var buildingsArray = [];
            var buildingsLength = objectSize(buildings);
            var createdLength = 0;
            while (createdLength < buildingsLength) {
                for (x in buildings) {
                    if (buildingsArray.indexOf(buildings[x].buildingTemplateID) < 0) {
                        var created = false;
                        var visible = "grayColour";
                        var button = "disabled";
                        var button2 = "cantBuild()";
                        if (buildings[x].canBeBuilt === true) {
                            visible = "";
                            button = "";
                            button2 = "buildBuilding(this.id)";
                        }
                        var spacing = "";
                        var buildingWrap = "";
                        if (buildings[x].buildingsRequired == 0) {
                            buildingWrap = buildingListItemWrap(buildings[x], visible, button, spacing, button2);
                            $(".buildingType" + buildings[x].buildingType).append(buildingWrap);
                            created = true;
                        } else {
                            if ($(".buildingOverview" + buildings[x].buildingsRequired).length > 0) {
                                if ($(".buildingOverview" + buildings[x].buildingsRequired + " .extenderWrapper").length > 0) {
                                    spacing = '<div class="extraSpacer"></div><i class="fas fa-window-minimize mr-2 extenderWrapper"></i>';
                                } else {
                                    spacing = '<i class="fas fa-window-minimize mr-2 extenderWrapper"></i>';
                                }
                                buildingWrap = buildingListItemWrap(buildings[x], visible, button, spacing, button2);
                                $(".buildingOverview" + buildings[x].buildingsRequired).after(buildingWrap);
                                created = true;
                            }
                        }
                        if (created === true) {
                            createdLength++;
                            buildingsArray.push(buildings[x].buildingTemplateID);
                            for (var y in buildings[x].itemsRequired) {
                                $(".buildingOverview" + buildings[x].buildingTemplateID + " .buildingItemsWrapper").append(
                                    '<div class="buildingItemWrap d-flex flex-row p-1 mr-1 mb-1 align-items-center justify-content-center">' +
                                    '<img class="buildingItem pr-1" src="/images/gamePage/items/' + buildings[x].itemsRequired[y].icon + '.png">' +
                                    '<div class="font-size-2"><span>' + buildings[x].itemsRequired[y].materialOwned + '</span><span>/</span><span>' + buildings[x].itemsRequired[y].materialNeeded + '</span></div>' +
                                    '</div>');
                            }
                        }
                    }
                }
            }
        }
    }
}

function buildingListItemWrap(data,visible,button,spacing,button2){
    if (data.isBuilt === false) {
        return '<div class="row ' + visible + ' align-items-center singleBuildingWrapper buildingOverview' + data.buildingTemplateID + '"><div class="col-6 col-sm-5 col-md-4 d-flex flex-row justify-content-start align-items-center" >' + spacing + '<div class="d-flex flex-row" data-toggle="popover" data-placement="top" title="' + data.name + '" data-content="' + data.description + '"><img src="/images/gamePage/buildings/' + data.icon + '.png" class="buildingImage"><div class="pl-2">' + data.name + '</div></div></div><div class="col-2 d-flex d-sm-none"><button class="btn btn-sm btn-danger py-0 px-1" data-toggle="collapse" data-target="#building' + data.buildingTemplateID + '" aria-expanded="false" aria-controls="building' + data.buildingTemplateID + '"><i class="fas fa-caret-square-down"></i></button></div><div class="buildingItemsWrapper d-none d-sm-flex col-12 col-sm-3 col-md-6 flex-row flex-wrap pt-1 pb-0 pl-1 pr-0"></div><div class="col-4 col-md-2 d-flex flex-row justify-content-end"><div class="mr-3"><span>' + data.staminaSpent + '</span><span>/</span><span>' + data.staminaRequired + '</span></div><button class="btn btn-danger ' + button + ' btn-sm py-0 px-1 font-weight-bold" onclick="' + button2 + '" id="buildingBuild' + data.buildingTemplateID + '"><i class="fas fa-plus"></i></button></div><div class="pt-1 pb-0 pl-1 pr-0 collapse" id="building' + data.buildingTemplateID + '"><div class="d-flex flex-row flex-wrap buildingItemsWrapper"</div></div>';
    } else {
        return '<div class="row align-items-center singleBuildingWrapper buildingOverview' + data.buildingTemplateID + '"><div class="col-6 col-sm-5 col-md-4 d-flex flex-row justify-content-start align-items-center greenBackgroundTransparent" >' + spacing + '<div class="d-flex flex-row" data-toggle="popover" data-placement="top" title="' + data.name + '" data-content="' + data.description + '"><img src="/images/gamePage/buildings/' + data.icon + '.png" class="buildingImage"><div class="pl-2">' + data.name + '</div></div></div><div class="col-6 col-sm-7 col-md-8 d-flex flex-row justify-content-end greenBackgroundTransparent"><div class="px-2 font-weight-bold">BUILT</div></div></div>';
    }
}

function setupZoneImage(data){
    createDirectionButtons(data);
    $(".zoneCoordWriting").empty().append("["+data.coordX+"/"+data.coordY+"]");
    createBackground(data.biomeType,data.depleted);
    createActionButtons(data.actions);
    createLocksInfo(data);
    $(".zoneAvatarImageWrap").empty().append('<img class="inzoneAvatarImage" src="/avatarimages/avatarIngame/'+data.avatarImage+'.png">');
    $(".zoneAvatarImageWrapPhone").empty().append('<img class="inzoneAvatarImage" src="/avatarimages/avatarIngame/'+data.avatarImage+'.png">');
}

function createLocksInfo(data){
    $(".zoneBuildingLocks").empty();
    if (data.fenceMax > 0){
        $(".zoneBuildingLocks").append('<div class="blackColour font-size-2"><b>Fence Lock:</b> '+data.fenceCurrent+'/'+data.fenceMax+'</div>')
    }
    if (data.storageLockMax > 0){
        $(".zoneBuildingLocks").append('<div class="blackColour font-size-2"><b>Chest Lock:</b> '+data.storageLockCurrent+'/'+data.storageLockMax+'</div>')
    }
}

function createBackground(id,depleted){
    if (depleted === true){
        $(".zoneImageWrapper").css("background-image", "url(/images/gamePage/zoneImages/backgrounds/"+id+"/BiomeBackgroundFillerDepleted.png)");
        $(".zoneImageInternal").css("background-image", "url(/images/gamePage/zoneImages/backgrounds/" + id + "/BiomeBackgroundDepleted.png)");
        $(".zoneImageWrapperPhone").css("background-image", "url(/images/gamePage/zoneImages/backgrounds/"+id+"/BiomeBackgroundFillerPhoneDepleted.png)");
        $(".zoneImageInternalPhone").css("background-image", "url(/images/gamePage/zoneImages/backgrounds/" + id + "/BiomeBackgroundPhoneDepleted.png)");
    } else {
        $(".zoneImageWrapper").css("background-image", "url(/images/gamePage/zoneImages/backgrounds/"+id+"/BiomeBackgroundFiller.png)");
        $(".zoneImageInternal").css("background-image", "url(/images/gamePage/zoneImages/backgrounds/" + id + "/BiomeBackground.png)");
        $(".zoneImageWrapperPhone").css("background-image", "url(/images/gamePage/zoneImages/backgrounds/"+id+"/BiomeBackgroundFillerPhone.png)");
        $(".zoneImageInternalPhone").css("background-image", "url(/images/gamePage/zoneImages/backgrounds/" + id + "/BiomeBackgroundPhone.png)");
    }
}

function createDirectionButtons(data){
    if (data.coordX === 0){
        $(".dirWest").hide()
    } else {
        $(".dirWest").show()
    }
    if (data.coordY === 0){
        $(".dirSouth").hide()
    } else {
        $(".dirSouth").show()
    }
    if (data.coordY === (data.mapSize-1)){
        $(".dirNorth").hide()
    } else {
        $(".dirNorth").show()
    }
    if (data.coordX === (data.mapSize-1)){
        $(".dirEast").hide()
    } else {
        $(".dirEast").show()
    }
}

function createActionButtons(actions){
    $(".zoneActionsWrap").empty();
    for (var x in actions){
        var actionButtonVar = null;
        switch (actions[x]){
            case 1:
                actionButtonVar = new actionButton("fas fa-blind","Search","Spend 1 stamina to search the zone for items","searchZone()");
                break;
            case 2:
                actionButtonVar = new actionButton("fas fa-bomb","Explode","Spend 5 stamina destroy the zone","destroyZone()");
                break;
            case 3:
                actionButtonVar = new actionButton("fas fa-gavel","Destroy Fence","Spend 1 stamina to break down the fence a little","actionFence()");
                break;
            case 4:
                actionButtonVar = new actionButton("fas fa-key","Pick Chest","Spend 1 stamina to try to open the chest a little","actionChest()");
                break;
            case 5:
                actionButtonVar = new actionButton("fas fa-wrench","Repair Fence","Spend 1 stamina to reinforce the gate lock","actionFence()");
                break;
            case 6:
                actionButtonVar = new actionButton("fas fa-screwdriver","Repair Chest","Spend 1 stamina to reinforce the chest lock","actionChest()");
                break;
            case 7:
                actionButtonVar = new actionButton("fas fa-medkit","Stamina","This is a cheat to gain more stamina in test games","gainStamina()");
                break;
            case 8:
                actionButtonVar = new actionButton("fas fa-hands","Worship","Approach the shrine and try to gain the favour of the gods","worshipShrine()");
                break;
            case 9:
                actionButtonVar = new actionButton("fas fa-blind redColour","Can't Search","This zone is now depleted, searching will do nothing","");
                break;
            case 10:
                actionButtonVar = new actionButton("fas fa-bomb redColour","Can't Explode","There is nothing left to find here","");
                break;
            case 11:
                actionButtonVar = new actionButton("fas fa-wrench redColour","Fence Repaired","The fence is now at maximum health","");
                break;
            case 12:
                actionButtonVar = new actionButton("fas fa-screwdriver redColour","Chest Secured","You can't improve the chest lock and further","");
                break;
        }
        if (actionButtonVar !== null){
            $(".zoneActionsWrap").append('<div class="d-flex flex-column justify-content-center align-items-center mr-2 mb-2"><div class="clickableActionButton p-1 d-flex justify-content-center align-items-center" data-toggle="popover" data-placement="top" title="'+actionButtonVar.title+'" data-content="'+actionButtonVar.text+'" onclick="'+actionButtonVar.action+'">' +
                '<i class="'+actionButtonVar.icon+'"></i>' +
                '</div><div class="d-flex d-md-none justify-content-center align-items-center font-size-1 actionButtonWriting" align="center">'+actionButtonVar.title+'</div></div>')
        }
    }
}

function createZoneBuildings(data){
    $(".zoneBuildingsImageWrap").empty();
    var list = [];
    for (var x in data){
        var name = null;
        var check = ""+data[x];
        switch(check){
            case "1":
                name = "firepit";
                list.push("Firepit");
                break;
            case "5":
                name = "fence";
                list.push("Fence");
                break;
        }
        if (name !== null){
            $(".zoneBuildingsImageWrap").append('<img class="buildingImageOverlay" src="/images/gamePage/zoneImages/buildingLayers/'+name+'.png">')
        }
    }
    var final = "";
    if (list.length !== 0){
        $(".zoneImageInternalPhone .zoneBuildingsImageWrap").addClass("phoneHighlightBorder");
        for (var x in list){
            final += list[x]+"<br />";
        }
    } else {
        final = "None";
        $(".zoneImageInternalPhone .zoneBuildingsImageWrap").removeClass("phoneHighlightBorder");
    }
    $(".zoneBuildingsImageWrap").attr('data-content',final);
}

function createOtherAvatars(data){
    $(".zoneOtherAvatarWrap").empty();
    $(".zoneOtherAvatarListWrapper").empty();
    var xEdge;
    var yEdge;
    var padding;
    for (var x in data){
        $(".zoneOtherAvatarListWrapper").append('<div class="col-6 d-flex flex-column justify-content-center align-items-center" id="avatarPhone'+data[x].avatarID+'" onclick="popupOtherPlayer(this.id)">' +
            '<img src="/avatarimages/avatarIngame/'+data[x].avatarImage+'.png" class="phoneAvatarListImage"><div class="font-size-2">'+data[x].profileID+'</div>' +
            '</div>');
        xEdge = Math.floor(Math.random()*3);
        yEdge = Math.floor(Math.random()*5);
        $(".zoneOtherAvatarWrap").append('<div class="zoneOtherAvatarWrapSingle" data-html="true" data-toggle="popover" data-placement="top" title="'+data[x].profileID+'" data-content="'+data[x].partyName+'" id="avatarOther'+data[x].avatarID+'" onclick="popupOtherPlayer(this.id)">' +
            '<img class="zoneOtherAvatarSingle" src="/avatarimages/avatarIngame/'+data[x].avatarImage+'.png">' +
            '</div>');
        padding = yEdge+"px 0 0 "+xEdge+"px";
        $("#avatarOther"+data[x].avatarID).css({"padding":padding})
    }
    var count = objectSize(data);
    if (count <= 0){
        $(".zoneOtherAvatarWrapPhone").empty().removeClass("phoneHighlightBorder");
        $(".zoneOtherAvatarListWrapper").append('<div class="col-8 grayColour" align="center">No other players in this zone currently</div>');
    } else if (count >=1){
        $(".zoneOtherAvatarWrapPhone").empty().append('<img src="/images/gamePage/zoneImages/otherPlayers/multiple.png">').addClass("phoneHighlightBorder");
    }
}

function createPlayersWrap(inParty,requests,partyName){
    $(".zonePartyMembersWrap").empty();
    $(".zonePartyRequestsWrap").empty();
    $(".zonePartyName").empty().append(partyName);
    var partyCount = objectSize(inParty);
    var buttons;
    if (partyCount != 1){
        $(".zonePartyNameEdit").addClass("d-none");
    } else {
        $(".zonePartyNameEdit").removeClass("d-none");
    }
    var word = "Kicking";
    var backgroundColour = "";
    for (var x in inParty) {
        var num = 0;
        if (inParty[x].self === true){
            if (partyCount > 1) {
                num = 3;
            }
            if (inParty[x].kickingVote === true) {
                backgroundColour = createBackgroundColours(inParty[x].partyVotes);
                if (inParty[x].yourVote === 1) {
                    num = 4;
                    word = "Agree"
                } else if (inParty[x].yourVote === 2){
                    num = 5;
                    word = "Against"
                } else {
                    num = 1;
                    word = "Kicking"
                }
            } else {
                backgroundColour = "rgba(200,200,200,0.3)"
            }
        } else {
            if (partyCount > 2) {
                if (inParty[x].kickingVote === true){
                    if (inParty[x].yourVote === 1) {
                        num = 4;
                        word = "Agree"
                    } else if (inParty[x].yourVote === 2){
                        num = 5;
                        word = "Against"
                    } else {
                        num = 1;
                        word = "Kicking"
                    }
                    backgroundColour = createBackgroundColours(inParty[x].partyVotes);
                } else {
                    num = 2;
                    backgroundColour = "rgba(200,200,200,0.3)"
                }
            }
        }
        buttons = playerPartyButtons(num, inParty[x].avatarID,word);
        $(".zonePartyMembersWrap").append('<div class="col-12 mb-2">' +
            '<div class="row zonePartyMemberSingleWrap pl-1 pl-sm-3 pr-3 pr-md-0 py-1 votingBack'+inParty[x].avatarID+'">' +
            '<div class="col-6 d-flex flex-row" align="left">' +
            '<img class="partyAvatarImage" src="/avatarimages/avatarIngame/'+inParty[x].avatarImage+'.png">' +
            '<div class="pl-3">'+inParty[x].profileID+'</div>' +
            '</div>' +
            '<div class="col-6 d-flex flex-row justify-content-end align-items-center">' +
            buttons +
            '</div>' +
            '</div>' +
            '</div>');
        $(".votingBack"+inParty[x].avatarID).css("background", backgroundColour);
    }
    var requestCount = objectSize(requests);
    if (requestCount > 0) {
        $(".requestsTitle").show();
        for (var x in requests) {
            if (requests[x].yourVote === 1) {
                num = 4;
                word = "Agree"
            } else if (requests[x].yourVote === 2){
                num = 5;
                word = "Against"
            } else {
                num = 1;
                word = "Joining"
            }
            backgroundColour = createBackgroundColours(requests[x].partyVotes);
            buttons = playerPartyButtons(1, requests[x].avatarID,word);
            $(".zonePartyRequestsWrap").append('<div class="col-12 mb-2">' +
                '<div class="row zonePartyMemberSingleWrap pl-1 pl-sm-3 pr-3 pr-md-0 py-1 votingRequest'+requests[x].avatarID+'">' +
                '<div class="col-6 d-flex flex-row" align="left">' +
                '<img class="partyAvatarImage" src="/avatarimages/avatarIngame/' + requests[x].avatarImage + '.png">' +
                '<div class="pl-3">' + requests[x].profileID + '</div>' +
                '</div>' +
                '<div class="col-6 d-flex flex-row justify-content-end align-items-center">' +
                buttons +
                '</div>' +
                '</div>' +
                '</div>');
            $(".votingRequest"+requests[x].avatarID).css("background", backgroundColour);
        }
    } else {
        $(".requestsTitle").hide()
    }
}

function createBackgroundColours(votes){
    var agree = 0;
    var against = 0;
    var none = 0;
    for (var x in votes){
        if (votes[x] === 0){
            none++
        } else if (votes[x] === 1){
            agree++
        } else {
            against++
        }
    }
    var total = objectSize(votes);
    var agreePerc = Math.round((agree/total)*100);
    var againstPerc = Math.round((against/total)*100);
    var nonePerc = Math.round((none/total)*100);
    var colour1 = "rgba(0,255,0,0.5)0%,rgba(0,255,0,0.5)"+(agreePerc-1)+"%";
    var colour2 = "rgba(200,200,200,0.2)"+(agreePerc+1)+"%,rgba(200,200,200,0.2)"+(agreePerc+nonePerc-1)+"%";
    var colour3 = "rgba(255,0,0,0.5)"+(agreePerc+nonePerc+1)+"%,rgba(255,0,0,0.5)100%";
    var comma1 = ", ";
    var comma2 = ", ";
    console.log(agreePerc+", "+(agreePerc+nonePerc)+", "+againstPerc);
    if (agreePerc < 1){
        colour1 = "";
        comma1 = "";
        if (nonePerc < 1){
            comma2 = "";
        }
    }
    if (nonePerc < 1) {
        colour2 = "";
    }
    if (againstPerc < 1){
        colour3 = "";
        comma2 = "";
        if (nonePerc <1){
            comma1 = "";
        }
    }
    return "linear-gradient(to right, "+colour1+comma1+colour2+comma2+colour3+")";
}

function playerPartyButtons(type,playerID,word){
    switch (type){
        case 1:
            return '<button class="btn btn-success btn-sm font-size-1 py-0 px-1" onclick="voteOnPlayer(this.id,1)" id="joinAPlayer'+playerID+'"><i class="fas fa-check"></i></button><div class="px-2 font-size-1 font-weight-bold">'+word+'</div><button class="btn btn-danger ml-2 btn-sm font-size-1 py-0 px-1" onclick="voteOnPlayer(this.id,2)" id="joinRPlayer'+playerID+'"><i class="fas fa-times"></i></button>';
            break;
        case 2:
            return '<div class="p-1 clickableFlash d-flex flex-row align-items-center justify-content-center" data-toggle="popover" data-placement="top" title="Kick" data-content="Vote to kick a player from the party" onclick="kickPlayer(this.id)" id="partyPlayer'+playerID+'"><i class="fas fa-user-times"></i><div class="font-size-2 ml-2 d-block d-md-none">Kick</div></div>';
            break;
        case 3:
            return '<div class="p-1 clickableFlash d-flex flex-row align-items-center justify-content-center" data-toggle="popover" data-placement="top" title="Leave" data-content="Choose to leave your current party" onclick="leaveParty(this.id)" id="partyPlayer'+playerID+'"><i class="fas fa-sign-out-alt"></i><div class="font-size-2 ml-2 d-block d-md-none">Leave</div></div>';
            break;
        case 4:
            return '<button class="btn btn-secondary disabled btn-sm font-size-1 py-0" id="joinAPlayer'+playerID+'"><i class="fas fa-check"></i></button><div class="px-2 font-size-1 font-weight-bold">'+word+'</div><button class="btn btn-danger btn-sm font-size-1 py-0" onclick="voteOnPlayer(this.id,2)" id="joinRPlayer'+playerID+'"><i class="fas fa-times"></i></button>';
            break;
        case 5:
            return '<button class="btn btn-success btn-sm font-size-1 py-0" onclick="voteOnPlayer(this.id,1)" id="joinAPlayer'+playerID+'"><i class="fas fa-check"></i></button><div class="px-2 font-size-1 font-weight-bold">'+word+'</div><button class="btn btn-secondary disabled btn-sm font-size-1 py-0" id="joinRPlayer'+playerID+'"><i class="fas fa-times"></i></button>';
            break;
        default:
            return "";
            break;
    }
}

function createAvatarBackpackView(current,upgrade1,upgrade2){
    var heatWord = current.heatBonus;
    if (current.heatBonus >= 0){
        heatWord = "+"+heatWord;
    }
    var backpackWord = current.backpackBonus;
    if (current.backpackBonus >= 0){
        backpackWord = "+"+backpackWord;
    }
    $(".zoneAvatarCurrentBackpack").empty().append('<div class="zoneEquipmentBorder justify-content-center align-items-center d-flex flex-column p-2" data-toggle="popover" data-placement="top" title="Current" data-html="true" data-content="Heat bonus: <b>'+heatWord+'</b><br>Space: <b>'+backpackWord+'</b>" >' +
        '<img src="/images/gamePage/sleepingBag/'+current.equipImage+'.png" class="zoneCurrentEquipmentIcon">' +
        '<div class="font-size-1" align="center">'+current.equipName+'</div>' +
        '</div>');
    var upgrade;
    if (upgrade1.equipmentID !== 1) {
        if (upgrade1.cost2Count == 0) {
            upgrade = createBackpackUpgradeSingle(upgrade1, 1);
        } else {
            upgrade = createBackpackUpgradeSingle(upgrade1, 2);
        }
    } else {
        upgrade = '<div class="zoneEquipmentBorder justify-content-center align-items-center d-flex flex-column p-2" data-toggle="popover" data-placement="top" title="No Upgrade" data-content="There are no further upgrades" onclick=""><div class="font-size-1 font-weight-bold standardWrapperTitle" align="center">No Upgrade</div></div>';
    }
    $(".zoneAvatarUpgradeBackpack").empty().append(upgrade);
    if (upgrade2.equipmentID !== 1) {
        if (upgrade2.cost2Count == 0) {
            upgrade = createBackpackUpgradeSingle(upgrade2, 1);
        } else {
            upgrade = createBackpackUpgradeSingle(upgrade2, 2);
        }
    } else {
        upgrade = '<div class="zoneEquipmentBorder justify-content-center align-items-center d-flex flex-column p-2" data-toggle="popover" data-placement="top" title="No Upgrade" data-content="There are no further upgrades" onclick=""><div class="font-size-1 font-weight-bold standardWrapperTitle" align="center">No Upgrade</div></div>';
    }
    $(".zoneAvatarUpgradeBackpack").append(upgrade);

}

function createBackpackUpgradeSingle(data,items){
    var upgradeItems = '<div class="itemObjectChest mr-1 mt-1"><img src="/images/gamePage/items/'+data.cost1Item.icon+'.png" class="itemImage"><span class="font-size-1 itemObjectChestNumber font-weight-bold" id="1">'+data.cost1Count+'</span></div>';
    if (items === 2){
        upgradeItems += '<div class="itemObjectChest mr-1 mt-1"><img src="/images/gamePage/items/'+data.cost2Item.icon+'.png" class="itemImage"><span class="font-size-1 itemObjectChestNumber font-weight-bold" id="1">'+data.cost2Count+'</span></div>';
    }
    return '<div class="zoneEquipmentBorder justify-content-center align-items-center d-flex flex-column p-2 clickableTransparent" data-toggle="popover" data-placement="top" title="Upgrade" data-content="Gives '+data.heatBonus+' heat bonus and '+data.backpackBonus+' space" id="backpackUpgradeButton'+data.equipmentID+'" onclick="upgradeBackpack(this.id)"><div class="font-size-1 font-weight-bold standardWrapperTitle" align="center">'+data.equipName+'</div><img src="/images/gamePage/sleepingBag/'+data.equipImage+'.png" class="zoneNextEquipmentIcon"><div class="font-weight-bold mt-2 font-size-1" align="center">Cost</div><div class="d-flex flex-row justify-content-between align-items-center">'+upgradeItems+'</div></div>';
}

function createAvatarUsable(data) {
    var count = 0;
    for (var x in data) {
        if (data[x].usable > 0) {
            count++;
        }
    }
    $(".zoneAvatarUseItems").empty();
    if (count < 1) {
        $(".zoneAvatarUseItems").append('<div class="grayColour" align="center">No items to use currently</div>')
    } else {
        var action = "";
        for (var x in data) {
            if (data[x].usable > 0) {
                switch (data[x].usable) {
                    case 1:
                        action = "Consume";
                        break;
                    case 2:
                        action = "Apply";
                }
                $(".zoneAvatarUseItems").append('<div class="d-flex flex-row clickableFlash"  id="useClick'+data[x].itemTemplateID+'" onclick="useItem(this.id)"><img src="/images/gamePage/items/' + data[x].icon + '.png" class="itemImage"><div class="pl-2 font-size-2">' + action + ' ' + data[x].identity + '</div></div>')
            }
        }
    }
}

function createAvatarRecipes(data){
    var count = objectSize(data);
    $(".zoneAvatarMakeItems").empty();
    if (count > 0){
        for (var x in data){
            $(".zoneAvatarMakeItems").append('<div class="d-flex flex-row clickableFlash" id="recipeClick'+data[x].recipeID+'" onclick="useRecipe(this.id)"><img src="/images/gamePage/recipes/' + data[x].recipeImage + '.png" class="itemImage"><div class=" pl-2 font-size-2">' + data[x].description + '</div></div>')
        }
    } else {
        $(".zoneAvatarMakeItems").append('<div class="grayColour" align="center">No available recipes currently</div>')
    }
}

function createAvatarResearch(current,maximum,options){
    $(".zoneAvatarReseachBarWrapper").empty();
    if (current < maximum){
        $(".zoneAvatarReseachBarWrapper").append('<div class="col-12 font-weight-bold font-size-2x" align="center">Research Buildings</div>' +
            '<div class="col-11 d-flex flex-column greenBackgroundTransparent p-2 justify-content-center align-items-center flex-wrap clickableFlash"  onclick="researchOnce()" data-html="true" data-toggle="popover" data-placement="top" title="Research" data-content="Discover new building options once you have studied enough, uses 1 stamina each time">' +
            '<div class="col-2 d-flex justify-content-center align-items-center font-size-3">' +
            '<i class="fas fa-flask" ></i>' +
            '</div>' +
            '<div>'+current+' / '+maximum+'</div>' +
            '</div>' +
            '</div>' +
            '</div>');
    } else {
        $(".zoneAvatarReseachBarWrapper").append('<div class="col-11">' +
            '<div class="row justify-content-center align-items-center zoneAvatarResearchWrapper">' +
            '<div class="col-12 greenBackgroundTransparent" align="center">Image here</div>' +
            '<div class="col-12 font-weight-bold font-size-2x" align="center">Choose a building type</div>' +
            '<div class="col-12 d-flex flex-row justify-content-center align-items-center flex-wrap zoneAvatarResearchOptions">' +
            '</div>' +
            '</div>' +
            '</div>');
        for (var x in options){
            var image = "";
            var type = ""+options[x].typeID;
            switch (type){
                case "1":
                    image = "firepit";
                    break;
                case "2":
                    image = "fence2";
                    break;
                case "3":
                    image = "trap";
                    break;
            }
            $(".zoneAvatarResearchOptions").append('<div class="clickableTransparent researchUpgradeImage" data-toggle="popover" data-placement="top" title="'+options[x].typeName+'" data-content="'+options[x].typeDescription+'" id="researchType'+options[x].typeID+'" onclick="selectResearch(this.id)"><img src="/images/gamePage/buildings/'+image+'.png" class="itemImage mr-2"></div>');
        }
    }
}

function createResearchList(data,avatarID){
    $(".zoneOtherAvatarResearch").empty();
    var count = objectSize(data);
    if (count > 0 ){
        for (var x in data){
            $(".zoneOtherAvatarResearch").append('<div class="my-1 row justify-content-center align-items-center clickable teachResearchWrap p-1" onclick="teachPlayerResearch(this.id)" id="teach'+avatarID+'+?!'+data[x].buildingTemplateID+'">' +
                '<div class="col-4"><img src="/images/gamePage/buildings/'+data[x].icon+'.png" class="itemImage"></div>' +
                '<div class="col-8 font-size-2 font-weight-bold">'+data[x].name+'</div>' +
                '</div>')
        }
    } else {
        $(".zoneOtherAvatarResearch").append('<div class="grayColour" align="center">There is nothing to teach currently</div>')
    }
}

function createPartyActions(data){
    $(".zoneAvatarOtherButtons").empty();
    var actions = [2];
    if (data.waitingToJoin === true){
        actions.push(3);
    } else {
        if (data.inParty === false){
            actions.push(1);
        }
    }
    var id = "";
    for (var x in actions){
        var actionButtonVar = null;
        switch (actions[x]){
            case 1:
                actionButtonVar = new actionButton("far fa-handshake","Join Party","Request to join with another players party, this request will be cancelled if you leave the zone or if the other player rejects you","joinParty(this.id)");
                id = "partyJoin"+data.avatarID;
                break;
            case 2:
                actionButtonVar = new actionButton("far fa-envelope","Message","Send a private message to a player on the same zone as you","messagePlayer()");
                id = "playerMessageButton";
                break;
            case 3:
                actionButtonVar = new actionButton("fas fa-times","Cancel Request","Cancel your request to join this party","cancelJoinParty(this.id)");
                id = "partyCancel"+data.avatarID;
                break;
        }
        if (actionButtonVar !== null){
            $(".zoneAvatarOtherButtons").append('<div class="d-flex flex-column justify-content-center align-items-center mr-2"><div class="clickableActionButton p-1 d-flex justify-content-center align-items-center" data-toggle="popover" data-placement="top" title="'+actionButtonVar.title+'" data-content="'+actionButtonVar.text+'" onclick="'+actionButtonVar.action+'" id="'+id+'">' +
                '<i class="'+actionButtonVar.icon+'"></i>' +
                '</div><div class="d-flex d-md-none justify-content-center align-items-center font-size-2" align="center">'+actionButtonVar.title+'</div></div>')
        }
    }
}

function createTributesWrap(list,type){
    var count = objectSize(list);
    $(".zoneShrineWorshipList").empty().removeClass("redBackgroundTransparent greenBackgroundTransparent");
    if (count === 0){
        $(".zoneShrineWorshipList").append('<div class="col-12 grayColour py-3" align="center">THIS SHRINE IS EMPTY</div>');
    } else {
        if (type === 3) {
            if (list.check == false) {
                $(".zoneShrineWorshipList").addClass("redBackgroundTransparent").append('<div class="col-12 py-3" align="center">Another god has been worshiped today</div>');
            } else {
                if (list.count > 0){
                    $(".zoneShrineWorshipList").addClass("greenBackgroundTransparent");
                }
                $(".zoneShrineWorshipList").append('<div class="col-12 py-3" align="center">'+list.shrine+' may still bless you today</div>');
            }
            var word = "Sacrifices";
            if (list.count === 1){
                word = "Sacrifice";
            }
            $(".zoneShrineWorshipList").append('<div class="col-12 py-3 d-flex flex-column justify-content-center align-items-center" align="center"><div class="font-size-4">'+list.count+'</div><div>'+word+'</div></div>');
        } else {
            var counter = 1;
            for (var x in list) {
                $(".zoneShrineWorshipList").append('<div class="col-12 d-flex flex-row justify-content-between align-items-center">' +
                    '<div class="d-flex justify-content-start flex-row">' +
                    '<div class="pr-2">'+counter+'.</div><div>'+list[x][1]+'</div>' +
                    '</div>' +
                    '<div class="font-weight-bold">'+list[x][0]+'</div>' +
                    '</div>');
                counter++;
            }
        }
    }
}

function createMapImage(data) {
    $(".zoneMapImageWrapper").empty();
    var top = 0;
    for (var x in data) {
        if (data[x].yaxis > top) {
            top = data[x].yaxis
        }
    }
    for (x = 0; x <= top; x++) {
        $(".zoneMapImageWrapper").prepend("<div class='row p-0 m-0 mapRowWrap" + x + " justify-content-center align-items-center'></div>");
    }
    for (x = 0; x<= top; x++){
        for (var y in data){
            if (data[y].xaxis === x){
                var depleted = "";
                var avatarImage = "";
                var campSite = "";
                var shrine = "";
                var borderSize = "mapZoneBox";
                var checker = 'mapZoneImageOverlay';
                var borderColour = "mapZoneBorder";
                if (data[y].marker !== 0){
                    borderSize = "mapZoneBox1";
                    checker = 'mapZoneImageOverlayBorder';
                    borderColour = "mapZoneBorderMarked"+data[y].marker;
                }
                if (data[y].depleted === 0){
                    depleted = "<img class='"+checker+"' src='/images/gamePage/mapMarkers/zoneDepleted.png'>";
                }
                if (data[y].currentZone === true){
                    avatarImage = "<img class='"+checker+"' src='/images/gamePage/mapMarkers/avatarImage.png'>";
                }
                if (data[y].camp === true){
                    campSite = "<img class='"+checker+"' src='/images/gamePage/mapMarkers/campSite.png'>";
                }
                if (data[y].biome === 100){
                    shrine = "<img class='"+checker+"' src='/images/gamePage/mapMarkers/shrine.png'>";
                }
                if (data[y].zoneID == selectedZoneID){
                    borderColour = "mapZoneBorderSelected";
                }
                $(".mapRowWrap"+data[y].yaxis).append("<div class='"+borderSize+" "+borderColour+" d-flex flex-column justify-content-center align-items-center biomeBackground"+data[y].biome+"' id='zoneLocation"+data[y].zoneID+"' onclick='selectedZone(this.id)'>"+depleted+campSite+shrine+avatarImage+"</div>");
            }
        }
    }
}

function createGodsWrapper(data) {
    $(".infoWrapShrinesList").empty();
    for (var x in data){
        if ($(".infoWrapShrineType"+data[x].class).length < 1){
            var favourText = "";
            var background = "";
            if (data[x].class !== 3){
                if (data[x].canWorship === false){
                    background = "redBackgroundTransparent";
                    favourText = "<div class='font-size-2' align='center'>You don't have the attention of these gods</div>";
                } else {
                    background = "greenBackgroundTransparent";
                    favourText = "<div class='font-size-2' align='center'>These gods are watching you</div>";
                }
            }
            $(".infoWrapShrinesList").append('<div class="col-md-4 col-12 '+background+' infoWrapShrineType'+data[x].class+'">' +
                '<div class="row d-flex justify-content-center align-items-center">' +
                '<div class="font-size-4 funkyFont">'+data[x].godClass+'</div>' +
                '</div> ' + favourText +
                '<div class="row p-2 d-flex flex-column justify-content-around align-items-center infoWrapShrineHolderList">' +
                '</div>' +
                '</div>')
        }
    }
    for (var x in data){
        var favoured = ""
        if (data[x].personalAchieve === true){
            favoured = "<div class='row justify-content-center align-items-center font-weight-bold font-size-2'><div class='greenBackgroundTransparent p-2'>You are this gods champion currently</div></div>"
        }
        $(".infoWrapShrineType"+data[x].class+" .infoWrapShrineHolderList").append('<div class="col-11 standardWrapper p-2">'+favoured+'<div class="row justify-content-center align-items-center font-weight-bold mb-2 mx-1">'+data[x].name+'</div> ' +
            '<div class="row shrineScores'+data[x].shrineID+' justify-content-start align-items-center mx-0">' +
            '</div>' +
            '</div>');
        if (data[x].class !== 3){
            var count = objectSize(data[x].tributeCurrent);
            if (count > 0) {
                var counter = 1;
                for (var y in data[x].tributeCurrent) {
                    $(".shrineScores"+data[x].shrineID).append('<div class="col-12 d-flex flex-row font-size-2">' + '<div class="mr-2">'+counter+'.</div>' +
                        '<div class="">'+data[x].tributeCurrent[y][1]+'</div>' +
                        '</div>');
                    counter++;
                }
            }else {
                $(".shrineScores"+data[x].shrineID).append('<div class="col-12 grayColour" align="center">No sacrifice made</div>');
            }
        }else {
            if (data[x].tributeCurrent.count === 0){
                $(".shrineScores"+data[x].shrineID).append('<div class="col-12 grayColour" align="center">No sacrifice made</div>');
            } else {
                if (data[x].personalAchieve === true){
                    $(".shrineScores"+data[x].shrineID).append('<div class="col-12 greenBackgroundTransparent d-flex flex-column justify-content-center align-items-center"><div class="font-size-2x">'+data[x].tributeCurrent.count+'</div><div class="font-size-2">Sacrifices</div></div>');
                } else {
                    $(".shrineScores"+data[x].shrineID).append('<div class="col-12 redBackgroundTransparent d-flex flex-column justify-content-center align-items-center"><div class="font-size-2">This god has abandoned you today</div> <div class="font-size-2x">'+data[x].tributeCurrent.count+'</div><div class="font-size-2">Sacrifices</div></div>');
                }
            }
        }
    }
}


function createEventsList(data) {
    $(".zoneLogsWrapper").empty();
    for (var x in data){
        var text = data[x].messageText;
        if (data[x].messageType === 0) {
            text = text.replace("#name#", "<span class='messagePlayerName lightGrayBackground px-2 py-1 '>" + data[x].avatarID + "</span>");
        }
        if (data[x].messageType === 5){
            text = text.replace("##?","<span class='lightGrayBackground px-2 py-1 messagePlayerName'>");
            text = text.replace("##!","</span>");
        }
        $(".zoneLogsWrapper").prepend('<div class="row">' +
            '<div class="col-2 col-md-1 border blackBorder resize-font-size-1 p-1 d-flex justify-content-center align-items-center">'+data[x].messageTime+'</div>' +
            '<div class="col-10 col-md-11 border blackBorder resize-font-size-1 p-1">'+text+'</div>' +
            '</div>')
    }
}


function createMapZoneDetails(data) {
    $(".zoneInformationBox").empty();
    if (data.known === false){
        $(".zoneInformationBox").append('<div align="center" class="grayColour font-size-2x">Unknown Zone</div>');
    } else {
        var depleted = "";
        if (data.depleted === 0){
            depleted = "Depleted"
        }
        var avatarInfo = "<div class='grayColour' align='center'>None</div>";
        if (data.partyThere === true) {
            avatarInfo = "";
            for (var x in data.playersInZone){
                if (data.playersInZone[x] !== "Unknown") {
                    avatarInfo += "<div class='font-size-2' align='center'>" + data.playersInZone[x].profileID + "</div>"
                } else {
                    avatarInfo += "<div class='font-size-2'  align='center'>Unknown Player</div>"

                }
            }
        }
        $(".zoneInformationBox").append('<div class="row p-2 justify-content-center">' +
            '<div align="center" class=" font-weight-bold font-size-3">'+data.biomeType+'</div>' +
            '</div>' +
            '<div class="row justify-content-center">' +
            '<div align="center" class="font-weight-bold redColour">'+depleted+'</div>' +
            '</div>' +
            '<div class="row p-2 justify-content-center">' +
            '<div class="col-11 normalBorder d-flex flex-column justify-content-center">' +
                '<div class="font-weight-bold">Zone Avatars:</div>'+
            avatarInfo +
            '</div>' +
            '</div>' +
            '<div class="row p-2 align-items-center">' +
            '<div class="input-group">' +
            '<select class="custom-select font-weight-bold" id="zoneMarkerSelector" selected="'+data.marker+'">' +
            '<option value="0" class="font-weight-bold">None</option>' +
            '<option value="1" class="redColour font-weight-bold">Red</option>' +
            '<option value="2" class="orangeColour font-weight-bold">Orange</option>' +
            '<option value="3" class="yellowColour font-weight-bold">Yellow</option>' +
            '<option value="4" class="greenColour font-weight-bold">Green</option>' +
            '<option value="5" class="blueColour font-weight-bold">Blue</option>' +
            '</select>' +
            '<div class="input-group-append">' +
            '<button class="btn btn-outline-secondary" type="button" onclick="markZoneColour()">Mark Zone</button>' +
            '</div>' +
            '</div>' +
            '</div>')
    }
}

//////////////////////////////////////////////////////////////
// ACTION BUTTONS
//////////////////////////////////////////////////////////////

function changeLocation(loc){
        dropLocation = loc;
        showItemLocation();
}

function changeView(type){
    switch (type){
        case 1:
            $(".showZoneView1").removeClass("d-sm-block");
            $(".showZoneView2").addClass("d-none").removeClass("d-block");
            $(".showAvatarOther").addClass("d-none");
            $(".showAvatarView").removeClass("d-none");
            $(".showShrineView").addClass("d-none");
            $(".showMapView").addClass("d-none");
            break;
        case 2:
            $(".showZoneView1").addClass("d-sm-block");
            $(".showZoneView2").removeClass("d-none").addClass("d-block");
            $(".showAvatarOther").addClass("d-none");
            $(".showAvatarView").addClass("d-none");
            $(".showShrineView").addClass("d-none");
            $(".showMapView").addClass("d-none");
            break;
        case 3:
            $(".showZoneView1").removeClass("d-sm-block");
            $(".showZoneView2").addClass("d-none").removeClass("d-block");
            $(".showAvatarOther").removeClass("d-none");
            $(".showAvatarView").addClass("d-none");
            $(".showShrineView").addClass("d-none");
            $(".showMapView").addClass("d-none");
            break;
        case 4:
            $(".showZoneView1").removeClass("d-sm-block");
            $(".showZoneView2").addClass("d-none").removeClass("d-block");
            $(".showAvatarOther").addClass("d-none");
            $(".showAvatarView").addClass("d-none");
            $(".showShrineView").removeClass("d-none");
            $(".showMapView").addClass("d-none");
            break;
        case 5:
            $(".showZoneView1").removeClass("d-sm-block");
            $(".showZoneView2").addClass("d-none").removeClass("d-block");
            $(".showAvatarOther").addClass("d-none");
            $(".showAvatarView").addClass("d-none");
            $(".showShrineView").addClass("d-none");
            $(".showMapView").removeClass("d-none");
            break;
    }
}

function changeInfoView(info){
    if (info !== typeView) {
        typeView = info;
        makeTypeView();
        getGamePage();
    }
}

function makeTypeView(){
    switch (typeView) {
        case 0:
            $(".infoWrapLog").removeClass("d-none");
            $(".infoWrapBuildings").addClass("d-none");
            $(".infoWrapParty").addClass("d-none");
            $(".infoWrapShrines").addClass("d-none");
            $(".infoButtonLog").removeClass("clickableTransparent").addClass("standardWrapper");
            $(".infoButtonBuild").removeClass("standardWrapper").addClass("clickableTransparent");
            $(".infoButtonParty").removeClass("standardWrapper").addClass("clickableTransparent");
            $(".infoButtonGods").removeClass("standardWrapper").addClass("clickableTransparent");
            break;
        case 1:
            $(".infoWrapLog").addClass("d-none");
            $(".infoWrapBuildings").removeClass("d-none");
            $(".infoWrapParty").addClass("d-none");
            $(".infoWrapShrines").addClass("d-none");
            $(".infoButtonLog").removeClass("standardWrapper").addClass("clickableTransparent");
            $(".infoButtonBuild").removeClass("clickableTransparent").addClass("standardWrapper");
            $(".infoButtonParty").removeClass("standardWrapper").addClass("clickableTransparent");
            $(".infoButtonGods").removeClass("standardWrapper").addClass("clickableTransparent");
            break;
        case 2:
            $(".infoWrapLog").addClass("d-none");
            $(".infoWrapBuildings").addClass("d-none");
            $(".infoWrapParty").removeClass("d-none");
            $(".infoWrapShrines").addClass("d-none");
            $(".infoButtonLog").removeClass("standardWrapper").addClass("clickableTransparent");
            $(".infoButtonBuild").removeClass("standardWrapper").addClass("clickableTransparent");
            $(".infoButtonParty").removeClass("clickableTransparent").addClass("standardWrapper");
            $(".infoButtonGods").removeClass("standardWrapper").addClass("clickableTransparent");
            break;
        case 3:
            $(".infoWrapLog").addClass("d-none");
            $(".infoWrapBuildings").addClass("d-none");
            $(".infoWrapParty").addClass("d-none");
            $(".infoWrapShrines").removeClass("d-none");
            $(".infoButtonLog").removeClass("standardWrapper").addClass("clickableTransparent");
            $(".infoButtonBuild").removeClass("standardWrapper").addClass("clickableTransparent");
            $(".infoButtonParty").removeClass("standardWrapper").addClass("clickableTransparent");
            $(".infoButtonGods").removeClass("clickableTransparent").addClass("standardWrapper");
            break;
    }
}

function showPhoneAvatars(){
    $(".zoneOtherAvatarWrapPhonePopup").removeClass("d-none");
}

function hidePhoneAvatars(){
    $(".zoneOtherAvatarWrapPhonePopup").addClass("d-none");
}

function dropItem(id){
    var newID = id.slice(7);
    console.log(newID);
    if (dropLocation === 0) {
        ajax_All(21, 14, typeBuild,typeView, newID)
    } else if (dropLocation === 1){
        if (chestExist === false) {
            createAlertBox(4, 1, "You can't drop items into a chest that doesn't exist");
        } else if (chestExist === "Locked"){
            createAlertBox(4, 1, "This chest is locked, join the party that owns the chest or break down the lock first");
        } else {
            ajax_All(16,14,typeBuild,typeView,newID);
        }
    }
}

function HUDReadyButton(){
    ajax_All(6,"HUD")
}

function pickGroundItem(id){
    var newID = id.slice(5);
    console.log(newID);
    ajax_All(44,14, typeBuild,typeView,newID);
}

function pickChestItem(id){
    var newID = id.slice(5);
    ajax_All(17,14,typeBuild,typeView,newID);
}

function changeBuildLocation(id){
    var newID = id.slice(12);
    if (newID !== typeBuild) {
        var change = true;
        if (newID === "storage") {
            if (chestExist === false) {
                change = false;
                createAlertBox(4, 1, "There is no chest to build from at this location");
            } else if (chestExist === "Locked"){
                change = false;
                createAlertBox(4, 1, "You can't use the item's from the chest as it's currently locked");
            }
        }
        if (change === true) {
            typeBuild = newID;
            getGamePage();
        }
    }
}

function buildBuilding(id){
    var newID = id.slice(13);
    ajax_All(5,14,typeBuild,typeView,newID,1);
}

function cantBuild(){
}

function moveDirection(dir){
    ajax_All(20,14,typeBuild,typeView,dir)
}

function searchZone(){
    ajax_All(22,14,typeBuild,typeView);
}

function destroyZone(){
    ajax_All(23,14,typeBuild,typeView);
}


function popupOtherPlayer(id){
    var newID = id.slice(11);
    ajax_All(2,15,newID);
}

function kickPlayer(id){
    var newID = id.slice(11);
    createAlertBox(4,1,"Are you sure you want to kick this player from the party? You can't undo this vote once it's started",4,"kickPlayerConfirm",newID);
}

function kickPlayerConfirm(id){
    var newID = id.slice(8);
    ajax_All(27,0,newID);
}

function researchOnce(){
    ajax_All(3,14,typeBuild,typeView);
}

function upgradeBackpack(id){
    var newID = id.slice(21);
    console.log(newID);
    ajax_All(45,14,typeBuild,typeView,newID);
}

function useItem(id){
    var newID = id.slice(8);
    console.log(newID);
    ajax_All(48,14,typeBuild,typeView,newID);
}

function useRecipe(id){
    var newID = id.slice(11);
    ajax_All(1,14,typeBuild,typeView,newID);
}

function selectResearch(id) {
    var newID = id.slice(12);
    ajax_All(8,14,typeBuild,typeView,newID);
}

function teachPlayerResearch(id){
    var userIDLoc = id.indexOf("+?!");
    var userID = id.slice(5,userIDLoc);
    var research = id.slice(userIDLoc+3);
    ajax_All(34,0,userID,research)
}

function joinParty(id) {
    console.log(id);
    var newID = id.slice(9);
    ajax_All(50,15,newID);
}

function confirmJoinParty(id){
    var newID = id.slice(18);
    ajax_All(30,15,newID);
}

function messagePlayer(id) {
    console.log(id);
}

function cancelJoinParty(id){
    var newID = id.slice(10);
    ajax_All(32,15,newID);
}

function switchRequestParty(id){
    var newID = id.slice(8);
    ajax_All(33,15,newID);
}

function voteOnPlayer(id,type){
    var newID = id.slice(11);
    if (type === 1) {
        ajax_All(28,0,newID)
    } else {
        ajax_All(29,0,newID)
    }
}

function voteOnPlayerConfirm(id) {
    var newID = id.slice(14);
    console.log(newID);
    ajax_All(52,0,newID)
}

function leaveParty(){
    createAlertBox(4,1,"Are you sure you want to leave this party?",2,"leavePartyConfirm");
}

function leavePartyConfirm(){
    ajax_All(51,14,typeBuild,typeView);
}

function leavePartyConfirm2(){
    ajax_All(26,14,typeBuild,typeView);
}

function changePartyName(){
    var name = $("#partyChangeName").val();
    var name2 = name.replace(/[^a-zA-Z0-9 ]/g, "");
    if (name !== name2){
        createAlertBox(5,1,"Your party name cannot contain special characters");
    } else {
        if (name.length > 20){
            createAlertBox(5,1,"The party name must be less than 20 characters");
        } else {
            if (name.length < 3){
                createAlertBox(5,1,"Please make the name at least 3 characters long");
            } else {
                ajax_All(31, 0, name2);
            }
        }
    }
}

function actionFence(){
    ajax_All(14,14,typeBuild,typeView);
}

function actionChest(){
    ajax_All(18,14,typeBuild,typeView);
}

function gainStamina(){
    ajax_All(202,0);
}

function worshipShrine(){
    ajax_All(11,16);
}

function worshipAtShrine(shrineID){
    var newID = shrineID.slice(13);
    ajax_All(43,0,newID);
}

function selectedZone(id){
    var newID = id.slice(12);
    selectedZoneID = newID;
    ajax_All(41,17,typeBuild,newID);
}

function markZoneColour() {
    var value = $("#zoneMarkerSelector").val();
    ajax_All(10,17,typeBuild,selectedZoneID,value);
}

//THESE ARE THE ACTION BUTTONS INFORMATION

function actionButton(icon,title,text,action){
    this.icon = icon;
    this.title = title;
    this.text = text;
    this.action = action;
}