///////////FIREPIT TAB JAVASCRIPT///////////

function firepitScreen(response){
    if("ALERT" in response){
        updateBackpack(response.DATA.backpack, response.DATA.backpackSize,false);
        firepitActions(response.DATA.logs);
        alerts(response.ALERT,response.DATA);
    } else {
        updateBackpack(response.backpack, response.backpackSize,true);
        firepitActions(response.logs);
        firepitcheck(response.firepit);
    }
}

function firepitcheck(firepit) {
    $("#firepittext").empty().append("<div id='testinginfo'>Current fuel: " + firepit.currentFuel + "</div><div id='testinginfo'>Heat supplied: " + firepit.temperatureIncrease + "</div><img id='firepitimage' src='/images/firepit2.png'>");
}


function updateBackpack(items,maxBackpack,type){
    $("#backpack").empty();
    for (var object in items) {
        if (type === true) {
            $("#backpack").append("<div class='imagediv'><image class='itemimage' src='/images/items/" + items[object].icon + "' id='" + items[object].itemID + "' onclick='burnItem(this.id)'><span class='imagetext'>" + items[object].identity + "<hr>" + items[object].description + "<hr> Fuel Value: " + items[object].fuelValue + "</span></div>");
        } else {
            $("#backpack").append("<div class='imagediv'><image class='itemimage' src='/images/items/" + items[object].icon + "' id='" + items[object].itemID + "'><span class='imagetext'>" + items[object].identity + "<hr>" + items[object].description + "<hr> Fuel Value: " + items[object].fuelValue + "</span></div>");
            $("#backpackwrapText").empty().append("Backpack");
        }
    }
    var difference = maxBackpack - objectSize(items);
    for (x=0;x<difference;x++){
        $("#backpack").append("<div class='imagediv'><image class='itemimage' src='/images/items/Empty.png' id='empty+"+x+"'><span class='imagetext'>Empty</span></div>")
    }
}

function burnItem(id){
    ajax_All(11,id);
}



function firepitActions(logs){
    $("#movementLogActions").empty();
    for (var num in logs) {
        var message = logs[num].messageText;
        var time = logs[num].messageTime;
        message = message.replace("#name#","<strong>"+logs[num].avatarID+"</strong>");
        $("#movementLogActions").prepend("<div class='movementLogActionLog'><div class='movementLogTimestamp'>"+time+"</div><span class='movementLogText'>"+message+"</span></div>")
    }
}