//THIS IS THE JAVASCRIPT FOR THE CONSTRUCTION PAGE

function updateAllConstruction(response){
    upgradeSleepingBag(response.upgradeCost,response.modifierLevel);
    researchImageBar(response.researchCost, response.researchStamina, response.researchLevel);
    showBuildings(response.buildings);
}

function personalUpgrade(response){
    upgradeSleepingBag(response.upgradeCost,response.modifierLevel);
}

function constructionUpgrade(response){
    researchImageBar(response.researchCost, response.researchStamina, response.researchLevel)
}


function upgradeSleepingBag(upgrade,level) {
    $("#sleepingBagUpgradeItems").empty();
    var itemArray = [];
    for (var object in upgrade) {
        if (itemArray[upgrade[object].itemTemplateID] === undefined) {
            itemArray[upgrade[object].itemTemplateID] = 1;
            $("#sleepingBagUpgradeItems").append("<div class='upgradeSleepingBagItem'><div class='imagediv'><image class='itemimage' src='/images/items/" + upgrade[object].icon + "'><span class='imagetext'>"+upgrade[object].identity+ "</span></div><div class='bagUpgradeImagetext' id='upgradeItem" + upgrade[object].itemTemplateID + "'>x 1</div></div>");
        } else {
            itemArray[upgrade[object].itemTemplateID] += 1;
            $("#upgradeItem" + upgrade[object].itemTemplateID).empty()
                .append("x " + itemArray[upgrade[object].itemTemplateID]);
        }
    }
    $("#sleepingBagLevel").empty()
        .append("Level: "+level);
}

function researchImageBar(cost,spent,level){
    var height = 30;
    var width = 250;
    var ctx = makeCanvas(width, height, "myCanvas");
    if (cost.isArray == true){
        $("#canvasLegend").empty()
            .append("<div>No further research</div>");
        drawRectangle(ctx, 0, height / 4, width, (height / 2), "#999999", "#000000");
    } else {
        $("#canvasLegend").empty()
            .append("<div>" + spent + "/" + cost + "</div>");
        drawRectangle(ctx, 0, height / 4, width, (height / 2), "#ffffff", "#000000");
        for (x = 0; x < spent; x++) {
            drawRectangle(ctx, (x * (width / cost)), height / 4, width / cost, (height / 2), "#ffff00", "#000000");
        }
    }
    $("#researchLevel").empty()
        .append("Level: "+level);
}

function showBuildings(response) {
    $("#knownBuildingsList").empty();
    for (var x in response) {
        if ($("#buildType" + response[x].buildingType).length == 0) {
            $("#knownBuildingsList").append("<div class='buildingTypeWrap' id='buildType" + response[x].buildingType + "'><div class='buildingTypeTitle'>" + response[x].buildingType + "</div></div>")
        }
    }
    for (var x in response) {
        var background = "canBeBuilt";
        if (response[x].canBeBuilt === false) {
            background = "cantBeBuilt"
        }
        var text ="<div class='" + background + "' id='building" + x + "'><div class='buildingListImageWrapper'><img class='buildingListImage' src='/images/buildings/" + response[x].icon + "'></div><div class='buildingListName'>" + response[x].name + "</div></div>";
        if (response[x].buildingsRequired == 0) {
            $("#buildType" + response[x].buildingType).append(text);
        } else {
            $("#building" + response[x].buildingsRequired).after(text);
            $("#building"+x).prepend("|--");
        }
        for (var y in response[x].itemsRequired) {
            console.log(y);
            $("#building" + x).append("<div class='buildingItemWrapper'><div class='buildingListImageWrapper'><img class='buildingListImage' src='/images/items/constructionImages/" + response[x].itemsRequired[y].icon + "'></div><div class='buildingItemsRequired'>" + response[x].itemsRequired[y].materialOwned + "/" + response[x].itemsRequired[y].materialNeeded + "</div></div>");
        }
        $("#building" + x).append("<div class='buildingStaminaWrap'><div class='buildingItemsRequired'>" + response[x].staminaSpent + "/" + response[x].staminaRequired + "</div><img class='buildingStaminaImage' src='/images/stamina2.png'></div><div class='buildingButton2' id='" + x + "'>+</div>");
    }
}


//This constructs the buildings tab
function buildingstab(building) {
    $('#zonebuildings').empty()
        .append("<div class='buildingdivwrapper2' id='0buildingwrap'>BUILDINGS</div>");
    for (x in building) {
        var wrap = x + "buildingwrap";
        var parentid = building[x].buildingsRequired + "buildingwrap";
        $("#" + parentid).after("<div class='buildingdivwrapper' id='" + wrap + "'></div>");
        var itemimage = "";
        if (building[x].isBuilt === false) {
            var counter = 0;
            for (material in building[x].itemsRequired) {
                counter++;
            }
            var ident2 = "";
            for (i = 0; i < (2 + counter); i++) {
                var buildinfo = "";
                var itemused = "";
                var itemcount = "";
                var innerwriting = "";
                var create = true;
                var getitem = 2;
                if (i > 1) {
                    for (material in building[x].itemsRequired) {
                        if (getitem === i) {
                            getitem = material;
                            break;
                        } else {
                            getitem++;
                        }
                    }
                }
                switch (i) {
                    case 0:
                        buildinfo = "text";
                        innerwriting = building[x].name;
                        itemimage = "/images/buildings/"+building[x].icon;
                        create = true;
                        break;
                    case 1:
                        ident2 = x + "button";
                        $("#" + wrap).append("<button class='buildingbutton' id='" + ident2 + "' onclick='buildingclick(this.id)'></button>");
                        buildinfo = "stamina";
                        innerwriting = building[x].staminaSpent + "/" + building[x].staminaRequired;
                        itemimage = "/images/stamina2.png";
                        create = true;
                        break;
                    default:
                        buildinfo = "matt";
                        itemused = building[x].itemsRequired[getitem];
                        innerwriting = itemused.materialOwned + "/" + itemused.materialNeeded;
                        itemimage = "/images/items/" + itemused.icon;
                        create = true;
                        break;
                }
                var ident3 = x + buildinfo;
                if (building[x].buildingsRequired != 0 && buildinfo == "text") {
                    var paddLeft = $("#"+parentid).css("padding-left");
                    paddLeft = parseInt(paddLeft.slice(0,paddLeft.length -2))+15;
                    $("#" + wrap).append("<div class='building" + buildinfo + "' id='" + ident3 + "'>&nbsp|---&nbsp<img src='" + itemimage + "' class='buildingimages'>" + innerwriting + "</div>")
                        .css({paddingLeft: paddLeft+"px"});
                    $("#"+ident3).css({width: (260-paddLeft)})
                } else {
                    $("#" + wrap).append("<div class='building" + buildinfo + "' id='" + ident3 + "'>&nbsp<img src='" + itemimage + "' class='buildingimages'>" + innerwriting + "</div>");
                }
                if (buildinfo == "text"){
                    $("#"+ident3).append("<span class='buildingImageText'>"+building[x].description+"</span>")
                }
            }
            var parentid = building[x].buildingsRequired;
            if (building[x].canBeBuilt === false) {
                $("#" + wrap).css("background-image", "url('/images/unexplored.png')");
                $("#" + ident2).prop('disabled', true).css('background-color', 'lightgrey');
            } else if (parentid != 0) {
                if (building[parentid].isBuilt === false) {
                    $("#" + wrap).css("background-image", "url('/images/unexplored.png')");
                    $("#" + ident2).prop('disabled', true).css('background-color', 'lightgrey');
                }
            }
        } else {
            var ident3 = x + "built";
            innerwriting = building[x].name;
            $("#" + wrap).append("<div class='buildingbuilt' id='" + ident3 + "'><img src='/images/buildings/" + building[x].icon + "' class='buildingimages'>" + building[x].name + "&nbsp;&nbsp;---------Complete---------</div>");
            $("#" + ident3).css("background-image", "url('../images/builtbuilding.png')")
        }
    }
}


function newResearchAlert(response){
    if (!alert("You have learnt how to build a "+response.researchName)) {
        window.location.reload();
    }
}

function upgradeSleeping(){
    ajax_All(2,"none");
}

function researchButton(){
    ajax_All(3,"none");
}