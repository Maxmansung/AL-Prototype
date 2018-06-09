<?php
if (isset($accessed) === false){
    header("location:/");
    exit("No access");
}
?>
<div class="row justify-content-center">
    <div class="col-11">
        <div class="row px-3 justify-content-around mb-3 align-items-center">
            <div class="col-12 d-flex flex-column justify-content-center align-items-center">
                <div align="center">You have already created a map</div><div class="funkyFont font-size-5" align="center"><?php echo $map->getName()?></div><div align="center">Once this map has finished you will be able to create another</div>
            </div>
            <div class="col-12 pt-5 darkGrayColour font-size-2" align="center">
                If there is an error with the current map you have created then please make a report to the Admins
            </div>
            <div class="col-12 d-flex flex-row justify-content-center py-3">
                <button class="btn btn-primary" id="<?php echo $map->getMapID()?>" onclick="reportCreatedMap(this.id)">Report Map</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="reportCreatedMapBox" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content blackColour " data-backdrop="static" data-keyboard="false">
            <div class="modal-header justify-content-center font-weight-bold font-size-3">
                <div class="modal-title">Report Map</div>
            </div>
            <div class="modal-body font-size-2">
                <div class="form-group">
                    <label for="selectComplaint" class="col-form-label">Reason for reporting map: </label>
                    <select id="selectComplaint">
                        <option id="Unavailable">Unavailable</option>
                        <option id="Wont end">Wont end</option>
                        <option id="Other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="message-text-report" class="col-form-label">Please give more information about the reason for reporting the map so that the admins understand what is required</label>
                    <textarea class="form-control" id="message-text-report"></textarea>
                    <div class="invalid-feedback" id="report-error"></div>
                    <div class="small grayColour" align="right">Max 500 chars</div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
            </div>
        </div>
    </div>
</div>