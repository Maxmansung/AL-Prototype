<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
switch($errorMessage){
    case 0:
        $errorText = "It seems the link you have been sent was incomplete, please report this to the admins";
        break;
    case 1:
        $errorText = "The account you are trying to activate does not exist, if you have reached this page by accident then please return to the home page";
        break;
    case 2:
        $errorText = "The details attached to this link are incorrect, this activation attempt has been logged with the admins";
        break;
    case 3:
        $errorText = "This account has already been activated, sign in to get playing!";
        break;
    default:
        $errorText = "Something unexpected has happened, please report this";
        break;
}
?>

<div class="row">
    <div class="col-12 px-3 funkyFont font-size-5" align="center">
       Uh oh!
    </div>
</div>
<div class="row">
    <div class="col-12 px-3 py-2" align="center">
        <?php echo $errorText?>
    </div>
</div>
<div class="row">
    <div class="col-12 px-3 py-2 d-flex flex-row align-items-center justify-content-center" align="center">
        <button class="btn-primary btn" onclick="goToPage('none')">Return</button>
    </div>
</div>
