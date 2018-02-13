<script src="/js/HUD_JS.js"></script>
<div id="HUDWrapper">
    <div id="timeAndTemp">
        <div id="tempAndPlaceWrap">
            <div id="mapNameHUD"></div>
            <div id="daynumber"></div>
            <div id="gameClock"></div>
            <div id="gameCountdown"></div>
        </div>
        <div class="verticalWrap" id="tempDataWrapper">
            <div class="tempDescriptionWrapper" >
                <span id='tempwrite'>
                    Zone Temp:
                </span>
                <span id="nightTempNumber">

                </span>
            </div>
            <div class="tempDescriptionWrapper" id="survivableTempHide">
                <span id='tempwrite'>
                    Lowest Survivable Temp:
                </span>
                <span id="surviveTempNumber">

                </span>
                <div id='tempOverviewHidden'>
                </div>
            </div>
        </div>
        <div id="survivalWarning"></div>
        <div class="horizontalWrap">
            <div id="staminabox">
                Stamina
                <div id="staminawrapper">
                </div>
            </div>
        </div>
        <div id="playerStatusView">
        </div>
        <div id="readywrap">
        </div>
    </div>
    <div id="expandButton">
        <div id="clickHereImage" onclick="displayGameHUD()">
        </div>
    </div>
</div>
