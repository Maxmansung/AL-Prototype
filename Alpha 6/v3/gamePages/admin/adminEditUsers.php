<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="row justify-content-center">
    <div class="col-12 col-sm-11 standardWrapper mt-5">
        <div class="row justify-content-end font-weight-bold font-size-2x"><div class="mx-3 mt-2 clickableLink" onclick = "selectPage(this.id)" id="none"><i class="fas fa-reply mr-2"></i>Back</div>
        </div>
        <div class="row py-2">
            <div class="col-12 font-weight-bold font-size-4 px-3 standardWrapperTitle">Edit Spirits</div>
        </div>
        <div class="row py-2 ">
            <div class="font-size-2x col-md-6 col-4 d-flex flex-row align-items-center justify-content-end"><div>Find spirit:</div></div>
            <div class="input-group col-8 col-md-6">
                <input type="text" class="form-control" id="adminPageSearchSpirit" placeholder="Username">
                <div class="input-group-append">
                    <div class="input-group-text clickableFlashMore" id="adminPageSearchSpiritButton" onclick="findSpiritAdmin()"><i class="fas fa-search"></i></div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-11" id="adminUsersWrapper">
                <div class="row">
                    <div class="col-11 font-size-3 grayColour p-3" align="center">Please search for a username</div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="adminUserWarning" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content blackColour " data-backdrop="static" data-keyboard="false">
            <div class="modal-header justify-content-center font-weight-bold font-size-3">
                <div class="modal-title">Give Warning</div>
            </div>
            <div class="modal-body">
                <div class="form-group d-flex flex-column justify-content-center align-items-center">
                    <label for="selectWarning" class="col-form-label font-weight-bold">Reason for warning</label>
                    <select id="selectWarning">
                        <option value="1">Agressive behaviour</option>
                        <option value="2">Innaproprite language</option>
                        <option value="3">Being called Andre</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="message-text-report" class="col-form-label font-size-2 font-weight-bold d-flex justify-content-center">Warning Details</label>
                    <textarea class="form-control" id="message-text-report" maxlength="100"></textarea>
                    <div class="invalid-feedback" id="report-error">Please write something</div>
                    <div class="small grayColour" align="right">Max 100 chars</div>
                </div>
                <div class="font-size-2 grayColour" align="center">
                    All warnings are logged, please do not overuse this function or your privileges may be removed
                </div>
            </div>
            <div class="modal-footer justify-content-between">
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="adminUserRank" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content blackColour " data-backdrop="static" data-keyboard="false">
            <div class="modal-header justify-content-center font-weight-bold font-size-3">
                <div class="modal-title">Change Spirit Rank</div>
            </div>
            <div class="modal-body">
                <div class="font-size-2 grayColour" align="center">
                    This should really only be used to activate or deactivate a player. On rare occasions this can be used to edit the moderators if required...
                </div>
                <div class="form-group d-flex flex-column justify-content-center align-items-center">
                    <label for="selectRank" class="col-form-label font-weight-bold">Rank</label>
                    <select id="selectRank" onchange="changeRankText()">
                        <?php
                        if ($profile->getAccountType() == 1){
                            echo '<option value="1a" class="redColour">Developer</option>
                        <option value="2">Admin</option>
                        <option value="3">Moderator</option>
                        <option value="4">Superior Unused</option>
                        <option value="5">Superior</option>
                        <option value="6">Regular</option>
                        <option value="7">Small</option>
                        <option value="8">New</option>
                        <option value="9">Lost</option>';
                        } else if($profile->getAccountType() == 2){
                            echo '<option value="1a" class="redColour">Developer</option>
                        <option value="2a" class="redColour">Admin</option>
                        <option value="3">Moderator</option>
                        <option value="4">Superior Unused</option>
                        <option value="5">Superior</option>
                        <option value="6">Regular</option>
                        <option value="7">Small</option>
                        <option value="8a" class="redColour">New</option>
                        <option value="9">Lost</option>';
                        } else{
                            echo '<option value="0" class="redColour">No Options</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="font-size-2" id="rankExplanation"></div>
            </div>
            <div class="modal-footer justify-content-between">
            </div>
        </div>
    </div>
</div>
<script>adminUserPageLoad()</script>