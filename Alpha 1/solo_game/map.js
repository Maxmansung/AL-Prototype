//This variable is the size of the map and will eventually become static but is required for testing for the correct size currently
var mapsize=12;
//This is the pixel size of each map part (dont forget to manually change the CSS property of .zone)
var pixelsize=20;

function map(xaxis,yaxis,environ, fitems, depleted, searchcount, temperature) {
    //The x axis of the zone
    this.xaxis = xaxis;
    //The y axis of the zone
    this.yaxis = yaxis;
    //The enviornmental value of the zone (used to change the chances of items found)
    this.environ = environ;
    //This array shows the items on the ground currently
    this.fitems = fitems;
    //This detects if the zone is depleted or not
    this.depleted = depleted;
    //This counts the number of searches performed, eventually depleting the zone
    this.searchcount = searchcount;
    //This is the bonus to survival the zone gives for tem
    this.temperature = temperature;
}

function enviroment(name, items, colour){
    this.name = name;
    this.items = items;
    this.colour = colour;
}
//These are the objects for different enviroment types. They change the items that can be found and the stats about the zone
enviroment[0] = new enviroment("Snow", ["Snow", "Snow", "Snow", "Snow", "Snow", "Wood", "Wood", "ZZNone", "ZZNone", "ZZNone"], "lightgrey");
enviroment[1] = new enviroment("Forest", ["Wood", "Wood", "Wood", "Wood", "Snow", "Snow", "ZZNone", "ZZNone", "ZZNone", "ZZNone"], "lightgreen");

for (x=0;x<=mapsize;x++){
    for (y=0;y<=mapsize;y++) {
        map[(((y-1)*mapsize)+x)-1] = new map(x, y, (Math.floor(Math.random() * 2)), [], false, 0, -1);
        }
    }

function mapcreate() {
    for (i = 0; i < ((mapsize * mapsize)); i++) {
        //This if statement defines the image (background) depending on zone enviroment variable

        var colour = enviroment[map[i].environ].colour;
        //This var creates the x co-ordinate of the box
        var padwidth = (map[i].xaxis * pixelsize);
        //This var creates the y co-ordinate of the box
        var padheight = (map[i].yaxis * pixelsize);
        //This creates a unique identifier for each HTML div
        var ident = ("zone" + i);
        $("#start").append("<div id='"+ident+"' class='zone'>" +
            "<img src='../images/unexplored.png' id='unexplored"+i+"' class='mapimages'>" +
            "<img src='../images/depleted.png' id='depleted"+i+"' class='mapimages'>" +
            "</div>");
        $("#"+ident).css({"left":padwidth+"px","top":padheight+"px","background":colour});
        $("#unexplored"+i).css("visibility", "hidden");

        //This creates a static div boarder around the map based on the map size to allow correct formatting
        var surround = ((mapsize * pixelsize) * 1.1);
        $("#surround").css({"height":surround+"px","width":surround+"px"});
    }
}

function unexplored(){
    var current = (((user[username1].yaxis-1)*mapsize)+user[username1].xaxis)-1;
    user[username1].mapping[current]=true;
    for (x=0;x<user[username1].mapping.length;x++){
        var zoneid = "unexplored"+x;
        var myNode = document.getElementById(zoneid);
        if (user[username1].mapping[x]==false){
            myNode.style.visibility = "visible";
        }
        else{
            myNode.style.visibility = "hidden";
        }
        zoneid = "depleted"+x;
        myNode = document.getElementById(zoneid);
        if (map[x].depleted == true){
            myNode.style.visibility = "visible";
        }
        else {
            myNode.style.visibility = "hidden";
        }
    }
}