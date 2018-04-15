<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 d-flex justify-content-between py-3 px-1 font-size-2 pageBottom mt-3">
            <div class="d-flex flex-column align-items-start">
                <div class="font-weight-bold"><?php echo $text->footerGameName() ?></div>
                <div class="font-size-2"><?php echo $text->footerGameVersion() ?></div>
            </div>
            <div class="d-flex flex-column align-items-center">
                <div class="font-weight-bold"><?php echo $text->footerHelpfulTitle() ?></div>
                <div class="clickableLink font-size-2"  onclick="goToPage('help')"><?php echo $text->footerHelpfulHelp() ?></div>
                <div class="clickableLink font-size-2"><a class="unclickableLink" href="https://arcticlandshelp.miraheze.org/wiki/Main_Page"><?php echo $text->footerHelpfulWiki() ?></a></div>
                <div class="clickableLink font-size-2"><a class="unclickableLink" href="http://arcticlandstest.xyz/bugTrack/login_page.php"><?php echo $text->footerHelpfulBug() ?></a></div>
            </div>
            <div class="d-flex flex-column align-items-end">
                <div class="font-weight-bold"><?php echo $text->footerContactTitle() ?></div>
                <div class="clickableLink font-size-2"><a class="unclickableLink" href="mailto:admin@arctic-lands.com"><?php echo $text->footerContactCreator() ?></a></div>
                <div class="clickableLink font-size-2" onclick="goToPage('credits')"><?php echo $text->footerContactCredits() ?></div>
            </div>
        </div>
    </div>
</div>
<div id="loadingScreen">
        <div class="loader"></div>
</div>
<div id="loadingScreen2">
    <img src="/images/baseImages/arctic-land-gif.gif" id="loadingImage">
    <div class="blackColour font-size-5 pt-3 funkyFont"><div class="font-size-3">LOADING...</div></div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="alertBox" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content blackColour " data-backdrop="static" data-keyboard="false">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>