function goToHelpPage(id){
    window.location.href = "/?page=help&h="+id;
}


function getBuildingInfo(id){
    var count = id.indexOf("+=");
    var type = id.slice(0,count);
    var num = id.slice(count+2);
    ajax_All(181,21,num,type);
}

function helpItemPage(id){
    console.log(id);
}

function createBuildingsPage(){
    ajax_All(182,20);
}

function createBuildingsIndex(data)
{
    $(".buildingsListIndex").empty();
    for (var x in data["head"]){
        var current = data["head"][x];
        $(".buildingsListIndex").append('<div class="d-flex flex-column pl-2 pb-2">' +
            '<div class="buildingListHeader font-size-2x font-weight-bold clickableFlashMore" onclick="getBuildingInfo(this.id)" id="head+='+current.buildingTypeID+'">' +
            current.name +
            '</div>' +
            '<div class="buildingListSelect d-flex flex-column pl-2" id="buildingList'+current.buildingTypeID+'">' +
            '</div>' +
            '</div>');
    }
    for (var x in data["build"]){
        var current = data["build"][x];
        $("#buildingList"+current.buildingTypeID).append('<div class="clickableLink" onclick="getBuildingInfo(this.id)" id="build+='+current.buildingTemplateID+'">'+
        current.name +
        '</div>');
    }
}

function createBuildingInformation(data)
{
    console.log(data);
    $(".buildingInformationSection").empty();
    if (data.header === true){
        var image = "none";
        switch (parseInt(data.image)){
            case 1:
                image = "firepit";
                break;
            case 2:
                image = "fence";
                break;
            case 3:
                image = "trap";
                break;
            case 4:
                image = "fireCage";
                break;
            case 5:
                image = "seedlings";
                break;

        }
        $(".buildingInformationSection").append('<div class="col-12 d-flex justify-content-center align-items-center flex-row">' +
            '<div class="font-weight-bold font-size-3">' +
            data.name +
            '</div>' +
            '</div> ' +
            '<div class="col-12 d-flex flex-column justify-content-center align-items-center pb-4"> ' +
                '<div align="center" class="py-2">'+data.description+'</div>' +
            '<img src="/images/gamePage/buildings/'+image+'.png"> ' +
            '</div> ' +
            '<div class="col-12 font-size-2" align="center">' +
                data.longDescription +
            '</div>');
    } else {
        $(".buildingInformationSection").append('<div class="col-12 d-flex justify-content-center align-items-center flex-column">' +
            '<div class="font-weight-bold font-size-3">' +
            data.name +
            '</div>' +
            '</div>' +
            '<div class="col-12 d-flex flex-column justify-content-center align-items-center">' +
            '<img src="/images/gamePage/buildings/'+data.image+'.png" class="helpBuildingImage">' +
            '</div>' +
            '<div class="col-12" align="center">'+data.description+'</div>' +
            '<div class="col-12 col-md-6">' +
            '<div class="borderAll grayBorder d-flex flex-column justify-content-center align-items-center m-2 p-2">' +
            '<div class="font-weight-bold" align="center">Items</div>' +
            '<div class="d-flex flex-row flex-wrap justify-content-center align-items-center" id="helpBuildingItemWrapper">' +
            '</div>' +
            '</div>' +
            '</div>' +
            '<div class="col-12 col-md-6">' +
            '<div class="borderAll grayBorder d-flex flex-column justify-content-center align-items-center m-2 p-2">' +
            '<div class="font-weight-bold mb-2" align="center">Zone Image</div>' +
            '<div class="zoneBuildingsImageWrap">' +
            '<div class="greenBackground zoneBuildingsImageWrap buildingImageOverlay"></div>' +
            '<img src="/images/gamePage/zoneImages/buildingLayers/'+data.image+'.png" class="buildingImageOverlay">' +
            '</div>' +
            '</div>' +
            '</div>' +
            '<div class="col-10 horizontalLine my-2"></div>' +
            '<div class="col-12 d-flex flex-column justify-content-center align-items-center">' +
            '<div class="d-flex justify-content-around flex-row align-items-center flex-wrap">' +
            '<div class="font-weight-bold mb-2 mx-2">Cost: <span class="font-weight-normal">'+data.staminaRequired+' stamina</span></div>' +
            '<div class="font-weight-bold mb-2 mx-2">Warmth: <span class="font-weight-normal">'+data.heat+'</span></div>' +
            '</div>' +
            '<div class="font-size-2" align="center">'+data.longDescription+'</div>' +
            '</div>' +
            '<div class="col-10 horizontalLine my-2"></div>' +
            '<div class="col-12 d-flex flex-column justify-content-center align-items-center font-size-2 mb-2">' +
            '<div class="font-weight-bold">Building required</div>' +
            '<div class="clickableLink">'+data.buildingsRequired+'</div>' +
            '</div>' +
            '<div class="horizontalLine col-10"></div>' +
            '<div class="col-12 d-flex flex-column justify-content-center align-items-center font-size-2 mb-2" id="helpBuildingRecipeWrapper">' +
        '<div class="font-weight-bold" align="center">Recipes</div> ' +
            '</div>');
        for (var y in data.itemsRequired){
            $("#helpBuildingItemWrapper").append('<div class="itemWrapperHelp d-flex flex-column justify-content-center align-items-center p-2 clickableTransparent" onclick="helpItemPage(this.id)" id="itemPage'+data.itemsRequired[y].materialRequired +'">' +
                '<div class="font-size-2 font-weight-bold" align="center">'+data.itemsRequired[y].identity +'</div>' +
                '<div class="d-flex flex-row justify-content-center align-items-center">' +
                '<img src="/images/gamePage/items/'+data.itemsRequired[y].icon +'.png" class="itemImage">' +
                '<div class="font-size-2 px-1" align="center">x'+data.itemsRequired[y].materialNeeded+'</div>' +
                '</div>' +
                '</div>');
        }
        var length = objectSize(data.recipes);
        if (length > 0) {
            for (var x in data.recipes) {
                $("#helpBuildingRecipeWrapper").append('<div class="d-flex flex-row justify-content-center align-items-center clickableTransparent">' +
                    '<div><img src="/images/gamePage/recipes/' + data.recipes[x].icon + '.png" class="itemImage"></div>' +
                    '<div class="px-2 font-size-2">' + data.recipes[x].name + '</div>' +
                    '</div>');
            }
        } else {
            $("#helpBuildingRecipeWrapper").append("<div class='font-size-2'>None</div>");
        }
    }
}