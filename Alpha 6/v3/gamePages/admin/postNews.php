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
            <div class="col-12 font-weight-bold font-size-4 px-3">News</div>
        </div>
        <div class="row justify-content-center clickable" data-toggle="collapse" data-target="#newNewsPost" aria-expanded="false" aria-controls="newNewsPost">
            <div class="col-11 font-size-2x standardWrapperTitle">Create News Post<i class="fas fa-sort-down ml-4 font-size-4"></i></div>
        </div>
        <div class="row collapse" id="newNewsPost">
            <div class="row justify-content-center">
                <div class="col-11 p-3 darkGrayColour">
                    <div class="row justify-content-center">
                        <div class="col-11 col-md-6 col-lg-5">
                            <input type="text" class="form-control col" id="newsTitle" placeholder="News Title" maxlength="30" autofocus>
                            <div class="invalid-feedback" id="usernameError">Text here</div>
                            <div class="small grayColour" align="right">30 character limit</div>
                        </div>
                    </div>
                </div>
                <div class="col-11">
                <?php
                include($_SERVER['DOCUMENT_ROOT']."/gamePages/forums/forumPostTextbox.php");
                ?>
                </div>
            </div>
            <div class="row mt-2 justify-content-around align-items-center">
                    <button class="btn btn-dark" onclick="postNews(0)">Save for later</button>
                    <button class="btn btn-danger" onclick="postNews(1)">Submit Now</button>
            </div>
        </div>
        <div class="row justify-content-center mt-5">
            <div class="col-11 font-size-2x standardWrapperTitle">Edit News</div>
        </div>
        <div class="row collapse" id="oldNewsPost">
            <div class="row justify-content-center">
                <div class="col-11 p-3 darkGrayColour">
                    <div class="row justify-content-center">
                        <div class="col-11 col-md-6 col-lg-5">
                            <input type="text" class="form-control col" id="newsTitle" placeholder="News Title" maxlength="30" autofocus>
                            <div class="invalid-feedback" id="usernameError">Text here</div>
                            <div class="small grayColour" align="right">30 character limit</div>
                        </div>
                    </div>
                </div>
                <div class="col-11">
                    <?php
                    include($_SERVER['DOCUMENT_ROOT']."/gamePages/forums/forumPostTextbox.php");
                    ?>
                </div>
            </div>
            <div class="row mt-2 justify-content-around align-items-center">
                <button class="btn btn-dark" onclick="editNews(0)">Save for later</button>
                <button class="btn btn-danger" onclick="editNews(1)">Submit Now</button>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-11 p-3 darkGrayColour" id="oldNewsPostWrapper">
                <div class="row adminLink mt-2 py-2">
                    <div class="col font-size-2x font-weight-bold">
                        This is the title
                    </div>
                    <div class="col-auto d-flex flex-row justify-content-around align-items-center">
                        <button class="btn btn-dark btn-sm mx-2" id="1+!edit" onclick="editNewsPost(this.id)">
                            Edit
                        </button>
                        <button class="btn btn-danger btn-sm mx-2">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>getAllNewsEdit()</script>