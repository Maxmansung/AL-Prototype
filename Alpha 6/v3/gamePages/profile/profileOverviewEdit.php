<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
echo "<div class='d-none getDataClass'  id='".$profile->getProfileID()."'></div>"
?>
<script src="/js/profilePage.js"></script>
<div class="container-fluid mt-5 mb-2">
    <div class="row px-2 justify-content-center">
        <div class="lightGrayBackground blackColour m-3 p-3 col-12 col-md-5">
            <div class="row justify-content-center font-size-3">
                Personal Details
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
        </div>
        <div class="lightGrayBackground blackColour m-3 p-3 col-12 col-md-5">
            <div class="font-size-3 row justify-content-center">Avatar</div>
            <form method="post" id="avatarImageUpload" class="my-3">
                <div class="row d-flex flex-column justify-content-between align-items-center">
                        <div class="col-8 d-flex flex-row justify-content-center align-items-center">
                            <img src="/avatarimages/Unknown.png" class="avatarImage" id="profilePageNewImage">
                        </div>
                    <div class="col-11 input-group my-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text btn btn-dark" onclick="submitNewImage()">Upload</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="profileImageUpload">
                            <label class="custom-file-label" for="profileImageUpload">Choose file</label>
                        </div>
                    </div>
                </div>
                <div class="font-size-1 my-3 darkGrayColour" align="center">
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
        <div class="lightGrayBackground blackColour m-3 p-3 col-12 col-md-5">
            <div class="row justify-content-center font-size-3">
                Show Reel
            </div>
            <div class="row pt-3">
                <div class="col-3">
                    <div class="favAchivementBorder p-2 d-flex flex-column justify-content-center align-items-center clickableBorder" onclick="profileEditChangeFav(1)" id="favAchieve1">
                        <div class="font-size-2">Fav #1</div>
                        <div class="achievementWrapper lightGrayBackground">
                            <img src="/images/profilePage/achievements/hacker.png" class="achievementImage">
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="favAchivementBorder p-2 d-flex flex-column justify-content-center align-items-center clickableBorder" onclick="profileEditChangeFav(2)" id="favAchieve2">
                        <div class="font-size-2">Fav #2</div>
                        <div class="achievementWrapper lightGrayBackground">
                            <img src="/images/profilePage/achievements/hacker.png" class="achievementImage">
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="favAchivementBorder p-2 d-flex flex-column justify-content-center align-items-center clickableBorder" onclick="profileEditChangeFav(3)" id="favAchieve3">
                        <div class="font-size-2">Fav #3</div>
                        <div class="achievementWrapper lightGrayBackground">
                            <img src="/images/profilePage/achievements/hacker.png" class="achievementImage">
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="favAchivementBorder p-2 d-flex flex-column justify-content-center align-items-center clickableBorder" onclick="profileEditChangeFav(4)" id="favAchieve4">
                        <div class="font-size-2">Fav #4</div>
                        <div class="achievementWrapper lightGrayBackground">
                            <img src="/images/profilePage/achievements/hacker.png" class="achievementImage">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="borderWrapperAchievements d-flex flex-row flex-wrap align-items-center justify-content-center">
                    </div>
                </div>
            </div>
            <div class="row justify-content-center pt-3">
                <button class="btn btn-dark" onclick="submitProfileAchievements()">Submit</button>
            </div>
        </div>
    </div>
</div>
    <script>
        loadProfileEditPage()
    </script>
