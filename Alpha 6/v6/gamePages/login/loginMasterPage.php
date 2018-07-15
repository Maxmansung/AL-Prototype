<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="container-fluid">
    <div align="center" class="indexPageTitle row justify-content-center mb-md-5 mt-2 font-size-2x">
        <div class="funkyFont m-3 col-md-7 col-11 font-size-5"><?php echo $text->loginMasterPageTitle();?></div>
        <div class="m-3 col-md-7 col-11">
            <?php echo $text->loginMasterPageWriting();?>
        </div>
        <div class="col-12 mb-4 mt-3" align="center">
            <button class="btn btn-primary justify-content-center align-items-center d-flex px-4" onclick="clickRegister()"><span><?php echo $text->loginMasterPagePlayNow();?></span></button>
        </div>
    </div>
    <div class="whiteBackground row justify-content-between blackColour">
        <div class="col-md-6 col-12 p-4 d-flex flex-row justify-content-center align-items-center">
            <img src="/images/loginPage/indexImage.png" class="indexPageImage">
        </div>
        <div class="col-lg-5 col-md-6 col-12 pr-md-4 pr-lg-0 py-md-2">
            <div class="row">
                <div class="funkyFont font-size-5 col-12 p-0" align="center"><?php echo $text->loginMasterPageAboutTitle();?></div>
            </div>
            <div class="row">
                <div class="col-md-6 col-12 px-4 py-2">
                    <div class="funkyFont font-size-4"><?php echo $text->loginMasterPageDescription1(1);?></div>
                    <div align="justify" class="font-size-2"><?php echo $text->loginMasterPageDescription1(2);?></div>
                </div>
                <div class="col-md-6 col-12 px-4 py-2">
                    <div class="funkyFont font-size-4"><?php echo $text->loginMasterPageDescription3(1);?></div>
                    <div align="justify" class="font-size-2"><?php echo $text->loginMasterPageDescription3(2);?></div>
                </div>
                <div class="col-md-6 col-12 px-4 py-2">
                    <div class="funkyFont font-size-4"><?php echo $text->loginMasterPageDescription2(1);?></div>
                    <div align="justify" class="font-size-2"><?php echo $text->loginMasterPageDescription2(2);?></div>
                </div>
                <div class="col-md-6 col-12 px-4 py-2">
                    <div class="funkyFont font-size-4"><?php echo $text->loginMasterPageDescription4(1);?></div>
                    <div align="justify" class="font-size-2"><?php echo $text->loginMasterPageDescription4(2);?></div>
                </div>
            </div>
        </div>
        <div class="col-1 d-none d-lg-block"></div>
    </div>
    <div class="d-md-flex d-none justify-content-between row whiteColour">
        <div class="col-1 d-none d-lg-block"></div>
        <div class="col-7 col-lg-6 col-xl-5 pl-md-5 pl-lg-0 pr-lg-5">
            <div class="font-size-4 pt-3 font-weight-bold font-size-3"><?php echo $text->loginMasterPageOnPhone(1);?></div>
            <div class="font-size-2 pb-4 font-size-2 text-justify">
                <?php echo $text->loginMasterPageOnPhone(2);?>
            </div>
        </div>
        <div class="col-5 col-lg-5 col-xl-6 pt-2 d-flex justify-content-center align-items-end">
            <img src="/images/loginPage/phonesImage.png" class="indexPageImage2">
        </div>
    </div>
    <div class="d-md-none d-flex justify-content-start whiteColour pl-3 font-size-4 py-5">
        Information about phone play here...
    </div>
    <div class="row justify-content-end whiteBackground">
        <div class="col-12 font-size-4 blackColour py-5 pr-5" align="right">...More information coming soon</div>
    </div>
</div>
