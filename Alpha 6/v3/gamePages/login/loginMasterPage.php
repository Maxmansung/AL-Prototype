<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="container-fluid">
    <div align="center" class="indexPageTitle row justify-content-center mt-md-5 mt-2">
        <h1 class="funkyFont m-3 col-md-9 col-11"><?php echo $text->loginMasterPageTitle();?></h1>
        <div class="m-3 col-md-9 col-11">
            <?php echo $text->loginMasterPageWriting();?>
        </div>
        <div class="col-12" align="center"><?php echo $text->loginMasterPagePlayNow();?></div>
        <div class="col-12 mb-4 mt-3" align="center">
            <button class="btn btn-primary btn-sm py-0 justify-content-center align-items-center d-flex" onclick="clickRegister()"><i class="fas fa-lock pr-2 font-size-3"></i><span><?php echo $text->loginMasterPageSignupFree();?></span></button>
        </div>
    </div>
    <div class="whiteBackground row justify-content-between blackColour pt-4 px-5">
        <div class="col-md-4 col-12 pr-md-5 pb-5" align="center">
            <div class="funkyFont font-size-4"><?php echo $text->loginMasterPageDescription1(1);?></div>
            <div align="justify" class="font-size-2"><?php echo $text->loginMasterPageDescription1(2);?></div>
        </div>
        <div class="col-md-4 col-12 px-md-5 pb-5" align="center">
            <div class="funkyFont font-size-4"><?php echo $text->loginMasterPageDescription2(1);?></div>
            <div align="justify" class="font-size-2"><?php echo $text->loginMasterPageDescription2(2);?></div>
        </div>
        <div class="col-md-4 col-12 pl-md-5 pb-5" align="center">
            <div class="funkyFont font-size-4"><?php echo $text->loginMasterPageDescription3(1);?></div>
            <div align="justify" class="font-size-2"><?php echo $text->loginMasterPageDescription3(2);?></div>
        </div>
    </div>
    <div class="d-md-flex d-none justify-content-between grayBackground row">
        <div class="col-6 pl-5">
            <div class="font-size-4 blackColour pt-3"><?php echo $text->loginMasterPageOnPhone(1);?></div>
            <div class="font-size-2 blackColour pb-4">
                <?php echo $text->loginMasterPageOnPhone(2);?>
            </div>
        </div>
        <div class="col-5 mt-2" id="phoneImage">
        </div>
    </div>
</div>
