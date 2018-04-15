//Profile Page
var achievementView = 1;

//Edit Profile Page
var favAchieve = 1;
var achievementList = [];
achievementList[1] = 0;
achievementList[2] = 0;
achievementList[3] = 0;
achievementList[4] = 0;



function loadProfilePage(){
    var data = $(".getDataClass").attr('id');
    ajax_All(35,2,data)
}


function showProfilePage(data){
    $(".profilesFoundWrapper").hide();
    profileDetails(data);
    achievementDetails(data.achievementsMain,"profilePageMainAchieve");
    achievementDetails(data.achievementsSpeed,"profilePageSpeedAchieve");
    activateTooltips();
    updateScores(data);
    switchScreen();
    profileListener();
}

function profileDetails(data){
    $(".profilePageImage").attr("src","/avatarimages/"+data.profilePicture);
    $(".profilePageFlag").attr("src","/avatarimages/flags/"+data.country+".png");
    $(".profilePageLogin").empty().append(data.login);
    $(".profilePageGender").empty().append(data.gender);
    $(".profilePageAge").empty().append(data.age);
    $(".profilePageBio").empty().append(data.bio);
    $(".profileFavouredGod").empty().append(data.favouriteGod);
    $(".profileMainGames").empty().append(data.mainGames);
    $(".profileSpeedGames").empty().append(data.speedGames);
    $(".profileSpiritName").empty().append(data.profileName);
    $(".profileSpiritType").empty().append(data.accountType+" Spirit");
    if (data.keyAchievement1 != null) {
        if (objectSize(data.achievementsMain[data.keyAchievement1]) != 0) {
            $(".showOff1").attr("src", "/images/profilePage/achievements/" + data.achievementsMain[data.keyAchievement1].details.icon);
        } else {
            $(".showOff1").attr("src", "/images/profilePage/achievements/" + data.achievementsSpeed[data.keyAchievement1].details.icon);
        }
    }
    if (data.keyAchievement2 != null) {
        if (objectSize(data.achievementsMain[data.keyAchievement2]) != 0) {
            $(".showOff2").attr("src", "/images/profilePage/achievements/" + data.achievementsMain[data.keyAchievement2].details.icon);
        } else {
            $(".showOff2").attr("src", "/images/profilePage/achievements/" + data.achievementsSpeed[data.keyAchievement2].details.icon);
        }
    }
    if (data.keyAchievement3 != null) {
        if (objectSize(data.achievementsMain[data.keyAchievement3]) != 0) {
            $(".showOff3").attr("src", "/images/profilePage/achievements/" + data.achievementsMain[data.keyAchievement3].details.icon);
        } else {
            $(".showOff3").attr("src", "/images/profilePage/achievements/" + data.achievementsSpeed[data.keyAchievement3].details.icon);
        }
    }
    if (data.keyAchievement4 != null) {
        if (objectSize(data.achievementsMain[data.keyAchievement4]) != 0) {
            $(".showOff4").attr("src", "/images/profilePage/achievements/" + data.achievementsMain[data.keyAchievement4].details.icon);
        } else {
            $(".showOff4").attr("src", "/images/profilePage/achievements/" + data.achievementsSpeed[data.keyAchievement4].details.icon);
        }
    }
}

function achievementDetails(list,type){
    $("."+type).empty();
    var length = objectSize(list);
    if (length >0) {
        for (var x in list) {
            $("." + type).append('<div class="singleAchievementWrapper p-1 d-flex flex-column justify-content-center align-items-center m-1">' +
                '<div class="achievementWrapper lightGrayBackground" data-toggle="tooltip" data-placement="top" title="' + list[x].details.name + '">' +
                '<img src="/images/profilePage/achievements/' + list[x].details.icon + '" class="achievementImage">' +
                '</div>' +
                '<div class="achievementCounter font-size-1">' +
                list[x].count +
                '</div>' +
                '</div>')
        }
    } else {
        $("."+type).append("<div class='funkyFont'>No Achievements gained in this game type</div>")
    }
}

function switchScreen(){
    if (achievementView === 1){
        $(".profilePageSpeedAchieve").removeClass("d-flex").addClass("d-none");
        $(".profilePageMainAchieve").removeClass("d-none").addClass("d-flex");
    } else {
        $(".profilePageSpeedAchieve").removeClass("d-none").addClass("d-flex");
        $(".profilePageMainAchieve").removeClass("d-flex").addClass("d-none");
    }
}

function achievementsViewChange(type){
    if (type === 1){
        $(".profilePageSpeedButton").removeClass("font-weight-bold font-size-2x").addClass("clickableFlash");
        $(".profilePageMainButton").removeClass("clickableFlash").addClass("font-weight-bold font-size-2x");
    } else {
        $(".profilePageMainButton").removeClass("font-weight-bold font-size-2x").addClass("clickableFlash");
        $(".profilePageSpeedButton").removeClass("clickableFlash").addClass("font-weight-bold font-size-2x");
    }
    if (type !== achievementView) {
        achievementView = type;
        switchScreen();
    }
}


function searchForSpirits(id) {
    var username = "";
    if (id === 1) {
        username = $("#profilePageSearchPhone").val();
    } else {
        username = $("#profilePageSearchScreen").val();
    }
    console.log(username+" and ID: "+id);
    ajax_All(38,3,username);
}

function createSearchResults(data){
    $(".profilesFoundWrapper").show();
    $(".profilesFound").empty();
    var count = objectSize(data);
    if (count > 0){
        for (var x in data){
            $(".profilesFound").append("<div class='col-11 d-flex flex-row my-1 justify-content-between align-items-center px-3 py-1 hoverHighlight' id='spirit+"+data[x].profile+"' onclick='findSpirit(this.id)'><div class='searchAvatarImageWrap d-flex flex-row justify-content-center align-items-center'><img class='searchAvatarImage' src='/avatarimages/"+data[x].profileImage+"'></div><div class='d-flex flex-column justify-content-center align-items-end'><div class='funkyFont font-size-3'>"+data[x].profile+"</div><div class='font-size-1 grayColour'>Last seen: "+data[x].login+"</div></div></div>");
        }
    } else {
        $(".profilesFound").append("<div class='funkyFont font-size-3 row justify-content-center'>No spirits match this name</div>")
    }
}

function findSpirit(id){
    var name = id.slice(7);
    window.location.href = "/?page=spirit&p="+name;
}


function profileListener() {
    $("#profilePageSearchPhone").keyup(function (event) {
        if (event.keyCode == 13) {
            $("#profilePageSearchPhoneButton").click();
        }
    });
    $("#profilePageSearchScreen").keyup(function (event) {
        if (event.keyCode == 13) {
            $("#profilePageSearchScreenButton").click();
        }
    });
}

function updateScores(data){
    $("#soloScoreWrap .leaderboardNumber").empty().append(data.soloLeaderboard);
    $("#teamScoreWrap .leaderboardNumber").empty().append(data.teamLeaderboard);
    $("#fullScoreWrap .leaderboardNumber").empty().append(data.fullLeaderboard);
}

///////////////////////////////////////////////////////////////

function showProfileEditPage(data){
    profileEditHighlightFav();
    profileEditPageDetails(data);
    profileEditShowAchievements(data.achievementsMain,data.achievementsSpeed);
    updateImageListener();
}

function loadProfileEditPage(){
    var data = $(".getDataClass").attr('id');
    ajax_All(36,2,data)
}

function profileEditPageDetails(data){
    $("#profileCountry").val(data.country);
    $("#profileGender").empty().val(data.gender);
    $("#profileAge").empty().val(data.age);
    $("#profileBio").empty().val(data.bio);
    $("#profileImageUpload").change(updateImage());
    if (data.keyAchievement1 != null) {
        if (objectSize(data.achievementsMain[data.keyAchievement1]) != 0) {
            $("#favAchieve1 .achievementWrapper .achievementImage").attr("src", "/images/profilePage/achievements/" + data.achievementsMain[data.keyAchievement1].details.icon);
        } else {
            $("#favAchieve1 .achievementWrapper .achievementImage").attr("src", "/images/profilePage/achievements/" + data.achievementsSpeed[data.keyAchievement1].details.icon);
        }
    }
    if (data.keyAchievement2 != null) {
        if (objectSize(data.achievementsMain[data.keyAchievement2]) != 0) {
            $("#favAchieve2 .achievementWrapper .achievementImage").attr("src", "/images/profilePage/achievements/" + data.achievementsMain[data.keyAchievement2].details.icon);
        } else {
            $("#favAchieve2 .achievementWrapper .achievementImage").attr("src", "/images/profilePage/achievements/" + data.achievementsSpeed[data.keyAchievement2].details.icon);
        }
    }
    if (data.keyAchievement3 != null) {
        if (objectSize(data.achievementsMain[data.keyAchievement3]) != 0) {
            $("#favAchieve3 .achievementWrapper .achievementImage").attr("src", "/images/profilePage/achievements/" + data.achievementsMain[data.keyAchievement3].details.icon);
        } else {
            $("#favAchieve3 .achievementWrapper .achievementImage").attr("src", "/images/profilePage/achievements/" + data.achievementsSpeed[data.keyAchievement3].details.icon);
        }
    }
    if (data.keyAchievement4 != null) {
        if (objectSize(data.achievementsMain[data.keyAchievement4]) != 0) {
            $("#favAchieve4 .achievementWrapper .achievementImage").attr("src", "/images/profilePage/achievements/" + data.achievementsMain[data.keyAchievement4].details.icon);
        } else {
            $("#favAchieve4 .achievementWrapper .achievementImage").attr("src", "/images/profilePage/achievements/" + data.achievementsSpeed[data.keyAchievement4].details.icon);
        }
    }
}

function profileEditChangeFav(id){
    favAchieve = id;
    profileEditHighlightFav();
}

function profileEditHighlightFav(){
    $("#favAchieve1").removeClass("favAchivementBorderSelected").addClass("favAchivementBorder");
    $("#favAchieve2").removeClass("favAchivementBorderSelected").addClass("favAchivementBorder");
    $("#favAchieve3").removeClass("favAchivementBorderSelected").addClass("favAchivementBorder");
    $("#favAchieve4").removeClass("favAchivementBorderSelected").addClass("favAchivementBorder");
    switch (favAchieve){
        case 1:
            $("#favAchieve1").removeClass("favAchivementBorder").addClass("favAchivementBorderSelected");
            break;
        case 2:
            $("#favAchieve2").removeClass("favAchivementBorder").addClass("favAchivementBorderSelected");
            break;
        case 3:
            $("#favAchieve3").removeClass("favAchivementBorder").addClass("favAchivementBorderSelected");
            break;
        case 4:
            $("#favAchieve4").removeClass("favAchivementBorder").addClass("favAchivementBorderSelected");
            break;
    }
}

function profileEditShowAchievements(main,speed){
    var achievementArrayUsed = [];
    $(".borderWrapperAchievements").empty();
    for (var x in main){
        $(".borderWrapperAchievements").append('<div class="selectableAchievementSingle p-1 m-1">' +
            '<div class="achievementWrapper lightGrayBackground" id="'+x+'" onclick="selectAchievementEdit(this.id)">' +
            '<img src="/images/profilePage/achievements/'+main[x].details.icon+'" class="achievementImage">' +
            '</div>' +
            '</div>');
        achievementArrayUsed.push(x);
    }
    for (x in speed){
        if(achievementArrayUsed.indexOf(x) <0) {
            $(".borderWrapperAchievements").append('<div class="selectableAchievementSingle p-1 m-1">' +
                '<div class="achievementWrapper lightGrayBackground" id="' + x + '" onclick="selectAchievementEdit(this.id)">' +
                '<img src="/images/profilePage/achievements/' + speed[x].details.icon + '" class="achievementImage">' +
                '</div>' +
                '</div>');
        }
    }
}

function selectAchievementEdit(id){
    achievementList[favAchieve] = id;
    var src = $('#'+id).children('img').attr('src');
    $("#favAchieve"+favAchieve).children('div').children('img').attr('src',src);
}


function updateImageListener() {
    $("#profileImageUpload").change(function () {
        updateImage()
    });
}


function updateImage() {
    var fileSelect = document.getElementById('profileImageUpload');
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
            $("#profilePageNewImage").attr("src",URL.createObjectURL(formData.get(0)));
            $(".custom-file-label").empty().append(formData.get(0).name);
        } else {
            alert("Please only use the correct file type")
        }
    }
}

function submitNewImage() {
    var fileSelect = document.getElementById('profileImageUpload');
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
            showLoading();
            // Set up the request.
            var hr = new XMLHttpRequest();
            // Open the connection.
            hr.open('POST', '/MVC/ajax_php/formatEditProfile.php', true);
            // Set up a handler for when the request finishes.
            hr.onreadystatechange = function () {
                if (hr.readyState == 4 && hr.status == 200) {
                    //console.log(hr.responseText);
                    var response = JSON.parse(hr.responseText);
                    console.log(response);
                    if ("ERROR" in response){
                        errors(response.ERROR);
                    } else if ("ALERT" in response){
                        alerts(response.ALERT,response.DATA)
                    } else {
                        createAlertBox(1,1,"Your image has been changed",1);
                    }
                    hideLoading();
                }
            };
            hr.send(formData);
        } else {
            errors(121);
        }
    } else {
        errors(122);
    }
}

function submitProfileEdit(){
    var bio = _("profileBio").value;
    var age = _("profileAge").value;
    var gender = _("profileGender").value;
    var country = _("profileCountry").value;
    var check = true;
    if (age <0 || age > 200){
        check = false;
    }
    gender2 = gender.replace(/[^a-zA-Z0-9!? ()*]/g, "");
    if (gender2 !== gender){
        check = false;
    }
    if (check === true){
        ajax_All(195,"none",bio,age,gender,country)
    }
}

function submitProfileAchievements(){
    ajax_All(194,0,achievementList[1],achievementList[2],achievementList[3],achievementList[4])
}