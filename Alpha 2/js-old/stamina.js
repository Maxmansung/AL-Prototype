var totalstam = 20;
var movestamina = 1;
var town = [];
var d = [];
var minsearches = 5;
var maxsearches = 10;
var mapsizes = 12;
var playercounts = 20;

////DATA////

function map(location, environ, fitems, depleted, searchcount, fuel) {
    //This is the map zone location to double check
    this.location = location;
    //The enviornmental value of the zone (used to change the chances of items found)
    this.environ = environ;
    //This array shows the items on the ground currently
    this.fitems = fitems;
    //This detects if the zone is depleted or not
    this.depleted = depleted;
    //This counts the number of searches performed, eventually depleting the zone
    this.searchcount = searchcount;
    //This is the running total temperature survivable
    this.fuel = fuel;
}

function usernamefind(){
    for (y in user){
        if (user[y].username == username){
            usr = y;
        }
    }
    gp = user[usr].playergroup;
    d.m = map[user[usr].location];
    d.u = user[usr];
    ajax_getday();
    chatboxtext();
}

function timestamping(){
    if (town.players < playercounts){
        town.timer = Date.now();
        $("#hudtimer").empty()
            .append("<div>Not full yet</div>");
    } else {
        var daylength = 57600000; //16Hrs
        //var daylength = 28800000; //8Hrs
        //var daylength = 300000; //5mins
        var t3 = Date.now() - town.timer;
        var countdown = daylength - t3;
        var seconds = (Math.floor(countdown / 1000)) % 60;
        var minutes = (Math.floor((countdown / 1000) / 60)) % 60;
        var hours = (Math.floor(((countdown / 1000) / 60) / 60)) % 60;
        $("#hudtimer").empty()
            .append("<div>" + hours + "hrs " + minutes + "mins</div>");
        //console.log(hours + "hrs " + minutes + "mins " + seconds + "secs");
        var timerexpire = hours + minutes + seconds;
        if (timerexpire <= 0) {
            ajax_checkday();
        }
        var refreshing = setTimeout(timestamping, 60000);
    }
}


//This refreshes the players stamina image
function staminaimage(){
    $("#staminawrapper").empty();
    for (x=0;x<(d.u.stamina);x++){
        $("#staminawrapper").append("<img src='../images/stamina2.png' id='stamina"+x+"' class='staminaimage'>");
    }
    var leftover = (totalstam - d.u.stamina);
    for (x=0;x<leftover;x++){
        $("#staminawrapper").append("<img src='../images/staminaempty.png' class='staminaimage'>");
    }
    day_data();
}

function usestamina(num){
    d.u.stamina -= num;
    ajax_postdata(d.u.stamina, "stamina", "ingameavatars", d.u.username, "../php_query/post_data.php");
}

////TEMPERATURE


function day_data(){;
    $("#daynumber").empty()
        .append("<span>DAY: "+town.day+"</span>")
        .css("color", "rgb("+Math.floor(255/town.day)+","+(town.day*3)+","+(town.day%2)*255);
    var calculate = calculatetemp();
    $("#tempdata").empty()
        .append("<div id='tempdatawrite'><span id='tempwrite'>Night Temp: </span><br>"+town.temperature+"&degC<hr><span id='tempwrite'>Survivable Temp: </span>"+calculate+"&degC</div>");
    if (d.u.ready == 1) {
        $("#readyimage").attr("src","../images/buttonready2.png");
    }else{
        $("#readyimage").attr("src","../images/buttonready1.png");
    }
    $("#loadingscreen").css("visibility", "hidden");
}

function calculatetemp(){
    var x = 0;
    if (d.m.buildings[3] == building[3].staminacost){
        if (d.m.buildings[5] == building[5].staminacost){
            if (d.u.playergroup == d.m.groupowner){
                x -= Math.floor(3*(Math.sqrt(d.m.fuel)));
            }
        } else {
            x -= Math.floor(3 * (Math.sqrt(d.m.fuel)));
        }
    }
    for (i in d.u.fitems){
        if (d.u.fitems[i] == "Torch"){
            x-= 1;
        }
    }
    return x;
}



function ajax_getday() {
    var hr = new XMLHttpRequest();
    hr.open("POST", "../php_query/get_day.php", true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function () {
        if (hr.readyState == 4 && hr.status == 200) {
            town = JSON.parse(hr.responseText);
            timestamping();
            staminaimage();
        }
    };
    hr.send("var1=true");
}


//////CHAT BOX////

function submittext(){
    var test = $("#inputchat").val();
    //var writing = "<strong>"+d.u.username+" said: </strong>"+test;
    if (test !== "") {
        ajax_postlog(test, "c");
        $("#inputchat").val("");
    }
    else{
        alert("There is nothing written");
    }
}

function chatboxtext(){
    var chat = new XMLHttpRequest();
    chat.open("POST", "../php_query/get_logs.php", true);
    chat.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    chat.onreadystatechange = function () {
        if (chat.readyState == 4 && chat.status == 200) {
            var chatboxs = JSON.parse(chat.responseText);
            console.log(chatboxs);
            chatboxtext2(chatboxs)
        }
    };
    chat.send("zone="+d.u.location);
}

function chatboxtext2(chatboxs){
    $("#chatbox").empty();
    for (var count in chatboxs) {
        var countdown = chatboxs[count].timestamp;
        var test2 = countdown.getMinutes();
        console.log(test2);
        var seconds = (Math.floor(countdown / 1000)) % 60;
        var minutes = (Math.floor((countdown / 1000) / 60)) % 60;
        var hours = (Math.floor(((countdown / 1000) / 60) / 60)) % 60;
        $("#chatbox").append("<div><i>"+hours+":"+minutes+"</i><strong>"+user[chatboxs[count].playerid].username+": </strong>"+chatboxs[count].text+"</div>");
    }
}


function ajax_postlog(data, type){
    var hr = new XMLHttpRequest();
    hr.open("POST", "../php_query/post_logs.php", true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function () {
        if (hr.readyState == 4 && hr.status == 200) {
            var test = hr.responseText;
            console.log(test);
        }
    };
    hr.send("text="+data+"&day="+town.day+"&type="+type+"&zone="+d.u.location+"&player="+d.u.playerid);
}

//////DAY ENDING////

function setready2(){
    if (d.u.ready == 0) {
        d.u.ready = 1;
        ajax_postready(d.u.ready, "ready", "ingameavatars", "NOT REQUIRED")
    } else {
        d.u.ready = 0;
        ajax_postready(d.u.ready, "ready", "ingameavatars", "NOT REQUIRED")
    }
    day_data();
}

function ajax_postready(data, vari, table, where){
    var hr = new XMLHttpRequest();
    hr.open("POST", "../php_query/post_data.php", true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function () {
        if (hr.readyState == 4 && hr.status == 200) {
            if (d.u.ready == 1) {
                ajax_checkready();
            } else {
                alert("Maybe you'll be ready later");
            }
        }
    };
    hr.send("data="+data+"&vari="+vari+"&table="+table+"&where="+where);
}


function ajax_checkday() {
    var hr = new XMLHttpRequest();
    hr.open("POST", "../php_query/get_day.php", true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function () {
        if (hr.readyState == 4 && hr.status == 200) {
            var checking = JSON.parse(hr.responseText);
            if (checking.timer == town.timer){
                dayending("timer");
            } else{
                location.reload();
            }
        }
    };
    hr.send("var1=true");
}


function ajax_checkready(){
    $("#loadingscreen").css("visibility", "visible");
    var hr = new XMLHttpRequest();
    hr.open("POST", "../php_query/check_ready.php", true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function () {
        if (hr.readyState == 4 && hr.status == 200) {
            var readyck = JSON.parse(hr.responseText);
            console.log(readyck);
            if (readyck.indexOf(0) == -1){
                console.log("Everyone ready");
                dayending("ready");
            } else {
                alert("Not everyone is ready yet");
                $("#loadingscreen").css("visibility", "hidden");
            }
        }
    };
    hr.send("data=true");
}

function dayending(data){
    var hr = new XMLHttpRequest();
    hr.open("POST", "dayend.php", true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function () {
        if (hr.readyState == 4 && hr.status == 200) {
            $("#loadingscreen").css("visibility", "hidden");
            var test = hr.responseText;
            if (test == "Complete") {
                location.reload();
            }else {
                console.log(test);
                alert("Sorry, something has gone wrong. Please refresh the page");
            }
        }
    };
    console.log(town.day);
    hr.send("data="+data+"&day="+town.day);
}

function setready(){
    var hr = new XMLHttpRequest();
    hr.open("POST", "../php_query/check_full.php", true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function () {
        if (hr.readyState == 4 && hr.status == 200) {
            var testing = JSON.parse(hr.responseText);
            if (testing <= 0 ){
                setready2();
            } else {
                alert("Waiting for the map to fill with players first, please be patient");
            }
        }
    };
    hr.send("data=true");
}