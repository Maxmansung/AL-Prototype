var pixelsize = 20;

function maploading() {
    ajax_getmapinfo("../php_query/get_map_data.php", "start", true);
}

function refreshmap(){
    d.m = map[user[usr].location];
    staminaimage();
    unexplored();
}

function mapcreate() {
    for (i = 0; i < ((mapsizes * mapsizes)); i++) {
        //This if statement defines the image (background) depending on zone enviroment variable
        var environ = map[i].environ;
        var colour = enviroment[environ].colour;
        //This var creates the x co-ordinate of the box
        var padheight = (Math.round(Math.floor(map[i].location / mapsizes)) * pixelsize);
        //This var creates the y co-ordinate of the box
        var padwidth = (((map[i].location + 1) % mapsizes) * pixelsize);
        //This creates a unique identifier for each HTML div
        var ident = ("zone" + i);
        $("#start").append("<div id='"+ident+"' class='zone'>" +
            "<img src='../images/unexplored.png' id='unexplored"+i+"' class='mapimages'>" +
            "<img src='../images/depleted.png' id='depleted"+i+"' class='mapimages'>" +
            "</div>");
        $("#"+ident).css({"left":padwidth+"px","top":padheight+"px","background":colour});
        $("#unexplored"+i).css("visibility", "visible");
        $("#depleted"+i).css("visibility", "hidden");
        //This creates a static div boarder around the map based on the map size to allow correct formatting
        var surround = ((mapsizes * pixelsize)*1.15);
        $("#surround").css({"height":surround+"px","width":surround+"px"});
    }
    zoneattributes();
    ajax_getuser_data();
}

function deplete(x){
    var locate = user[usr].location;
    map[locate].depleted = x;
    ajax_postmap(map[locate].depleted, "depleted", "mapzones", locate);
    refreshmap()
}

function zoneattributes() {
    //This function assigns a listener to each zone on creation that detects if the mouse enters or leaves
    for (i = 0; i < ((mapsizes * mapsizes)); i++) {
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
    $("#zonelocation").empty();
    $("#players").empty();
    $("#environment").empty();
    var tempzoneid = parseInt(location.slice(4));
    var enviro = map[tempzoneid].environ;
    var gp = user[usr].playergroup;
    var yaxis = (Math.round(Math.floor(tempzoneid / mapsizes)))+1;
    var xaxis = ((tempzoneid) % mapsizes)+1;
    $("#zonelocation").append("<strong>["+ xaxis+" / "+yaxis+"]</strong>");
    if (group[gp].mapping[tempzoneid] == true) {
        var p = playertest(tempzoneid);
        var writing1 = zoneinfo(enviro);
        $("#players").append("<strong>Players: </strong>"+p);
        $("#environment").append(writing1);
     }
     else {
        $("#zonelocation").append("<div><strong>Unexplored</strong></div>");
     }
}
//This looks for players in the location
function playertest(zone){
    var names = "";
    for (i in user) {
        if (user[i].alive == 1) {
            if (user[i].playergroup == gp) {
                if (user[i].location == zone) {
                    names += user[i].username + ", ";
                }
            }
        }
    }
    if (names == ""){
        names = "None";
    }
    return names;
}