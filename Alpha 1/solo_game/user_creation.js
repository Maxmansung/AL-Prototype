//This is the count of the players in the game
var playercount = 0;
//This variable is the players starting bag size
var bagsizes = 4;
//This is the players starting stamina (AP)
var startstamina = 40;
//This is the base temp of the player at start
var basetemp = 0;

//This creates the player object
function user(xaxis,yaxis,username, fitems, bagsize, stamina, mapping, alive){
    this.xaxis = xaxis;
    this.yaxis = yaxis;
    this.username = username;
    this.fitems = fitems;
    this.bagsize = bagsize;
    this.stamina = stamina;
    this.mapping = mapping;
    this.alive = alive;
}

//This creates our current player in the game and places them at a random location
function playerlocal() {
    var xzone = (Math.floor((Math.random() * mapsize)+1));
    var yzone = (Math.floor((Math.random() * mapsize)+1));
    user[playercount] = new user(xzone, yzone, username1, [], bagsizes, startstamina,[], true);
    var userlocation = ((((yzone-1)*mapsize)+xzone)-1);
    var textaction = "Player-"+username1+" has been created in zone: "+xzone+"/"+yzone;
    chatbox[userlocation].actions.unshift(textaction);
    NPCcreation(12);
    addnone();
    startingmap();
    newlocation();
    directional();
    bagimages();
}

function addnone(){
    for (x=0;x<playercount;x++) {
        var userbag = user[x].fitems;
        while (userbag.length !== bagsizes) {
            userbag.push("ZZNone");
        }
        userbag.splice(1, 1, "Torch");
    }
}

//This function will create some random NPC objects, used for testing the detection of other players on the map
function NPCcreation(count) {
    $("#chooseplayer").append("<option value='0'>Start Player</option>");
    playercount += 1;
    for (x = 1; x <= count; x++) {
        user[playercount] = new user((Math.floor((Math.random() * mapsize) + 1)), (Math.floor((Math.random() * mapsize) + 1)), "Player-" + playercount, [], bagsizes, startstamina,[], true);
        $("#chooseplayer").append("<option value='"+playercount+"'>Player-"+playercount+"</option>");
        var userlocation = ((((user[playercount].yaxis-1)*mapsize)+user[playercount].xaxis)-1);
        var textaction = "Player-"+playercount+" has been created in zone: "+user[playercount].xaxis+"/"+user[playercount].yaxis;
        chatbox[userlocation].actions.unshift(textaction);
        playercount += 1;
    }
}
//This makes all of the map grey to start with
function startingmap(){
    var mapcount = mapsize*mapsize;
    for (i=0;i<playercount;i++) {
        var x = 0;
        while (x < mapcount) {
            user[i].mapping[x] = false;
            x++
        }
    }
}

function playerselect(){
    var act = document.getElementById("chooseplayer").value;
    username1 = act;
    refreshimages();
}

/*

//This shows the location of all the NPCs, used to test the creation of the NPCs (not for use at the moment)
function npcmovement (){
    testingwriting = user[username1].username+" is at: "+user[username1].xaxis+", "+user[username1].yaxis+"</br>";
    for (x=1; x<playercount; x++){
        testingwriting += user[x].username+" at "+user[x].xaxis+", "+user[x].yaxis+"</br>";
    }
    document.getElementById("testing").innerHTML = testingwriting;
}

//This makes one of the NPC's randomly change its xaxis location, used to test if the map is able to detect changes in the variables (Not for use at the moment)
function testing(){
    var moving = (Math.floor((Math.random() * playercount)));
    user[moving].xaxis = (Math.floor((Math.random() * mapsize)+1));
    npcmovement();
}

*/