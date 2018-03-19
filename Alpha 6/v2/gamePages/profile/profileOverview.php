<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="login-window mt-3 col-12 col-md-5" id="profileOverviewWrap">
    <div class="my-3 mx-1 d-flex flex-row col">
        <div class="profileImage">
            <img src="/avatarimages/Unknown.png" class="avatarImage" id="profilePageImage">
        </div>
        <div class="d-flex flex-column col pr-0">
            <div class="d-flex flex-row justify-content-between">
                <div class="funkyFont font-size-3" id="profilePageName">

                </div>
                <div class="flagImage">
                    <img src="https://www.arctic-lands.com/images/flags/United%20Kingdom.png" id="profilePageFlag">
                </div>
            </div>
            <div class="font-size-2" id="profilePageBio"></div>
        </div>
    </div>
    <div class="row mx-1 justify-content-between align-items-baseline mb-2">
        <div class="font-size-1">
            Last login:
            <span id="profilePageLogin"></span>
        </div>
        <div class="font-size-1">
            Gender:
            <span id="profilePageGender"></span>
        </div>
        <div class="font-size-1">
            Age:
            <span id="profilePageAge"></span>
        </div>
        <?php
        if ($profile->getProfileID() === $person){
            echo '<div class="clickableFlash" onclick="switchEditScreen()">
                    <i class="fas fa-edit"></i>
                </div>';
        }
        ?>
    </div>
</div>
<div class="login-window mt-3 col-12 col-md-5" id="profileEditWrap">
    <div class="row">
        <div class="clickableFlash ml-2 mt-1 funkyFont" onclick="closeEditScreen()">Back</div>
    </div>
    <div class="row justify-content-center funkyFont font-size-3">
        Edit profile
    </div>
    <div class="row mt-1 justify-content-center">
        <div class="col-11 d-flex flex-column">
            <div class="form-text">Bio</div>
            <textarea class="form-control" id="profileBio" rows="3" maxlength="120"></textarea>
        </div>
    </div>
    <div class="row mt-3 justify-content-center">
        <div class="col-11 d-flex flex-row justify-content-between">
            <div class="form-text">Age</div>
            <input type="number" class="form-control col-2" id="profileAge" min="0" max="200">
        </div>
    </div>
    <div class="row mt-3 justify-content-center">
        <div class="col-11 d-flex flex-row justify-content-between">
            <div class="form-text">Gender</div>
            <input type="text" class="form-control col-6" id="profileGender" maxlength="20">
        </div>
    </div>
    <div class="row mt-1 justify-content-center">
        <div class="col-11 d-flex flex-column">
            <div class="form-text">Country</div>
            <select id="profileCountry" selected="">
                <?php
                include_once ($_SERVER['DOCUMENT_ROOT']."/gamePages/profile/profileCountry.php");
                ?>
            </select>
        </div>
    </div>
    <div class="row justify-content-center mt-3">
        <button class="btn btn-dark" onclick="submitProfileEdit()">Submit</button>
    </div>
    <hr class="col-8" style="width: 100%; color: white; height: 1px; background-color:white;">
    <form method="post" id="avatarImageUpload" class="my-3">
        <div class="funkyFont font-size-3">Change Avatar</div>
        <div class="d-flex flex-column justify-content-between align-items-center ">
            <div class="profileImage">
                <img src="/avatarimages/Unknown.png" class="avatarImage" id="profilePageNewImage">
            </div>
            <div class="input-group my-3">
                <div class="input-group-prepend">
                    <span class="input-group-text btn btn-dark" onclick="submitNewImage()">Upload</span>
                </div>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="profileImageUpload">
                    <label class="custom-file-label" for="profileImageUpload">Choose file</label>
                </div>
            </div>
        </div>
        <div class="font-size-1 my-3 grayColour" align="center">
            Your avatar can only be changed once every 12 hours
            <br/>
            <br/>
            Please only upload JPEG,JPG,PNG or GIF files
            <br/>
            <br/>
            File size can be no bigger than 1MB
        </div>
    </form>
</div>
