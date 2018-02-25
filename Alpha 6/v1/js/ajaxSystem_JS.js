//This ajax function is used for all of the data collection within the map screen
function ajax_All(type, view, data1, data2, data3, data4, data5, data6){
    $("#loadingscreen").css("visibility", "visible");
    var hr = new XMLHttpRequest();
    hr.open("POST", "/MVC/ajax_php/ajax_MVC.php", true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function () {
        if (hr.readyState == 4 && hr.status == 200) {
            var response = JSON.parse(hr.responseText);
            console.log(response);
            if ("ERROR" in response){
                errors(response.ERROR);
            } else if ("ALERT" in response){
                alerts(response.ALERT,response.DATA)
            } else {
                switchArray(type,response);
            }
            $("#loadingscreen").css("visibility", "hidden");
        }
    };
    hr.send("type="+type+"&view="+view+"&data1="+data1+"&data2="+data2+"&data3="+data3+"&data4="+data4+"&data5="+data5+"&data6="+data6);
}


function switchArray(type,response){
    console.log("Type: "+type);
    type = parseInt(type);
    switch(type){
        default:
            break;
    }
}