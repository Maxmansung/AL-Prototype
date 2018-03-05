//THIS IS A TEMPORARY FUNCTION AND WILL BE REPLACED BY ACTUAL ALERTS FROM THE DATABASE
function alertItem(type,title,text,image){
    this.type = type;
    this.title = title;
    this.text = text;
    this.image = image;
}

var alert1 = new alertItem("warning","Testing Alerts!","This is a test alert, please close it","");
var alert2 = new alertItem("happy","More Testing!","This is also a test alert, please keep ignoring it","");
var alertArray = [alert1,alert2];


function createNotifications(){
    var data = alertArray;
    var notificationCount = objectSize(data);
    $("#alertBar .alertWrapper").remove();
    $("#notificationsCounter").empty().append(notificationCount);
    for (var x in data){
        $("#alertBar").append('<div class="row alertWrapper mx-1">'+
            '<div class="alert alert-dark alert-dismissible fade show col-12" role="alert">'+
            '<h4 class="alert-heading">'+data[x].title+'</h4>'+
            data[x].text+
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
            '<span aria-hidden="true">&times;</span>'+
            '</button>'+
            '</div>'+
            '</div>');
    }
}

//This function logs a player out of the game
function logoutButton(){
    ajax_All(199)
}

function goToPage(data){
    if (data != "none" && data != "") {
        window.location.href = "/?page="+data;
    } else {
        window.location.href = "/";
    }
}