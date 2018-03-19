<?php
?>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<div class="container-fluid pageBottom">
    <div class="row d-flex justify-content-between p-3">
        <div>Created by Maxmansung<br>Email: <a href="mailto:admin@arctic-lands.com">admin@arctic-lands.com</a></div>
        <div>Alpha 0.6.0 build</div>
    </div>
</div>
<div id="loadingScreen">
        <div class="loader"></div>
</div>
<div id="loadingScreen2">
    <img src="/images/SquaidInk/arctic-land-gif.gif" id="loadingImage">
    <div class="blackColour font-size-5 pt-3 funkyFont"><div class="font-size-3">LOADING...</div></div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="alertBox">
    <div class="modal-dialog" role="document">
        <div class="modal-content blackColour">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<script>hideLoading()</script>