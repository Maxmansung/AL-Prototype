//These are the functions that happen when the page is loaded. Most simply create variables that will eventually be stored on the server
function onloading(){
    //Creates the map. This appears complex as the map is created based on variables each time
    mapcreate();
    //This creates the empty chatbox variables
    createchatboxes();
    //Creates the player character, eventually this will be replaced by a function to call the details from the server
    playerlocal();
    //Creates the attributes of each zone, much of this can remain in the function but when the map size is static this can be replaced with static coding
    zoneattributes();
    //This creates the starting buildings
    startingbuildings();
    //This updates all the HTML images
    refreshimages();
}


//This function performs all the refresh image functions
function refreshimages(){
    if (user[username1].alive == false){
        $("#deadscreen").remove();
        $("#wrapper").hide();
        $("#Mainwindow").append("<div id='deadscreen'><strong>"+user[username1].username+" IS DEAD!</strong>")
        chatboxrefresh();
    }
    else {
        $("#deadscreen").remove();
        $("#wrapper").show();
        unexplored();
        staminaimage();
        bagimages();
        addimages();
        buildingstab();
        tempdisp();
        newlocation();
        actionchecker();
        chatboxrefresh();
    }
}