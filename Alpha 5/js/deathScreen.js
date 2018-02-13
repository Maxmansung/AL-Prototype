////////DEATH PAGE//////////

function getDeathInfo(){
    ajax_All(9,"none",2);
}

function confirmDeath(){
    $("#confirmDeath").attr("disabled", true);
    ajax_All(7,"none","x");
}

function displayDeathPage(response){
    deathScreenWriting(response);
    if (response.deathStatistics != null) {
        //makePieChart(response.deathStatistics);
    } else {
        //emptyPieChart();
    }
    deathAchievements(response.achievementDetails,response.scoreAchieve);
    makeShrineScore(response.shrineDisplay);
}

function makePieChart(stats) {
    var ctx = makeCanvas(200, 200, "myCanvas");
    var canvas = document.getElementById("myCanvas");
    var total_value = 0;
    for (var type in stats) {
        total_value += stats[type];
    }
    //drawing the pie chart as a single object
    var start_angle = 0;
    for (type in stats) {
        val = stats[type];
        colour = getPieColour(type);
        var slice_angle = 2 * Math.PI * val / total_value;
        drawPieSlice(
            ctx,
            canvas.width / 2,
            canvas.height / 2,
            Math.min(canvas.width / 2, canvas.height / 2),
            start_angle,
            start_angle + slice_angle,
            colour
        );

        start_angle += slice_angle;
    }
    //This section creates the lables for the chart
    start_angle = 0;
    for (type in stats) {
        val = stats[type];
        colour = getPieColour(type);
        slice_angle = 2 * Math.PI * val / total_value;
        var pieRadius = Math.min(canvas.width / 2, canvas.height / 2);
        var labelX = canvas.width / 2 + (pieRadius / 2) * Math.cos(start_angle + slice_angle / 2);
        var labelY = canvas.height / 2 + (pieRadius / 2) * Math.sin(start_angle + slice_angle / 2);

        var labelText = Math.round(100 * val / total_value);
        ctx.fillStyle = "#000000";
        ctx.font = "bold 20px Arial";
        ctx.fillText(labelText + "%", labelX, labelY);
        start_angle += slice_angle;
    }
    //This section creates the legend
    var legendHTML = "";
    for (type in stats) {
        colour = getPieColour(type);
        var name = getLegendName(type);
        legendHTML += "<div class='myLegendText'><span style='display:inline-block;width:20px;background-color:" + colour + ";'>&nbsp;</span> " + name + "</div>";
    }
    $("#myLegend").append(legendHTML);
}

function deathAchievements(achievements,score){
    $("#deathAchievements").empty();
    if (objectSize(achievements) == 0){
        $("#deathAchievements").append("You achieved nothing!");
    } else {
        for (var single in achievements) {
            var achieve = achievements[single].details;
            $("#deathAchievements").append("<div class='userAchieveWrap'><div class='userAchieveName'>" + achieve.name + "</div><div class='userAchieveImageWrap'><img src='/images/achievements/" + achieve.icon + "' class='userAchieveImage'><span class='userAchieveText'>" + achieve.description + "</span></div><div class='userAchieveCount'>" + achievements[single].count + "</div></div>");
        }
        $("#deathAchieveScore").empty().append("Score: <strong>"+score+"</strong>");
    }
}

function emptyPieChart(){
    var ctx = makeCanvas(200, 200, "myCanvas");
    ctx.fillStyle = "#ff0000";
    drawArc(ctx,100,100,90,0,360);
    ctx.fill();
    ctx.fillStyle = "#ffffff";
    ctx.font = "bold 15px Arial";
    ctx.fillText("No actions performed", 25, 100);
}

function makeShrineScore(response){
    var total = 0;
    for (var shrine in response){
        total += response[shrine].score;
    }
    $("#shrineScores").empty();
    if (total !== 0) {
        $("#shrineScoresTotal").empty().append(total);
        for (var shrine in response) {
            $("#shrineScores").append("<div class='shrineOverviewWrap'><img class='shrineFinalImage' src='/images/shrines/" + response[shrine].shrineIcon + "'><div class='shrineImageText'>" + response[shrine].shrineName + "</div><div class='shrineImageScore'>" + response[shrine].score + "</div></div>")
        }
    } else {
        $("#shrineScoresTotal").hide();
        $("#totalScoreTitle").hide();
        $("#shrineAchievements").append("<div id='informationText'>You didn't gain the favour of any god this time round, try to find some shrines in your next life</div>")
    }
}

function deathScreenWriting(response){
    $("#deathCauseSection").empty().append("Cause of death<br> <strong>"+response.deathType+"</strong>");
    $("#deathCauseDescription").empty().append("("+response.deathDescription+")");
    $("#deathSurvivedTotal").empty().append("<span>Died on day: </span><span id='deathDayNumber'>"+response.deathDay+"</span>");
    if (response.gameType !== "Tutorial") {
        if (response.partyPlayersLeft > 1) {
            $("#deathMapSection").empty().append("Although the land of <span class='boldWriting'>" + response.mapName + "</span> may not miss you the " + response.partyPlayersLeft + " people left of <span class='boldWriting'>" + response.partyName + "</span> might do.");
        } else if (response.partyPlayersLeft === 1) {
            $("#deathMapSection").empty().append("Although the land of <span class='boldWriting'>" + response.mapName + "</span> may not miss you the one player left in the <span class='boldWriting'>" + response.partyName + "</span> party hopefully is");
        } else {
            $("#deathMapSection").empty().append("Although the land of <span class='boldWriting'>" + response.mapName + "</span> may not miss you but perhaps the name <span class='boldWriting'>" + response.partyName + "</span> will be remembered.");
        }
    } else {
        $("#deathMapSection").empty().append("This map was a tutorial map, therefore no-one will remember you lived.<br><br>Keep practicing though and soon you'll be ready for the real world!!");
    }
}