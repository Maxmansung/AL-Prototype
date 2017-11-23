//////////////THE DIARY PAGE (AN OVERVIEW OF WHAT HAS HAPPENED/////////////


function zoneActionsView(response){
    diaryActions(response.logs,response.currentDay);
    updateZoneActions(response.nightTemp,response.day,response.personalTemp,response.currentDay);
    makeShrineStats(response.shrines);
}


function diaryActions(logs,currentDay){
    $("#movementLogOverviewActions").empty();
    for (var num in logs) {
        if (logs[num].mapDay == currentDay){}
        var message = logs[num].messageText;
        var time = logs[num].messageTime;
        message = message.replace("#name#","<strong>"+logs[num].avatarID+"</strong>");
        if (logs[num].chatlogType === "ChatlogWorld"){
            $("#movementLogOverviewActions").prepend("<div class='movementLogOverviewActionLog' id='worldActionLog'><div class='movementLogOverviewTimestamp'>" + time + "</div><span class='movementLogOverviewText'>" + message + "</span></div>")
        } else {
            if (message.includes("took a")) {
                $("#movementLogOverviewActions").prepend("<div class='movementLogOverviewActionLog'  id='takingAlert'><div class='movementLogOverviewTimestamp'>" + time + "</div><span class='movementLogOverviewText'>" + message + "</span></div>")
            } else {
                if (logs[num].chatlogType === "ChatlogGroup") {
                    $("#movementLogOverviewActions").prepend("<div class='movementLogOverviewActionLog' id='partyActionLog'><div class='movementLogOverviewTimestamp'>" + time + "</div><span class='movementLogOverviewText'>" + message + "</span></div>")
                } else {
                    $("#movementLogOverviewActions").prepend("<div class='movementLogOverviewActionLog'><div class='movementLogOverviewTimestamp'>" + time + "</div><span class='movementLogOverviewText'>" + message + "</span></div>")
                }
            }
        }
    }
}

function getNewDay(){
    var day = $('#daySelectionDrop').val();
    ajax_All(12,day)
}

function updateZoneActions(nightTemp,day,personalTemp,maxDay){
    $("#zoneTempDisplay").empty()
        .append(nightTemp*-1);
    $("#currentDayInput").empty()
        .append(day);
    $("#playerTempDisplay").empty()
        .append(personalTemp*-1);
    $("#daySelectionDrop").empty();
    for (var x=parseInt(maxDay);x>0;x--){
        $("#daySelectionDrop").append("<option value='"+x+"'>"+x+"</option>");
    }
}

function makeShrineStats(stats) {
    $("#myLegend").empty();
    var height = 200;
    var width = 300;
    var ctx = makeCanvas(width, height, "myCanvas");
    drawChartAxis(ctx, width, height);
    var totalValue = 0;
    var count = 0;
    for (type in stats) {
        totalValue += stats[type].totalTribute;
        count++;
    }
    if (totalValue !== 0) {
        var barHeight = (height * 0.8) / count;
        var barWidth = (width * 0.8);
        var current = 0;
        var count2 = 1;
        for (type in stats) {
            val = stats[type].totalTribute;
            var colour = getGraphColour(count2);
            console.log(colour);
            drawRectangle(ctx, (width * 0.11), ((height * 0.11) + (barHeight * current)), barWidth * (val / totalValue), ((height * 0.79) / count) - 10, colour, colour);
            current++;
            count2++;
        }
        //This section creates the legend
        var legendHTML = "";
        count2 = 1;
        for (type in stats) {
            colour = getGraphColour(count2);
            var name = stats[type].shrineName;
            legendHTML += "<div class='shrineLegendText'><span style='display:inline-block;width:20px;background-color:" + colour + ";'>&nbsp;</span> " + name + " - "+ stats[type].totalTribute +"</div>";
            count2++;
        }
        $("#myLegend").append(legendHTML);
    } else {
        $("#myLegend").hide();
        ctx.font = "20px Times New Roman";
        ctx.fillText("No tribute made yet", width * 0.25, height * 0.5);
    }
}