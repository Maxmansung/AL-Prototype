/////////BUILDINGS PAGE////////

//This constructs the buildings tab
function buildingstab(building) {
    $('#zonebuildings').empty()
        .append("<div class='buildingdivwrapper2' id='0buildingwrap'>BUILDINGS</div>");
    for (x in building) {
        //console.log(building[x]);
        var wrap = x + "buildingwrap";
        var parentid = building[x].buildingsRequired + "buildingwrap";
        $("#" + parentid).after("<div class='buildingdivwrapper' id='" + wrap + "'></div>");
        var itemimage = "";
        if (building[x].isBuilt === false) {
            var counter = 0;
            for (material in building[x].itemsRequired) {
                counter++;
            }
            var ident2 = "";
            for (i = 0; i < (2 + counter); i++) {
                var buildinfo = "";
                var itemused = "";
                var itemcount = "";
                var innerwriting = "";
                var create = true;
                var getitem = 2;
                if (i > 1) {
                    for (material in building[x].itemsRequired) {
                        if (getitem === i) {
                            getitem = material;
                            break;
                        } else {
                            getitem++;
                        }
                    }
                }
                switch (i) {
                    case 0:
                        buildinfo = "text";
                        innerwriting = building[x].name;
                        itemimage = "/images/buildings/"+building[x].icon;
                        create = true;
                        break;
                    case 1:
                        ident2 = x + "button";
                        $("#" + wrap).append("<button class='buildingbutton' id='" + ident2 + "' onclick='buildingclick(this.id)'></button>");
                        buildinfo = "stamina";
                        innerwriting = building[x].staminaSpent + "/" + building[x].staminaRequired;
                        itemimage = "/images/stamina2.png";
                        create = true;
                        break;
                    default:
                        buildinfo = "matt";
                        itemused = building[x].itemsRequired[getitem];
                        innerwriting = itemused.materialOwned + "/" + itemused.materialNeeded;
                        itemimage = "/images/items/" + itemused.icon;
                        create = true;
                        break;
                }
                var ident3 = x + buildinfo;
                if (building[x].buildingsRequired != 0 && buildinfo == "text") {
                    var paddLeft = $("#"+parentid).css("padding-left");
                    paddLeft = parseInt(paddLeft.slice(0,paddLeft.length -2))+15;
                    $("#" + wrap).append("<div class='building" + buildinfo + "' id='" + ident3 + "'>&nbsp|---&nbsp<img src='" + itemimage + "' class='buildingimages'>" + innerwriting + "</div>")
                        .css({paddingLeft: paddLeft+"px"});
                    $("#"+ident3).css({width: (260-paddLeft)})
                } else {
                    $("#" + wrap).append("<div class='building" + buildinfo + "' id='" + ident3 + "'>&nbsp<img src='" + itemimage + "' class='buildingimages'>" + innerwriting + "</div>");
                }
                if (buildinfo == "text"){
                    $("#"+ident3).append("<span class='buildingImageText'>"+building[x].description+"</span>")
                }
            }
            var parentid = building[x].buildingsRequired;
            if (building[x].canBeBuilt === false) {
                $("#" + wrap).css("background-image", "url('/images/unexplored.png')");
                $("#" + ident2).prop('disabled', true).css('background-color', 'lightgrey');
            } else if (parentid != 0) {
                if (building[parentid].isBuilt === false) {
                    $("#" + wrap).css("background-image", "url('/images/unexplored.png')");
                    $("#" + ident2).prop('disabled', true).css('background-color', 'lightgrey');
                }
            }
        } else {
            var ident3 = x + "built";
            innerwriting = building[x].name;
            $("#" + wrap).append("<div class='buildingbuilt' id='" + ident3 + "'><img src='/images/buildings/" + building[x].icon + "' class='buildingimages'>" + building[x].name + "&nbsp;&nbsp;---------Complete---------</div>");
            $("#" + ident3).css("background-image", "url('../images/builtbuilding.png')")
        }
    }
}

//This function sends the message to build a building
function buildingclick(id){
    var buildingID = id.slice(0,-6);
    ajax_All(5,buildingID)
}