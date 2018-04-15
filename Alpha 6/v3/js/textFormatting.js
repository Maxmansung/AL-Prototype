

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

function addSmileType(text,emoji) {
    var pattern = new RegExp(emoji.key, "g");
    final = text.replace(pattern, "<img src='" + emoji.src + "' class='textImageEmoji' title='" + emoji.text + "'>");
    return final;
}