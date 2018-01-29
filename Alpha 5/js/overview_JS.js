//THIS PAGE PERFORMS THE FUNCTIONS FOR BOTH THE "OVERVIEW" AND "SHRINE" PAGES

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


function updateSpecialPage(response){
    $("#playerTributes").empty();
    $("#totalTribute").empty();
    var shrineTributes = response.specialZoneDetails.currentArrayView;
    if (objectSize(shrineTributes) === 0){$("#playerTributes").append("<div class='playerTribute'><strong>No sacrifices made here yet</strong></div>")

    } else {
        for (player in shrineTributes) {
            if (shrineTributes[player].avatarID == "Unknown"){
                $("#playerTributes").append("<div class='playerTribute'><div class='playerTributeName'>"+ shrineTributes[player].player + "</div><div class='playerTributeParty'>(" + shrineTributes[player].party + ")</div><div class='playerTributeTotal'>Tribute: " + shrineTributes[player].count + "</div></div>")
            } else {
                $("#playerTributes").append("<div class='playerTribute'><div class='playerTributeName'><a class='usernamelink' href='/user.php?u=" + shrineTributes[player].avatarID + "'>" + shrineTributes[player].player + "</a></div><div class='playerTributeParty'>(" + shrineTributes[player].party + ")</div><div class='playerTributeTotal'>Tribute: " + shrineTributes[player].count + "</div></div>")
            }
        }
    }
    $("#totalTribute").append("Total: " + response.specialZoneDetails.totalTribute);
    if (response.specialZoneFavours === true){
        $("#zoneOverviewChoice").empty().append("Your party is favoured by this god").css("background","rgba(0,255,0,0.4");
    } else {
        $("#zoneOverviewChoice").empty().append("A party of your size will never be blessed by this god").css("background","rgba(255,0,0,0.4");
    }
}

function performSpecialAction(id){
    ajax_All(43,id,5);
}