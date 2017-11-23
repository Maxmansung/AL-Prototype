function chatbox(actions, chat, other){
    this.actions = actions;
    this.chat = chat;
    this.other = other;
}

function createchatboxes(){
    var maptotal = mapsize * mapsize;
    for (x=0;x<=maptotal;x++){
        chatbox[x]=new chatbox([],[],[]);
    }
}

function chatboxrefresh(){
    var userlocation = ((((user[username1].yaxis-1)*mapsize)+user[username1].xaxis)-1);
    $("#chatbox").empty();
    for (x=0;x<chatbox[userlocation].actions.length;x++) {
        $("#chatbox").append("<div class='chatdivwrapper'>"+chatbox[userlocation].actions[x]+"</div>");
    }
}

function submittext(){
    var test = document.getElementById("inputchat").value;
    var writing = "<strong>Player-"+username1+" said: </strong>"+test;
    if (test !== "") {
        var userlocation = ((((user[username1].yaxis-1)*mapsize)+user[username1].xaxis)-1);
        chatbox[userlocation].actions.unshift(writing);
        refreshimages();
    }
    else{
        alert("There is nothing written");
    }
}