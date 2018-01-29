///////////PLAYER PROFILE PAGE JAVASCRIPT///////////

var users = [];
var countNum = 1;


function viewPlayerProfile(response){
    displayProfile(response);
    displayAchievemets(response.achievements);
    makeUserStats(response.playStatistics);
    showAllShrines(response.shrinesDetail);
    setupListener();
}


function ajax_editProfile(bio, age, gender, country, picture){
    var hr = new XMLHttpRequest();
    hr.open("POST", "/MVC/ajax_php/formatEditProfile.php", true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function () {
        if (hr.readyState == 4 && hr.status == 200) {
            var response = JSON.parse(hr.responseText);
            console.log(response);
            if ("ERROR" in response){
                console.log(response.ERROR);
                errors(response.ERROR);
            } else if ("Success" in response){
                if(!alert("Your profile has been updated")){window.location = "/user.php?u="+response.Success;}
            }

        }
    };
    hr.send("bio="+bio+"&age="+age+"&gender="+gender+"&country="+country+"&picture="+picture);
}


function sanitizeInputs(){
    var bio = _("updateProfileBio").value;
    var age = parseInt(_("updateProfileAge").value);
    var gender = _("updateProfileGender").value;
    var country = _("updateProfileCountry").value;
    var picture = _("updateProfilePicture").value;
    if (bio !== ""){
        if (bio.length >160 ){
            $("#errorBio").append("Bio too long");
            return;
        }
    }
    if (age !== ""){
        if (Number.isInteger(age) === false ){
            $("#errorAge").append("Please enter a number");
            return;
        } else {
            if (age < 0 || age > 150) {
                $("#errorAge").append("Keep the age between 0 and 150 for realism sake");
                return;
            }
        }
    }
    if (gender !== ""){
        if (gender.length > 20){
            $("#errorGender").append("For the sake of formatting keep it less than 20 chars");
            return;
        }
    }
    if (country !== ""){
    }
    if (picture !== ""){
    }
    ajax_editProfile(bio,age,gender,country,picture)
}

function displayProfile(profile){
    $("#userCardName").empty()
        .append(profile.profileID);
    $("#userCardLogin").empty()
        .append("Last Online: "+profile.lastlogin);
    $("#userCardBio").empty()
        .append(profile.bio);
    $("#userCardAge").empty()
        .append("Age: "+profile.age);
    $("#userCardHonour").empty()
        .append(profile.profileTitle);
    $("#userCardFavour").empty()
        .append("<span id='userCardTotalFavour'>Favour: "+profile.favourScore+"</span><span>Level: "+profile.profileLevel+"</span>");
    $("#userCardGender").empty()
        .append("Gender: "+profile.gender);
    $("#userCardScore").empty()
        .append("<span>Achievement Score: "+profile.profileScore+"</span>");
    $("#userCardImage").empty()
        .append("<img src='/avatarimages/"+profile.profilePicture+"' id='userCardImageFile'>");
    $("#userCardCountry").empty()
        .append("<div id='userCardFlagImgWrap'><img src='/images/flags/"+profile.country+".png' id='userCardFlagImg'><span id='userCardFlagImgInfo'>"+profile.country+"</span></div>");
    if (profile.isPlayer === true){
        $("#userCardInfoWrap").append("<div class='editBioDiv' id='"+profile.profileID+"' onclick='editBio()'>" +
            "<img src='/images/edit_text.png' id='editBioImage'>" +
            "<span id='editBioSpan'>" +
            "Edit biography" +
            "</span>" +
            "</div>")
    }
}


function showAllShrines(response){
    $("#userShrinesWrap").empty();
    if (objectSize(response) === 0){
        $("#userShrinesWrap").append("<span class='nothingGained'>No favour gained yet</span>");
    }else {
        for (var shrine in response) {
            $("#userShrinesWrap").append("<div class='shrineOverviewWrap'><img class='shrineFinalImage' src='/images/shrines/" + response[shrine].shrineIcon + "'><div class='shrineImageText'>" + response[shrine].shrineName + "</div><div class='shrineImageScore'>" + response[shrine].score + "</div></div>")
        }
    }
}

function displayAchievemets(achievements){
    $("#userAchieveList").empty();
    if (objectSize(achievements) === 0){
        $("#userAchieveList").append("<span class='nothingGained'>No achievements gained yet</span>");
    }else {
        for (var single in achievements) {
            var achieve = achievements[single].details;
            $("#userAchieveList").append("<div class='userAchieveWrap'><div class='userAchieveName'>" + achieve.name + "</div><div class='userAchieveImageWrap'><img src='/images/achievements/" + achieve.icon + "' class='userAchieveImage'><span class='userAchieveText'>" + achieve.description + "</span></div><div class='userAchieveCount'>" + achievements[single].count + "</div></div>");
        }
    }
}

function editBio(){
    window.location ="admin/editProfile.php";
}

function updateEdit(response){
    $("#updateProfileBio").val(response.bio);
    $("#updateProfileAge").val(response.age);
    $("#updateProfileGender").val(response.gender);
    $("#updateProfileCountry").val(response.country);
    $("#userCardImage").empty()
        .append("<img src='/avatarimages/"+response.profilePicture+"' id='userCardImageFile'>");

}

function makeUserStats(stats) {
    $("#myLegend").empty();
    var height = 200;
    var width = 300;
    var ctx = makeCanvas(width, height, "myCanvas");
    drawChartAxis(ctx, width, height);
    if (stats != null) {
        var totalValue = 0;
        var count = 0;
        for (type in stats) {
            totalValue += stats[type];
            count++;
        }
        var barHeight = (height*0.8)/count;
        var barWidth = (width*0.8);
        var current = 0;
        for (type in stats){
            val = stats[type];
            var colour = getPieColour(type);
            drawRectangle(ctx, (width * 0.11), ((height * 0.11)+(barHeight*current)), barWidth*(val/totalValue), ((height * 0.79)/count)-10, colour, colour);
            current++
        }
        //This section creates the legend
        var legendHTML = "";
        for (type in stats) {
            colour = getPieColour(type);
            var name = getLegendName(type);
            legendHTML += "<div class='myLegendText'><span style='display:inline-block;width:20px;background-color:" + colour + ";'>&nbsp;</span> " + name + "</div>";
        }
        $("#myLegend").append(legendHTML);
    }
    else {
        $("#myLegend").hide();
        ctx.font = "30px Times New Roman";
        ctx.fillText("No stats yet",width*0.2, height*0.55);
    }
}

function updateImagePreview(){
    var fileSelect = document.getElementById('fileToUpload');
    var files = fileSelect.files;
    var formData = new FormData();
    if (files.length == 1) {
        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            if (!file.type.match('image/*')) {
                continue;
            }
            formData.append(i, file, file.name);
        }
        if (formData.get(0) != null) {
            console.log(formData.get(0));
            userCardImageFile.src = window.URL.createObjectURL(formData.get(0));
        } else {
            alert("Please only use the correct file type")
        }
    }
}

function getFileDetails(){
    var form = document.getElementById('avatarImageUpload');
    var fileSelect = document.getElementById('fileToUpload');
    var uploadButton = document.getElementById('uploadButton');
    form.onsubmit = function(event) {
        event.preventDefault();
        // Get the selected files from the input.
        var files = fileSelect.files;
        // Create a new FormData object.
        var formData = new FormData();
        if (files.length == 1) {
            // Loop through each of the selected files.
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                // Check the file type.
                if (!file.type.match('image/*')) {
                    continue;
                }
                // Add the file to the request.
                formData.append(i, file, file.name);
            }
            if (formData.get(0) != null) {
                // Set up the request.
                var hr = new XMLHttpRequest();
                // Open the connection.
                hr.open('POST', '/MVC/ajax_php/formatEditProfile.php', true);
                // Set up a handler for when the request finishes.
                hr.onreadystatechange = function () {
                    if (hr.readyState == 4 && hr.status == 200) {
                        var response = JSON.parse(hr.responseText);
                        console.log(response);
                        if ("ERROR" in response){
                            console.log(response.ERROR);
                            errors(response.ERROR);
                        } else {
                            window.location.href = "/user.php?u="+response.SUCCESS;
                        }
                    }
                };
                hr.send(formData);
            } else {
                alert("Please only use PNG, JPEG, GIF or JPG file types");
            }
        }else {
            alert("Please upload a single file");
        }
    };
}

function setupListener(){
        $("#searchPlayerName").keyup(function(event){
            if(event.keyCode == 13){
                $("#submitPlayerSearch").click();
            }
        });
        $("#foundPlayersListWrapper").hide();
}

function searchForPlayer(){
    var username = $("#searchPlayerName").val();
    ajax_All(38,username,13);
    $("#loadingscreen").css("visibility", "visible");
}

function displayUsersSetup(usersArray){
    users = usersArray;
    countNum = 1;
    $("#foundPlayersListWrapper").show();
    displayUsers()
}

function displayUsersMore(){
    var length = objectSize(users);
    if (length >(countNum*5)){
        countNum++
    }
    displayUsers()
}

function displayUsersLess(){
    if (countNum > 1){
        countNum--;
    }
    displayUsers()
}

function displayUsers(){
    $("#foundPlayersList").empty();
    var length = objectSize(users);
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
        $("#foundPlayersList").append("<div class='playerNameWrapper'>" +
            "<div class='playerImageWrapper'>" +
            "<img class='playerImageFile' src='/avatarimages/"+users[x].profileImage+"'>"+
            "</div>" +
            "<span class='playerDetailsWrapper'>" +
            "<a class='playerNameLink' href='/user.php?u=" +users[x].profile+"'>" +
            users[x].profile+
            "</a>" +
            "</span>" +
            "</div>");
    }
    $("#pageNumber").empty().append("Page "+countNum+" of "+Math.ceil(length/5));
    $("#totalResults").empty().append("<strong>"+length+"</strong> results found");
}