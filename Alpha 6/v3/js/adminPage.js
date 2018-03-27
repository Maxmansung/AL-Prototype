var allNews = [];
var edited = 0;

function selectPage(id){
    window.location.href = "/?page=admin&a="+id;
}

function postNews(visibiility){
    var title = $("#newNewsPost #newsTitle").val();
    var text = $("#newNewsPost .postBoxTextbox").val();
    if (title.length < 3){
        errors(128);
    } else if (title.length > 30){
        errors(129);
    } else if (text.length < 10){
        errors(130);
    } else {
        ajax_All(205, 0, title, text, visibiility);
    }
}

function editNews(visibiility){
    var title = $("#oldNewsPost #newsTitle").val();
    var text = $("#oldNewsPost .postBoxTextbox").val();
    if (title.length < 3){
        errors(128);
    } else if (title.length > 30){
        errors(129);
    } else if (text.length < 10){
        errors(130);
    } else {
        ajax_All(207, 0, title, text, visibiility,edited);
    }
}

function getAllNewsEdit(){
    ajax_All(206,6);
}

function createNewsEditPage(data){
    allNews = data;
    $("#oldNewsPostWrapper").empty();
    for (var x in allNews){
        if (allNews[x].visible == 1){
            singleNewsLine(allNews[x],"Live")
        } else {
            singleNewsLine(allNews[x],"Draft")
        }
    }
}

function singleNewsLine(data,background){
    $("#oldNewsPostWrapper").append('<div class="row newsLink'+background+' mt-2 py-2">' +
        '<div class="col">' +
        '<span class="font-size-2x font-weight-bold">'+data.title +'</span><span class="darkGrayColour pl-2">('+background+')</span>'+
        '</div>' +
        '<div class="col-auto d-flex flex-row justify-content-around align-items-center">' +
        '<button class="btn btn-dark btn-sm mx-2" id="'+data.newsID+'+!edit" onclick="editNewsPost(this.id)">Edit</button>' +
        '<button class="btn btn-danger btn-sm mx-2" id="'+data.newsID+'+!delete" onclick="deleteNewsPost(this.id)">Delete</button> ' +
        '</div></div>')
}

function editNewsPost(id){
    var count = id.indexOf("+!");
    edited = id.slice(0,count);
    var final = 0;
    for (var test in allNews){
        if (allNews[test].newsID === edited){
            final = test;
        }
    }
    $("#oldNewsPost").collapse();
    $("#oldNewsPost #newsTitle").empty().val(allNews[final].title);
    $("#oldNewsPost .postBoxTextbox").empty().val(allNews[final].postText);
}

function deleteNewsPost(id){
    var count = id.indexOf("+!");
    edited = id.slice(0,count);
    createAlertBox(4,1,"Are you sure you want to delete this post?",2,"deletePostFinal");
}

function deletePostFinal(){
    ajax_All(208,0,edited);
}

function createNewMap(){
    $("#createMapName").removeClass("is-invalid");
    $("#createMapPlayers").removeClass("is-invalid");
    $("#createMapEdge").removeClass("is-invalid");
    $("#createMapType").removeClass("is-invalid");
    var title = $("#createMapName").val();
    var players = $("#createMapPlayers").val();
    var size = $("#createMapEdge").val();
    var type = $('input[name=createMapType]:checked').val();
    var titleClean = title.replace(/[^a-zA-Z0-9 -]/g, "");
    if (players == 0){
        var playersClean = 0;
    } else {
        var playersClean = parseInt(players);
    }
    if (size == 0){
        var sizeClean = 0;
    } else {
        var sizeClean = parseInt(size);
    }
    var posting = true;
    if (title !== titleClean){
        posting = false;
        $("#mapNameError").empty().append("Please dont use special characters");
        $("#createMapName").addClass("is-invalid");
    } else if (titleClean.length > 20){
        posting = false;
        $("#mapNameError").empty().append("Titles need to be less than 20 characters");
        $("#createMapName").addClass("is-invalid");
    }
    if (playersClean > 40 || playersClean <1){
        posting = false;
        $("#playerCountError").empty().append("Players must be 1-40");
        $("#createMapPlayers").addClass("is-invalid");
    }
    if (sizeClean > 30 || sizeClean < 3){
        posting = false;
        $("#edgeSizeError").empty().append("Size must be 3-30");
        $("#createMapEdge").addClass("is-invalid");
    }
    if (type !== "full" && type !== "check"){
        posting = false;
        $("#gameTypeError").empty().append("Please select one of the options");
        $("#createMapType").addClass("is-invalid");
    }
    if (posting === true){
        ajax_All(209,0,titleClean,playersClean,sizeClean,type)
    }
}