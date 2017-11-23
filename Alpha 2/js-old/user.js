var usr = "ERROR";
var gp = "ERROR";
var move = false;


function user(username, location, fitems, bagsize, stamina, alive, playergroup, playerid, agreeinvite, ready) {
    this.username = username;
    this.location = location;
    this.fitems = fitems;
    this.bagsize = bagsize;
    this.stamina = stamina;
    this.alive = alive;
    this.playergroup = playergroup;
    this.playerid = playerid;
    this.agreeinvite = agreeinvite;
    this.ready = ready;
}

function group(mapping, invited, kick, known){
    this.mapping = mapping;
    this.invited = invited;
    this.kick = kick;
    this.known = known;
}

function unexplored(){
    for (y in group[gp].mapping){
        if (group[gp].mapping[y] == 1){
            $("#unexplored"+y).css("visibility", "hidden");
            if (map[y].depleted == 1){
                $("#depleted"+y).css("visibility", "visible");
            } else {
                $("#depleted"+y).css("visibility", "hidden");
            }
        }
        else{
            $("#unexplored"+y).css("visibility", "visible");
            $("#depleted"+y).css("visibility", "hidden");
        }
    }
    $("#loadingscreen").css("visibility", "hidden");
}

function newlocation() {
    $("#playerimg").remove();
    var userlocation = user[usr].location;
    group[gp].mapping[userlocation] = 1;
    var ident = "zone" + userlocation;
    $("#" + ident).append("<img src='../images/playerlocation.png' id='playerimg' class='mapimages'>");
    $("#playerimg").css("z-index", "100");
    if (move == true) {
        move = false;
        removeinvites();
    }
    checkplayers();
}

function ajax_refreshgroup_data() {
    var hr = new XMLHttpRequest();
    hr.open("POST", "../php_query/get_group_data.php", true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function () {
        if (hr.readyState == 4 && hr.status == 200) {
            group = JSON.parse(hr.responseText);
            newlocation();
        }
    };
    hr.send("var1=true");
}

function removeinvites(){
    for (x in group){
        if (group[x].invited[usr] == 1){
            group[x].invited[usr] = 0;
            console.log("User uninvited");
            ajax_postarray(group[x].invited, "invited", "ingamegroups", x, "../php_query/post_array_group.php");
        }
    }
}


function checkplayers() {
    var count = 0;
    for (x in user) {
        if (group[gp].known[x] == 0) {
            if (user[usr].location == user[x].location) {
                group[gp].known[x] = 1;
                count += 1;
            }
        }
    }
    ajax_postdata(user[usr].location, "zonelocation", "ingameavatars", user[usr].username, "../php_query/post_data.php");
    ajax_postarray(group[gp].mapping, "mapping", "ingamegroups", gp, "../php_query/post_array_group.php");
    if (count > 0) {
        ajax_postarray(group[gp].known, "known", "ingamegroups", gp, "../php_query/post_array_group.php");
    }
    refreshmap();
}

//This function moves the player direction when the button is pressed
function movedirection(dir) {
    if (user[usr].stamina > 0) {
        $("#loadingscreen").css("visibility", "visible");
        switch (dir) {
            case "n":
                var test = (Math.round(Math.floor(user[usr].location / mapsizes)));
                if (test > 0) {
                    user[usr].location -= mapsizes;
                    move = true;
                    ajax_refreshgroup_data();
                    usestamina(movestamina);
                }else{
                    refreshmap();
                }
                break;
            case "s":
                var test = ((Math.round(Math.floor(user[usr].location / mapsizes))) + 1);
                if (test < mapsizes) {
                    user[usr].location += mapsizes;
                    move = true;
                    ajax_refreshgroup_data();
                    usestamina(movestamina);
                }else{
                    refreshmap();
                }
                break;
            case "e":
                var test = (user[usr].location + 1) % mapsizes;
                if (test != 0) {
                    user[usr].location += 1;
                    move = true;
                    ajax_refreshgroup_data();
                    usestamina(movestamina);
                }else{
                    refreshmap();
                }
                break;
            case "w":
                var test = (user[usr].location + 1) % mapsizes;
                if (test != 1) {
                    user[usr].location -= 1;
                    move = true;
                    ajax_refreshgroup_data();
                    usestamina(movestamina);
                } else{
                    refreshmap();
                }
                break;
        }
    } else {
        alert("You have no stamina");
    }
}