function showProfilePage(data){
    profileDetails(data);
    achievementDetails(data.achievementsMain);
    activateTooltips();
}

function profileDetails(data){
    $("#profilePageName").empty().append(data.profileID);
    $("#profilePageImage").attr("src","/avatarimages/"+data.profilePicture);
    $("#profilePageFlag").attr("src","/avatarimages/flags/"+data.country+".png");
    $("#profilePageLogin").empty().append(data.login);
    $("#profilePageGender").empty().append(data.gender);
    $("#profilePageAge").empty().append(data.age);
    $("#profilePageBio").empty().append(data.bio);
}

function achievementDetails(list){
    $("#achievementWrapperMain").empty();
    for (var x in list){
        $("#achievementWrapperMain").append('<div class="singleAchievementWrapper">'+
                '<div class="achievementWrapper" data-toggle="tooltip" data-placement="top" title="'+list[x].details.name+'">'+
            '<img src="/images/achievements/'+list[x].details.icon+'" class="achievementImage">'+
                '</div>'+
            '<div class="achievementCounter font-size-1">'+
            list[x].count+
            '</div>'+
            '</div>')
    }
}