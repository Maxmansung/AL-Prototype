//This ajax function is used for all of the data collection within the map screen
function ajax_All(type, view, data1, data2, data3, data4, data5, data6){
    if (typeof view == "undefined"){
        view = "";
    }
    if (typeof data1 == "undefined"){
        data1 = "";
    }
    if (typeof data2 == "undefined"){
        data2 = "";
    }
    if (typeof data3 == "undefined"){
        data3 = "";
    }
    if (typeof data4 == "undefined"){
        data4 = "";
    }
    if (typeof data5 == "undefined"){
        data5 = "";
    }
    if (typeof data6 == "undefined"){
        data6 = "";
    }
    showLoading();
    var hr = new XMLHttpRequest();
    hr.open("POST", "/MVC/ajax_php/ajax_MVC.php", true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function () {
        if (hr.readyState == 4 && hr.status == 200) {
            console.log(hr.responseText);
            var response = JSON.parse(hr.responseText);
            console.log(response);
            if ("ERROR" in response){
                errors(response.ERROR);
            } else if ("ALERT" in response){
                alerts(response.ALERT,response.DATA)
            } else {
                switchArray(type,response);
            }
            hideLoading();
        }
    };
    hr.send("type="+type+"&view="+view+"&data1="+data1+"&data2="+data2+"&data3="+data3+"&data4="+data4+"&data5="+data5+"&data6="+data6);
    //console.log("type="+type+"&view="+view+"&data1="+data1+"&data2="+data2+"&data3="+data3+"&data4="+data4+"&data5="+data5+"&data6="+data6)
}

//This ajax function is to get background information
function ajax_background(type, view,data1){
    var tool = new XMLHttpRequest();
    tool.open("POST", "/MVC/ajax_php/ajax_MVC.php", true);
    tool.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    tool.onreadystatechange = function () {
        if (tool.readyState == 4 && tool.status == 200) {
            //console.log(tool.responseText);
            var response = JSON.parse(tool.responseText);
            //console.log(response);
            if ("ERROR" in response){
                errors(response.ERROR);
            } else if ("ALERT" in response){
                alerts(response.ALERT,response.DATA)
            } else {
                switchArray(type,response);
            }
        }
    };
    tool.send("type="+type+"&view="+view+"&data1="+data1+"&data2=&data3=&data4=&data5=&data6=");
}


function switchArray(type,response){
    console.log("Type: "+type);
    type = parseInt(type);
    if ("HUD" in response){
        buildGamePageHUD(response.HUD);
    }
    switch(type){
        case 0:
            createNotifications(response.view);
            break;
        case 2:
        case 30:
        case 32:
        case 33:
        case 50:
            createOtherAvatarPage(response.view);
            break;
        case 6:
            if (response.HUD.readyStat === false){
                createAlertBox(0, 1, "The day will not end until you are marked as ready");
            } else {
                createAlertBox(0, 1, "The day will not end until everyone else on the map is ready");
            }
            break;
        case 1:
        case 3:
        case 5:
        case 9:
        case 14:
        case 16:
        case 17:
        case 18:
        case 20:
        case 21:
        case 22:
        case 23:
        case 26:
        case 28:
        case 29:
        case 44:
        case 45:
        case 48:
        case 51:
            buildGamePageMain(response.view);
            break;
        case 11:
            createShrinePage(response.view);
            break;
        case 35:
            showProfilePage(response.view);
            break;
        case 36:
            showProfileEditPage(response.view);
            break;
        case 38:
            createSearchResults(response.view);
            break;
        case 10:
        case 41:
            createMapPage(response.view);
            break;
        case 49:
            createJoingameLinks(response.view);
            break;
        case 53:
            createDeathPage(response.view);
            break;
        case 188:
            leaderboardSetup(response.view);
            break;
        case 192:
            createPostView(response.view);
            break;
        case 193:
            saveThreadsData(response.view);
            break;
        case 198:
            window.location.reload();
            break;
        case 206:
            createNewsEditPage(response.view);
            break;
        case 210:
            createEditMapAdmin(response.view);
            break;
        case 211:
            createEditPlayerAdmin(response.view);
            break;
        case 218:
            makeReportsPage(response.view);
            break;
        case 220:
            createEditUserItem(response.view);
            break;
        case 225:
            createNewsOverview(response.view);
            break;
        case 226:
            createSingleNewsPage(response.view);
            break;
        case 229:
            createTestPage(response.view);
            break;
        default:
            console.log("This view does not have an associated function currently");
            break;
    }
}

//This shortens the usage of document.getelementbyid into just _
function _(x) {
    return document.getElementById(x);
}


//This empties a form section
function emptyElement(x){
    _(x).innerHTML = "";
}

//This function counts the length of an object
function objectSize(obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
}

//This function counts the number of items within an object that match a specific example
function objectSizeVariable(obj,variable,comparison) {
    var size = 0;
    for (var key in obj) {
        if (obj[key][variable] === comparison){
            size++;
        }
    }
    return size;
}

//This function refreshes the page
function refreshPage(){
    window.location.reload()
}

function hideLoading(){
    setTimeout(function(){
        $("#loadingScreen2").hide(1000);
        $("#loadingScreen").hide(1000);
    }, 0);
}

function pageSetupFinal(){
    hideLoading();
}

function showLoading(){
    $("#loadingScreen2").show("1000");
}

function activateTooltips() {
    $(function () {
        $('[data-toggle="tooltip"]').tooltip({
            trigger : 'hover'
        })
    });
    var is_touch_device = ("ontouchstart" in window) || window.DocumentTouch && document instanceof DocumentTouch;
    $(function () {
        $('[data-toggle="popover"]').popover({trigger: is_touch_device ? "" : "hover"})
    });
}

function setLanguage(data){
    ajax_All(204,"x",data);
}

function goToPage(data){
    showLoading();
    if (data != "none" && data != "") {
        window.location.href = "/?page="+data;
    } else {
        window.location.href = "/";
    }
}