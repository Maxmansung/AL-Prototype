var unreadArray = [];
var loopload = setInterval(getAlertSetup, 60000);

function createNotifications(data){
    createUnviewedList(data);
    createNotificationsIcons(data)
}

function createUnviewedList(data){
    var counter = 0;
    for (var x in data){
        if (data[x].alerting == 1){
            counter++;
            unreadArray.push(data[x].alertID);
        }
    }
    $(".notificationsCounter").empty().append(counter);
}


function createNotificationsIcons(data){
    $("#alertBar .alertWrapper").remove();
    for (var x in data){
        $("#alertBar").append('<div class="row alertWrapper mx-1">'+
            '<div class="alert alert-dark alert-dismissible fade show col-12" role="alert">'+
            '<h4 class="alert-heading">'+data[x].title+'</h4>'+
            data[x].alertMessage+
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="closeAlertSystem(this.id)" id="alert++'+data[x].alertID+'">'+
            '<span aria-hidden="true">&times;</span>'+
            '</button>'+
            '</div>'+
            '</div>');
    }
}

function markAsViewed() {
    $(".notificationsCounter").empty().append(0);
    unreadArrayAjax = unreadArray.toString();
    ajax_background(187,0,unreadArrayAjax);
}

function closeAlertSystem(id){
    var finalID = id.slice(7);
    ajax_background(186,0,finalID);
}

function getAlertSetup(){
    ajax_background(0,12,"");
}

//This function logs a player out of the game
function logoutButton(){
    ajax_All(199)
}