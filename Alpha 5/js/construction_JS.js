//THIS IS THE JAVASCRIPT FOR THE CONSTRUCTION PAGE

var itemsLocation = "Chest";
var chestItems = [];
var groundItems = [];
var backpackItems = [];
var maxStorage = 0;

function updateAllConstruction(response){
    upgradeSleepingBag(response.upgradeCostSleep,response.modifierLevel);
    updateRecipes(response.recipes,response.usingItems);
    showBuildings(response.buildings);
    chestItems = response.storageItems;
    groundItems = response.zoneItems;
    backpackItems = response.backpackItems;
    maxStorage = response.maxStorage;
    createBackpackImages(response.backpackSize,response.upgradeCostBag);
    if (response.mapType !== "Tutorial"){
        researchImageBar(response.researchCost, response.researchStamina, response.researchLevel, response.researchTypes);
    }
    updateStorageDetails(response.storageDetails);
    updateStorageItems();
    updateFirepitDetails(response.firepitDetails);
    updateLocks(response.lockDetails);
}

function personalUpgrade(response){
    upgradeSleepingBag(response.upgradeCostSleep,response.modifierLevel);
    backpackItems = response.backpackItems;
    createBackpackImages(response.backpackSize,response.upgradeCostBag);
    updateFirepitDetails(response.firepitDetails);
    updateRecipes(response.recipes,response.usingItems);
}

function constructionUpgrade(response){
    if (response.mapType !== "Tutorial") {
        researchImageBar(response.researchCost, response.researchStamina, response.researchLevel, response.researchTypes);
    }
    showBuildings(response.buildings);
    updateLocks(response.lockDetails);
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

function researchImageBar(cost,spent,level,researches){
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
    $("#researchChoiceWrap").empty().append("<div class='titleText'>Select a Discovery </div>");
    for (var type in researches){
        $("#researchChoiceWrap").append("<div class='researchTypeWrap' id='"+type+"' onclick='chooseNewResearch(this.id)'><div class='researchTypeName'>"+researches[type].typeName+"</div><div class='researchTypeInfo'>"+researches[type].typeDescription+"</div></div>")
    }
    if (cost === spent){
        $("#researchBuildingButton").empty().attr("onclick","researchScreenView()")
            .append("<img class='buttonImage' src='/images/researchCompleteIcon.png'><div class='imagetext'>Complete Research<br><div class='explanationText'>Choose what type of building to discover</div></div>")
    }
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
        var button = "buildButton2";
        var onClick = "onclick='buildingclick(this.id)'";
        if (response[x].isBuilt === true){
            background = "hasBeenBuilt";
            button = "buildButton4";
        } else if (response[x].canBeBuilt === false) {
            background = "cantBeBuilt";
            button = "buildButton3";
            onClick = "";
        } else if (response[x].buildingsRequired != 0) {
            parentID = response[x].buildingsRequired;
            if (response[parentID].isBuilt === false) {
                background = "cantBeBuilt";
                button = "buildButton3";
                onClick = "";
            }

        }
        var text = "<div class='" + background + "' id='building" + x + "'><div class='buildingTitleWrapper'><div class='buildingListImageWrapper'><img class='buildingListImage' src='/images/buildings/" + response[x].icon + "'><span class='imagetext'>" + response[x].name + "<hr>"+response[x].description+"</span></div><div class='buildingListName'>" + response[x].name + "</div></div><div class='buildingItemsListWrapper'></div></div>";
        if (response[x].buildingsRequired == 0) {
            $("#buildType" + response[x].buildingType).append(text);
        } else {
            var counter = 0;
            var parentBuilding = response[x].buildingsRequired;
            while (parentBuilding != 0) {
                parentBuilding = response[parentBuilding].buildingsRequired;
                counter++;
            }
            $("#building" + response[x].buildingsRequired).after(text);
            for (var z = 0; z < counter; z++) {
                if (z === 0) {
                    $("#building" + x + " .buildingTitleWrapper").prepend("<img class='buildingListImage' id='buildingImagePadding' src='/images/buildings/childBuilding.png'>");
                } else {
                    $("#building" + x + " .buildingTitleWrapper").prepend("<div class='buildingImageBlank'></div>");
                }
            }
        }
        if (response[x].isBuilt === false) {
            for (var y in response[x].itemsRequired) {
                $("#building" + x + " .buildingItemsListWrapper").append("<div class='buildingItemWrapper'><div class='buildingListImageWrapper'><img class='buildingListImage' src='/images/items/constructionImages/" + response[x].itemsRequired[y].icon + "'><span class='imagetext'>" + response[x].itemsRequired[y].identity + "</span></div><div class='buildingItemsRequired'>" + response[x].itemsRequired[y].materialOwned + "/" + response[x].itemsRequired[y].materialNeeded + "</div></div>");
            }
            $("#building" + x).append("<div class='buildingStaminaWrap'><div class='buildingItemsRequired'>" + response[x].staminaSpent + "/" + response[x].staminaRequired + "</div><img class='buildingStaminaImage' src='/images/stamina2.png'></div><img class='" + button + "Icon' id='" + x + "' src='/images/" + button + ".png' " + onClick + "'>");
        } else {
            $("#building" + x).append("<div class='buildingStaminaWrap'><div class='completedBuilding'>Built</div>")
        }
    }
}

function updateFirepitDetails(response){
    if(!("ERROR" in response)){
        $("#firepitOverview").show();
        $("#firepitFuel").empty().append("Fuel: "+response.currentFuel);
        $("#firepitTempBonus").empty().append("Heat Bonus: "+response.temperatureIncrease);
    } else {
        $("#firepitOverview").hide();
    }
}



function updateRecipes(info,use){
    $("#recipesUseWrap").empty();
    $("#itemsUseWrap").empty();
    var recipeLength = objectSize(info);
    var useLength = objectSize(use);
    if (recipeLength === 0){
        $("#recipiesWrapper").hide();
    } else {
        for (var key in info){
            $("#consumablesWrapper").show();
            $("#recipesUseWrap").append("<div class='selectableText' id='"+info[key].recipeID+"' onclick='useRecipe(this.id)'><img class='recipeItemImage' src='/images/recipe/"+info[key].recipeImage+"'><span>"+info[key].description+"</span></div>");
        }
    }
    $("#useActions").empty();
    if (useLength === 0){
        $("#consumablesWrapper").hide();
    } else {
        for (var key in use){
            $("#consumablesWrapper").show();
            $("#itemsUseWrap").append("<div class='selectableText' id='"+use[key].templateID+"' onclick='useItem(this.id)'><img class='recipeItemImage' src='/images/items/"+use[key].image+"'><span>"+use[key].description+"</span></div>");

        }
    }
}

function createBackpackImages(size,upgrade){
    $("#firepitBackpackWrap").empty();
    $("#backpackHolderWrap").empty();
    for (var item in backpackItems){
        $("#firepitBackpackWrap").append("<div class='imagediv'><image class='itemimage' src='/images/items/" + backpackItems[item].icon + "' id='" + backpackItems[item].itemID + "' onclick='burnItem(this.id)'><span class='imagetext'>" + backpackItems[item].identity + "<hr>" + backpackItems[item].description + "</span></div>");
        $("#backpackHolderWrap").append("<div class='imagediv'><image class='itemimage' src='/images/items/" + backpackItems[item].icon + "' id='" + backpackItems[item].itemID + "' onclick='dropItem(this.id)'><span class='imagetext'>" + backpackItems[item].identity + "<hr>" + backpackItems[item].description + "</span></div>");
    }
    var empty = size - objectSize(backpackItems);
    for(var x = 0;x<empty;x++){
        var backpackEmpty = "<div class='imagediv'><image class='itemimage' src='/images/items/Empty.png' id='empty+" + x + "'><span class='imagetext'>Empty</span></div>";
        $("#firepitBackpackWrap").append(backpackEmpty);
        $("#backpackHolderWrap").append(backpackEmpty);
    }
    $("#backpackUpgradeItems").empty();
    var itemArray = [];
    for (var object in upgrade) {
        if (itemArray[upgrade[object].itemTemplateID] === undefined) {
            itemArray[upgrade[object].itemTemplateID] = 1;
            $("#backpackUpgradeItems").append("<div class='upgradeSleepingBagItem'><div class='imagediv'><image class='itemimage' src='/images/items/" + upgrade[object].icon + "'><span class='imagetext'>"+upgrade[object].identity+ "</span></div><div class='bagUpgradeImagetext' id='upgradeItem2" + upgrade[object].itemTemplateID + "'>x 1</div></div>");
        } else {
            itemArray[upgrade[object].itemTemplateID] += 1;
            $("#upgradeItem2" + upgrade[object].itemTemplateID).empty()
                .append("x " + itemArray[upgrade[object].itemTemplateID]);
        }
    }
    $("#backpackLevel").empty()
        .append("Size: "+size);
}

function updateStorageItems() {
    if ("ERROR" in chestItems){
        if (chestItems["ERROR"] !== "Lock"){
            $("#storageTabBuilt").hide();
            itemsLocation = "Ground";
        } else {
            $("#storageTabBuilt").show();
        }
    } else {
        $("#storageTabBuilt").show();
    }
    var response = [];
    if (itemsLocation === "Chest"){
        response = chestItems;
        console.log("Show");
        $("#itemsListArrayWrap #storageDetails").show();
    } else if (itemsLocation === "Ground"){
        response = groundItems;
        console.log("Hide");
        $("#itemsListArrayWrap #storageDetails").hide();
    }
    $("#itemListArray").empty();
    $("#itemListArrayTitle").empty().append(itemsLocation);
    if (itemsLocation === "Chest" && chestItems["ERROR"] === "Lock"){
        $("#itemListArray").append("<div class='smallWriting'>The chest is locked</div>");
    } else {
        if (objectSize(response) === 0 && response === groundItems) {
        } else {
            for (var object in response) {
                $("#itemListArray").append("<div class='imagediv'><image class='itemimage' src='/images/items/" + response[object].icon + "' id='" + response[object].itemID + "' onclick='dropItem(this.id)'><span class='imagetext'>" + response[object].identity + "<hr>" + response[object].description + "</span></div>")
            }
            if (itemsLocation === "Chest") {
                var difference = maxStorage - objectSize(response);
                for (x = 0; x < difference; x++) {
                    $("#itemListArray").append("<div class='imagediv'><image class='itemimage' src='/images/items/Empty.png' id='empty+" + x + "'><span class='imagetext'>Empty</span></div>")
                }
            }
        }
    }
}
function updateStorageDetails(response){
    if (!("ERROR" in response)) {
        $("#itemsListArrayWrap #storageDetails").remove();
        $("#itemsListArrayWrap").append("<div id='storageDetails'><div id='storageData'><div class='buildingDetailsWriting'>Level: " + response.storageLevel + "</div><div class='buildingDetailsWriting'>Capacity: " + response.maximumCapacity + "</div></div><div id='storageUpgrade'><div id='storageUpgradeItemsOuter'><div class='buildingDetailsWriting'>Upgrade Storage</div><div id='storageUpgradeItemsInner'></div></div></div><button id='storageUpgradeButton' onclick='upgradeStorage()'>Upgrade</button></div>");
        var itemArray = [];
        var upgrade = response.upgradeItems;
        for (var object in upgrade) {
            if (itemArray[upgrade[object].itemTemplateID] === undefined) {
                itemArray[upgrade[object].itemTemplateID] = 1;
                $("#storageUpgradeItemsInner").append("<div class='storageUpgradeItemWrap'><div class='imagediv'><image class='itemimage' src='/images/items/" + upgrade[object].icon + "'><span class='imagetext'>" + upgrade[object].identity + "</span></div><span class='buildingDetailsWriting' id='upgradeItem" + upgrade[object].itemTemplateID + "'>x 1</span></div>")
            } else {
                itemArray[upgrade[object].itemTemplateID] += 1;
                $("#upgradeItem" + upgrade[object].itemTemplateID).empty()
                    .append("x " + itemArray[upgrade[object].itemTemplateID]);
            }
        }
    } else {
        if (response["ERROR"] === "Lock"){
            $("#itemsListArrayWrap #storageDetails").remove();
        }
    }
}

function updateLocks(response){
    var size = objectSize(response);
    if (size < 1){
        $("#locksWrapper").hide();
    } else {
        $("#locksWrapper").show();
        for (var lock in response) {
            $("#lockArray").empty()
                .append("<div class='singleLockWrapper' id='singleLock"+lock+"'><div class='buildingListImageWrapper'><img class='buildingListImage' src='/images/buildings/"+response[lock].buildingIcon+"' class='buildingListImage'></div><div class='singleLockName'>"+response[lock].type+"</div><div class='singleLockHealth'>Strength: <strong>"+response[lock].current+"/"+response[lock].maximum+"</strong></div></div>");
            if (response[lock].access === true){
                $("#singleLock"+lock).css("background-color", "rgba(0,255,0,0.3)")
                    .append("<div class='imagediv'><img class='teachResearchImg' src='/images/hammerBuilding.png' id='"+response[lock].buildingID+"' onclick='reinforceGateLock(this.id)'><div class='imagetext'>Repair " + response[lock].type + "<br><div class='explanationText'>Use 1 stamina to repair the lock</div></div></div>");
            } else {
                $("#singleLock"+lock).css("background-color", "rgba(255,0,0,0.3)")
                    .append("<div class='imagediv'><img class='teachResearchImg' src='/images/hammerBreaking.png' id='"+response[lock].buildingID+"' onclick='breakGateLock(this.id)'><div class='imagetext'>Break " + response[lock].type + "<br><div class='explanationText'>Use 1 stamina to break the lock</div></div></div>");
            }
        }
    }
}

function switchStorage(test){
    if (test === 1){
        itemsLocation = "Chest";
    } else {
        itemsLocation = "Ground";
    }
    updateStorageItems();
}

function firepitBackpackView(){
    $("#firepitBackpackWrap").css("visibility", 'visible');
    $("#disableScreenFirepit").css("visibility", 'visible');

}

function hideBackpackScreen(){
    $("#firepitBackpackWrap").css("visibility", 'hidden');
    $("#disableScreenFirepit").css("visibility", 'hidden');
}

function researchScreenView(){
    $("#disableScreenResearch").css("visibility", 'visible');
    $("#researchChoiceWrap").css("visibility", 'visible');

}

function hideResearchScreen(){
    $("#disableScreenResearch").css("visibility", 'hidden');
    $("#researchChoiceWrap").css("visibility", 'hidden');
}

function newResearchAlert(response){
    if (!alert("You have learnt how to build a "+response.researchName)) {
        window.location.reload();
    }
}

function upgradeSleeping(){
    ajax_All(2,"none",0);
}

function researchButton(){
    ajax_All(3,"none",0);
}

function burnItem(id){
    ajax_All(11,id,0);
}

function upgradeStorage(){
    ajax_All(17,"none",0);
}

//This function sends the message to build a building
function buildingclick(id){
    ajax_All(5,id,0)
}

function upgradeBackpack(){
    ajax_All(45,"none",0);
}

function dropItem(id){
    if (itemsLocation === "Chest") {
        ajax_All(16, id,0)
    } else if (itemsLocation === "Ground"){
        ajax_All(21,id,0)
    }
}

function reinforceGateLock(id){
    ajax_All(18, id,0);
}

function breakGateLock(id){
    ajax_All(14, id,0);
}

function chooseNewResearch(id){
    ajax_All(8,id,"x");
}

function useRecipe(id){
    ajax_All(1,id,0)
}

function useItem(id){
    ajax_All(48,id,0)
}