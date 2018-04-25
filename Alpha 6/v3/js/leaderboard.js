function getScores(){
    var data = parseInt($(".getDataClass").attr('id'));
    switch (data){
        case 2:
            $("#leaderboardTitleName").empty().append("Most favoured by the War Gods");
            break;
        case 3:
            $("#leaderboardTitleName").empty().append("Most favoured by the Life Gods");
            break;
        default:
            $("#leaderboardTitleName").empty().append("Most favoured by the Cold Gods");
            break;
    }
    ajax_All(188,9,data);
}

function leaderboardSetup(data){
    createLeaderboardPage(data);
}

function createLeaderboardPage(data){
    $(".leaderboardScoreWrapper").empty();
    var alternate = 1;
    var spirit = "";
    var length = objectSize(data);
    if (length >0) {
        for (var x in data) {
            spirit = "spirit&p=" + data[x].profileID;
            $(".leaderboardScoreWrapper").append('<div class="row justify-content-between leaderboardPlayer' + alternate + ' clickableFlashMore"  onclick="goToPage(this.id)" id="' + spirit + '">' +
                '<div class="col-2 col-md-1 pl-2 font-weight-bold">' + data[x].position + '.</div>' +
                '<div class="col-7 col-md-8" align="left">' + data[x].profile + '</div>' +
                '<div class="col-3 col-md-1 pr-2" align="right">' + data[x].score + '</div>' +
                '</div>');
            if (alternate === 1) {
                alternate = 2;
            } else {
                alternate = 1;
            }
        }
    } else {
        $(".leaderboardScoreWrapper").append("<div class='row justify-content-center'>" +
            "<div align='center'>" +
            "No spirits favoured currently" +
            "</div>" +
            "</div>");
    }
}