    function importantLink(title,text,link){
    this.title = title;
    this.text = text;
    this.link = link;
}

var linkForum = new importantLink("Forum","Arctic Lands discussion","forum&f=g");
var linkScores = new importantLink("Leaderboard","See where you rank in the game","score");
var linkHelp = new importantLink("Help","Understand how the game works","help");
var linkSpirit = new importantLink("Spirit","See your record within the arctic lands","spirit");
var linkArray = [linkSpirit,linkScores,linkForum,linkHelp];



function getJoingameInfo(){
    ajax_All(49,1);
}

function createJoingameLinks(data){
    createNews(data.NEWS);
    createMaps(data.MAPS);
    createImportantLinks();
}

function createImportantLinks(){
    $("#importantLinksWrapper").empty();
    for (var x in linkArray){
        $("#importantLinksWrapper").append('<div class="col-11 importantLinkWrapper d-flex flex-column align-items-start mb-2" id="link'+linkArray[x].link+'" onclick="goToLink(this.id)">' +
            '<div class="font-weight-bold">'+linkArray[x].title+'</div>' +
            '<div class="font-size-2">'+linkArray[x].text+'</div>' +
            '</div>')
    }
}

function goToLink(id){
    var final = id.slice(4);
    goToPage(final)
}

function createNews(data){
    $("#newsListWrapper").empty();
    for (var x in data){
        $("#newsListWrapper").append("<div class='col-12 row align-items-center justify-content-between py-1 my-1 px-md-5 px-4 newsLinkWrapper' id='newsLink"+data[x].newsID+"' onclick='clickNews(this.id)'></div>");
        $("#newsLink"+data[x].newsID).append('<div class="newsDate d-flex flex-column align-items-center"><div><strong>'+data[x].month+'</strong></div><div>'+data[x].day+'</div></div><div class="mr-md-auto mr-0 ml-auto ml-md-4 d-flex flex-column"><div class="font-weight-bold">'+data[x].title+'</div><div class="darkGrayColour font-size-2">By '+data[x].author+'</div></div></div><div class="d-none d-md-block"><i class="far fa-comments"></i>  <span class="blueColour">'+data[x].comments+' </span>'+textNewsComments()+'</div>')
    }
}

function createMaps(data){
    $("#joinGameListWrapper").empty();
    for (var x in data){
        var wrapper = "customGameMapWrapper";
        var type = "Custom";
        var speed = "Speed";
        if(data[x].gameType === 3){
            wrapper = "tutorialMapWrapper";
            type = "Practice";
        } else if (data[x].gameType === 1){
            wrapper = "fullMapWrapper";
            type = "Main";
        } else if (data[x].gameType === 5){
            wrapper = "testingGameMapWrapper";
            type = "Testing";
        }
        if(data[x].mapSpeed === 1){
            speed = "Realtime";
        }
        $("#joinGameListWrapper").append('<div class="col-11 joinGameMapWrapper '+wrapper+' d-flex flex-row justify-content-between align-items-center my-2 py-1 px-2">' +
            '<div class="d-flex flex-column">' +
            '<div class="font-weight-bold">'+data[x].mapName+'</div>' +
            '<div class="d-flex flex-sm-row flex-column align-items-sm-center">' +
            '<div class="font-size-2">Map Size '+data[x].mapSize+'x'+data[x].mapSize+'</div>' +
            '<div class="d-sm-block d-none px-2">|</div>' +
            '<div class="font-size-2">Type: '+type+' ('+speed+')</div>' +
            '</div>' +
            '</div>' +
            '<div class="mapJoinButton py-1 col-lg-3 col-md-4 col-sm-4 col-5 px-0" align="center" id="'+data[x].mapID+'" onclick="joinMap(this.id)">' +
            'JOIN '+data[x].currentPlayers+'/'+data[x].maxPlayers+
            '</div>' +
            '</div>')
    }
}

function joinMap(id){
    ajax_All(40,0,id);
}

function clickNews(id){
    var newID = id.slice(8)
    window.location.href = "/?page=news&n="+newID;
}