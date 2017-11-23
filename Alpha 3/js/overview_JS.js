
function createOverview(response){
    $("#zoneOverviewOwner").empty();
    $("#zoneOverviewName").empty();
    $("#zoneOverviewInformation").empty();
    $("#zoneOverviewBonuses").empty()
        .append("<span id='overviewTempTitle'>Temperature modifiers</span><span class='spanTempWriting'>Zone Temperature: "+response.biomeTempMod+"</span><span class='spanTempWriting'>Buildings Bonus: "+(response.buildingTempBonus-response.firepitBonus)+"</span><span class='spanTempWriting'>Firepit Bonus: "+response.firepitBonus+"</span><div id='smallLineTemp'></div><span class='spanTempWriting'>Total: "+(parseInt(response.buildingTempBonus)+parseInt(response.biomeTempMod))+"</span><div id='smallLineTemp'></div>");
        if (response.zoneOwners == null){
            $("#zoneOverviewOwner").append("Unclaimed Zone");
            $("#zoneOverviewName").hide();
        } else {
            $("#zoneOverviewOwner").append("Controlled by: "+response.zoneOwners);
            $("#zoneOverviewName").append(response.outpostName);
        }
    if (response.lockValue == 0){
        $("#zoneOverviewLock").hide();
    } else {
        drawLockHealth(response.lockValue,response.lockTotal);
        $("#zoneOverviewLockButton").empty();
        if (response.canEnterZone === true){
            $("#zoneOverviewLockButton").append("<button id='gateLockChange' onclick='reinforceGateLock()'>Reinforce</button>");
        } else {
            $("#zoneOverviewLockButton").append("<button id='gateLockChange' onclick='breakGateLock()'>Break</button>");
        }
    }
    if (response.firepitBonus === 0){
        $("#zoneOverviewFirepit").hide();
    } else {
        $("#zoneOverviewFirepit").append("Firepit heat: "+response.firepitBonus);
    }

}

function drawLockHealth(current,total){
    $("#canvasLegend").empty()
        .append("<div>"+current+"/"+total+"</div>");
    var height = 30;
    var width = 250;
    var ctx = makeCanvas(width, height, "myCanvas");
    var colour = "#ffffff";
    drawRectangle(ctx, 0, height/4, width, (height/2), colour, "#000000");
    for (x = 0; x < current;  x++)
    {
        drawRectangle(ctx, (x*(width/total)), height / 4, width/total, (height / 2), "#555555", "#000000");
    }
}


function reinforceGateLock(){
    console.log("Reinforcing");
    ajax_All(14, "reinforce");
}

function breakGateLock(){
    console.log("Break");
    ajax_All(14, "break");
}