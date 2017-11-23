function item(icon, actions, actionid, information, fuel) {
    this.icon = icon; //the image
    this.actions = actions; //if the item has a related action
    this.actionid = actionid; //unique ID for each action
    this.information = information; //Generic information
    this.fuel = fuel //fuel added when placed onto fire (can be negative)
}

item["Wood"] = new item("../images/items/stickicon2.png", true, 1, "A small stick, it's great for building fires.", 1);
item["Snow"] = new item("../images/items/snow.png", true, 2, "A ball of snow, not much use to keep you warm and it's not like there's a shortage.", -1);
item["Torch"] = new item("../images/items/torch2.png", false, 0, "A flaming torch, giver of life, the warming glow draws you close.", 1);
item["ZZNone"] = new item("../images/items/Empty.png", false, 0, "There's nothing here.", 0);
item["Snowman"] = new item("../images/items/snowman2.png", false, 0, "So you did want to build a Snowman!", -2);
item["Wood_Log"] = new item("../images/items/small_log.png", false, 0, "A slightly larger, less pathetic piece of wood", 3);

//ITEM ACTIONS//

function itemvalue(){
    $("#loadingscreen").css("visibility", "visible");
    var act = document.getElementById("itemactions").value;
    switch (act){
        case "Wood":
            maketorch();
            break;
        case "Snow":
            makesnowman();
            break;
    }
    $("#loadingscreen").css("visibility", "hidden");
}

function maketorch(){
    if (d.m.buildings[3] == building[3].staminacost) {
        if (d.m.buildings[5] == building[5].staminacost) {
            if (d.u.playergroup == d.m.groupowner) {
                var itemloc = d.u.fitems.indexOf("Wood");
                d.u.fitems.splice(itemloc, 1, "Torch");
                ajax_postarray(d.u.fitems, "fitems", "ingameavatars", d.u.username, "../php_query/post_array.php");
                refreshzone();
                alert("You made a torch");
            }
        } else {
            var itemloc = d.u.fitems.indexOf("Wood");
            d.u.fitems.splice(itemloc, 1, "Torch");
            ajax_postarray(d.u.fitems, "fitems", "ingameavatars", d.u.username, "../php_query/post_array.php");
            refreshzone();
            alert("You made a torch");
        }
    }
    else{
        refreshzone();
        alert("You need a fire to do that");
    }
}

//Snowman creation
function makesnowman() {
    //find the first snow and removes it
    var itemloc1 = d.u.fitems.indexOf("Snow");
    d.u.fitems.splice(itemloc1, 1, "ZZNone");
    //Looks for second snow
    var itemloc2 = d.u.fitems.indexOf("Snow");
    if (itemloc2 == -1) {
        //not enough snow, alerts the player
        alert("You need two Snow to do that!");
        //replaces the snow
        d.u.fitems.splice(itemloc1, 1, "Snow");

    } else {
        //creates the snowman and alerts the player
        d.u.fitems.splice(itemloc1, 1, "Snowman");
        d.u.fitems.splice(itemloc2, 1, "ZZNone");
        ajax_postarray(d.u.fitems, "fitems", "ingameavatars", d.u.username, "../php_query/post_array.php");
        refreshzone();
        alert("You made a Snowman!")
    }
}

//ENVIROMENT//

function enviroment(name, items, colour){
    this.name = name;
    this.items = items;
    this.colour = colour;
}
//These are the objects for different enviroment types. They change the items that can be found and the stats about the zone
enviroment[0] = new enviroment("Dirt plain", ["Wood", "Snow", "Snow", "ZZNone", "ZZNone", "ZZNone", "ZZNone", "ZZNone", "ZZNone", "ZZNone"], "#DEF095");
enviroment[1] = new enviroment("Snow Field", ["Wood", "Wood", "Snow", "Snow", "Snow", "Snow", "Snow", "ZZNone", "ZZNone", "ZZNone"], "#CEE9E8");
enviroment[2] = new enviroment("Lowland shrub", ["Wood", "Wood", "Wood","Snow", "Snow", "Snow", "ZZNone", "ZZNone", "ZZNone", "Wood_Log"], "#74E950");
enviroment[3] = new enviroment("Forest", ["Wood", "Wood", "Wood", "Wood", "Wood", "Wood", "Snow", "ZZNone", "Wood_Log", "Wood_Log"], "#3C8426");


function zoneinfo(id){
    switch (id){
        case 0:
            return "Dirt extends in every direction with just patches of snow remaining. It looks as though someone has been clearing away as much of the snow as they can. You wonder what they may have been looking for...";
            break;
        case 1:
            return "An empty snow covered field. Maybe there's something below all that snow, but it's probably just more snow...";
            break;
        case 2:
            return "Small spiky bushes stick out from the snow around making it difficult to walk through this zone. You could probably find something to burn here though.";
            break;
        case 3:
            return "Tall trees surround you, making it difficult to find your way. If you could chop them down you could probably make a pretty big fire. At least global warming isn't a concern any more";
            break;
        default:
            return "ERROR";
            break;
    }
}

//BUILDINGS//

function building(name, parentbuilding, material1, material2, material3, material4, staminacost, buildicon){
    //The name of the building to be printed
    this.name = name;
    //If there is a parent building required this is the number for it
    this.parentbuilding = parentbuilding;
    //The material name and how much is needed. Can use 4 different materials currently
    this.material1 = material1;
    this.material2 = material2;
    this.material3 = material3;
    this.material4 = material4;
    //The stamina required to build the item
    this.staminacost = staminacost;
    //The icon for the building
    this.buildicon = buildicon;
}

building[0] = new building("BUILDINGS", 0, ["ZZNone", 0], ["ZZNone", 0], ["ZZNone", 0], ["ZZNone", 0], 0, "../images/fence.png");
building[1] = new building("Fence", 0, ["Snow", 5], ["Wood", 5], ["Wood_Log", 2], ["ZZNone", 0], 30, "../images/fence2.png");
building[2] = new building("Chest", 0, ["Snow", 1], ["Wood", 1], ["Wood_Log", 1], ["ZZNone", 0], 10, "../images/storage.png");
building[3] = new building("Firepit", 0, ["Wood", 3], ["Torch", 1], ["ZZNone", 1], ["ZZNone", 0], 10, "../images/firepit.png");
building[4] = new building("Outpost", 0, ["Snowman", 5], ["Wood_Log", 3], ["ZZNone", 0], ["ZZNone", 0], 20, "../images/outpost.png");
building[5] = new building("Fence Lock", 4, ["Snow", 1], ["Wood", 1], ["ZZNone", 0], ["ZZNone", 0], 8, "../images/fence-lock.png");
building[6] = new building("Chest Lock", 4, ["Snow", 1], ["Wood", 1], ["ZZNone", 0], ["ZZNone", 0], 8, "../images/storage-lock.png");