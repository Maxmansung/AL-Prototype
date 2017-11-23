function item(icon, actions, actionid, information){
    this.icon = icon;
    this.actions = actions;
    this.actionid = actionid;
    this.information = information;
}

item["Wood"] = new item("../images/items/stickicon2.png", true, 1, "A small stick, it's great for building fires");
item["Snow"] = new item("../images/items/snow.png", false, 0, "A ball of snow, not much use to keep you warm and it's not like there's a shortage");
item["Torch"] = new item("../images/items/torch2.png", false, 0, "A flaming torch, giver of life, the warming glow draws you close");
item["ZZNone"] = new item("../images/items/Empty.png", false, 0, "There's nothing here");


function actionchecker() {
    $("#backpackactions").empty();
    $("#itemactions").empty();
    for (x = 0; x < user[username1].bagsize; x++) {
        var items = user[username1].fitems[x];
        if (item[items].actions == true){
            var action = item[items].actionid;
            switch (action) {
                case 1:
                    //This prevents a duplicate
                    var myNode = document.getElementById("itemactions");
                    var duplicates1 = 0;
                    for (i=0;i<myNode.options.length;i++){
                        if (myNode.option[i].value == "Wood"){
                            duplicates1 +=1;
                        }
                    }
                    if (duplicates1 <1) {
                        //Action for wood
                        $("#itemactions").append("<option value='Wood'>Create a torch</option>");
                    }
                    break;
            }
        }
    }
    if (document.getElementById("itemactions").options.length == 0){
        $("#itemactions").append("<option value='None'>Nothing</option>");

    }
}

function itemvalue(){
    var act = document.getElementById("itemactions").value;
    switch (act){
        case "Wood":
            maketorch();
            break;
    }
}

function maketorch(){
    var userloc = ((((user[username1].yaxis-1)*mapsize)+user[username1].xaxis)-1);
    if (building[1].locationarray[userloc] == true) {
        var itemloc = user[username1].fitems.indexOf("Wood");
        user[username1].fitems.splice(itemloc, 1, "Torch");
        alert("You made a torch");
        refreshimages();
    }
    else{
        alert("You need a fire to do that");
    }
}