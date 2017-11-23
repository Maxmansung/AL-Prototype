////////DEATH PAGE//////////

function getDeathInfo(){
    ajax_All(9,"none");
}

function confirmDeath(){
    $("#confirmDeath").attr("disabled", true);
    ajax_All(7,"none");
}

function displayDeathPage(response){
    if (response.deathStatistics != null) {
        makePieChart(response.deathStatistics);
    } else {
        emptyPieChart();
    }
    deathAchievements(response.achievementDetails);
}

function makePieChart(stats) {
    console.log(stats);
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

function deathAchievements(achievements){
    $("#deathAchievements").empty();
    if (objectSize(achievements) == 0){
        $("#deathAchievements").append("You achieved nothing!");
    } else {
        for (var single in achievements) {
            var achieve = achievements[single].details;
            $("#deathAchievements").append("<div class='userAchieveWrap'><div class='userAchieveName'>" + achieve.name + "</div><div class='userAchieveImageWrap'><img src='/images/achievements/" + achieve.icon + "' class='userAchieveImage'><span class='userAchieveText'>" + achieve.description + "</span></div><div class='userAchieveCount'>" + achievements[single].count + "</div></div>");
        }
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