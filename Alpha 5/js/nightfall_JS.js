function displayNight(data){
    createTimer(data.timerUntil);
}

function createTimer(timestamp){
    var timer = timeConverter(timestamp,"minutes");
    $("#countdownTimer").empty()
        .append(timer+" minutes");
    console.log(timestamp);
}