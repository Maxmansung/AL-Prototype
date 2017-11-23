var checking = false;

function checkfence(){
    $("#overviewwrap").empty();
    if (d.m.buildings[4]==building[4].staminacost){
        $("#overviewwrap").append("<div id='zoneoverviewowner'>This zone is owned by Group: "+d.m.groupowner+"</div>");
    } else {
        $("#overviewwrap").append("<div id='zoneoverviewowner'>Build an Outpost to claim this zone</div>");
    }
    if (d.m.buildings[1]==building[1].staminacost){
        $("#overviewwrap").append("<div id='zonegates'>FENCE BUILT</div>");
        if (d.m.buildings[5]==building[5].staminacost){
            $("#overviewwrap").append("<div id='zonegates'>LOCK BUILT</div>");
            if (d.m.groupowner != d.u.playergroup){
                $(".bmenutab").css("visibility", "hidden");
            }
        } else {
            $("#overviewwrap").append("<div id='zonegates'>No lock has been built for the gates yet</div>");
        }
    } else {
        $("#overviewwrap").append("<div id='zonegates'>No fence has been built yet</div>");
    }
    $("#loadingscreen").css("visibility", "hidden");
}


///AJAX/////

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
                ajax_getday();
                checkfence();
            } else{
                d = JSON.parse(maps.responseText);
            }
        }
    };
    maps.send("data=true");
}