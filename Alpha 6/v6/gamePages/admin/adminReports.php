<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="row justify-content-center">
    <div class="col-12 col-sm-11 standardWrapper mt-5 py-4">
        <div class="row justify-content-end font-weight-bold font-size-2x"><div class="mx-3 clickableLink" onclick = "selectPage(this.id)" id="none"><i class="fas fa-reply mr-2"></i>Back</div>
        </div>
        <div class="row">
            <div class="col-12 font-weight-bold font-size-4 px-3">Reports</div>
        </div>
        <div class="row justify-content-center py-3">
            <div class="col-11 adminCreateInfo font-size-2 p-3">
                If you have access to this section then you are considered a mod, please make sure that you use these responsabilities with care, all actions performed will be recorded and logged and those found to be abusing their powers will be removed from the game.
            </div>
        </div>
        <?php
            if ($profile->getAccessEditForum()===1) {
                echo '<div class="row justify-content-center clickable" data-toggle="collapse" data-target="#forumReports" aria-expanded="false" aria-controls="forumReports">
                        <div class="col-11 font-size-2x standardWrapperTitle">Forum Reports<i class="fas fa-sort-down ml-4 font-size-4"></i></div>
                    </div>
                    <div class="row collapse" id="forumReports">
                    <div class="row justify-content-center py-1 px-2">
                    <div class="col-11 grayColour" align="center">No forum reports currently</div>
                    </div>
                    </div>';
            }
            if ($profile->getAccessEditMap()===1) {
                echo '<div class="row justify-content-center clickable" data-toggle="collapse" data-target="#mapReports" aria-expanded="false" aria-controls="mapReports">
                <div class="col-11 font-size-2x standardWrapperTitle">Map Reports<i class="fas fa-sort-down ml-4 font-size-4"></i></div>
            </div>
            <div class="row collapse" id="mapReports">
                    <div class="row justify-content-center py-1 px-2">
                    <div class="col-11 grayColour" align="center">No map reports currently</div>
                    </div>
            </div>';
            }
        ?>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="reportPosResponse" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content blackColour " data-backdrop="static" data-keyboard="false">
            <div class="modal-header justify-content-center font-weight-bold font-size-3">
                <div class="modal-title"></div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="message-text-report" class="col-form-label">Please write a response to the reporter</label>
                    <textarea class="form-control" id="message-text-report"></textarea>
                    <div class="invalid-feedback" id="report-error">No response written</div>
                    <div class="small grayColour" align="right">Less than 500 char please</div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
            </div>
        </div>
    </div>
</div>
<script>getReportsPage()</script>