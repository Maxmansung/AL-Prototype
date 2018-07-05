<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="row">
    <div class="col-12 standardWrapper infoWrapParty d-none">
        <div class="row pt-2 justify-content-center">
            <div class="col-12 d-flex justify-content-center font-weight-bold align-items-center">
                <div class="zonePartyName mr-2 font-size-5 funkyFont"></div>
                <div class="zonePartyNameEdit clickableFlash" data-toggle="collapse" href="#zonePartyNameEdit" role="button" aria-expanded="false" aria-controls="zonePartyNameEdit"><i class="fas fa-pencil-alt"></i></div>
            </div>
            <div class="col-12 collapse" id="zonePartyNameEdit">
                <div class="row justify-content-center">
                    <input type="text" maxlength="20" placeholder="Party Name" id="partyChangeName">
                    <button class="btn-primary btn btn-sm ml-2" onclick="changePartyName()">Edit</button>
                </div>
                <div class="row justify-content-center font-size-1 grayColour">20 char maximum, no special characters</div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 order-1 order-md-0">
                <div class="row  mt-2" align="center"><div class="col-12 font-weight-bold">Members</div></div>
                <div class="row zonePartyMembersWrap px-2 pb-2">
                </div>
                <div class="row justify-content-center align-items-center">
                <button class="btn btn-dark p-1 m-1" onclick="event.stopPropagation(); goToPage('forum&f=pc')">Message your Party</button>
                </div>
                <div class="row" align="center"><div class="col-12 font-weight-bold requestsTitle">Requests</div></div>
                <div class="row zonePartyRequestsWrap px-2 pb-2">
                </div>
            </div>
            <div class="col-md-6 col-12 px-5 py-3 font-size-2 order-0 order-md-1">
                <div class="d-md-flex d-none mb-4">This is the party page, it will show you the people that are waiting to join your party, it will also give you the option to vote on players that are being kicked or asking to join.</div>
                <div class="row my-md-2 mx-xl-5 mx-lg-3 mx-md-1 redBackgroundTransparent py-5 justify-content-center align-items-center font-weight-bold">Image Here</div>
                <div class="d-md-flex d-none mt-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras id sem volutpat, vehicula leo vel, tempus purus. Maecenas tellus magna, consequat aliquet consectetur eu, gravida efficitur velit.
                </div>
            </div>
        </div>
    </div>
</div>