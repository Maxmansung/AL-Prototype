var allPosts = [];


function getAllNews(){
    var data = "";
    ajax_All(225,13,data);
}

function getSingleNews(){
    var data = $(".getDataClass").attr('id');
    ajax_All(226,13,data);
}

function createNewsOverview(data){
    var size = objectSize(data);
    createNewsPage(data)
}

function openNewsPage(data){
    var newID = data.slice(8);
    window.location.href = "/?page=news&n="+newID;
}

function createSingleNewsPage(data){
    createNewsDetails(data.DATA);
    createComments(data.COMMENT);
    allPosts = data.COMMENT;
}

function createNewsDetails(data){
    $("#newsPageTitle").empty().append(data.title);
    $("#newsPageDate").empty().append(data.day+" "+data.month);
    var text = convertPostText(data.postText);
    $("#newsPageWriting").empty().append(text);
}

function createNewsPage(data){
    console.log(data);
    $("#newsListWrapper").empty();
    for (var x in data){
        $("#newsListWrapper").append("<div class='col-11 row align-items-center justify-content-between rounded py-2 my-2 px-md-5 px-4 newsLinkWrapper' id='newsLink"+data[x].newsID+"' onclick='openNewsPage(this.id)'></div>");
        $("#newsLink"+data[x].newsID).append('<div class="newsDate d-flex flex-column align-items-center"><div><strong>'+data[x].month+'</strong></div><div>'+data[x].day+'</div></div><div class="mr-md-auto mr-0 ml-auto ml-md-4 d-flex flex-column"><div class="font-weight-bold">'+data[x].title+'</div><div class="darkGrayColour font-size-2">By '+data[x].author+'</div></div></div><div class="d-none d-md-block"><i class="far fa-comments"></i>  <span class="blueColour">'+data[x].comments+' </span>'+textNewsComments()+'</div>')
    }
}

function createComments(comments){
    var length = objectSize(comments);
    $("#newsCommentsWrapper").empty();
    if (length > 0){
        for (var x in comments){
            var background = "";
            var buttonEdit = "";
            var buttonReport = "";
            if (comments[x].reported === 1){
                background = "redBackgroundTransparent";
                buttonEdit = '<div class="mx-2">|</div><div class="clickableLink mx-2 blackColour font-weight-bold" onclick="modifyComment(this.id)" id="modPost'+comments[x].commentID+'">MOD</div>';
            }
            if (comments[x].editable == 1){
                buttonReport = '<div class="mx-2 clickableLink">QUOTE</div><div class="mx-2"> | </div><div class="mx-2 clickableLink" id="'+comments[x].commentID+'!+?'+comments[x].creatorID+'" onclick="createReportModalNews(this.id)">REPORT</div>'
            }
            var postText = convertPostText(comments[x].commentText);
            $("#newsCommentsWrapper").append(
                '<div class="col-11 mt-2 '+background+'" id="forumPostWrap'+comments[x].commentID+'">' +
                '<div class="row col-12 align-items-center pr-0">' +
                '<img src="/avatarimages/'+comments[x].avatarImage+'" class="forumPostAvatar">' +
                '<div class="grayBackground col p-2 d-flex flex-row justify-content-between align-items-center">' +
                '<div class="d-flex flex-column">' +
                '<div class="font-weight-bold">'+comments[x].authorID+'</div>' +
                '<div class="font-size-2">'+comments[x].authorDetails+'</div>' +
                '</div>' +
                '<div class="d-flex flex-column font-size-1">' +
                '<div>Time posted</div>' +
                '<div>'+comments[x].editedDate+'</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div class="row font-size-2 blackColour px-4 py-2"><div class="col-12">' +
                postText +
                '</div></div>' +
                '<div class="row font-size-2 justify-content-end grayColour px-4">' +
                buttonReport +buttonEdit+
                '</div>' +
                '</div>')
        }
    } else {
        $("#newsCommentsWrapper").append("<div class='grayColour col-12 py-3' align='center'>No comments currently</div>")
    }
}

function postComment(){
    var data = $(".getDataClass").attr('id');
    var text = $("#postBoxTextbox").val();
    var check = true;
    if(text.length < 10){
        createAlertBox(0,1,"Your post is too short, please add more");
        check = false;
    }
    if(text.length > 5000){
        createAlertBox(0,1,"That is a very lengthy message, please try to shorten it");
        check = false;
    }
    if (check === true) {
        ajax_All(185,0,data,text);
    }
}

function createReportModalNews(id){
    var split = id.indexOf("!+?");
    var post = id.slice(0,split);
    var name = id.slice(split+3);
    $("#reportPostBox .modal-header").empty().append("Report post by "+name);
    $("#reportPostBox .modal-footer").empty().append("<button class='btn btn-dark' data-dismiss='modal' aria-label='Close'>Cancel</button><button class='btn btn-danger' id='"+post+"' onclick='postReportComment(this.id)'>Report Post</button>");
    $("#message-text-report").empty();
    $('#reportPostBox').modal({
        backdrop: 'static',
        keyboard: false
    });
}

function postReportComment(id){
    var text = _("message-text-report").value;
    var text2 = _("selectComplaint").value;
    textchange = text.replace(/[^a-zA-Z0-9!?"' .,;:()]/g, "");
    if (textchange != text){
        $("#message-text-report").addClass("is-invalid");
        $("#report-error").empty().append("Please avoid special characters");
    } else {
        if (textchange.length > 500){
            $("#message-text-report").addClass("is-invalid");
            $("#report-error").empty().append("Please use 500 char or less");

        } else {
            if (textchange.length < 4){
                $("#message-text-report").addClass("is-invalid");
                $("#report-error").empty().append("Please give some detail");
            } else {
            $('#reportPostBox').modal("hide");
            var finalReport = text2 + ":- " + text;
            ajax_All(184, 0, id, finalReport);
            }
        }
    }

}


function modifyComment(id){
    var newID = id.slice(7);
    var arrayID = 0;
    console.log(allPosts);
    for(var x in allPosts){
        if (allPosts[x].commentID == newID){
            arrayID = x;
        }
    }
    $("#showPostMessage").collapse();
    $("#postBoxTextbox").val(allPosts[arrayID].commentText);
    $("#postButton").empty().append('<div class="col-12 font-size-2 pb-2" align="center">You are currently editing the post by <div class="font-weight-bold">'+allPosts[arrayID].authorID+'</div></div><button class="btn btn-dark btn-sm" id="editInfo'+newID+'" onclick="checkEditComment(this.id)">Edit</button><button class="btn btn-danger btn-sm" id="deleteInfo'+newID+'" onclick="checkDeleteComment(this.id)">Delete</button>');
}

function checkEditComment(id){
    var newID = id.slice(8);
    var arrayID = 0;
    for(var x in allPosts){
        if (allPosts[x].commentID == newID){
            arrayID = x;
        }
    }
    $("#modPostWarning .modal-header").empty().append("Edit post by "+allPosts[arrayID].authorID);
    $("#modPostWarning .modal-footer").empty().append("<button class='btn btn-dark' data-dismiss='modal' aria-label='Close'>No</button><button class='btn btn-danger' id='e"+id+"' onclick='editComment(this.id)'>Yes</button>");
    $("#message-text-report").empty();
    $('#modPostWarning').modal({
        backdrop: 'static',
        keyboard: false
    });
}

function editComment(id){
    $('#modPostWarning').modal("hide");
    var newID = id.slice(9);
    var text = $("#postBoxTextbox").val();
    var check = true;
    if(text.length < 10){
        createAlertBox(0,1,"Your post is too short, please add more");
        check = false;
    }
    if(text.length > 5000){
        createAlertBox(0,1,"That is a very lengthy message, please try to shorten it");
        check = false;
    }
    if (check === true){
        ajax_All(228,0,newID,text);
    }
}

function checkDeleteComment(id){
    var newID = id.slice(10);
    var arrayID = 0;
    for(var x in allPosts){
        if (allPosts[x].commentID == newID){
            arrayID = x;
        }
    }
    $("#modPostWarning .modal-header").empty().append("Delete post by "+allPosts[arrayID].authorID);
    $("#modPostWarning .modal-footer").empty().append("<button class='btn btn-dark' data-dismiss='modal' aria-label='Close'>No</button><button class='btn btn-danger' id='d"+id+"' onclick='deleteComment(this.id)'>Yes</button>");
    $("#message-text-report").empty();
    $('#modPostWarning').modal({
        backdrop: 'static',
        keyboard: false
    });

}

function deleteComment(id){
    $('#modPostWarning').modal("hide");
    var newID = id.slice(11);
    var text = "";
    ajax_All(227,0,newID,text);
}