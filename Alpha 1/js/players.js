function playerloading() {
    ajax_getuser_data();
    ajax_getmapinfo("../php_query/get_map_data.php","group",false);
}

function refreshplayer(){
    staminaimage();
    userrefresh();
    grouprefresh();
    zoneplayersrefresh();
    checkgroupinvites();
    checkgroupkicks();
}

function checkplayergroups() {
    for (z in group) {
        var count = 0;
        for (y in user) {
            if (user[y].playergroup == z) {
                count += 1;
            }
        }
        if (count !== 0) {
            for (num in group[z].invited) {
                if (group[z].invited[num] == 1) {
                    console.log("Player "+num+" is in group "+user[num].playergroup+" and looking at group "+z);
                    if (user[num].playergroup != z) {
                        var testing = user[num].playergroup;
                        var newcount = 0;
                        for (tester1 in user) {
                            if (user[tester1].playergroup == testing) {
                                newcount += 1
                            }
                        }
                            if (newcount < 2) {
                                var total = 0;
                                var accept = 0;
                                var reject = 0;
                                for (i in user) {
                                    if (user[i].playergroup == z) {
                                        if (user[i].alive == 1) {
                                            total += 1;
                                            switch (user[i].agreeinvite[num]) {
                                                case 1:
                                                    accept += 1;
                                                    break;
                                                case 2:
                                                    reject += 1;
                                                default:
                                                    break;
                                            }
                                        }
                                    }
                                }
                                console.log("Player " + num + " to join: Total: " + total + ", Accept: " + accept);
                                var sixty = total * 0.59;
                                var forty = total * 0.41;
                                if (accept > sixty) {
                                    for (a in user) {
                                        user[a].agreeinvite[num] = 0;
                                        ajax_postarray(user[a].agreeinvite, "agreeinvite", "ingameavatars", user[a].username, "../php_query/post_array_other.php");
                                    }
                                    var previous = user[num].playergroup;
                                    for (maps in group[z].mapping) {
                                        if (group[previous].mapping[maps] == 1) {
                                            group[z].mapping[maps] = 1;
                                        }
                                    }
                                    for (know in group[z].known) {
                                        if (group[previous].known[know] == 1) {
                                            group[z].known[know] = 1;
                                        }
                                    }
                                    ajax_postarray(group[z].mapping, "mapping", "ingamegroups", z, "../php_query/post_array_group.php");
                                    ajax_postarray(group[z].known, "known", "ingamegroups", z, "../php_query/post_array_group.php");
                                    user[num].playergroup = z;
                                    group[z].invited[num] = 0;
                                    ajax_postarray(group[z].invited, "invited", "ingamegroups", z, "../php_query/post_array_group.php");
                                    ajax_postdata(user[num].playergroup, "playergroup", "ingameavatars", user[num].username, "../php_query/post_data_other.php");
                                    setTimeout(location.reload, 2000);
                                } else if (reject > forty) {
                                    for (a in user) {
                                        user[a].agreeinvite[num] = 0;
                                        ajax_postarray(user[a].agreeinvite, "agreeinvite", "ingameavatars", user[a].username, "../php_query/post_array_other.php");
                                    }
                                    group[z].invited[num] = 0;
                                    ajax_postarray(group[z].invited, "invited", "ingamegroups", z, "../php_query/post_array_group.php");
                                    setTimeout(location.reload, 2000);
                                }
                            } else {
                                console.log("Invite Conflict: Group >1");
                                group[z].invited[num] = 0;
                                ajax_postarray(group[z].invited, "invited", "ingamegroups", z, "../php_query/post_array_group.php");
                            }
                        }
                    else {
                        console.log("Invite Conflict: Already in group");
                        group[z].invited[num] = 0;
                        ajax_postarray(group[z].invited, "invited", "ingamegroups", z, "../php_query/post_array_group.php");
                    }
                }
            }
            for (num in group[z].kick) {
                if (group[z].kick[num] == 1) {
                    if (user[num].playergroup == z) {
                        var testing = user[num].playergroup;
                        var newcount = 0;
                        for (tester1 in user) {
                            if (user[tester1].playergroup == testing) {
                                newcount += 1
                            }
                        }
                        if (newcount > 1) {
                            var total = 0;
                            var accept = 0;
                            var reject = 0;
                            for (i in user) {
                                if (user[i].playergroup == z) {
                                    if (user[i] !== user[num]) {
                                        total += 1;
                                        switch (user[i].agreeinvite[num]) {
                                            case 1:
                                                accept += 1;
                                                break;
                                            case 2:
                                                reject += 1;
                                            default:
                                                break;
                                        }
                                    }
                                }
                            }
                            console.log("Player " + num + " to kick: Total: " + total + ", Accept: " + accept);
                            var sixty = total * 0.59;
                            var forty = total * 0.41;
                            if (accept > sixty) {
                                var moved = false;
                                for (a in group) {
                                    if (moved == false) {
                                        var count3 = 0;
                                        for (b in user) {
                                            if (user[b].playergroup == a) {
                                                count3 += 1;
                                            }
                                        }
                                        if (count3 == 0) {
                                            moved = true;
                                            var z = user[num].playergroup;
                                            group[a].mapping = group[z].mapping;
                                            group[a].known = group[z].known;
                                            user[num].playergroup = a;
                                            var count4 = 0;
                                            for (i in user[num].agreeinvite) {
                                                if (user[num].agreeinvite[i] !== 0) {
                                                    user[num].agreeinvite[i] = 0;
                                                    count4 += 1;
                                                }
                                            }
                                            if (count4 > 0) {
                                                ajax_postarray(user[num].agreeinvite, "agreeinvite", "ingameavatars", "NOT REQUIRED", "../php_query/post_array.php");
                                            }
                                            ajax_postarray(group[a].mapping, "mapping", "ingamegroups", a, "../php_query/post_array_group.php");
                                            ajax_postarray(group[a].known, "known", "ingamegroups", a, "../php_query/post_array_group.php");
                                            ajax_postdata(user[num].playergroup, "playergroup", "ingameavatars", user[num].username, "../php_query/post_data_other.php");
                                            setTimeout(location.reload, 2000);
                                        }
                                    }
                                }
                            } else if (reject > forty) {
                                for (a in user) {
                                    user[a].agreeinvite[num] = 0;
                                    ajax_postarray(user[a].agreeinvite, "agreeinvite", "ingameavatars", user[a].username, "../php_query/post_array_other.php");
                                }
                                group[z].kick[num] = 0;
                                ajax_postarray(group[z].kick, "kick", "ingamegroups", z, "../php_query/post_array_group.php");
                                setTimeout(location.reload, 2000);
                            }
                        } else {
                            console.log("Kicking Conflict: group <2");
                            group[z].kick[num] = 0;
                            ajax_postarray(group[z].kick, "kick", "ingamegroups", z, "../php_query/post_array_group.php");
                        }
                    } else{
                        console.log("Kicking Conflict: not in group");
                        group[z].kick[num] = 0;
                        ajax_postarray(group[z].kick, "kick", "ingamegroups", z, "../php_query/post_array_group.php");
                    }
                }
            }
        }
        else {
            console.log("Group "+z+" is empty");
            if (group[z].mapping.indexOf(1) !== -1) {
                console.log("Mapping emptied");
                for (maps in group[z].mapping) {
                    group[z].mapping[maps] = 0;
                }
                ajax_postarray(group[z].mapping, "mapping", "ingamegroups", z, "../php_query/post_array_group.php");
            }
            for (mapcount in map){
                if (map[mapcount].groupowner == z) {
                    console.log("Map zone " + mapcount + " owned by group");
                    map[mapcount].groupowner = 21;
                    ajax_postdata(map[mapcount].groupowner, "groupowner", "mapzones", mapcount, "../php_query/post_mapdata.php");
                    var arraytest = false;
                    if (map[mapcount].buildings[5] > 0) {
                        console.log("Fence Lock has stamina");
                        map[mapcount].buildings[5] = 0;
                        arraytest = true;
                    }
                    if (map[mapcount].buildings[6] > 0) {
                        console.log("Chest Lock has stamina");
                        map[mapcount].buildings[6] = 0;
                        arraytest = true;
                    }
                    if (map[mapcount].buildings[4] >= building[4].staminacost) {
                        console.log("Outpost is completed");
                        map[mapcount].buildings[4] = 0;
                        arraytest = true;
                    }
                    if (arraytest == true) {
                        ajax_postarray(map[mapcount].buildings, "buildings", "mapzones", mapcount, "../php_query/post_maparray.php");
                    }
                }
            }
        }
    }
}


//This shows all the people in the game and shows if you know them or not
function userrefresh(){
    $("#playerbox2").empty();
    for (y in user){
        if (y != usr) {
            $("#playerbox2").append("<div class='playerdiv' id='playerdiv"+y+"'></div>");
            if (user[y].alive == 1) {
                if (user[y].ready == 1){
                    $("#playerdiv" + y).css("background-color", "lightgreen");
                }
                if (group[gp].known[y] == 1) {
                    $("#playerdiv" + y).append("<div class='playerdivname'><a class='usernamelink' href='user.php?u=" + user[y].username + "'><strong>" + user[y].username + "</strong></a></div>")
                        .append("<div class='playerdivgroup'><strong>Group: </strong>" + user[y].playergroup + "</div>");
                } else {
                    $("#playerdiv" + y).append("<div class='playerdivname'>Unknown survivor</div>")
                        .append("<div class='playerdivgroup'><strong>Group:</strong> Unknown</div>");
                }
            }else{
                    $("#playerdiv" + y).append("<div class='playerdivname'><strong><strike>" + user[y].username + "</strike></strong></div>")
                        .append("<div class='playerdivgroup'><strong>DEAD</strong></div>")
                        .css("background-color", "lightblue");
            }
        }
    }
}
//This shows the players in your group and allows you to kick them from the group
function grouprefresh(){
    $("#groupbox").empty();
    $("#groupbox").append("<strong>Group "+user[usr].playergroup+"</strong>");
    for (y in user){
        if (user[y].playergroup == user[usr].playergroup){
            if (user[y].alive == 1) {
                $("#groupbox").append("<div class='playerdiv' id='classdiv" + y + "'></div>");
                $("#classdiv" + y).append("<div class='playerdivname'><a class='usernamelink' href='user.php?u=" + user[y].username + "'><strong>" + user[y].username + "</strong></a></div>");
                var count = 0;
                for (surv in user) {
                    if (user[surv].playergroup == user[usr].playergroup) {
                        if (user[surv].alive == 1) {
                            count += 1;
                        }
                    }
                }
                if (y != usr) {
                    if (count > 2) {
                        if (group[gp].kick[y] !== 1) {
                            $("#classdiv" + y).append("<button class='invitegroup' id='kick" + y + "' onclick='kickfromgroup(this.id)'>Kick</button>")
                        }else{
                            $("#classdiv" + y).append("<div class='invitegroup'><strong>Voting to kick</strong></div>")
                        }
                    }
                } else {
                    if (count > 1) {
                        $("#classdiv" + y).append("<button class='invitegroup' onclick='leavegroup()'>Leave</button>")
                    }
                }
            }
        }
    }
}
//This shows the players in your zone allows you to invite them into your group
function zoneplayersrefresh(){
    var count = 0;
    $("#zoneplayersbox").empty().show();
    var yaxis = (Math.round(Math.floor(user[usr].location / mapsizes)))+1;
    var xaxis = ((user[usr].location + 1) % mapsizes);
    $("#zoneplayersbox").append("<strong>Players in zone ["+ xaxis+" / "+yaxis+"]</strong>");
    for (y in user){
        if (user[y].location == user[usr].location) {
            if (user[y].alive == 1) {
                if (y != usr) {
                    count += 1;
                    $("#zoneplayersbox").append("<div class='playerdiv' id='zonediv" + y + "'></div>");
                    $("#zonediv" + y).append("<div class='playerdivname'><a class='usernamelink' href='user.php?u=" + user[y].username + "'><strong>" + user[y].username + "</strong></a></div>");
                    if (user[y].playergroup != user[usr].playergroup) {
                        var count = 0;
                        for (surv in user) {
                            if (user[surv].playergroup == user[usr].playergroup) {
                                count += 1;
                            }
                        }
                        if (count < 2) {
                            var playerg = user[y].playergroup;
                            if (group[playerg].invited[usr] !== 1) {
                                $("#zonediv" + y).append("<div class='invitegroup'> Join group: <strong>" + playerg + " - </strong><button class='joinbutton' id='invite" + y + "' onclick='invitetogroup(this.id)'>+</button></div>");
                            } else {
                                $("#zonediv" + y).append("<div class='invitegroup'><strong>Request sent</strong></div>");
                            }
                        }
                    }
                }
            }
        }

    }
    if (count < 1){
        $("#zoneplayersbox").hide();
    }
}

function checkgroupinvites(){
    var count = 0;
    $("#playerinvites").empty()
        .append("<strong>Invites to group</strong>")
        .show();
    for (x in group[gp].invited) {
        if (group[gp].invited[x] == 1) {
            if (user[x].alive == 1) {
                count += 1;
                $("#playerinvites").append("<div class='inviteddiv' id='inviteddiv" + x + "'><strong>" + user[x].username + "</strong></div>");
                $("#inviteddiv" + x).append("<div class='groupopinion' id='checkinginvited" + x + "'></div>");
                $("#checkinginvited" + x).append("<div id='writing" + x + "'><p style='text-align:center;'><span style='float:left;'>Accepted</span>Undecided<span style='float:right;'>Rejected</span></p></div>");
                for (y in user) {
                    if (user[y].playergroup == gp) {
                        if (user[y].alive == 1) {
                            switch (user[y].agreeinvite[x]) {
                                case 0:
                                    if (y == usr) {
                                        $("#checkinginvited" + x).append("<div class='groupplayercenter'><button id='playera" + x + "' onclick='playeropinion(this.id, 1)'>Accept</button>" + user[y].username + "<button id='playerr" + x + "' onclick='playeropinion(this.id, 2)'>Reject</button></div>");
                                        break;
                                    } else {
                                        $("#checkinginvited" + x).append("<div class='groupplayercenter'>" + user[y].username + "</div>");
                                        break;
                                    }
                                case 1:
                                    $("#checkinginvited" + x).append("<div class='groupplayerleft'>" + user[y].username + "</div>");
                                    break;
                                case 2:
                                    $("#checkinginvited" + x).append("<div class='groupplayerright'>" + user[y].username + "</div>");
                                    break;
                                default:
                                    console.log("ERROR with agree invite variable for player " + user[y].username + ". Array = " + user[y].agreeinvite[x]);
                                    break;
                            }
                        }
                    }
                }
            }
        }
    }
    if (count < 1){
        $("#playerinvites").hide()
    }
}

function checkgroupkicks(){
    var count = 0;
    $("#playerkicks").empty()
        .append("<strong>Kicks from group</strong>")
        .show();
    for (x in group[gp].kick) {
        if (group[gp].kick[x] == 1) {
            if (user[x].alive == 1) {
                count += 1;
                $("#playerkicks").append("<div class='inviteddiv' id='inviteddiv" + x + "'><strong>" + user[x].username + "</strong></div>");
                $("#inviteddiv" + x).append("<div class='groupopinion' id='checkinginvited" + x + "'></div>");
                $("#checkinginvited" + x).append("<div id='writing" + x + "'><p style='text-align:center;'><span style='float:left;'>Kick</span>Undecided<span style='float:right;'>Keep</span></p></div>");
                for (y in user) {
                    if (user[y].playergroup == gp) {
                        if (user[y].alive == 1) {
                            if (y !== x) {
                                switch (user[y].agreeinvite[x]) {
                                    case 0:
                                        if (y == usr) {
                                            $("#checkinginvited" + x).append("<div class='groupplayercenter'><button id='playera" + x + "' onclick='playeropinion(this.id, 1)'>Kick</button>" + user[y].username + "<button id='playerr" + x + "' onclick='playeropinion(this.id, 2)'>Keep</button></div>");
                                            break;
                                        } else {
                                            $("#checkinginvited" + x).append("<div class='groupplayercenter'>" + user[y].username + "</div>");
                                            break;
                                        }
                                    case 1:
                                        $("#checkinginvited" + x).append("<div class='groupplayerleft'>" + user[y].username + "</div>");
                                        break;
                                    case 2:
                                        $("#checkinginvited" + x).append("<div class='groupplayerright'>" + user[y].username + "</div>");
                                        break;
                                    default:
                                        console.log("ERROR with agree invite variable for player " + user[y].username + ". Array = " + user[y].agreeinvite[x]);
                                        break;
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    if (count < 1){
        $("#playerkicks").hide();
    }
    $("#loadingscreen").css("visibility", "hidden");
}

function ajax_refreshgroup_data(data, type) {
    var hr = new XMLHttpRequest();
    hr.open("POST", "../php_query/get_group_data.php", true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function () {
        if (hr.readyState == 4 && hr.status == 200) {
            group = JSON.parse(hr.responseText);
            if (type == "join") {
                var person = data.slice(6);
                var join = user[person].playergroup;
                group[join].invited[usr] = 1;
                ajax_postarray(group[join].invited, "invited", "ingamegroups", join, "../php_query/post_array_group.php");
                removevotes(join);
            }
            if (type == "kick"){
                var player1 = data.slice(4);
                var join = user[player1].playergroup;
                group[join].kick[player1] = 1;
                ajax_postarray(group[join].kick, "kick", "ingamegroups", join, "../php_query/post_array_group.php");
            }
            console.log("Changing Groups");
            $("#loadingscreen").css("visibility", "hidden");
        }
    };
    hr.send("var1=true");
}

function invitetogroup(x){
    $("#loadingscreen").css("visibility", "visible");
    ajax_refreshgroup_data(x, "join");
}

function playeropinion(x, y){
    var player = x.slice(7);
    user[usr].agreeinvite[player] = y;
    ajax_postarray(user[usr].agreeinvite, "agreeinvite", "ingameavatars", "NOT REQUIRED", "../php_query/post_array.php");
    ajax_getgroup_data();
}

function leavegroup(){
    for (x in group){
        var count = 0;
        for (y in user){
            if (user[y].playergroup == x){
                count +=1;
            }
        }
        if (count == 0){
            var z = user[usr].playergroup;
            group[x].mapping = group[z].mapping;
            group[x].known = group[z].known;
            user[usr].playergroup = x;
            var count2 = 0;
            for (i in user[usr].agreeinvite){
                if (user[usr].agreeinvite[i] !== 0){
                    user[usr].agreeinvite[i] = 0;
                    count2 +=1;
                }
            }
            if (count2 > 0){
                ajax_postarray(user[usr].agreeinvite, "agreeinvite", "ingameavatars", "NOT REQUIRED", "../php_query/post_array.php");
            }
            ajax_postarray(group[x].mapping, "mapping", "ingamegroups", x , "../php_query/post_array_group.php");
            ajax_postarray(group[x].known, "known", "ingamegroups", x , "../php_query/post_array_group.php");
            ajax_postdata(user[usr].playergroup, "playergroup", "ingameavatars", user[usr].username, "../php_query/post_data_other.php");
            ajax_getgroup_data();
            break;
        }
    }
}

function kickfromgroup(x){
    $("#loadingscreen").css("visibility", "visible");
    ajax_refreshgroup_data(x, "kick");
}

function removevotes(g){
    console.log("Player "+usr+" is joining group "+g);
    for (x in user){
        if (user[x].playergroup == g){
            if (user[x].agreeinvite[usr] != 0) {
                user[x].agreeinvite[usr] = 0;
                console.log("Player " + x + " vote has been removed for player " + usr);
                ajax_postarray(user[x].agreeinvite, "agreeinvite", "ingameavatars", user[x].username, "../php_query/post_array_other.php");
            }
        }
    }
}