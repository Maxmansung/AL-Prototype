///////////FORUM PAGE JAVASCRIPT///////////

var postList = [];
var countNum = 1;

function ajax_getForum(type, data){
    $("#loadingscreen").css("visibility", "visible");
    var hr = new XMLHttpRequest();
    hr.open("POST", "/MVC/ajax_php/forum_ajax.php", true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function () {
        if (hr.readyState == 4 && hr.status == 200) {
            var response = JSON.parse(hr.responseText);
            console.log(response);
            if ("ERROR" in response){
                console.log(response.ERROR);
                errors(response.ERROR);
            } else {
                if (type === "main") {
                    addCategories(response);
                } else if (type === "thread"){
                    addThreads(response.threads);
                    changeForumTitle(response.title);
                    addOverview();
                } else if (type === "new"){
                    newPostPost(response.threadID);
                } else if (type === "post"){
                    location.reload();
                } else if(type === "fetch"){
                    displayPostsSetup(response.threads)
                }
            }
            $("#loadingscreen").css("visibility", "hidden");
        }
    };
    hr.send("type="+type+"&data="+data);
}

function addCategories(list){
    $("#forumCategories").empty();
    for(var item in list){
        if (list[item].accessType == true) {
            $("#forumCategories").append("<div class='categoryLink' id='" + item + "'>" +
                "<div class='categoryTitle'>" + list[item].catagoryName + "</div>" +
                "<div class='categoryFlavour'>" + list[item].flavourText + "</div></div>");
            if (list[item].newPosts === true){
                $("#"+item+" .categoryTitle").after("<div class='newPostImage'><img src='/images/newPost.png'></div>")
            }
            $("#" + item).click(function () {
                window.location = "/forum.php?p=" + this.id;
            });
        } else {
            $("#forumCategories").append("<div class='categoryLink' id='" + item + "'>" +
                "<div class='categoryTitle'><del>" + list[item].catagoryName + "</del></div>" +
                "<div class='categoryFlavour'>No access at this time</div></div>");
        }
    }
}

function addThreads(list){
    $("#forumThreadList").empty();
    for (var thread in list){
        var playerLink = "";
        if (list[thread].creatorID != "Unknown") {
            playerLink = "<a class='creatorNameLink' href='/user.php?u=" + list[thread].creatorID + "'> " + list[thread].creatorID + "</a>";
        } else {
            playerLink = list[thread].creatorID;
        }
        $("#forumThreadList").prepend("<div class='singleThread' id='thread" + list[thread].threadID + "'><div class='singleThreadHorizontal'>" +
            "<div class='singleThreadTitle' id='" + list[thread].threadID + "' onclick='getThreadPosts(this.id)'>" + list[thread].threadTitle + "</div>" +
            "<div class='lastPostCreator'>Last Post:<strong> N/A</strong></div>" +
            "</div><div class='singleThreadHorizontal'><div class='singleThreadCreator'>" +
            playerLink+"</div>" +
            "<span class='totalPostsDetail'>Total: "+ list[thread].posts +"</span></div></div>");
        if (list[thread].newPost === true){
            $("#"+list[thread].threadID).css("color","rgba(255,0,0,1");
        }
    }
}

function writeNewThread(){
    $("#forumThreadDetails").empty()
        .append("<div id='newThreadWrapper'><div id='newThreadTitle'><div id='newThreadInstruct'>Title:</div>" +
            "<input id='newThreadTitleInput' type='text' maxlength='50' ></div>" +
            "<div id='postReplyView'></div>"+
            "<div id='wrapTextFormatting'>" +
            "<div id='textSmilesButton' class='textPremadeButton' onclick='showFormatting(this.id)'>Smiles</div>" +
            "<div id='textFormatButton' class='textPremadeButton' onclick='showFormatting(this.id)'>Format</div>" +
            "</div>"+
            "<div id='iconsShowWrap'></div>"+
            "<div id='newThreadPost'><textarea rows='20' maxlength='5000' id='newPostText' onkeyup='updateDisplay()'></textarea>" +
            "<div id='newPostInstruct'>Max 5000 characters</div></div>" +
            "<div id='postThreadButton' onclick='newThread()'>Post</div></div>");
}

function newThread() {
    var title = $("#newThreadTitleInput").val();
    var post = $("#newPostText").val();
    if (title.length > 50) {
        alert("Please keep the title less than 50 chars")
    } else if (title.length < 4) {
        alert("Please make the title longer than 4 chars")
    } else if (checkInput(title) == true) {
        alert("Please avoid special characters in the title")
    } else if (post.length < 1){
        alert("Please post longer than 10 chars")
    } else if (post.length >5000){
        alert("Please keep posts below 5000 chars")
    } else if (checkInput(title) == true){
        alert("Please avoid special characters in the post")
    } else{
        newThreadPost(title);
    }
}

function changeForumTitle(title){
    $("#forumThreadTitle").empty()
        .append(title);
}

function newThreadPost(title){
    var data = $("#forumTypeID").text();
    var post = $("#newPostText").val();
    $length = post.length;
    data += "&title="+title+"&length="+$length;
    ajax_getForum("new",data);
}

function newPostPost(threadID){
    var post = $("#newPostText").val();
    var data = $("#forumTypeID").text();
    var final = data+"&post="+encodeURIComponent(post)+"&thread="+threadID;
    ajax_getForum("post",final);
}

function addOverview(){
}

function checkInput(input) {
    var pattern = new RegExp(/[^a-z1-9!?:;@,.\-_+%()'"%$£#~|¬ ]/mi); //unacceptable chars
    return pattern.test(input);
}

function getThreadPosts(threadID){
    $("#"+threadID).css("color","rgba(0,0,0,1");
    var data = $("#forumTypeID").text();
    data = data+"&thread="+threadID;
    ajax_getForum("fetch",data);
}

function displayPosts(){
    $("#forumThreadPostsList").empty();
    var length = objectSize(postList);
    var current = 0;
    var start = 0;
    if (length > (5*countNum)){
        current = 5*countNum;
    } else {
        current = length;
    }
    if (length < (5*(countNum-1))){
        start = 0;
    } else {
        start = 5*(countNum-1);
    }
    for (var x = start; x<current; x++){
        var formattedText = getTextFormatting(postList[x].postText);
        var classType = "forumPostDetails";
        if (postList[x].newPost === true){
            classType = "forumPostDetailsNew";
        }
        if (postList[x].creatorID != "Unknown") {
            $("#forumThreadPostsList").append("<div class='forumPostWrap'><div class='"+classType+"'>" +
                "<div class='forumPostHeightWrapDetails'><div class='forumPostProfilePic'>" +
                "<img src='/avatarimages/" + postList[x].avatarImage + "' id='userCardImageFile'></div>" +
                "<div class='forumPostProfileName'>" +
                "<a href='/user.php?u=" + postList[x].creatorID + "'> " + postList[x].creatorID + "</a></div>" +
                "<div class='forumPostDate'>" + postList[x].timeFormat + "</div></div></div>" +
                "<div class='forumPostTextWrap'><div class='forumPostHeightWrapText'>" +
                "" + formattedText + "</div></div></div>");
        } else {
            $("#forumThreadPostsList").append("<div class='forumPostWrap'><div class='"+classType+"'>" +
                "<div class='forumPostHeightWrapDetails'><div class='forumPostProfilePic'>" +
                "<img src='/avatarimages/" + postList[x].avatarImage + "' id='userCardImageFile'></div>" +
                "<div class='forumPostProfileName'>" + postList[x].creatorID + "</div>" +
                "<div class='forumPostDate'>" + postList[x].timeFormat + "</div></div></div>" +
                "<div class='forumPostTextWrap'><div class='forumPostHeightWrapText'>" +
                "" + formattedText + "</div></div></div>");
        }
    }
    $("#postReplyWrap").hide();
    $("#postReplyView").hide();
    $("#iconsShowWrap").hide();
    $(".replyButtonPost").empty().append("Reply").attr("onclick","showReply()");
    $("#pageNumber").empty().append((start+1)+" - "+current+" of<strong> "+length+"</strong>");
}

function showReply(){
    $("#postReplyWrap").show();
    $("#postReplyView").show();
    $(".replyButtonPost").empty().append("Submit").attr("onclick","replyToPost(this.id)");
}

function replyToPost(postID){
    var counter = postID.indexOf("?!");
    var data = $("#forumTypeID").text();
    var threadID = postID.slice(counter+2,postID.length);
    var post = $("#newPostText").val();
    if (post.length < 10){
    alert("Please post longer than 10 chars")
    } else if (post.length >5000) {
        alert("Please keep posts below 5000 chars")
    } else {
        var final = data + "&post=" + encodeURIComponent(post) + "&thread=" + threadID;
        ajax_getForum("post", final);
    }
}

function displayPostsSetup(usersArray){
    postList = usersArray;
    var length = objectSize(postList);
    countNum = Math.ceil(length/5);
    $("#foundPlayersListWrapper").show();
    $("#forumThreadDetails").empty().append("<div id='forumThreadPostsList'></div>" +
        "<div id='directionalButtonWrapper' class='horizontalWrap'>" +
        "<button id='less' onclick='displayPostsLess()'>back</button>"+
        "<span id='pageNumber'>"+
        "</span>"+
        "<button id='more' onclick='displayPostsMore()'>more</button>"+
        "</div>"+
        "<div id='postReplyView'></div>"+
        "<div id='postReplyWrap'>" +
        "<div id='wrapTextFormatting'>" +
        "<div id='textSmilesButton' class='textPremadeButton' onclick='showFormatting(this.id)'>Smiles</div>" +
        "<div id='textFormatButton' class='textPremadeButton' onclick='showFormatting(this.id)'>Format</div>" +
        "</div>"+
        "<div id='iconsShowWrap'></div>"+
        "<textarea rows='10' maxlength='5000' id='newPostText' onkeyup='updateDisplay()'></textarea>" +
        "<div id='newPostInstruct'>Max 5000 characters</div></div>" +
        "<div class='replyButtonPost' id=?!"+postList[0].threadID+"' onclick='showReply()'>Reply</div>");
    displayPosts();
}

function updateDisplay(){
    var post = $("#newPostText").val();
    var text = getTextFormatting(post);
    $("#postReplyView").empty().append(text);
}

function displayPostsMore(){
    var length = objectSize(postList);
    if (length >(countNum*5)){
        countNum++
    }
    displayPosts()
}

function displayPostsLess(){
    if (countNum > 1){
        countNum--;
    }
    displayPosts()
}

function showFormatting(id){
    $("#iconsShowWrap").empty().show();
    if (id === "textSmilesButton"){
        for (var x in emojiArray){
            $("#iconsShowWrap").append("<div class='formatTextIcon' id='"+emojiArray[x].key+"' onclick='insertText(this.id)'><img class='formatTextImage' src='"+emojiArray[x].src+"'><span class='formatTextWriting'>"+emojiArray[x].text+"</span></div>");
        }
    } else if (id === "textFormatButton"){
        for (var x in formatArray) {
            $("#iconsShowWrap").append("<div class='formatTextIcon' id='" + formatArray[x].key + "' onclick='insertText(this.id)'><div class='formatTextType'>"+formatArray[x].text+"</div></div>");
        }
    }
}

function insertText(text){
    $("#newPostText").append(text);
    updateDisplay();
}