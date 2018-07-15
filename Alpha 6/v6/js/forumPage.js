var allThreads = [];
var threadsPage = 0;
var maxPages = 0;
var postsPage = 0;
var maxPostsPages = 0;
var allPosts = [];
var catagory = "";
var numberPerPage = 0;
var numberPerPagePosts = 0;
var threadID = "";

//Change page functions
function goToForum(id){
    window.location.href = "/?page=forum&f="+id;
}

function goToCatagories(){
    window.location.href = "/?page=forum";
}

function getPost(id){
    var newID = id.slice(6);
    window.location.href = "/?page=forum&f="+catagory+"&t="+newID;
}

function phoneBackPost(){
    window.location.href = "/?page=forum&f="+catagory
}

function newThreadButton(){
    window.location.href = "/?page=forum&f="+catagory+"&t=new";
}

//Page load ajax function
function displayPage(){
    catagory = $(".getDataClass").attr('id');
    threadID = $(".getDataClass2").attr('id');
    if (threadID == null) {
        ajax_All(193, 4, catagory,threadsPage);
    } else {
        ajax_All(192,5,catagory,threadsPage,threadID,postsPage);
    }
}

//Load threads from ajax
function saveThreadsData(data){
    allThreads = data;
    numberPerPage = data['maxThreads'];
    maxPages = Math.ceil(data['count']/numberPerPage);
    if (threadsPage === 0) {
        threadsPage = maxPages;
    }
    refreshPageData();
}

//Load posts from ajax
function createPostView(data){
    $(".textBoxPost").hide();
    allPosts = data.posts.postList;
    numberPerPagePosts = data.posts.maxPosts;
    maxPostsPages = Math.ceil(allPosts['count']/numberPerPagePosts);
    if (postsPage === 0) {
        postsPage = maxPostsPages;
    }
    $(".threadTitlePosts").empty().append(data.posts.title);
    saveThreadsData(data.threads);
    makeThreadSelected(threadID);
    createAllPosts();
}

//Load threads with javascript data
function refreshPageData(){
    createStickyThreads();
    createOtherThreads();
    changePageButtons();
}

function createStickyThreads(){
    $(".priorityThreadsBox").empty();
    for (var x in allThreads) {
        if (allThreads[x].stickyThread == 1) {
            threadLayout("priorityThreadsBox", "threadTitleWrap1", allThreads[x])
        }
    }
}

function createOtherThreads(){
    $(".otherThreadsBox").empty();
    for (var x in allThreads) {
        if (allThreads[x].stickyThread != 1) {
            if (x != "count" && x != "maxThreads") {
                threadLayout("otherThreadsBox", "threadTitleWrap2", allThreads[x])
            }
        }
    }
}

function createAllPosts(){
    $("#forumPostAllWrapper").empty();
    for(var x in allPosts) {
        if (x != "count") {
            var postText = convertPostText(allPosts[x].postText);
            postLayoutDisplay(allPosts[x], postText);
        }
    }
    changePostsButtons();
}

function threadLayout(type,background,singleData){
    var newPost = "";
    if (singleData.newPost == true){
        newPost = "font-weight-bold"
    }
    $("."+type).prepend('<div class="row col-12 m-0 p-0 '+background+' clickable" id="thread'+singleData.threadID+'" onclick="getPost(this.id)">' +
        '<div class="col-7 m-0 px-2 threadSingleTitle font-size-2x align-items-center d-flex flex-row">' +
        '<div class="d-flex flex-column"><div class="font-size-2x '+newPost+'">' + singleData.threadTitle + '</div><div class="font-size-2">'+singleData.creatorID+'</div></div>' +
        '</div>' +
        '<div class="col-5 m-0 px-2 threadSingleDetails d-flex flex-column" align="right">' +
        '<div class="font-size-2x">' + singleData.posts + '</div>' +
        '<div class="font-size-1">' +singleData.dateFormat+', by '+ singleData.lastPostBy + '</div>' +
        '</div>' +
        '</div>');
}

function postLayoutDisplay(data,postText){
    var background = "";
    var buttonEdit = "";
    var buttonReport = "";
    if (data.reportedPost === 1){
        background = "redBackgroundTransparent";
        buttonEdit = '<div class="mx-2">|</div><div class="clickableLink mx-2 blackColour font-weight-bold" onclick="modifyPost(this.id)" id="modPost'+data.postID+'">MOD</div>';
    }
    if (data.editable == 1){
        buttonReport = '<div class="mx-2 clickableLink">QUOTE</div><div class="mx-2"> | </div><div class="mx-2 clickableLink" id="'+data.postID+'!+?'+data.creatorID+'" onclick="createReportModal(this.id)">REPORT</div>'
    }
    $("#forumPostAllWrapper").append(
        '<div class="col-12 mt-2 '+background+'" id="forumPostWrap'+data.postID+'">' +
        '<div class="row col-12 align-items-center pr-0">' +
        '<img src="/avatarimages/'+data.avatarImage+'" class="forumPostAvatar">' +
        '<div class="grayBackground col p-2 d-flex flex-row justify-content-between align-items-center">' +
        '<div class="d-flex flex-column">' +
        '<div class="font-weight-bold">'+data.creatorID+'</div>' +
        '<div class="font-size-2">'+data.editable+'</div>' +
        '</div>' +
        '<div class="d-flex flex-column font-size-1">' +
        '<div>'+data.timeFormat+'</div>' +
        '<div>Time posted</div>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '<div class="row font-size-2 blackColour px-4 py-2"><div class="col-12 d-flex flex-row flex-wrap">' +
        postText +
        '</div></div>' +
        '<div class="row font-size-2 justify-content-end grayColour px-4">' +
        buttonReport +buttonEdit+
        '</div>' +
        '</div>')
}

function changePageBack(type){
    if(threadsPage > 1){
        if (type === 1) {
            threadsPage--;
        } else {
            threadsPage = 1;
        }
        displayPage()
    }
}

function changePageForward(type){
    if(threadsPage < maxPages){
        if (type === 1) {
            threadsPage++;
        } else {
            threadsPage = maxPages;
        }
        displayPage()
    }
}

function changePostPageBack(type){
    if(postsPage > 1){
        if (type === 1) {
            postsPage--;
        } else {
            postsPage = 1;
        }
        displayPage()
    }
}

function changePostPageForward(type){
    if(postsPage < maxPostsPages){
        if (type === 1) {
            postsPage++;
        } else {
            postsPage = maxPostsPages;
        }
        displayPage()
    }
}

function changePageButtons(){
    $(".changeThreadsPage").empty();
    if (threadsPage <= 1){
        $(".changeThreadsPage").append(' <div class="grayColour font-size-4 pl-3"><i class="fas fa-angle-double-left mr-4" onclick="changePageBack(0)"></i><i class="fas fa-angle-left" onclick="changePageBack(1)"></i></div>');
    } else {
        $(".changeThreadsPage").append(' <div class="blackColour font-size-4 pl-3"><i class="fas fa-angle-double-left clickableFlash mr-4" onclick="changePageBack(0)"></i><i class="fas fa-angle-left clickableFlash" onclick="changePageBack(1)"></i></div>');
    }
    $(".changeThreadsPage").append("<div class='blackColour'><span>Page: "+(threadsPage)+"/"+(maxPages)+"</span></div>");
    if (threadsPage >= maxPages){
        $(".changeThreadsPage").append('<div class="grayColour font-size-4 pr-3"><i class="fas fa-angle-right" onclick="changePageForward(1)"></i><i class="ml-4 fas fa-angle-double-right" onclick="changePageForward(0)"></i></div>');
    } else {
        $(".changeThreadsPage").append('<div class="blackColour font-size-4 pr-3""><i class="fas fa-angle-right clickableFlash" onclick="changePageForward(1)"></i><i class="ml-4 fas fa-angle-double-right clickableFlash" onclick="changePageForward(0)"></i></div>');
    }
}

function changePostsButtons(){
    $(".forumPostDirectionButtons").empty();
    if (postsPage <= 1){
        $(".forumPostDirectionButtons").append(' <div class="grayColour font-size-4"><i class="fas fa-angle-double-left mr-2" onclick="changePostPageBack(0)"></i><i class="fas fa-angle-left" onclick="changePostPageBack(1)"></i></div>');
    } else {
        $(".forumPostDirectionButtons").append(' <div class="blackColour font-size-4"><i class="fas fa-angle-double-left clickableFlash mr-2" onclick="changePostPageBack(0)"></i><i class="fas fa-angle-left clickableFlash" onclick="changePostPageBack(1)"></i></div>');
    }
    $(".forumPostDirectionButtons").append("<div class='blackColour'><span>Page: "+(postsPage)+"/"+(maxPostsPages)+"</span></div>");
    if (postsPage >= maxPostsPages){
        $(".forumPostDirectionButtons").append('<div class="grayColour font-size-4"><i class="fas fa-angle-right" onclick="changePostPageForward(1)"></i><i class="ml-2 fas fa-angle-double-right" onclick="changePostPageForward(0)"></i></div>');
    } else {
        $(".forumPostDirectionButtons").append('<div class="blackColour font-size-4""><i class="fas fa-angle-right clickableFlash" onclick="changePostPageForward(1)"></i><i class="ml-2 fas fa-angle-double-right clickableFlash" onclick="changePostPageForward(0)"></i></div>');
    }
}

function modifyPost(id){
    var newID = id.slice(7);
    var arrayID = 0;
    for(var x in allPosts){
        if (allPosts[x].postID == newID){
            arrayID = x;
        }
    }
    $(".textBoxPost").show();
    $("#postBoxTextbox").val(allPosts[arrayID].postText);
    $("#postButton").empty().append('<div class="col-12 font-size-2 pb-2" align="center">You are currently editing the post by <div class="font-weight-bold">'+allPosts[arrayID].creatorID+'</div></div><button class="btn btn-dark btn-sm" id="editInfo'+newID+'" onclick="checkEditInformation(this.id)">Edit</button><button class="btn btn-danger btn-sm" id="deleteInfo'+newID+'" onclick="checkDeleteInformation(this.id)">Delete</button>');
}

function showTextBox(){
    $(".textBoxPost").show();
    $("#postBoxTextbox").val("");
    $("#postButton").empty().append('<button class="btn btn-dark btn-sm" onclick="postInformation()">Post</button>');
}

function checkEditInformation(id){
    var newID = id.slice(8);
    var arrayID = 0;
    for(var x in allPosts){
        if (allPosts[x].postID == newID){
            arrayID = x;
        }
    }
    $("#modPostWarning .modal-header").empty().append("Edit post by "+allPosts[arrayID].creatorID);
    $("#modPostWarning .modal-footer").empty().append("<button class='btn btn-dark' data-dismiss='modal' aria-label='Close'>No</button><button class='btn btn-danger' id='e"+id+"' onclick='editInformation(this.id)'>Yes</button>");
    $("#message-text-report").empty();
    $('#modPostWarning').modal({
        backdrop: 'static',
        keyboard: false
    });
}

function editInformation(id){
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
        ajax_All(224,0,catagory,newID,text);
    }
}

function checkDeleteInformation(id){
    var newID = id.slice(10);
    var arrayID = 0;
    for(var x in allPosts){
        if (allPosts[x].postID == newID){
            arrayID = x;
        }
    }
    $("#modPostWarning .modal-header").empty().append("Delete post by "+allPosts[arrayID].creatorID);
    $("#modPostWarning .modal-footer").empty().append("<button class='btn btn-dark' data-dismiss='modal' aria-label='Close'>No</button><button class='btn btn-danger' id='d"+id+"' onclick='deleteInformation(this.id)'>Yes</button>");
    $("#message-text-report").empty();
    $('#modPostWarning').modal({
        backdrop: 'static',
        keyboard: false
    });

}

function deleteInformation(id){
    $('#modPostWarning').modal("hide");
    var newID = id.slice(11);
    var text = "";
    ajax_All(223,0,catagory,newID,text);
}

function postInformation(){
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
        ajax_All(191, 0, catagory, text, threadID);
    }
}

function postNewThread(){
    var title = $("#postTitleCreate").val();
    var type = $("#postTypeCreate").val();
    var sticky = 0;
    if ($("#postStickyCreate").is(':checked') === true){
        sticky = 1;
    }
    var text = $("#postBoxTextbox").val();
    var titleCheck = title.replace(/[^A-Za-z0-9 !?\-_()@:,."]/g, "");
    if (title != titleCheck){
        createAlertBox(0,1,"Please avoid special characters in the title");
    } else if(text.length >= 5000){
        createAlertBox(0,1,"Please try to keep the post shorter than 5000 chars");
    } else if(text.length < 10){
        createAlertBox(0,1,"Your post is too short, please add more");
    } else if(title.length < 4){
        createAlertBox(0,1,"Your title is less than 4 chars");
    } else if(title.length > 50){
        createAlertBox(0,1,"Your title is longer than 50 chars");
    } else {
        console.log(sticky);
        ajax_All(190,0,title,text,catagory,type,sticky);
    }
}

function createReportModal(id){
    var split = id.indexOf("!+?");
    var post = id.slice(0,split);
    var name = id.slice(split+3);
    $("#reportPostBox .modal-header").empty().append("Report post by "+name);
    $("#reportPostBox .modal-footer").empty().append("<button class='btn btn-dark' data-dismiss='modal' aria-label='Close'>Cancel</button><button class='btn btn-danger' id='"+post+"' onclick='postReport(this.id)'>Report Post</button>");
    $("#message-text-report").empty();
    $('#reportPostBox').modal({
        backdrop: 'static',
        keyboard: false
    });
}

function postReport(id){
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
            }
            $('#reportPostBox').modal("hide");
            var finalReport = text2 + ":- " + text;
            ajax_All(189, 0, id, catagory, finalReport);
        }
    }
}

function makeThreadSelected(id){
    $(".threadSelected").removeClass("threadSelected");
    $("#thread"+id).addClass("threadSelected")
}