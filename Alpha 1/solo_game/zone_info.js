//Used to compact the information regarding the players in the zone
var playernames = "";
//This is lets the game know if the item can be picked up
var pickupitem = true;

function zoneattributes() {
    //This function assigns a listener to each zone on creation that detects if the mouse enters or leaves
    for (i = 0; i < ((mapsize * mapsize)); i++) {
        var ident3 = "zone"+i;
        $("#"+ident3).hover(function () {
            $(this).css("border-color", "blue");
        },
            function () {
            $(this).css("border-color", "black")
        })
        .click(function () {
            $("#zonesurround").remove();
            $(this).append("<img src='../images/Surround.png' id='zonesurround' class='mapimages'>").css("z-index", "10");
            infobox(this.id);
        });
    }
}
//This function states what will go into the infobox to the upper right of the map once it has been clicked on
function infobox(location) {
    $("#infowindow").empty();
    var tempzoneid = parseInt(location.slice(4));
    if (user[username1].mapping[tempzoneid] == true) {
        playernames = "<strong>Players: </strong>";
        var maplocstring = map[tempzoneid].xaxis + ', ' + map[tempzoneid].yaxis;
        playertest(tempzoneid);
        $("#infowindow").append("<div><strong>Zone: </strong>[" + maplocstring + "]</br>"+ playernames+"</div>");
    }
    else {
        $("#infowindow").append("<div><strong>Unexplored</strong></div>");
    }
}

function playertest(zone){
    for (x=0;x<playercount;x++){
        //This variable has 1 taken from it as each map ID starts from 0
        var playerloc = (((user[x].yaxis-1)*mapsize)+user[x].xaxis)-1;
        if (playerloc == zone) {
            playernames += user[x].username+", ";
        }
    }
}