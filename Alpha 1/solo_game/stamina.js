//This checks if the player has enough stamina to perform an action
function staminacheck(){
    return user[username1].stamina > 0;
}
//This is what happens if the player does not have enough stamina
function nostamina(){
    alert("You do not have enough stamina!")
}
//This refreshes the players stamina image
function staminaimage(){
    $("#staminawrapper").empty();
    for (x=0;x<(user[username1].stamina);x++){
        $("#staminawrapper").append("<img src='../images/stamina2.png' id='stamina"+x+"' class='staminaimage'>");
    }
}
//This is the button to refresh the stamina
function staminarefresh() {
    dayend();
    currentday += 1;
    actualtemp -= (Math.floor(Math.random()*(2*currentday))+1);
    mintemp = actualtemp-(Math.floor(Math.random() * (currentday+1)));
    maxtemp = actualtemp+(Math.floor(Math.random() * (currentday+1)));
    woodloss();
    user[username1].stamina = startstamina;
    refreshimages();
}
