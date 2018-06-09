function getPageInfo(){
    ajax_All(53,18);
}

function createDeathPage(data){
    $(".deathPageMapName").empty().append(data.mapName);
    $(".deathPageCause").empty().append(data.deathType.causeName);
    $(".deathPageDescription").empty().append(data.deathType.description);
    $(".deathPageDays").empty().append(data.deathDay);
    $(".deathPageNightTemp").empty().append((data.nightTemp*-1));
    $(".deathPageSurvTemp").empty().append((data.survivableTemp*-1));
    createFavour(data.favourSolo,data.favourTeam,data.favourMap);
    createAchievements(data.achievements);
    activateTooltips();
}

function createFavour(solo,team,map){
    $(".deathPageTopGod").empty();
    if (solo > 0 || team > 0 || map > 0) {
        if (solo === team && team === map){
            type = godSolo();
            bottomGod(type, solo);
            type = godTeam();
            bottomGod(type, team);
            type = godMap();
            bottomGod(type, map);
        } else {
            var test1 = solo + team;
            var test2 = solo + map;
            var test3 = team + map;
            var checker = true;
            if (test1 === 0 || test2 === 0 || test3 === 0) {
                checker = false;
            }
            if (checker === true) {
                var biggest = "";
                var type = "";
                if (solo > team && solo > map) {
                    biggest = "solo";
                    type = godSolo();
                    topGod(type, solo);
                } else if (team > solo && team > map) {
                    biggest = "team";
                    type = godTeam();
                    topGod(type, team);
                } else if (map > solo && map > team) {
                    biggest = "map";
                    type = godMap();
                    topGod(type, map);
                } else {
                    if (solo === 0) {
                        type = godTeam();
                        bottomGod(type, team);
                        type = godMap();
                        bottomGod(type, map);
                    } else if (team === 0) {
                        type = godSolo();
                        bottomGod(type, solo);
                        type = godMap();
                        bottomGod(type, map);
                    } else if (map === 0) {
                        type = godTeam();
                        bottomGod(type, team);
                        type = godSolo();
                        bottomGod(type, solo);
                    } else {
                        if (solo === team) {
                            type = godSolo();
                            topGod(type, solo);
                            type = godTeam();
                            topGod(type, team);
                            type = godMap();
                            bottomGod(type, map);
                        } else if (team === map) {
                            type = godTeam();
                            topGod(type, team);
                            type = godMap();
                            topGod(type, map);
                            type = godSolo();
                            bottomGod(type, solo);
                        } else if (solo === map) {
                            type = godMap();
                            topGod(type, map);
                            type = godSolo();
                            topGod(type, solo);
                            type = godTeam();
                            bottomGod(type, team);
                        }
                    }
                }
                if (biggest !== "") {
                    if (biggest !== "solo") {
                        if (solo !== 0) {
                            type = godSolo();
                            bottomGod(type, solo);
                        }
                    }
                    if (biggest !== "team") {
                        if (team !== 0) {
                            type = godTeam();
                            bottomGod(type, team);
                        }
                    }
                    if (biggest !== "map") {
                        if (map !== 0) {
                            type = godMap();
                            bottomGod(type, map);
                        }
                    }
                }
            } else {
                if (solo > 0) {
                    type = godSolo();
                    topGod(type, solo);
                }
                if (team > 0) {
                    type = godTeam();
                    topGod(type, team);
                }
                if (map > 0) {
                    type = godMap();
                    topGod(type, map);
                }
            }
        }
    } else {
        $(".deathPageTopGod").append('<div class="grayColour font-size-3 font-weight-bold">No Gods Worshiped</div>')
    }
}

function topGod(type,count){
    $(".deathPageTopGod").append('<div class="col-6 col-md-4 leaderboardSelect lightGrayBackground d-flex flex-column justify-content-between align-items-center p-2" align="center">' + type +
        '<div class="font-size-3">'+count+'</div>' +
        '</div>');

}

function bottomGod(type,count){
    $(".deathPageBottomGod").append('<div class="col-4 col-md-3 leaderboardSelect lightGrayBackground d-flex flex-column justify-content-between align-items-center p-2" align="center">' + type +
        '<div class="font-size-3">'+count+'</div>' +
        '</div>');

}

function godSolo(){
    return'<div class="font-size-3"><i class="fas fa-snowflake"></i></div><div class="font-size-2x font-weight-bold">Cold Gods</div>';
}

function godTeam(count){
    return'<div class="font-size-3"><i class="fas fa-bomb"></i></div><div class="font-size-2x font-weight-bold">War Gods</div>';
}

function godMap(count){
    return'<div class="font-size-3"><i class="fas fa-leaf"></i></div><div class="font-size-2x font-weight-bold">Life Gods</div>';
}

function createAchievements(data){
    $(".deathPageAchievementWrapper").empty();
    var lengthArray = objectSize(data);
    if (lengthArray > 0) {
        console.log(data);
        for (var x in data) {
            $(".deathPageAchievementWrapper").append('<div class="singleAchievementWrapper p-1 d-flex flex-column justify-content-center align-items-center m-1">' +
                '<div class="achievementWrapper lightGrayBackground" data-toggle="tooltip" data-placement="top" title="' + data[x].details.name + '">' +
                '<img src="/images/profilePage/achievements/' + data[x].details.icon + '" class="achievementImage">' +
                '</div>' +
                '<div class="achievementCounter font-size-1">' +
                data[x].count +
                '</div>' +
                '</div>');
        }
    } else {
        $(".deathPageAchievementWrapper").append('<div class="grayColour">No Achievements found in this game</div>');
    }
}

function confirmDeath(){
    ajax_All(7,0);
}