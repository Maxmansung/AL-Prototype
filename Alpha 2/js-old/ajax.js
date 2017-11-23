var mapsize = 5;

function ajaxObj( meth, url ) {
    var x = new XMLHttpRequest();
    x.open( meth, url, true );
    x.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    return x;
}
function ajaxReturn(x){
    if(x.readyState == 4 && x.status == 200){
        return true;
    }
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

function ajax_getuser_data() {
    $("#loadingscreen").css("visibility", "visible");
    var hr = new XMLHttpRequest();
    hr.open("POST", "../php_query/get_user_data.php", true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function () {
        if (hr.readyState == 4 && hr.status == 200) {
            user = JSON.parse(hr.responseText);
            ajax_getgroup_data();
        }
    };
    hr.send("var1=true");
}

function ajax_getmapinfo(php, type, vari){
    $("#loadingscreen").css("visibility", "visible");
    var maps = new XMLHttpRequest();
    maps.open("POST", php, true);
    maps.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    maps.onreadystatechange = function () {
        if (maps.readyState == 4 && maps.status == 200) {
            map = JSON.parse(maps.responseText);
            if (type == "start") {
                mapcreate();
            }
        }
    };
    maps.send("data="+vari);
}

function ajax_getgroup_data() {
    var hr = new XMLHttpRequest();
    hr.open("POST", "../php_query/get_group_data.php", true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function () {
        if (hr.readyState == 4 && hr.status == 200) {
            group = JSON.parse(hr.responseText);
            var count = group[0].mapping.length;
            var count2 = group[0].invited.length;
            for (num in group) {
                for (x = 0; x < count; x++) {
                    group[num].mapping[x] = parseInt(group[num].mapping[x]);
                }
                for (x = 0; x < count2; x++) {
                    group[num].invited[x] = parseInt(group[num].invited[x]);
                }
                for (x = 0; x < count2; x++) {
                    group[num].kick[x] = parseInt(group[num].kick[x]);
                }
            }
            if (window.location.pathname == "/game/map.php"){
                usernamefind();
                newlocation();
            }
            if (window.location.pathname == "/game/players.php"){
                usernamefind();
                refreshplayer();
                checkplayergroups();
            }
        }
    };
    hr.send("var1=true");
}

function ajax_getzone(){
    var maps = new XMLHttpRequest();
    maps.open("POST", "../php_query/get_zone.php", true);
    maps.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    maps.onreadystatechange = function () {
        if (maps.readyState == 4 && maps.status == 200) {
            d.m = JSON.parse(maps.responseText);
            usernamefind();
            checkplayergroups();
            refreshplayer();
        }
    };
    maps.send("data=true");
}