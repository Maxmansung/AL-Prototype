

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
var bold = new textFormat("<span class='font-weight-bold px-1'>","</span>","**","Bold");
var italic = new textFormat("<span class='font-italic px-1'>","</span>","//","Italics");
var deleted = new textFormat("<div class='font-size-2 col-12 font-weight-bold' align='center'>Admin</div><div class='deletedTextFormat col-12 d-flex flex-row justify-content-center font-size-2x p-4 mb-0'>","</div><div class='col-12'></div>","$%*","Deleted");
var roleplay = new textFormat("<div class='col-12'></div><div class='roleplayTextFormat d-flex flex-row justify-content-center p-1 m-1'>","</div><div class='col-12'></div>","^^","Roleplay");
var formatArray = [bold,italic,roleplay,deleted];



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
            if (alternate === true){
                newText = text+format.end;
            }
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
    final = text.replace(pattern, "<img src='" + emoji.src + "' class='textImageEmoji mx-1' title='" + emoji.text + "'>");
    return final;
}

function addTextFormat(type){
    insertAtCaret(type,-2);
}

function addEmoji(type){
    insertAtCaret(type,1)
}

function showEmojis(){
    $("#emojiWrapper").collapse();
}

$('.keepSelection').on('mousedown', function(event) {
// do your magic
    event.preventDefault();
});

function insertAtCaret(text,position) {
    var txtarea = document.getElementById("postBoxTextbox");
    if (!txtarea) {
        return;
    }
    var scrollPos = txtarea.scrollTop;
    var strPos = 0;
    var br = ((txtarea.selectionStart || txtarea.selectionStart == '0') ?
        "ff" : (window.getSelection() ? "ie" : false ) );
    if (br == "ie") {
        txtarea.focus();
        var range = window.getSelection().createRange();
        range.moveStart ('character', -txtarea.value.length);
        strPos = range.text.length;
    } else if (br == "ff") {
        strPos = txtarea.selectionStart;
    }

    var front = (txtarea.value).substring(0, strPos);
    var back = (txtarea.value).substring(strPos, txtarea.value.length);
    txtarea.value = front + text + back;
    strPos = strPos + text.length + position;
    if (br == "ie") {
        txtarea.focus();
        var ieRange = document.selection.createRange();
        ieRange.moveStart ('character', -txtarea.value.length);
        ieRange.moveStart ('character', strPos);
        ieRange.moveEnd ('character', 0);
        ieRange.select();
    } else if (br == "ff") {
        txtarea.selectionStart = strPos;
        txtarea.selectionEnd = strPos;
        txtarea.focus();
    }

    txtarea.scrollTop = scrollPos;
}

function createEmojiLine(){
    $("#emojiList").empty();
    for (var x in emojiArray){
        $("#emojiList").append('<div class="emojiSelect d-flex flex-column justify-content-center align-items-center" id="'+emojiArray[x].key+'" onclick="addEmoji(this.id)">' +
            '<img src="' + emojiArray[x].src + '" class="textImageEmoji" title="'+emojiArray[x].text+'"></div>')
    }

}

$(document).ready(function () {
    $('textarea[data-limit-rows=true]')
        .on('keypress', function (event) {
            var textarea = $(this),
                text = textarea.val(),
                numberOfLines = (text.match(/\n/g) || []).length + 1,
                maxRows = parseInt(textarea.attr('rows'));

            if (event.which === 13 && numberOfLines === maxRows ) {
                return false;
            }
        });
});