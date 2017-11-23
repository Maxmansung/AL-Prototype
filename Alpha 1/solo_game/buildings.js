//Count of the buildings for the function to make them all "Not built"
var buildingscount = 2;
//This is a variable function used to count the items on the ground of the zone
var itemcounter = function(value) {
    if(value == this) return value;
};


function building(name, locationarray, parentbuilding, material1, material2, material3, material4, staminacost, staminaspent, buildicon){
    //The name of the building to be printed
    this.name = name;
    //This array hold the information regarding if the building has been built in each zone (the array point refers to the zone number)
    this.locationarray = locationarray;
    //If there is a parent building required this is the number for it
    this.parentbuilding = parentbuilding;
    //The material name and how much is needed. Can use 4 different materials currently
    this.material1 = material1;
    this.material2 = material2;
    this.material3 = material3;
    this.material4 = material4;
    //The stamina required to build the item
    this.staminacost = staminacost;
    //The stamina used in each zone (the array point refers to the zone number)
    this.staminaspent = staminaspent;
    //The icon for the building
    this.buildicon = buildicon;
}

building[0] = new building("Firepit", [], 0, ["Wood", 3], ["Torch", 1], ["ZZNone", 0], ["ZZNone", 0], 5, [], "../images/firepit.png");
building[1] = new building("Chest", [], 0, ["Snow", 4], ["Wood", 1], ["ZZNone", 0], ["ZZNone", 0], 10, [], "../images/chest.png");

//This makes all the buildings register as not built at the start of the game
function startingbuildings(){
    var zonecount = mapsize*mapsize;
    for (x=0;x<zonecount;x++){
        for (i=0;i<buildingscount;i++){
            building[i].locationarray[x]=false;
            building[i].staminaspent[x]=0;
        }
    }
    var userlocation = (((user[username1].yaxis-1)*mapsize)+user[username1].xaxis)-1;
    building[0].locationarray[userlocation] = true;
    fireplace[userlocation] = new fireplace(3);
}

function buildingstab() {
    $('#zonebuildings').empty();
    var userlocation = (((user[username1].yaxis - 1) * mapsize) + user[username1].xaxis) - 1;
    for (x = 0; x < buildingscount; x++) {
        var wrap = building[x].name+userlocation+"wrap";
        $("#zonebuildings").append("<div class='buildingdivwrapper' id='"+wrap+"'></div>");
        var testingblank1 = false;
        var testingblank2 = false;
        var testingblank3 = false;
        var testingblank4 = false;
        var itemimage = "";
        if (building[x].locationarray[userlocation] === false) {
            for (i = 0; i < 6; i++) {
                var buildinfo = "";
                var thing = "";
                var thing2 = "";
                var itemcount = "";
                var innerwriting = "";
                var create = true;
                switch (i) {
                    case 0:
                        buildinfo = "text";
                        innerwriting = building[x].name;
                        itemimage = building[x].buildicon;
                        create = true;
                        break;
                    case 1:
                        buildinfo = "matt";
                        thing = map[userlocation].fitems;
                        thing2 = building[x].material1[0];
                        itemimage = item[thing2].icon;
                        itemcount = (thing.filter(itemcounter, thing2).length);
                        innerwriting = itemcount + "/" + building[x].material1[1];
                        create = true;
                        testingblank1 = itemcount >= building[x].material1[1];
                        break;
                    case 2:
                        if (building[x].material2[1] !== 0) {
                            buildinfo = "matt";
                            thing = map[userlocation].fitems;
                            thing2 = building[x].material2[0];
                            itemimage = item[thing2].icon;
                            itemcount = (thing.filter(itemcounter, thing2).length);
                            innerwriting = itemcount + "/" + building[x].material2[1];
                            create = true;
                            testingblank2 = itemcount >= building[x].material2[1];
                        }
                        else {
                            create = false;
                            testingblank2 = true;
                        }
                        break;
                    case 3:
                        if (building[x].material3[1] !== 0) {
                            buildinfo = "matt";
                            thing = map[userlocation].fitems;
                            thing2 = building[x].material3[0];
                            itemimage = item[thing2].icon;
                            itemcount = (thing.filter(itemcounter, thing2).length);
                            innerwriting = itemcount + "/" + building[x].material3[1];
                            create = true;
                            testingblank3 = itemcount >= building[x].material3[1];
                        }
                        else {
                            create = false;
                            testingblank3 = true;
                        }
                        break;
                    case 4:
                        if (building[x].material4[1] !== 0) {
                            buildinfo = "matt";
                            thing = map[userlocation].fitems;
                            thing2 = building[x].material4[0];
                            itemimage = item[thing2].icon;
                            itemcount = (thing.filter(itemcounter, thing2).length);
                            innerwriting = itemcount + "/" + building[x].material4[1];
                            create = true;
                            testingblank4 = itemcount >= building[x].material4[1];
                        }
                        else {
                            create = false;
                            testingblank4 = true;
                        }
                        break;
                    case 5:
                        var ident2 = x + "+" + userlocation + "?" + building[x].name;
                        $("#" + wrap).append("<button class='buildingbutton' id='" + ident2 + "' onclick='staminabuild(this.id)'></button>");
                        buildinfo = "stamina";
                        innerwriting = building[x].staminaspent[userlocation] + "/" + building[x].staminacost;
                        itemimage = "../images/stamina.png";
                        create = true;

                }
                var ident3 = building[x].name + userlocation + buildinfo;
                if (create == true) {
                    $("#" + wrap).append("<div class='building" + buildinfo + "' id='" + ident3 + "'><img src='" + itemimage + "' class='buildingimages'>" + innerwriting + "</div>");
                }
            }
            if (testingblank1 !== true || testingblank2 !== true || testingblank3 !== true || testingblank4 !== true) {
                var testingthing = building[x].name + userlocation + "wrap";
                $("#"+testingthing).css("background-image","url('../images/unexplored.png')");
                document.getElementById(ident2).disabled = true;
                document.getElementById(ident2).style.backgroundColor = "lightgrey";
            }
        }
        else{
            var ident3 = building[x].name + userlocation + "built";
            innerwriting = building[x].name;
            $("#" + wrap).append("<div class='buildingbuilt' id='" + ident3 + "'><img src='" +building[x].buildicon+ "' class='buildingimages'>"+building[x].name+"&nbsp;&nbsp;---------Complete---------</div>");
            $("#"+ident3).css("background-image","url('../images/builtbuilding.png')")
        }
    }
}

function staminabuild(id){
    if (staminacheck() == true) {
        var idlength = id.indexOf("+");
        var idlength2 = id.indexOf("?");
        var temparrayid = parseInt(id.slice(idlength, idlength2));
        var buildingid = parseInt(id.slice(0, idlength));
        user[username1].stamina -= 1;
        building[buildingid].staminaspent[temparrayid] += 1;
        if (building[buildingid].staminaspent[temparrayid] == building[buildingid].staminacost){
            buildingcompleted(id);
        }
        refreshimages();
    }
    else {
        nostamina();
    }
}

function buildingcompleted(id){
    var idlength = id.indexOf("+");
    var idlength2 = id.indexOf("?");
    var userlocation = parseInt(id.slice(idlength, idlength2));
    var buildingid = parseInt(id.slice(0, idlength));
    for (x=0;x<4;x++) {
        var materialcount = 0;
        var materialname = "ZZNone";
        switch (x) {
            case 0:
                materialcount = building[buildingid].material1[1];
                materialname = building[buildingid].material1[0];
                break;
            case 1:
                materialcount = building[buildingid].material2[1];
                materialname = building[buildingid].material2[0];
                break;
            case 2:
                materialcount = building[buildingid].material3[1];
                materialname = building[buildingid].material3[0];
                break;
            case 3:
                materialcount = building[buildingid].material4[1];
                materialname = building[buildingid].material4[0];
                break;
        }
        if (materialcount !== 0) {
            for (i=0; i<materialcount; i++) {
                var location = map[userlocation].fitems.indexOf(materialname);
                map[userlocation].fitems.splice(location, 1);
            }
        }
    }
    building[buildingid].locationarray[userlocation] = true;
    alert(building[buildingid].name+" has been built!");
    switch (buildingid){
        case 1:
            fireplace[userlocation] = new fireplace(3);
            break;
        case 2:
            break;
        default:
            break;
    }
    refreshimages();
}

function fireplacedeplete(local){
    if (fireplace[local].wood <= 0){
        building[1].locationarray[local] = false;
        alert("The fire has been destroyed!!")
    }
}