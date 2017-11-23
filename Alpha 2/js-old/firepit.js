var checking = false;

function firepitcheck(){
    $("#firepittext").empty();
    if (d.m.buildings[3] == building[3].staminacost){
        $("#backpackwrap").show();
        $("#firepittext").append("<div id='testinginfo'>Current fuel: "+d.m.fuel+"</div><div id='testinginfo'>Heat supplied: "+Math.floor(3*(Math.sqrt(d.m.fuel)))+"</div><img id='firepitimage' src='../images/firepit2.png'>");
        $("#backpack").empty();
        for (it in d.u.fitems){
            var items = d.u.fitems[it];
            var image = item[items].icon;
            var writing = item[items].information;
            $("#backpack").append("<div class='imagediv'><image class='itemimage' src='"+image+"' id='"+items+"+"+it+"' onclick='dropitem(this.id)'><span class='imagetext'>"+writing+"</span></div>")
        }
    } else {
    $("#firepittext").append("<div id='testinginfo'>Nothing built yet...</div><img id='firepitimage' src='../images/firepit1.png'>");
        $("#backpackwrap").hide();
    }
    $("#loadingscreen").css("visibility", "hidden");
}

function dropitem(data){
    var idlength = data.indexOf("+");
    var item = data.slice(0, idlength);
    if (item !== "ZZNone") {
        ajax_checkfuel(item);
    }
}

function dropitem2(data){
    console.log(data);
    if (data == "Snowman"){
        alert("As you watch the snowman melt into the fire a faint scream echos on the wind, sending a shiver down your spine...");
    }
    d.m.fuel += item[data].fuel;
    if (d.m.fuel < 1){
        if (d.m.buildings[3] >= building[3].staminacost) {
            console.log("Removing firepit");
            d.m.buildings[3] = 0;
            ajax_postarray(d.m.buildings, "buildings", "mapzones", d.u.location, "../php_query/post_maparray.php");
        }
    }
    var rem = d.u.fitems.indexOf(data);
    d.u.fitems.splice(rem, 1, "ZZNone");
    d.u.fitems.sort();
    ajax_postdata(d.m.fuel, "fuel", "mapzones", d.u.location);
    ajax_postarray(d.u.fitems, "fitems", "ingameavatars", "NOT REQUIRED", "../php_query/post_array.php");
    firepitcheck();
    staminaimage();
}





/////////AJAX/////////

function ajax_firepitdata(){
    $("#loadingscreen").css("visibility", "visible");
    var maps = new XMLHttpRequest();
    maps.open("POST", "../php_query/get_map_zone.php", true);
    maps.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    maps.onreadystatechange = function () {
        if (maps.readyState == 4 && maps.status == 200) {
            if (checking === false) {
                d = JSON.parse(maps.responseText);
                if (d.m.buildings[5] >= building[5].staminacost){
                    if (d.m.groupowner != d.u.playergroup){
                        window.location.href = 'http://www.arctic-lands.online/game/overview.php';
                    }
                }
                if (d.m.fuel < 1){
                    if (d.m.buildings[3] >= building[3].staminacost) {
                        d.m.buildings[3] = 0;
                        ajax_postarray(d.m.buildings, "buildings", "mapzones", d.u.location, "../php_query/post_maparray.php");
                    }
                }
                checking = true;
                ajax_getday();
                firepitcheck();
            } else{
                d = JSON.parse(maps.responseText);
            }
        }
    };
    maps.send("data=true");
}

function ajax_checkfuel(data){
    $("#loadingscreen").css("visibility", "visible");
    var maps = new XMLHttpRequest();
    maps.open("POST", "../php_query/check_fuel.php", true);
    maps.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    maps.onreadystatechange = function () {
        if (maps.readyState == 4 && maps.status == 200) {
            d.m.fuel = parseInt(maps.responseText);
            dropitem2(data)
        }
    };
    maps.send("data="+d.u.location);
}


function ajax_postdata(data, vari, table, where){
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

function ajax_postarray(data, vari, table, where, php){
    var hr = new XMLHttpRequest();
    hr.open("POST", php, true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function () {
        if (hr.readyState == 4 && hr.status == 200) {
            //console.log(hr.responseText);
        }
    };
    var data2 = JSON.stringify(data);
    hr.send("data="+data2+"&vari="+vari+"&table="+table+"&where="+where);
}