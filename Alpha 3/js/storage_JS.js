////////STORAGE PAGE JAVASCRIPT/////////////


function updateStorageOverall(response){
    updateStorage(response.storageItems, response.storage1.maximumCapacity);
    updateBackpackStorage(response.backpack, response.avatar.maxInventorySlots);
    storageDetails(response.storage1, response.upgrade, response.lock1);
    storageActions(response.logs);
}


function updateBackpackStorage(items,maxBackpack){
    $("#backpackStorage").empty();
    for (var object in items){
        $("#backpackStorage").append("<div class='imagediv'><image class='itemimage' src='/images/items/"+items[object].icon+"' id='"+items[object].itemID+"' onclick='dropItem(this.id)'><span class='imagetext'>"+items[object].identity+"<hr>"+items[object].description+"</span></div>")

    }
    var difference = maxBackpack - objectSize(items);
    for (x=0;x<difference;x++){
        $("#backpackStorage").append("<div class='imagediv'><image class='itemimage' src='/images/items/Empty.png' id='empty+"+x+"'><span class='imagetext'>Empty</span></div>")
    }
}

function updateStorage(items,maxStorage){
    $("#storageWrapWriting").empty()
        .append("<strong>Storage</strong> ("+maxStorage+" items)");
    $("#storage").empty();
    for (var object in items){
        $("#storage").append("<div class='imagediv'><image class='itemimage' src='/images/items/"+items[object].icon+"' id='"+items[object].itemID+"' onclick='dropItem(this.id)'><span class='imagetext'>"+items[object].identity+"<hr>"+items[object].description+"</span></div>")
    }
    var difference = maxStorage - objectSize(items);
    for (x=0;x<difference;x++){
        $("#storage").append("<div class='imagediv'><image class='itemimage' src='/images/items/Empty.png' id='empty+"+x+"'><span class='imagetext'>Empty</span></div>")
    }
}

function storageDetails(storage,upgrade,lock){
    $("#storageLevel").empty()
        .append("Level: "+storage.storageLevel);
    if (lock.armour !== false){
        $("#storageLockedWriting").empty()
            .append("<strong>This storage chest is locked</strong>");
        $("#storageLock").empty()
            .append("<div>The chest lock has<strong>&nbsp"+lock.armour+" armour&nbsp</strong>left</div>");
        if (lock.access === true){
            $("#storageLock").append("<button id='storageLockChange' onclick='reinforceStorageLock()'>Reinforce</button>");
        } else {
            $("#storageLock").append("<button id='storageLockChange' onclick='breakStorageLock()'>Break</button>");
        }
    } else {
        $("#storageLock").hide();
    }
    $("#upgradeStorageCost").empty();
    var itemArray = [];
    for (var object in upgrade){
        if (itemArray[upgrade[object].itemTemplateID] === undefined) {
            itemArray[upgrade[object].itemTemplateID] = 1;
            $("#upgradeStorageCost").append("<div class='upgradeStorageItem'><div class='imagediv'><image class='itemimage' src='/images/items/" + upgrade[object].icon + "'><span class='imagetext'>" +upgrade[object].identity+ "</span></div><div id='upgradeItem"+upgrade[object].itemTemplateID+"'>x 1</div></div><nl>");
        } else {
            itemArray[upgrade[object].itemTemplateID]+=1;
            $("#upgradeItem"+upgrade[object].itemTemplateID).empty()
                .append("x "+itemArray[upgrade[object].itemTemplateID]);
        }
    }
}

function storageLocked(){
    $("#upgradeStorageWrap").hide();
    $("#backpackWrapStorage").hide();
    $("#storageWrap").hide();

}

function dropItem(id){
    ajax_All(16,id)
}

function upgradeStorage(){
    ajax_All(17,"none");
}

function reinforceStorageLock(){
    ajax_All(18, "reinforce");
}

function breakStorageLock(){
    ajax_All(18, "break");
}



function storageActions(logs){
    $("#movementLogActions").empty();
    for (var num in logs) {
        var message = logs[num].messageText;
        var time = logs[num].messageTime;
        message = message.replace("#name#","<strong>"+logs[num].avatarID+"</strong>");
        if(message.includes("took a")) {
            $("#movementLogActions").prepend("<div class='movementLogActionLog'  id='takingAlert'><div class='movementLogTimestamp'>" + time + "</div><span class='movementLogText'>" + message + "</span></div>")
        } else {
            $("#movementLogActions").prepend("<div class='movementLogActionLog'><div class='movementLogTimestamp'>" + time + "</div><span class='movementLogText'>" + message + "</span></div>")
        }
    }
}