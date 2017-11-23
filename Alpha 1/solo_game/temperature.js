//This is the starting temperature of the game
var actualtemp = 0;
var currentday = 1;
var mintemp = actualtemp-(Math.floor(Math.random() * (currentday+1)));
var maxtemp = actualtemp+(Math.floor(Math.random() * (currentday+1)));


function fireplace(wood) {
    this.wood = wood
}


function tempdisp(){
    var userlocation = (((user[username1].yaxis-1)*mapsize)+user[username1].xaxis)-1;
    var playertemp = zonetemp(userlocation, username1);
    $("#firepitimage").hide();
    $("#firepitwood").empty();
    if (building[0].locationarray[userlocation] == true){
        $("#firepitimage").show();
        $("#firepitwood").append("<div>Fire has " + fireplace[userlocation].wood + " wood</div>");
    }
    $("#tempwriting")
        .empty()
        .append("<div><strong>Tonight's temp:</strong> Minus "+mintemp+" to "+maxtemp+" &degC</div>")
        .append("\n<div><strong>Current survival:</strong> "+playertemp+" &degC</div>");
}

function dayend(){
    for (x=0;x<playercount;x++) {
        var userlocation = (((user[x].yaxis - 1) * mapsize) + user[x].xaxis) - 1;
        var currenttemp = zonetemp(userlocation, x);
        if (currenttemp > actualtemp) {
            user[x].alive = false;
            var actiontext = "Player-"+x+" has DIED!";
            chatbox[userlocation].actions.unshift(actiontext);
        }
    }
    if (user[username1].alive == false){

        alert("Game Over");
        //location.reload();
    }else {
        alert("Still Alive")
    }
}

function zonetemp(zone, player){
    var local = map[zone].temperature;
    local += basetemp;
    if (building[0].locationarray[zone] == true) {
        local -= fireplace[zone].wood;
    }
    for (i=0;i<user[player].bagsize;i++) {
        if (user[player].fitems[i] == "Torch") {
            local += -1;
        }
    }
    return local;
}

function woodloss() {
    var maptotal = mapsize*mapsize;
    for (x=0;x<maptotal;x++){
        if (building[1].locationarray[x] == true){
            fireplace[x].wood -=1
        }
    }
}

function addwood() {
    var woodlocation = user[username1].fitems.indexOf("Wood");
    if (woodlocation!== -1) {
        var currentlocal = (((user[username1].yaxis - 1) * mapsize) + user[username1].xaxis) - 1;
        fireplace[currentlocal].wood += 1;
        user[username1].fitems.splice(woodlocation, 1, "ZZNone");
        refreshimages();
    }
    else {
        alert("You have no wood!");
    }
}

function addsnow() {
    var woodlocation = user[username1].fitems.indexOf("Snow");
    if (woodlocation!== -1) {
        var currentlocal = (((user[username1].yaxis - 1) * mapsize) + user[username1].xaxis) - 1;
        fireplace[currentlocal].wood -= 1;
        user[username1].fitems.splice(woodlocation, 1, "ZZNone");
        fireplacedeplete(currentlocal);
        refreshimages();
    }
    else {
        alert("You have no snow!");
    }
    
}