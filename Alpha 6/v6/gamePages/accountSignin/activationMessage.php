<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="row">
    <div class="col-12 px-3 funkyFont font-size-5" align="center">
        A spirit activates...
    </div>
</div>
<div class="row">
    <div class="col-12 px-3 py-2" align="center">
        You watch as the world you've lived on for so long begins to blur and as it does all the pain and suffering fades from your body.
    </div>
</div>
<div class="row">
    <div class="col-12 px-3 py-2" align="center">
        For a moment you are at peace, surrounded by a blinding whiteness, when suddenly the feelings come rushing back.
    </div>
</div>
<div class="row">
    <div class="col-12 px-3 py-2" align="center">
        A blast of air hits you, so cold that it burns, and before your fingers numb you feel the smooth edges of the ice below you.
    </div>
</div>
<div class="row">
    <div class="col-12 px-3 py-2" align="center">
        WELCOME "<span class="font-weight-bold" id="profileActivationName"><?php echo $profileName ?></span>"
    </div>
</div>
<div class="row justify-content-center pb-3">
    <div class="form-group col-11 pt-5">
        <input class="form-control" type="password" id="confirmPasswordActivation" placeholder="Confirm Password" autofocus>
        <div class="invalid-feedback" id="confirmPasswordError"></div>
        <label for="confirmPasswordActivation" class="small">
            Confirm your password and get started
        </label>
    </div>
    <button class="btn btn-primary btn-lg" id="confirmButton" onclick="confirmActivation()">Open your eyes</button>
</div>
<script>activationListener()</script>