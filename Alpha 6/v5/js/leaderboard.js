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
    $("#leaderboardTopRanks").empty();
    var spirit = "";
    var length = objectSize(data);
    if (length >0) {
        $("#leaderboardTopRanks").append('<div class="col-4 d-flex justify-content-end flex-column font-size-2 clickableTransparent" onclick="goToPage(this.id)" id="leaderboardClick3"> ' +
            '<div class="d-flex justify-content-center align-items-center">' +
            '<img id="leaderboardImage3" class="circleImage" src="/avatarimages/generic.png">' +
            '</div>' +
            '<div id="leaderBoardPositionName3" align="center"></div>' +
            '<div id="leaderboardPositionScore3" align="center"></div>' +
            '</div>' +
            '<div class="col-4 d-flex justify-content-end flex-column mb-4 font-size-2x clickableTransparent" onclick="goToPage(this.id)" id="leaderboardClick1">' +
            '<div class="d-flex justify-content-center align-items-center">' +
            '<img id="leaderboardImage1" class="circleImage" src="/avatarimages/generic.png">' +
            '</div>' +
            '<div id="leaderBoardPositionName1" align="center"></div>' +
            '<div id="leaderboardPositionScore1" align="center"></div>' +
            '</div>' +
            '<div class="col-4 d-flex justify-content-end flex-column mb-2 clickableTransparent" onclick="goToPage(this.id)" id="leaderboardClick2">' +
            '<div class="d-flex justify-content-center align-items-center">' +
            '<img id="leaderboardImage2" class="circleImage" src="/avatarimages/generic.png">' +
            '</div>' +
            '<div id="leaderBoardPositionName2" align="center"></div>' +
            '<div id="leaderboardPositionScore2" align="center"></div> ' +
            '</div>');
        for (var x in data) {
            spirit = "spirit&p=" + data[x].profileID;
            if (data[x].position > 3) {
                $(".leaderboardScoreWrapper").append('<div class="row justify-content-between pb-2 clickableFlashMore"  onclick="goToPage(this.id)" id="' + spirit + '">' +
                    '<div class="col-2 col-md-3 font-weight-bold" align="center">' + data[x].position + '.</div>' +
                    '<div class="col-7 col-md-6 " align="center">' + data[x].profile + '</div>' +
                    '<div class="col-3 col-md-3" align="center">' + data[x].score + '</div>' +
                    '</div>');
            } else {
                $("#leaderBoardPositionName"+data[x].position).empty().append(data[x].profile);
                $("#leaderboardPositionScore"+data[x].position).empty().append(data[x].score);
                $("#leaderboardImage"+data[x].position).attr("src","/avatarimages/"+data[x].avatar);
                $("#leaderboardClick"+data[x].position).attr("id",spirit);
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