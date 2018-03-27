var achievementView = 1;

function showProfilePage(data){
    profileDetails(data);
    achievementDetails(data.achievementsMain,"achievementWrapperMain");
    achievementDetails(data.achievementsSpeed,"achievementWrapperSpeed");
    switchScreen();
    activateTooltips();
    closeEditScreen();
    profileListener();
}

function profileDetails(data){
    $("#profilePageName").empty().append(data.profileID);
    $("#profilePageImage").attr("src","/avatarimages/"+data.profilePicture);
    $("#profilePageFlag").attr("src","/avatarimages/flags/"+data.country+".png");
    $("#profileCountry").val(data.country);
    $("#profilePageLogin").empty().append(data.login);
    $("#profilePageGender").empty().append(data.gender);
    $("#profileGender").empty().val(data.gender);
    $("#profilePageAge").empty().append(data.age);
    $("#profileAge").empty().val(data.age);
    $("#profilePageBio").empty().append(data.bio);
    $("#profileBio").empty().val(data.bio);
    $("#profileImageUpload").change(updateImage());
}

function achievementDetails(list,type){
    $("#"+type).empty();
    var length = objectSize(list);
    if (length >0) {
        for (var x in list) {
            $("#" + type).append('<div class="singleAchievementWrapper">' +
                '<div class="achievementWrapper" data-toggle="tooltip" data-placement="top" title="' + list[x].details.name + '">' +
                '<img src="/images/achievements/' + list[x].details.icon + '" class="achievementImage">' +
                '</div>' +
                '<div class="achievementCounter font-size-1">' +
                list[x].count +
                '</div>' +
                '</div>')
        }
    } else {
        $("#"+type).append("<div class='funkyFont'>No Achievements gained in this game type</div>")
    }
}

function switchScreen(){
    if (achievementView === 1){
        $("#achievementWrapperMainOuter").show();
        $("#achievementWrapperSpeedOuter").hide();
    } else {
        $("#achievementWrapperMainOuter").hide();
        $("#achievementWrapperSpeedOuter").show();
    }
}

function achievementsViewChange(){
    if (achievementView === 1){
        achievementView = 0;
    } else {
        achievementView = 1;
    }
    switchScreen();
}

function switchEditScreen(){
    $("#profileEditWrap").show();
    $("#profileOverviewWrap").hide();
}

function closeEditScreen(){
    $("#profileEditWrap").hide();
    $("#profileOverviewWrap").show();
}

function submitProfileEdit(){
    var bio = _("profileBio").value;
    var age = _("profileAge").value;
    var gender = _("profileGender").value;
    var country = _("profileCountry").value;
    var check = true;
    if (age <0 || age > 200){
        check = false;
        console.log("Failed age");
    }
    gender2 = gender.replace(/[^a-zA-Z0-9!? ()*]/g, "");
    if (gender2 !== gender){
        check = false;
        console.log("Failed gender");
    }
    if (check === true){
        console.log("Posting");
        ajax_All(195,"none",bio,age,gender,country)
    }
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
            console.log(formData.get(0));
            userCardImageFile.src = window.URL.createObjectURL(formData.get(0));
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

function searchForSpirits() {
    var username = $("#searchForUsername").val();
    ajax_All(38,3,username);
}

function createSearchResults(data){
    $("#profilesFound").empty();
    var count = objectSize(data);
    if (count > 0){
        for (var x in data){
            console.log(data[x]);
            $("#profilesFound").append("<div class='row my-1 justify-content-between align-items-center px-3 py-1 hoverHighlight' id='spirit+"+data[x].profile+"' onclick='findSpirit(this.id)'><div class='searchAvatarImageWrap d-flex flex-row justify-content-center align-items-center'><img class='searchAvatarImage' src='/avatarimages/"+data[x].profileImage+"'></div><div class='d-flex flex-column justify-content-center align-items-end'><div class='funkyFont font-size-3'>"+data[x].profile+"</div><div class='font-size-1 grayColour'>Last seen: "+data[x].login+"</div></div></div>");
        }
    } else {
        $("#profilesFound").append("<div class='funkyFont font-size-3 row justify-content-center'>No spirits match this name</div>")
    }
}

function findSpirit(id){
    var name = id.slice(7);
    window.location.href = "/?page=spirit&p="+name;
}


function profileListener() {
    $("#searchForUsername").keyup(function (event) {
        if (event.keyCode == 13) {
            $("#searchProfileButton").click();
        }
    });
}