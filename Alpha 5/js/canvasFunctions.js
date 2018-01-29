//////////////////THESE FUNCTIONS ARE USED IN CANVASES//////////

//This returns the canvas values
function makeCanvas(width, height,id){

    var myCanvas = document.getElementById(id);
    myCanvas.width = width;
    myCanvas.height = height;
    var ctx = myCanvas.getContext("2d");
    return ctx
}

//This creates a line
function drawLine(ctx, startX, startY, endX, endY){
    ctx.beginPath();
    ctx.moveTo(startX,startY);
    ctx.lineTo(endX,endY);
    ctx.strokeStyle = "#000000";
    ctx.stroke();
}

function drawRectangle(ctx, startX, startY, endX, endY, colour, border){
    ctx.fillStyle = colour;
    ctx.lineWidth = "2";
    ctx.strokeStyle = border;
    ctx.beginPath();
    ctx.rect(startX,startY,endX,endY);
    ctx.fill();
    ctx.stroke();
}

function drawChartAxis(ctx, width, height){
    startX = width*0.1;
    startY = height*0.9;
    endYvert = height*0.1;
    endXhoriz = width*0.9;
    drawLine(ctx,startX,startY,startX,endYvert);
    drawLine(ctx,startX,startY,endXhoriz,startY);
    ctx.fillText("0",startX+1,startY+10);
    ctx.fillText("50",((startX+endXhoriz)/2)-10,startY+10);
    ctx.fillText("100",endXhoriz-10,startY+10);
    ctx.fillText("%",((startX+endXhoriz)/2)-10,startY+20);
}

//This creates a circle/arc
function drawArc(ctx, centerX, centerY, radius, startAngle, endAngle){
    ctx.beginPath();
    ctx.arc(centerX, centerY, radius, startAngle, endAngle);
    ctx.stroke();
}

//This creates a slice of a circle
function drawPieSlice(ctx,centerX, centerY, radius, startAngle, endAngle, colour ){
    ctx.fillStyle = colour;
    ctx.beginPath();
    ctx.moveTo(centerX,centerY);
    ctx.arc(centerX, centerY, radius, startAngle, endAngle);
    ctx.closePath();
    ctx.fill();
}

//This Switch returns the colours for different actions
function getPieColour(name){
    switch (name){
        case "move":
            return "#9BC53D";
            break;
        case "build":
            return "#995D81";
            break;
        case "search":
            return "#FA7921";
            break;
        case "break":
            return "#F55D3E";
            break;
        case "research":
            return "#26547C";
            break;
        default:
            return "#000000"
    }
}

//This Switch returns colours for a graph without related colours
function getGraphColour(count){
    switch (count){
        case 1:
            return "#9BC53D";
            break;
        case 2:
            return "#995D81";
            break;
        case 3:
            return "#FA7921";
            break;
        case 4:
            return "#F55D3E";
            break;
        case 5:
            return "#26547C";
            break;
        default:
            return "#000000"
    }
}

//This Switch returns the colours for different actions
function getLegendName(name){
    switch (name){
        case "move":
            return "Moving";
            break;
        case "build":
            return "Building";
            break;
        case "search":
            return "Searching";
            break;
        case "break":
            return "Destroying";
            break;
        case "research":
            return "Researching";
            break;
        default:
            return "Other"
    }
}