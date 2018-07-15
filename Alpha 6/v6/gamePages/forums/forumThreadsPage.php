<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
$title = "";
switch($forum){
    case "g":
        $title = $text->forumThreadsTitle($forum);
        break;
    case "mc":
        if ($profile->getAvatar() == ""){
            header("location:/?page=forum");
            exit("No access");
        } else {
            $avatar = new avatarController($profile->getAvatar());
            $map = new mapController($avatar->getMapID());
            $title = '<div class="pr-3">'.$text->forumThreadsTitle($forum).'</div><i class="fas fa-caret-right mr-3"></i><div>'.$map->getName().'</div>';
        }
        break;
    case "pc":
        if ($profile->getAvatar() == ""){
            header("location:/?page=forum");
            exit("No access");
        } else {
            $avatar = new avatarController($profile->getAvatar());
            $party = new partyController($avatar->getPartyID());
            $title = '<div class="pr-3">'.$text->forumThreadsTitle($forum).'</div><i class="fas fa-caret-right mr-3"></i><div>'.$party->getPartyName().'</div>';
        }
        break;
    default:
        header("location:/?page=forum");
        exit("No access");

}
if (isset($_GET['t'])){
    $thread = $_GET['t'];
    if ($thread === "new"){
        $show = "forumNewThread.php";
    } else {
        $show = "forumThreadsPost.php";
        echo "<div class='d-none getDataClass2'  id='" . $thread . "'></div>";
    }
} else {
    $show = "forumPlaceholderPage.php";
}
echo "<div class='d-none getDataClass'  id='".$forum."'></div>"
?>


<div class="row justify-content-center mt-5">
    <div class="col-xl-4 col-lg-5 col-md-6 col-12 font-size-2 standardWrapper mr-lg-5 order-1 order-md-0">
        <div class="row d-flex flex-row align-items-center font-size-2x m-2">
            <div class="pr-3 clickableLink font-weight-bold" onclick="goToCatagories()"><?php echo $text->forumThreadsForums()?></div><i class="fas fa-caret-right mr-3"></i><?php echo $title;?>
        </div>
        <div class="horizontalLine py-3 d-flex flex-row justify-content-center">
            <div class="border-left px-3 clickableLink" onclick="createAlertBox(5,1,'This does not currently work',0)"><?php echo $text->forumThreadsSearch()?></div>
            <div class="border-left border-right px-3 clickableLink" onclick="refreshPage()"><?php echo $text->forumThreadsRefresh()?></div>
            <div class="border-right px-3 clickableLink" onclick="newThreadButton()"><?php echo $text->forumThreadsNewThread()?></div>
        </div>
        <div class="row font-size-2 d-flex flex-row justify-content-between blackColour mx-3">
            <div><?php echo $text->forumThreadsThreads()?></div><div><?php echo $text->forumThreadsResponses()?></div>
        </div>
        <div class="col-12 forumTitleMain px-2">
            <?php echo $text->forumThreadsPriorityThreads()?>
        </div>
        <div class="col-12 p-0 priorityThreadsBox">
        </div>
        <div class="col-12 p-0 otherThreadsBox mt-3">
        </div>
        <div class="row mx-3 justify-content-between changeThreadsPage align-items-center">
        </div>
    </div>
    <?php
    include($_SERVER['DOCUMENT_ROOT']."/gamePages/forums/".$show);
    ?>
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
                    <textarea class="form-control" data-limit-rows="true" rows="10" id="message-text-report"></textarea>
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
<script>
    displayPage()
</script>