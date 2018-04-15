<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="container-fluid">
    <div align="center" class="indexPageTitle row justify-content-center mt-md-5 mt-2 font-size-2x">
        <div class="funkyFont m-3 col-md-7 col-11 font-size-5"><?php echo $text->loginMasterPageTitle();?></div>
        <div class="m-3 col-md-7 col-11">
            <?php echo $text->loginMasterPageWriting();?>
        </div>
        <div class="col-12 mb-4 mt-3" align="center">
            <button class="btn btn-primary justify-content-center align-items-center d-flex px-4" onclick="clickSignin()"><span><?php echo $text->loginMasterPagePlayNow();?></span></button>
        </div>
    </div>
    <div class="whiteBackground row justify-content-between blackColour">
        <div class="col-md-6 col-12 p-4 d-flex flex-row justify-content-center align-items-center">
            <img src="/images/loginPage/indexImage.png" class="img-fluid">
        </div>
        <div class="col-md-6 col-12 px-md-4 py-md-2">
            <div class="row">
                <div class="funkyFont font-size-5 col-12 p-0" align="center"><?php echo $text->loginMasterPageAboutTitle();?></div>
            </div>
            <div class="row">
                <div class="col-md-6 col-12 px-4 py-2">
                    <div class="funkyFont font-size-4"><?php echo $text->loginMasterPageDescription1(1);?></div>
                    <div align="justify" class="font-size-2"><?php echo $text->loginMasterPageDescription1(2);?></div>
                </div>
                <div class="col-md-6 col-12 px-4 py-2">
                    <div class="funkyFont font-size-4"><?php echo $text->loginMasterPageDescription2(1);?></div>
                    <div align="justify" class="font-size-2"><?php echo $text->loginMasterPageDescription2(2);?></div>
                </div>
                <div class="col-md-6 col-12 px-4 py-2">
                    <div class="funkyFont font-size-4"><?php echo $text->loginMasterPageDescription3(1);?></div>
                    <div align="justify" class="font-size-2"><?php echo $text->loginMasterPageDescription3(2);?></div>
                </div>
                <div class="col-md-6 col-12 px-4 py-2">
                    <div class="funkyFont font-size-4"><?php echo $text->loginMasterPageDescription4(1);?></div>
                    <div align="justify" class="font-size-2"><?php echo $text->loginMasterPageDescription4(2);?></div>
                </div>
            </div>
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
