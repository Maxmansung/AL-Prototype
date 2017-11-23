

function ajax_HUD() {
    var hr = new XMLHttpRequest();
    hr.open("POST", "../php/get_HUD.php", true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function () {
        if (hr.readyState == 4 && hr.status == 200) {
            var data = hr.responseText;
            timestamping(data);
            console.log(data);
        }
    };
    hr.send("var1=true");
}

function timestamping(countdown){
        var seconds = (Math.floor(countdown / 1000)) % 60;
        var minutes = (Math.floor((countdown / 1000) / 60)) % 60;
        var hours = (Math.floor(((countdown / 1000) / 60) / 60)) % 60;
        $("#hudtimer").empty()
            .append("<div>" + hours + "hrs " + minutes + "mins</div>");
        //console.log(hours + "hrs " + minutes + "mins " + seconds + "secs");
}