var checking = false;

//This is a variable function used to count the items on the ground of the zone
var itemcounter = function(value) {
    if(value == this) return value;
};



function buildingstab() {
    $('#zonebuildings').empty();
    for (x in building) {
        var wrap = x+"buildingwrap";
        if (x != 0) {
            var parentid = building[x].parentbuilding + "buildingwrap";
            $("#" + parentid).after("<div class='buildingdivwrapper' id='" + wrap + "'></div>");
            var testingblank1 = false;
            var testingblank2 = false;
            var testingblank3 = false;
            var testingblank4 = false;
            var itemimage = "";
            if (d.m.buildings[x] != building[x].staminacost) {
                var ident2 = "";
                for (i = 0; i < 6; i++) {
                    var buildinfo = "";
                    var thing = "";
                    var thing2 = "";
                    var itemcount = "";
                    var innerwriting = "";
                    var create = true;
                    switch (i) {
                        case 0:
                            buildinfo = "text";
                            innerwriting = building[x].name;
                            itemimage = building[x].buildicon;
                            create = true;
                            break;
                        case 1:
                            buildinfo = "matt";
                            thing = d.m.fitems;
                            thing2 = building[x].material1[0];
                            itemimage = item[thing2].icon;
                            itemcount = (thing.filter(itemcounter, thing2).length);
                            innerwriting = itemcount + "/" + building[x].material1[1];
                            create = true;
                            testingblank1 = itemcount >= building[x].material1[1];
                            break;
                        case 2:
                            if (building[x].material2[1] !== 0) {
                                buildinfo = "matt";
                                thing = d.m.fitems;
                                thing2 = building[x].material2[0];
                                itemimage = item[thing2].icon;
                                itemcount = (thing.filter(itemcounter, thing2).length);
                                innerwriting = itemcount + "/" + building[x].material2[1];
                                create = true;
                                testingblank2 = itemcount >= building[x].material2[1];
                            }
                            else {
                                create = false;
                                testingblank2 = true;
                            }
                            break;
                        case 3:
                            if (building[x].material3[1] !== 0) {
                                buildinfo = "matt";
                                thing = d.m.fitems;
                                thing2 = building[x].material3[0];
                                itemimage = item[thing2].icon;
                                itemcount = (thing.filter(itemcounter, thing2).length);
                                innerwriting = itemcount + "/" + building[x].material3[1];
                                create = true;
                                testingblank3 = itemcount >= building[x].material3[1];
                            }
                            else {
                                create = false;
                                testingblank3 = true;
                            }
                            break;
                        case 4:
                            if (building[x].material4[1] !== 0) {
                                buildinfo = "matt";
                                thing = d.m.fitems;
                                thing2 = building[x].material4[0];
                                itemimage = item[thing2].icon;
                                itemcount = (thing.filter(itemcounter, thing2).length);
                                innerwriting = itemcount + "/" + building[x].material4[1];
                                create = true;
                                testingblank4 = itemcount >= building[x].material4[1];
                            }
                            else {
                                create = false;
                                testingblank4 = true;
                            }
                            break;
                        case 5:
                            ident2 = x+"button";
                            $("#" + wrap).append("<button class='buildingbutton' id='" + ident2 + "' onclick='buildingclick(this.id)'></button>");
                            buildinfo = "stamina";
                            innerwriting = d.m.buildings[x] + "/" + building[x].staminacost;
                            itemimage = "../images/stamina2.png";
                            create = true;
                            break;
                    }
                    var ident3 = x + buildinfo;
                    if (create == true) {
                        if (building[x].parentbuilding != 0 && buildinfo == "text") {
                            $("#" + wrap).append("<div class='building" + buildinfo + "' id='" + ident3 + "'>&nbsp|---&nbsp<img src='" + itemimage + "' class='buildingimages'>" + innerwriting + "</div>");
                        } else {
                            $("#" + wrap).append("<div class='building" + buildinfo + "' id='" + ident3 + "'><img src='" + itemimage + "' class='buildingimages'>" + innerwriting + "</div>");
                        }
                    }
                }
                var parentid = building[x].parentbuilding;
                if (testingblank1 !== true || testingblank2 !== true || testingblank3 !== true || testingblank4 !== true) {
                    $("#" + wrap).css("background-image", "url('../images/unexplored.png')");
                    $("#" + ident2).prop('disabled', true).css('background-color', 'lightgrey');
                } else if (d.m.buildings[parentid] != building[parentid].staminacost) {
                    $("#" + wrap).css("background-image", "url('../images/unexplored.png')");
                    $("#" + ident2).prop('disabled', true).css('background-color', 'lightgrey');
                }
            }
            else {
                var ident3 = x + "built";
                innerwriting = building[x].name;
                $("#" + wrap).append("<div class='buildingbuilt' id='" + ident3 + "'><img src='" + building[x].buildicon + "' class='buildingimages'>" + building[x].name + "&nbsp;&nbsp;---------Complete---------</div>");
                $("#" + ident3).css("background-image", "url('../images/builtbuilding.png')")
            }
        } else {
            $("#zonebuildings").append("<div class='buildingdivwrapper2' id='" + wrap + "'>BUILDINGS</div>");
        }
    }
    staminaimage();
    $("#loadingscreen").css("visibility", "hidden");
}

function buildingclick(id) {
    if (d.u.stamina>0) {
        ajax_checkzone(id);
    } else {
        alert("You do not have enough stamina");
    }
}

function buildingcompleted(id){
    for (x=0;x<4;x++) {
        var materialcount = 0;
        var materialname = "ZZNone";
        switch (x) {
            case 0:
                materialcount = building[id].material1[1];
                materialname = building[id].material1[0];
                break;
            case 1:
                materialcount = building[id].material2[1];
                materialname = building[id].material2[0];
                break;
            case 2:
                materialcount = building[id].material3[1];
                materialname = building[id].material3[0];
                break;
            case 3:
                materialcount = building[id].material4[1];
                materialname = building[id].material4[0];
                break;
        }
        if (materialcount !== 0) {
            for (i=0; i<materialcount; i++) {
                var location = d.m.fitems.indexOf(materialname);
                d.m.fitems.splice(location, 1);
            }
        }
    }
    if (id == 3){
        d.m.fuel = 2;
        ajax_postdata(d.m.fuel, "fuel", "mapzones", d.u.location, "../php_query/post_mapdata.php")
    }
    if (id == 4){
        d.m.groupowner = d.u.playergroup;
        ajax_postdata(d.m.groupowner, "groupowner", "mapzones", d.u.location, "../php_query/post_mapdata.php")
    }
    ajax_postarray(d.m.fitems, "fitems", "mapzones", d.u.location);
    ajax_postarray(d.m.buildings, "buildings", "mapzones", d.u.location);
    alert(building[id].name+" has been built!");
}

/////////AJAX/////////


function ajax_builddata(){
    $("#loadingscreen").css("visibility", "visible");
    var maps = new XMLHttpRequest();
    maps.open("POST", "../php_query/get_map_zone.php", true);
    maps.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    maps.onreadystatechange = function () {
        if (maps.readyState == 4 && maps.status == 200) {
            if (checking === false) {
                d = JSON.parse(maps.responseText);
                checking = true;
                if (d.m.buildings[5] >= building[5].staminacost){
                    if (d.m.groupowner != d.u.playergroup){
                        window.location.href = 'http://www.arctic-lands.online/game/overview.php';
                    }
                }
                ajax_getday();
                buildingstab();
            } else{
                d = JSON.parse(maps.responseText);
            }
        }
    };
    maps.send("data=true");
}

function ajax_checkzone(id){
    $("#loadingscreen").css("visibility", "visible");
    var maps = new XMLHttpRequest();
    maps.open("POST", "../php_query/check_map_fitems.php", true);
    maps.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    maps.onreadystatechange = function () {
        if (maps.readyState == 4 && maps.status == 200) {
            var testarray = [];
            testarray = JSON.parse(maps.responseText);
            var checkdata = 0;
            for (x in d.m.fitems) {
                if (d.m.fitems[x] ==testarray[x]) {
                    checkdata += 1
                }
            }
            if (checkdata == d.m.fitems.length) {
                var idlength = id.indexOf("b");
                var x = parseInt(id.slice(0, idlength));
                ajax_addbuild(building[x].staminacost, d.u.location, x);
            } else {
                console.log("Change in items");
                d.m.fitems = testarray;
                buildingstab();
            }
        }
    };
    maps.send("data="+d.u.location);
}

function ajax_addbuild(data, where, check){
    $("#loadingscreen").css("visibility", "visible");
    var hr = new XMLHttpRequest();
    hr.open("POST", "../php_query/check_builddata.php", true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function () {
        if (hr.readyState == 4 && hr.status == 200) {
            var testarray = JSON.parse(hr.responseText);
            if (d.m.buildings[check] != testarray[check]){
                d.m.buildings = testarray;
                if (testarray[check] == building[check].staminacost) {
                    alert("This building has already been completed");
                    buildingstab();
                }else {
                    d.m.buildings[check] += 1;
                    if (d.m.buildings[check] == building[check].staminacost) {
                        buildingcompleted(check)
                    } else {
                        ajax_postarray(d.m.buildings, "buildings", "mapzones", where);
                    }
                }
            } else {
                d.m.buildings[check] += 1;
                if (d.m.buildings[check] == building[check].staminacost) {
                    buildingcompleted(check)
                } else {
                    ajax_postarray(d.m.buildings, "buildings", "mapzones", where);
                }
            }
        }
    };
    hr.send("data="+data+"&where="+where);
}

function ajax_postarray(data, vari, table, where){
    var hr = new XMLHttpRequest();
    hr.open("POST", "../php_query/post_maparray.php", true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function () {
        if (hr.readyState == 4 && hr.status == 200) {
            if (vari == "buildings") {
                usestamina(1);
                buildingstab();
            }
        }
    };
    var data2 = JSON.stringify(data);
    hr.send("data="+data2+"&vari="+vari+"&table="+table+"&where="+where);
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