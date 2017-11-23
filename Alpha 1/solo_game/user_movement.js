//The main players username, this is different to the other user items as it is currently a single player game
var username1 = playercount;
//This is the cost of moving between zones
var movementcost = 1;

//This function disables the directional buttons when you reach the edge of the map
function directional(){
    if (user[username1].xaxis == mapsize){
        $("#buteast").attr('title', 'false');
    }
    else{
        $("#buteast").attr('title', 'true');
    }
    if (user[username1].xaxis == 1){
        $("#butwest").attr('title', 'false');
    }
    else{
        $("#butwest").attr('title', 'true');
    }
    if (user[username1].yaxis == mapsize){
        $("#butsouth").attr('title', 'false');
    }
    else{
        $("#butsouth").attr('title', 'true');
    }
    if (user[username1].yaxis == 1){
        $("#butnorth").attr('title', 'false');
    }
    else{
        $("#butnorth").attr('title', 'true');
    }
 }

//This function creates the player location in the new zone
function newlocation() {
    $("#playerimg").remove();
    var userlocation = ((((user[username1].yaxis - 1) * mapsize) + user[username1].xaxis)-1);
    var ident = "zone" + userlocation;
    $("#"+ident).append("<img src='../images/playerlocation.png' id='playerimg' class='mapimages'>");
    $("#playerimg").css("z-index", "100");
}

//This function moves the player direction when the button is pressed
function movedirection(xdir, ydir, id, enter, leave){
    if (id.getAttribute("title") === "true") {
        if (staminacheck() == true) {
            var userlocation = ((((user[username1].yaxis-1)*mapsize)+user[username1].xaxis)-1);
            var movementwriting = "Footprints in the snow leave the zone to the "+leave;
            chatbox[userlocation].actions.unshift(movementwriting);
            user[username1].xaxis += xdir;
            user[username1].yaxis += ydir;
            newlocation();
            directional();
            userlocation = ((((user[username1].yaxis-1)*mapsize)+user[username1].xaxis)-1);
            movementwriting = "Footprints in the snow enter the zone from the "+enter;
            chatbox[userlocation].actions.unshift(movementwriting);
            user[username1].stamina -= movementcost;
            refreshimages();
        }
        else {
            nostamina();
        }
    }
}

//This is used to filter "1None" items from the list
function checknone(item){
    return item !== "ZZNone"
}

//This checks if the players backpack can fit the object being picked up
function bagchecker(){
    //This counts the number of items that are not "1None"
    var count = user[username1].fitems.filter(checknone).length;
    //And then compares it to the bag size to see if the bag is full
    pickupitem = count < user[username1].bagsize;
}

//This function adds the images to the backpack window
function bagimages() {
    $("#backpack").empty();
    user[username1].fitems.sort();
    //All images are then re-added to ensure it is up to date from the variable
    for (x=0;x<(user[username1].fitems.length);x++) {
        //This make the zone item name into a single variable for ease
        var testingname = user[username1].fitems[x];
        //This checks that the item name is a real item
        if (typeof item[testingname] !== 'undefined') {
            var itemname = "p"+username1+"+"+x+"?"+testingname;
            //This causes the item to be dropped up when clicked on
            if (testingname !== "ZZNone") {
                $("#backpack").append("<img src='" + item[testingname].icon + "' id ='" + itemname + "' class='foundobject' draggable='true' ondragstart='moveitem(event)' >");
            }
            else {
                $("#backpack").append("<img src='" + item[testingname].icon + "' id ='" + itemname + "' class='foundobject' draggable='false'>");
            }
        }
    }
}