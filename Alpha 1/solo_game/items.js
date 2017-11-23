//This is the maximum number of searches a zone allows before depletion
var maxsearches = 20;
//This is the minimum number of searches a zone allows before depletion
var minsearches = 5;
//This is for different responses
var responsecounter = false;

//This is the function for when the player presses the search button
function searchbutton(){
    if (staminacheck() == true) {
        user[username1].stamina -=1;
        itemrandomiser();
        refreshimages();
    }
    else{
        nostamina();
    }
}

//This function defines what item is found based on the zone type
function itemrandomiser(){
    var zonelocation = (((user[username1].yaxis-1)*mapsize)+user[username1].xaxis)-1;
    var founditem = "ZZNone";
    var itemnumber = (Math.floor(Math.random()*10));
    if (map[zonelocation].depleted == false) {
        map[zonelocation].searchcount += 1;
        var depletecheck = (Math.floor(Math.random() * (maxsearches-minsearches))+minsearches)/map[zonelocation].searchcount;
        if (depletecheck < 1){
            map[zonelocation].depleted = true;
        }
        founditem = enviroment[map[zonelocation].environ].items[itemnumber];
    }
    else {
        //If the zone is depleted then no items are returned
        user[username1].stamina +=1;
        founditem = "Depleted";

    }
    //This switch statement places the item that is found based on the random number
    if (founditem == "Depleted") {
        $("#Information").css("color", "red").text("Zone is depleted");
    }
    else if (founditem == "ZZNone") {
        if (responsecounter == false) {
            $("#Information").css("color", "black").text("No items found");
            responsecounter = true;
        }
        else {
            $("#Information").css("color", "blue").text("Found nothing again!");
            responsecounter = false;
        }
    }
    else{
        var tempzoneid = (((user[username1].yaxis - 1) * mapsize) + user[username1].xaxis) - 1;
        map[tempzoneid].fitems.push(founditem);
        $("#Information").css("color", "green").text("You found: " + founditem);
    }
    refreshimages();
}

//This is the option to add item images to the screen
function addimages() {
    $("#zoneitemholder").empty();
    var zonelocation = (((user[username1].yaxis-1)*mapsize)+user[username1].xaxis)-1;
    map[zonelocation].fitems.sort();
    //This cycles through the items on the zone
    for (x=0;x<(map[zonelocation].fitems.length);x++){
        //This make the zone item name into a single variable for ease
        var testingname = map[zonelocation].fitems[x];
        //This checks that the item name is a real item
        if (typeof item[testingname] !== 'undefined'){
            var imagename = "g"+zonelocation+"+"+x+"?"+testingname;
            $("#zoneitemholder").append("<img id='"+imagename+"' class='foundobject' src='"+item[testingname].icon+"' draggable='true' ondragstart='moveitem(event)'>");
        }
    }
}


function moveitem(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
}

function dropground(ev) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    var type = data.slice(0, 1);
    if (type == "p") {
        var idlength2 = data.indexOf("?");
        var playerlocation = (((user[username1].yaxis - 1) * mapsize) + user[username1].xaxis) - 1;
        var thisitem = data.slice(idlength2 + 1);
        map[playerlocation].fitems.push(thisitem);
        var idlength = data.indexOf("+");
        var temparrayid = parseInt(data.slice(idlength, idlength2));
        user[username1].fitems.splice(temparrayid, 1, "ZZNone");
        refreshimages();
    }
}

function bagdrop(ev) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    var type = data.slice(0, 1);
    if (type == "g") {
        var idlength2 = data.indexOf("?");
        var thisitem = data.slice(idlength2 + 1);
        if (user[username1].fitems.filter(checknone).length < user[username1].bagsize) {
            var position = user[username1].fitems.indexOf("ZZNone");
            user[username1].fitems.splice(position, 1, thisitem);
            var idlength = data.indexOf("+");
            var temparrayid = parseInt(data.slice(idlength, idlength2));
            var tempzoneid = parseInt(data.slice(1, idlength));
            map[tempzoneid].fitems.splice(temparrayid, 1);
            refreshimages();
        }
        else {
            alert("Bag is full")
        }
    }
}


function allowDrop(ident) {
    ident.preventDefault();
}