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
            //console.log(hr.responseText);
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


function switchArray(type,response){
    console.log("Type: "+type);
    type = parseInt(type);
    switch(type){
        case 35:
            showProfilePage(response.view);
            break;
        case 38:
            createSearchResults(response.view);
            break;
        case 49:
            createNews(response.view);
            break;
        case 192:
            createPostViewPhone(response.view);
            break;
        case 193:
            saveThreadsData(response.view);
            break;
        case 198:
            window.location.reload();
            break;
        default:
            console.log("Error Unknown");
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

function showLoading(){
    $("#loadingScreen2").show("1000");
}

function activateTooltips() {
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
}