<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
$title = "";
switch($forum){
    case "g":
        $title = '<i class="fas fa-globe mr-4"></i>General Chat';
        break;
    case "mc":
        if ($profile->getAvatar() == ""){
            header("location:/?page=forum");
            exit("No access");
        } else {
            $avatar = new avatarController($profile->getAvatar());
            $map = new mapController($avatar->getMapID());
            $title = '<i class="fas fa-map mr-4"></i>' . $map->getName();
        }
        break;
    case "pc":
        if ($profile->getAvatar() == ""){
            header("location:/?page=forum");
            exit("No access");
        } else {
            $avatar = new avatarController($profile->getAvatar());
            $party = new partyController($avatar->getPartyID());
            $title = '<i class="fas fa-users mr-4"></i>' . $party->getPartyName();
        }
        break;
    default:
        header("location:/?page=forum");
        exit("No access");

}
echo "<div class='d-none getDataClass'  id='".$forum."'></div>"
?>
<div class="row py-2 justify-content-center">
    <?php
    echo '<div class="col-9 d-sm-flex d-none blackColour font-size-4 font-weight-bold my-5 px-0 justify-content-between"><div class="col-8">'.$title.'</div><div class="col-3 clickableFlash" align="right" onclick="goToCatagories()">Back</div></div>
    <div class="col-11 d-sm-none d-flex justify-content-between blackColour font-size-2x font-weight-bold my-3"><div class="col-8">'.$title.'</div><div class="col-3 clickableFlash" align="right" onclick="goToCatagories()">Back</div></div>'
    ?>
</div>
<div class="row justify-content-center d-md-flex d-none">
    <div class="row col-md-10 p-0 forumThreadsWrapper justify-content-between align-items-start">
        <div class="row col-lg-4 col-md-5 font-size-2 ml-3 my-3">
            <div class="row col-12 justify-content-center"><button class="btn btn-dark btn-sm col-8" onclick="newThreadButton()">+ Create a Thread</button></div>
            <div class="row col-12 font-size-2 justify-content-between blackColour">
                <div>Subjects</div><div>Response</div>
            </div>
            <div class="row col-12 forumTitleMain px-2">
                Important threads
            </div>
            <div class="row col-12 p-0 priorityThreadsBox">
            </div>
            <div class="row col-12 forumTitleMain px-2">
            </div>
            <div class="row col-12 p-0 otherThreadsBox">
            </div>
            <div class="row col-12 p-0 justify-content-between changeThreadsPage align-items-center">
            </div>
        </div>
        <?php
        include_once ($_SERVER['DOCUMENT_ROOT']."/gamePages/forums/forumPlaceholderPage.php");
        include_once ($_SERVER['DOCUMENT_ROOT']."/gamePages/forums/forumNewThread.php");
        include_once ($_SERVER['DOCUMENT_ROOT']."/gamePages/forums/forumThreadsPost.php");
        ?>
    </div>
</div>
<div class="container-fluid p-0 mb-3 d-md-none d-flex justify-content-center">
    <div class="col-l2 forumThreadsWrapper">
        <div class="row font-size-2 justify-content-center p-2 m-2" id="forumThreadSelectPhone">
            <button class="btn btn-dark btn-sm col-7 my-3" onclick="newThreadButton()">+ Create a Thread</button>
            <div class="row col-12 font-size-2 justify-content-between blackColour px-4">
                <div>Subjects</div><div>Responses</div>
            </div>
            <div class="col-12 mx-2 forumTitleMain">
                Important threads
            </div>
            <div class="col-12 p-0 priorityThreadsBox">
            </div>
            <div class="col-12 forumTitleMain">
            </div>
            <div class="col-12 p-0 otherThreadsBox">
            </div>
            <div class="row col-12 justify-content-between align-items-center changeThreadsPage">
            </div>
        </div>
        <?php
        include_once ($_SERVER['DOCUMENT_ROOT']."/gamePages/forums/forumThreadPostPhone.php");
        include_once ($_SERVER['DOCUMENT_ROOT']."/gamePages/forums/forumNewThreadPhone.php");
        ?>
    </div>
</div>
<script>
    displayPage()
</script>