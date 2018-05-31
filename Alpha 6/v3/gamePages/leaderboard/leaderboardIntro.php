<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="row justify-content-center p-3">
    <div class="col-11" align="center">Here you will see the leaderboards for the different gods. This score will cover a season and each season will last < INSERT MONTHS HERE >. Gain favour by supporting your chosen gods each day, the longer you live then the more favour you will gain. </div>
</div>
<div class="row darkGrayBackground whiteColour justify-content-center justify-content-sm-between my-3 mx-2 p-2">
    <div class="col-11 col-sm-6 col-md-4 d-flex flex-column justify-content-center align-items-center blueColour lightGrayBackground">IMAGE HERE</div>
    <div class="col-11 col-sm-6 col-md-8 p-3 d-flex flex-column">
        <div class="font-weight-bold font-size-2x pb-2" align="left">Cold Gods</div>
        <div class="font-size-2">These are the gods of the lone wolves, they favour those that refuse to team up and that go it alone. They may die fast but they burn bright.<br><br>Its a lonely life under these gods but perhaps that's for the best...</div>
        <div class="mt-3 font-weight-bold font-size-2 grayColour" align="center">Gods that favour these players</div>
        <div class="grayColour font-size-2" align="center">The Great Snowman</div>
    </div>
</div>
<div class="row darkGrayBackground whiteColour justify-content-center justify-content-sm-between my-3 mx-2 p-2">
    <div class="col-11 col-sm-6 col-md-4 d-flex flex-column justify-content-center align-items-center order-1 order-sm-1 blueColour lightGrayBackground"><img src="/images/gamePage/shrines/ice_shrine.png" class="tempShrineImage d-none d-sm-flex"></div>
    <div class="col-11 col-sm-6 col-md-8 p-3 d-flex flex-column order-2 order-sm-2">
        <div class="font-weight-bold  font-size-2x pb-2" align="left">War Gods</div>
        <div class="font-size-2">These gods favour the waring tribes. Find a friend, make a base but don't get too strong. Together you can become more than the individual but beware of those around that might try to take what you have.<br><br>Battle those around to become the last tribe standing</div>
        <div class="mt-3 font-weight-bold font-size-2 grayColour" align="center">Gods that favour these players</div>
        <div class="grayColour font-size-2" align="center">Old Xeadas</div>
    </div>
</div>
<div class="row darkGrayBackground whiteColour justify-content-center justify-content-sm-between my-3 mx-2 p-2">
    <div class="col-11 col-sm-6 col-md-4 d-flex flex-column justify-content-center align-items-center blueColour lightGrayBackground">IMAGE HERE</div>
    <div class="col-11 col-sm-6 col-md-8 p-3 d-flex flex-column">
        <div class="font-weight-bold font-size-2x pb-2" align="left">Life Gods</div>
        <div class="font-size-2">Can you unite the whole land to work together? Only those that shun all other gods will gain their favour. If even one person goes against this the whole land will be shunned by them. <br><br>Either through kindness or force you will need to convince them all of your belief</div>
        <div class="mt-3 font-weight-bold font-size-2 grayColour" align="center">Gods that favour these players</div>
        <div class="grayColour font-size-2" align="center">Dunia's Shadow</div>
    </div>
</div>