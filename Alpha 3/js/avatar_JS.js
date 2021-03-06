////// THE AVATAR PAGE ////////

function updateAvatar(response){
    updateBackpack(response.backpack,response.maxBackpack);
    updateRecipes(response.recipes);
    showTemperature(response.tempBase,response.tempItems,response.tempMod);
    showProfilePicture(response.profilePic);
    upgradeSleepingBag(response.upgradeCost,response.modifierLevel);
    researchImageBar(response.researchCost, response.researchStamina, response.researchLevel)
}

function updateBackpack(items,maxBackpack){
    $("#backpack").empty();
    for (var object in items){
        $("#backpack").append("<div class='imagediv'><image class='itemimage' src='/images/items/"+items[object].icon+"' id='"+items[object].itemID+"'><span class='imagetext'>"+items[object].identity+"<hr>"+items[object].description+"</span></div>")

    }
    var difference = maxBackpack - objectSize(items);
    for (x=0;x<difference;x++){
        $("#backpack").append("<div class='imagediv'><image class='itemimage' src='/images/items/Empty.png' id='empty+"+x+"'><span class='imagetext'>Empty</span></div>")
    }
}

function updateRecipes(info){
    $("#itemactions").empty();
    $("#actionbutton").attr("disabled", true);
    if (info.length === 0){
        $("#itemactions").append("<option value='None'>Nothing</option>");
    } else {
        $("#actionbutton").attr("disabled", false);
        for (var key in info){
            $("#itemactions").append("<option value="+info[key].recipeID+">"+info[key].description+"</option>");
        }
    }
}

function showTemperature(tempBase, tempItems,tempMod){
    var total = parseInt(tempBase)+parseInt(tempMod)+parseInt(tempItems);
    $("#avatarOverviewTemp").empty()
        .append("<span id='overviewTempTitle'>Personal Temperature</span><span class='spanTempWriting'>Base survivable: "+tempBase+"</span><span class='spanTempWriting'>Items bonus: "+tempItems+"</span><span class='spanTempWriting'>Sleeping bag: "+tempMod+"</span><div id='smallLineTemp'></div><span class='spanTempWriting'>Total: "+total+"</span><div id='smallLineTemp'></div>")
}

function showProfilePicture(profilePic){
    $("#avatarOverviewImage").empty()
        .append("<img src='/avatarimages/"+profilePic+"' id='userCardImageFile'>");
}

function recipeIDValue(){
    var act = document.getElementById("itemactions").value;
    ajax_All(1,act)
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
    $("#canvasLegend").empty()
        .append("<div>"+spent+"/"+cost+"</div>");
    var height = 30;
    var width = 250;
    var ctx = makeCanvas(width, height, "myCanvas");
    var colour = "#ffffff";
    drawRectangle(ctx, 0, height/4, width, (height/2), colour, "#000000");
    for (x = 0; x < spent;  x++)
    {
        drawRectangle(ctx, (x*(width/cost)), height / 4, width/cost, (height/ 2), "#ffff00", "#000000");
    }
    $("#researchLevel").empty()
        .append("Level: "+level);
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