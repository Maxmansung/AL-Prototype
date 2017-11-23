var checking = false;

function refreshzone(){
    staminaimage();
    populate();
    zoneinformation();
}

function zoneinformation(){
    var env = d.m.environ;
    var environments = zoneinfo(env);
    var title = enviroment[env].name;
    $("#zoneinformation").empty()
        .append("<div id='zonename'><div>"+title+"</div></div>")
        .append("<div id='zoneinfowrite'>"+environments+"</div>");
    if (d.m.depleted == true){
        $("#zonename").append("<div id='depletedzone'>(Depleted)</div>");
    }
}

function populate(){
    if (d.m.depleted == true){
        zoneinformation();
    }
    $("#backpack").empty();
    for (it in d.u.fitems){
        var items = d.u.fitems[it];
        var image = item[items].icon;
        var writing = item[items].information;
        $("#backpack").append("<div class='imagediv'><image class='itemimage' src='"+image+"' id='"+items+"+"+it+"' onclick='dropitem(this.id)'><span class='imagetext'>"+writing+"</span></div>")
    }
    $("#grounditems").empty();
    var loc = (d.u.location);
    for (it in d.m.fitems){
        var items = d.m.fitems[it];
        var image = item[items].icon;
        var writing = item[items].information;
        $("#grounditems").append("<div class='imagediv'><image class='itemimage' id='"+items+"+"+loc+"' src='"+image+"' onclick='pickupcheck(this.id)'><span class='imagetext'>"+writing+"</span></div>")
    }
    actionchecker();
}

function dropitem2(it) {
    var loc = d.u.location;
    var rem = d.u.fitems.indexOf(it);
    d.m.fitems.push(it);
    d.m.fitems.sort();
    d.u.fitems.splice(rem, 1, "ZZNone");
    d.u.fitems.sort();
    ajax_postarray(d.m.fitems, "fitems", "mapzones", loc, "../php_query/post_maparray.php");
    ajax_postarray(d.u.fitems, "fitems", "ingameavatars", d.u.username , "../php_query/post_array.php");
    refreshzone();
}

function pickupcheck(data){
    ajax_testmap("fitems", data);
}

function dropitem(data){
    var idlength = data.indexOf("+");
    var item = data.slice(0, idlength);
    if (item !== "ZZNone") {
        ajax_testmap("drop", item);
    } else{
        $("#loadingscreen").css("visibility", "hidden");
        refreshzone();
    }
}

function pickupitem(it){
    var idlength = it.indexOf("+");
    var item = it.slice(0, idlength);
    var loc = it.slice(idlength+1);
    if (item !== "ZZNone") {
        var find = d.u.fitems.indexOf("ZZNone");
        if (find !== -1) {
            d.u.fitems.splice(find, 1, item);
            d.u.fitems.sort();
            var rem = d.m.fitems.indexOf(item);
            d.m.fitems.splice(rem, 1);
            d.m.fitems.sort();
            ajax_postarray(d.m.fitems,"fitems", "mapzones", loc, "../php_query/post_maparray.php");
            ajax_postarray(d.u.fitems,"fitems", "ingameavatars", d.u.username, "../php_query/post_array.php");
            refreshzone();
        } else{
            refreshzone();
            alert("No more room in your bag");
        }
    }
}

function checkdepleted(){
    ajax_testmap("search");
}

function itemrandomiser() {
    if (d.u.stamina>0) {
        var loc = d.u.location;
        var founditem = "ZZNone";
        var itemnumber = (Math.floor(Math.random() * 10));
        if (d.m.depleted == false) {
            d.m.searchcount += 1;
            ajax_postmap(d.m.searchcount, "searchcount", "mapzones", loc);
            var depletecheck = (Math.floor(Math.random() * (maxsearches - minsearches)) + minsearches) /d.m.searchcount;
            if (depletecheck < 1) {
                d.m.depleted = true;
                ajax_postmap(d.m.depleted, "depleted", "mapzones", loc);
            }
            founditem = enviroment[d.m.environ].items[itemnumber];
            usestamina(1);
            if (founditem !== "ZZNone") {
                d.m.fitems.push(founditem);
                d.m.fitems.sort();
                ajax_postarray(d.m.fitems,"fitems", "mapzones", loc, "../php_query/post_maparray.php");
                refreshzone();
            }
            else{
                refreshzone();
                alert("Nothing was found");
            }
        } else {
            refreshzone();
            alert("Zone is depleted");
        }
    }else{
        refreshzone();
        alert("You have no stamina");
    }
}


function actionchecker() {
    $("#itemactions").empty();
    for (var x = 0; x < d.u.bagsize; x++) {
        var items = d.u.fitems[x];
        if (item[items].actions == true){
            var action = item[items].actionid;
            switch (action) {
                case 1:
                    //This prevents a duplicate
                    var myNode = document.getElementById("itemactions");
                    var duplicates1 = 0;
                    for (var i = 0; i < myNode.options.length; ++i) {
                        if (myNode.options[i].value == "Wood") {
                            duplicates1 += 1;
                        }
                    }
                    if (duplicates1 < 1) {
                        //Action for wood
                        $("#itemactions").append("<option value='Wood'>Create a torch</option>");
                    }
                    break;
                case 2:
                    //Prevents dupes
                    var myNode = document.getElementById("itemactions");
                    var duplicates1 = 0;
                    for (var i = 0; i < myNode.options.length; ++i) {
                        if (myNode.options[i].value == "Snow") {
                            duplicates1 += 1;
                        }
                    }
                    if (duplicates1 < 1) {
                        //Action for snow
                        $("#itemactions").append("<option value='Snow'>Create a snowman</option>");
                    }
            }
        }
    }
    if (document.getElementById("itemactions").options.length == 0){
        $("#itemactions").append("<option value='None'>Nothing</option>");

    }
    $("#loadingscreen").css("visibility", "hidden");
}

//AJAX CODES//

function ajax_postarray(data, vari, table, where, php){
    var hr = new XMLHttpRequest();
    hr.open("POST", php, true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function () {
        if (hr.readyState == 4 && hr.status == 200) {
        }
    };
    var data2 = JSON.stringify(data);
    hr.send("data="+data2+"&vari="+vari+"&table="+table+"&where="+where);
}

function ajax_postmap(data, vari, table, where){
    var hr = new XMLHttpRequest();
    hr.open("POST", "../php_query/post_mapdata.php", true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function () {
        if (hr.readyState == 4 && hr.status == 200) {
            //console.log(hr.responseText);
        }
    };
    hr.send("data="+data+"&vari="+vari+"&table="+table+"&where="+where);
}

function ajax_testmap(ck, data){
    $("#loadingscreen").css("visibility", "visible");
    var maps = new XMLHttpRequest();
    maps.open("POST", "../php_query/get_map_zone.php", true);
    maps.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    maps.onreadystatechange = function () {
        if (maps.readyState == 4 && maps.status == 200) {
            if (checking === false) {
                d = JSON.parse(maps.responseText);
                checking = true;
                ajax_getday();
                refreshzone();
            } else{
                if (ck == "fitems") {
                    var c = "";
                    var checkdata = 0;
                    c = JSON.parse(maps.responseText);
                    for (x in d.m.fitems) {
                        if (d.m.fitems[x] == c.m.fitems[x]) {
                            checkdata += 1
                        }
                    }
                    if (checkdata == c.m.fitems.length) {
                        pickupitem(data);
                    } else {
                        alert("That item has been picked up");
                        d = c;
                        $("#loadingscreen").css("visibility", "hidden");
                        refreshzone();
                    }
                }
                if (ck == "drop"){
                    d = JSON.parse(maps.responseText);
                    dropitem2(data);
                }
                if (ck == "search"){
                    d = JSON.parse(maps.responseText);
                    itemrandomiser();
                }
            }
        }
    };
    maps.send("data=true");
}

function ajax_postdata(data, vari, table, where, php){
    var hr = new XMLHttpRequest();
    hr.open("POST", php, true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function () {
        if (hr.readyState == 4 && hr.status == 200) {
            //console.log(hr.responseText);
        }
    };
    hr.send("data="+data+"&vari="+vari+"&table="+table+"&where="+where);
}