<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="row justify-content-center">
    <div class="col-12 col-sm-11 standardWrapper mt-5">
        <div class="row justify-content-end font-weight-bold font-size-2x"><div class="mx-3 mt-2 clickableLink" onclick = "selectPage(this.id)" id="none"><i class="fas fa-reply mr-2"></i>Back</div>
        </div>
        <div class="row py-2">
            <div class="col-12 font-weight-bold font-size-4 px-3 " align="center">Finding Chances</div>
        </div>
        <div class="row justify-content-center">
            <div class="input-group mb-3 col-11 col-sm-8 col-md-6 col-lg-4">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="">Modifier</span>
                </div>
                <input type="number" min="-5" max="5" class="form-control" id="modNumber" placeholder="0" value="0" aria-label="Modifier" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" onclick="changeModifier()">Change</button>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-11 col-sm-10 col-md-8 col-lg-6 font-size-2" align="center">
                <b>Drugged:</b> -1<br>
                <b>Frostbite:</b> -2<br>
                <b>Failed Search:</b> +1 (increases each missed search, this is reset when you succeed)<br>
            </div>
        </div>
        <div class="row py-2 justify-content-center testMainWrapper">
        </div>
    </div>
</div>
<script>getItemTestView()</script>