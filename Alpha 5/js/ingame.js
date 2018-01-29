/////////GENERAL FUNCTIONS PAGE////////////////

///////TESTING FUNCTIONS ////

function testdie(){
    ajax_All(201,"none","x");
}

function testStamina(){
    ajax_All(202,"none","x")
}

function testconfimdeath(){
    ajax_All(7,"none","x")
}

///////GENERAL FUNCTIONS ////

function buildingNotBuilt(text){
    $("#buildingswindow").empty()
        .append("<div class='buildingNotBuilt'>There is no "+text+" built currently!</div>");
}

//////OBJECT MANIPULATION///

//This emptied whatever is in the HTML element x
function emptyElement(x){
    $("#"+x).empty();
}

//This shortens the usage of document.getelementbyid into just _
function _(x) {
    return document.getElementById(x);
}


//This converts a timestamp into specific units
function timeConverter(UNIX_timestamp, type){
    var a = new Date(UNIX_timestamp * 1000);
    var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    var year = a.getFullYear();
    var month = months[a.getMonth()];
    var date = a.getDate();
    var hour = a.getHours();
    if (hour.toString().length == 1){
        hour = "0"+hour;
    }
    var min = a.getMinutes();
    if (min.toString().length == 1){
        min = "0"+min;
    }
    var sec = a.getSeconds();
    var time = "ERROR";
    if (type === "all") {
        time = date + ' ' + month + ' ' + year + ' ' + hour + ':' + min + ':' + sec;
    } else if (type === "time"){
        time = hour+":"+min;
    } else if (type === "minutes"){
        time = a.getMinutes();
    }
    return time;
}

//This converts milliseconds into hours and minutes
function msToTime(duration) {
    var minutes = parseInt((duration/(60))%60);
    var hours = parseInt((duration/(60*60))%24);
    if (hours < 1){
        return minutes+"mins";
    } else {
        return hours + "hrs " + minutes+"mins";
    }
}