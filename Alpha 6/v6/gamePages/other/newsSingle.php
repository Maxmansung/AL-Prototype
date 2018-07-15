<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="row justify-content-end pr-4 pt-2">
    <div class="clickableFlashMore" onclick="goToPage('news')">
        <b><i class="fas fa-reply"></i>Back</b>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-11 standardWrapperTitle d-flex flex-column">
        <div class="font-size-4" id="newsPageTitle"></div>
        <div class="font-size-3 grayColour" id="newsPageDate"></div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-11 pt-3 font-size-2" id="newsPageWriting">
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-11 funkyFont font-size-4 mb-3 standardWrapperTitle" id="newsPageAuthor" align="right">
        Maxmansung
    </div>
</div>
<?php
$profile->getProfileAccess();
if ($profile->getAccessAllGames() === 1){
    echo "<div class='row justify-content-center pb-3'>
                <div class='col-11 pb-2 font-weight-bold' align='center'>
                    <button class='btn btn-primary' data-toggle='collapse' data-target='#showPostMessage' aria-controls='showPostMessage' aria-expanded='false' aria-label='Write Comment'>Write Comment</button>
                </div>
                <div class='col-11 collapse' id='showPostMessage'>
                    <div class='row'>";
                    include($_SERVER['DOCUMENT_ROOT']."/templates/insertTextBox.php");
                    echo "<div class='col-12 font-size-2 grayColour' align='right'>Between 10-5000 chars only please</div>
                    </div>
                    <div class='row justify-content-around py-2' id='postButton'>
                        <button class='btn btn-dark' onclick='postComment()'>Post Comment</button>
                    </div>
                </div>
           </div>";
} else {
    echo "<div class='row justify-content-center pb-3'>
           <div class='col-11 grayColour' align='center'>You cannot comment without being logged in</div>
           </div>";

}
?>
<div class="row justify-content-center">
    <div class="col-11 standardWrapperTitle font-size-3" align="center">
        Comments
    </div>
</div>
<div class="row justify-content-center mb-3" id="newsCommentsWrapper">
</div>
<div class="modal" tabindex="-1" role="dialog" id="reportPostBox" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content blackColour " data-backdrop="static" data-keyboard="false">
            <div class="modal-header justify-content-center font-weight-bold font-size-3">
                <div class="modal-title"></div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="selectComplaint" class="col-form-label"><?php echo $text->forumReportingReasons(0)?></label>
                    <select id="selectComplaint">
                        <option id="Swearing"><?php echo $text->forumReportingReasons(1)?></option>
                        <option id="Abusive"><?php echo $text->forumReportingReasons(2)?></option>
                        <option id="Other"><?php echo $text->forumReportingReasons(3)?></option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="message-text-report" class="col-form-label"><?php echo $text->forumReportingInformation()?></label>
                    <textarea class="form-control" data-limit-rows="true" rows="5"  id="message-text-report"></textarea>
                    <div class="invalid-feedback" id="report-error"></div>
                    <div class="small grayColour" align="right"><?php echo $text->forumReportingInformationDescription()?></div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="modPostWarning" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content blackColour " data-backdrop="static" data-keyboard="false">
            <div class="modal-header justify-content-center font-weight-bold font-size-3">
                <div class="modal-title"></div>
            </div>
            <div class="modal-body">
                <div class="">Are you sure?</div>
            </div>
            <div class="modal-footer justify-content-between">
            </div>
        </div>
    </div>
</div>
<script>getSingleNews()</script>