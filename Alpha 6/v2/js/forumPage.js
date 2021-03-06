var allThreads = [];
var threadsPage = 0;
var maxPages = 0;
var postsPage = 0;
var maxPostsPages = 0;
var allPosts = [];
var catagory = "";
var numberPerPage = 10;
var numberPerPagePosts = 10;
var threadID = "";

function goToForum(id){
    window.location.href = "/?page=forum&f="+id;
}

function goToCatagories(){
    window.location.href = "/?page=forum";
}

function displayPage(){
    catagory = $(".getDataClass").attr('id');
    ajax_All(193,4,catagory);
}

function saveThreadsData(data){
    allThreads = data;
    $("#forumThreadSelectPhone").show();
    $("#forumThreadPostPhone").hide();
    $("#forumNewThreadPhone").hide();
    $("#forumRulesLarge").show();
    $("#forumNewThread").hide();
    $("#forumThreadsPost").hide();
    refreshPageData();
}

function refreshPageData(){
    createStickyThreads();
    createOtherThreads();
    changePageButtons();
}

function createStickyThreads(){
    $(".priorityThreadsBox").empty();
    var alternate1 = 1;
    for (var x in allThreads) {
        var background = "";
        if (allThreads[x].stickyThread == 1) {
            if (alternate1 === 1) {
                background = "threadTitleWrap1";
                alternate1 = 0
            } else {
                background = "threadTitleWrap2";
                alternate1 = 1
            }
            threadLayout("priorityThreadsBox",background,allThreads[x])
        }
    }
}

function createOtherThreads(){
    $(".otherThreadsBox").empty();
    var alternate1 = 1;
    var counter = 0;
    var background = "";
    maxPages = Math.ceil((objectSize(allThreads))/numberPerPage)-1;
    for (var x in allThreads) {
        if (allThreads[x].stickyThread != 1) {
            counter++;
            if (counter >= numberPerPage * threadsPage && counter < numberPerPage * (threadsPage + 1)) {
                if (alternate1 === 1) {
                    background = "threadTitleWrap1";
                    alternate1 = 0
                } else {
                    background = "threadTitleWrap2";
                    alternate1 = 1
                }
                threadLayout("otherThreadsBox", background, allThreads[x])
            }
        }
    }
}

function threadLayout(type,background,singleData){
    $("."+type).prepend('<div class="row col-12 m-0 p-0 ' + background + ' clickable" id="'+singleData.threadID+'" onclick="getPost(this.id)">' +
        '<div class="col-7 m-0 px-2 threadSingleTitle font-size-2x align-items-center d-flex flex-row">' +
        '<div class="">' + singleData.threadTitle + '</div>' +
        '</div>' +
        '<div class="col-5 m-0 px-2 threadSingleDetails d-flex flex-column" align="right">' +
        '<div class="font-size-2x">' + singleData.posts + '</div>' +
        '<div class="font-size-2 grayColour">' + singleData.creatorID + '</div>' +
        '</div>' +
        '</div>');
}

function changePageBack(type){
    if(threadsPage > 0){
        if (type === 1) {
            threadsPage--;
        } else {
            threadsPage = 0;
        }
        refreshPageData();
    }
}

function changePageForward(type){
    if(threadsPage < maxPages){
        if (type === 1) {
            threadsPage++;
        } else {
            threadsPage = maxPages;
        }
        refreshPageData();
    }
}

function changePostPageBack(type){
    if(postsPage > 0){
        if (type === 1) {
            postsPage--;
        } else {
            postsPage = 0;
        }
        createAllPosts();
    }
}

function changePostPageForward(type){
    if(postsPage < maxPostsPages){
        if (type === 1) {
            postsPage++;
        } else {
            postsPage = maxPostsPages;
        }
        createAllPosts();
    }
}

function changePageButtons(){
    $(".changeThreadsPage").empty();
    if (threadsPage <= 0){
        $(".changeThreadsPage").append(' <div class="grayColour font-size-4 pl-3"><i class="fas fa-angle-double-left mr-4" onclick="changePageBack(0)"></i><i class="fas fa-angle-left" onclick="changePageBack(1)"></i></div>');
    } else {
        $(".changeThreadsPage").append(' <div class="blackColour font-size-4 pl-3"><i class="fas fa-angle-double-left clickableFlash mr-4" onclick="changePageBack(0)"></i><i class="fas fa-angle-left clickableFlash" onclick="changePageBack(1)"></i></div>');
    }
    $(".changeThreadsPage").append("<div class='blackColour'><span>Page: "+(threadsPage+1)+"/"+(maxPages+1)+"</span></div>");
    if (threadsPage >= maxPages){
        $(".changeThreadsPage").append('<div class="grayColour font-size-4 pr-3"><i class="fas fa-angle-right" onclick="changePageForward(1)"></i><i class="ml-4 fas fa-angle-double-right" onclick="changePageForward(0)"></i></div>');
    } else {
        $(".changeThreadsPage").append('<div class="blackColour font-size-4 pr-3""><i class="fas fa-angle-right clickableFlash" onclick="changePageForward(1)"></i><i class="ml-4 fas fa-angle-double-right clickableFlash" onclick="changePageForward(0)"></i></div>');
    }
}

function changePostsButtons(){
    $(".forumPostDirectionButtons").empty();
    if (postsPage <= 0){
        $(".forumPostDirectionButtons").append(' <div class="grayColour font-size-4 pl-3"><i class="fas fa-angle-double-left mr-4" onclick="changePostPageBack(0)"></i><i class="fas fa-angle-left" onclick="changePostPageBack(1)"></i></div>');
    } else {
        $(".forumPostDirectionButtons").append(' <div class="blackColour font-size-4 pl-3"><i class="fas fa-angle-double-left clickableFlash mr-4" onclick="changePostPageBack(0)"></i><i class="fas fa-angle-left clickableFlash" onclick="changePostPageBack(1)"></i></div>');
    }
    $(".forumPostDirectionButtons").append("<div class='blackColour'><span>Page: "+(postsPage+1)+"/"+(maxPostsPages+1)+"</span></div>");
    if (postsPage >= maxPostsPages){
        $(".forumPostDirectionButtons").append('<div class="grayColour font-size-4 pr-3"><i class="fas fa-angle-right" onclick="changePostPageForward(1)"></i><i class="ml-4 fas fa-angle-double-right" onclick="changePostPageForward(0)"></i></div>');
    } else {
        $(".forumPostDirectionButtons").append('<div class="blackColour font-size-4 pr-3""><i class="fas fa-angle-right clickableFlash" onclick="changePostPageForward(1)"></i><i class="ml-4 fas fa-angle-double-right clickableFlash" onclick="changePostPageForward(0)"></i></div>');
    }
}

function postLayoutPhone(data,postText){
    $("#forumPostAllWrapperPhone").append('<div class="row col-12 p-0 m-0 my-2 forumPostWrapper blackColour justify-content-center">'+
        '<div class="row col-12 px-3 m-0 my-1 justify-content-between font-size-2">'+
        '<img src="/avatarimages/'+data.avatarImage+'" class="forumPostAvatar">'+
        '<div class="d-flex flex-column font-size-2 justify-content-between">'+
        '<div class="font-weight-bold">'+data.creatorID+'</div>'+
    '<div class="font-size-2">'+data.timeFormat+'</div>'+
    '</div>'+
    '</div>'+
    '<div class="row col-12 px-2 pt-0 pb-1 font-size-2 justify-content-center">'+
        '<div class="col-12 px-1 forumPostText">'+
        postText+
    '</div>'+
    '</div>'+
    '</div>')
}

function postLayoutLarge(data,postText){
    $("#forumPostAllWrapperLarge").append('<div class="row col-12 mt-2 forumPostWrapper blackColour">'+
        '<div class="col-4 d-flex flex-column justify-content-center align-items-center font-size-2 p-0">'+
        '<img src="/avatarimages/'+data.avatarImage+'" class="forumPostAvatar m-2">'+
        '<div class="font-weight-bold">'+data.creatorID+'</div>'+
    '<div class="font-size-2">'+data.timeFormat+'</div>'+
    '</div>'+
    '<div class="col-8 forumPostText font-size-2">'+
        postText+
    '</div>'+
    '</div>')
}

function createAllPosts(){
    $("#forumPostAllWrapperLarge").empty();
    $("#forumPostAllWrapperPhone").empty();
    var counter = 0;
    for(var x in allPosts){
        if (counter >= numberPerPagePosts * postsPage && counter < numberPerPagePosts * (postsPage + 1)) {
            var postText = convertPostText(allPosts[x].postText);
            postLayoutLarge(allPosts[x],postText);
            postLayoutPhone(allPosts[x],postText);
        }
        counter++;
    }
    changePostsButtons()
}

function getPost(id){
    threadID = id;
    ajax_All(192,5,catagory,id);
}

function phoneBackPost(){
    $("#forumThreadSelectPhone").show();
    $("#forumThreadPostPhone").hide();
    $("#forumNewThreadPhone").hide();
    $("#forumRulesLarge").show();
    $("#forumThreadsPost").hide();
    $("#forumNewThread").hide();
}

function createPostViewPhone(data){
    $("#forumThreadSelectPhone").hide();
    $("#forumThreadPostPhone").show();
    $("#forumNewThreadPhone").hide();
    $("#forumRulesLarge").hide();
    $("#forumNewThread").hide();
    $("#forumThreadsPost").show();
    $(".textBoxPost").hide();
    allPosts = data.threads;
    maxPostsPages = Math.ceil((objectSize(allPosts))/numberPerPagePosts)-1;
    postsPage = maxPostsPages;
    $(".threadTitlePosts").empty().append(data.title);
    createAllPosts();
}

function newThreadButton(){
    $("#forumThreadSelectPhone").hide();
    $("#forumThreadPostPhone").hide();
    $("#forumNewThreadPhone").show();
    $("#forumRulesLarge").hide();
    $("#forumThreadsPost").hide();
    $("#forumNewThread").show();
}

function showTextBox(){
    $(".textBoxPost").show();
    $("#postButtonLarge").empty().append('<button class="btn btn-dark btn-sm" onclick="postInformationLarge()">Post</button>');
    $("#postButtonPhone").empty().append('<button class="btn btn-dark btn-sm" onclick="postInformationPhone()">Post</button>');
}

function postInformationLarge(){
    var text = $("#textBoxPostLarge .postBoxTextbox").val();
    postInformation(text);
}

function postInformationPhone(){
    var text = $("#textBoxPostPhone .postBoxTextbox").val();
    postInformation(text);
}

function postInformation(text){
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

function createThreadLarge(){
    var thing = "#forumNewThread";
    postNewThread(thing)
}

function createThreadPhone(){
    var thing = "#forumNewThreadPhone";
    postNewThread(thing)
}

function postNewThread(classType){
    var title = $(classType+" #postTitleCreate").val();
    var type = $(classType+" #postTypeCreate").val();
    var sticky = 0;
    if ($(classType+" #postStickyCreate").is(':checked') === true){
        sticky = 1;
    }
    var text = $(classType+" .postBoxTextbox").val();
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
        ajax_All(190,0,title,text,catagory,type,sticky);
    }
}









//THESE ARE THE EMOJI AND TEXT FORMATTING OBJECTS, MORE CAN BE ADDED HERE


function emoji(src,text,key){
    this.src = src;
    this.text = text;
    this.key = key;
}

function textFormat(start,end,key,text){
    this.start = start;
    this.end = end;
    this.key = key;
    this.text = text;
}


//These are all of the emoji images
var smileEmoji = new emoji("https://discordapp.com/assets/4f22736614151ae463b63a5a78aac9d9.svg","Smile Emoji","##smile");
var frownEmoji = new emoji("https://discordapp.com/assets/3b32193b9673582d2704e53ec1056b6e.svg","Frown Emoji","##frown");
var cryEmoji = new emoji("https://discordapp.com/assets/4dc13fd52f691020a1308c5b6cbc6f49.svg","Cry Emoji","##cry");
var emojiArray = [smileEmoji,frownEmoji,cryEmoji];


//These are all the different ways to format text
var bold = new textFormat("<strong>","</strong>","**","Bold");
var italic = new textFormat("<i>","</i>","//","Italics");
var roleplay = new textFormat("<div class='roleplayTextFormat'>","</div>","^^","Roleplay");
var formatArray = [bold,italic,roleplay];



function convertPostText(text){
    var final = text.replace(/[\n\r]/g,"<br/>");
    final = getAllTextStyles(final);
    final = getAllSmiles(final);
    return final;
}

function getAllTextStyles(text){
    var final = text;
    var length = formatArray.length;
    for (var x = 0; x<length;x++){
        final = formatTextType(final,formatArray[x]);
    }
    return final;
}

function getAllSmiles(text){
    var final = text;
    var length = emojiArray.length;
    for (var x = 0; x<length;x++) {
        final = addSmileType(final, emojiArray[x]);
    }
    return final;
}

function formatTextType(text,format){
    var alternate = false;
    var checker = true;
    var newText = text;
    while (checker === true){
        if (alternate === false) {
            newText = text.replace(format.key, format.start);
        } else {
            newText = text.replace(format.key, format.end);
        }
        if (newText === text){
            checker = false;
        } else {
            text = newText;
        }
        alternate = alternate !== true;
    }
    return newText;
}

function addSmileType(text,emoji){
    var pattern = new RegExp(emoji.key,"g");
    final = text.replace(pattern,"<img src='"+emoji.src+"' class='textImageEmoji' title='"+emoji.text+"'>");
    return final;
}