//////////////THE DIARY PAGE (AN OVERVIEW OF WHAT HAS HAPPENED/////////////


function zoneActionsView(response){
    diaryActions(response.logs,response.currentDay);
    updateZoneActions(response.nightTemp,response.day,response.personalTemp,response.currentDay);
}


function diaryActions(logs,currentDay){
    $("#movementLogOverviewActions").empty();
    for (var num in logs) {
        if (logs[num].mapDay == currentDay){}
        var message = logs[num].messageText;
        var time = logs[num].messageTime;
        message = message.replace("#name#","<strong>"+logs[num].avatarID+"</strong>");
        if(message.includes("took a")) {
            $("#movementLogOverviewActions").prepend("<div class='movementLogOverviewActionLog'  id='takingAlert'><div class='movementLogOverviewTimestamp'>" + time + "</div><span class='movementLogOverviewText'>" + message + "</span></div>")
        } else {
            if (logs[num].chatlogType === "ChatlogGroup"){
                $("#movementLogOverviewActions").prepend("<div class='movementLogOverviewActionLog' id='partyActionLog'><div class='movementLogOverviewTimestamp'>" + time + "</div><span class='movementLogOverviewText'>" + message + "</span></div>")
            } else {
                $("#movementLogOverviewActions").prepend("<div class='movementLogOverviewActionLog'><div class='movementLogOverviewTimestamp'>" + time + "</div><span class='movementLogOverviewText'>" + message + "</span></div>")
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