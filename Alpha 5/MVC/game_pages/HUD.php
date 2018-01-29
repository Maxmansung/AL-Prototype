<script src="/js/HUD_JS.js"></script>
<div id="HUDWrapper">
    <div id="timeAndTemp">
        <div id="mapNameHUD"></div>
        <div id="daynumber"></div>
        <div id="gameClock"></div>
        <div id="gameCountdown"></div>
        <div class="verticalWrap" id="tempDataWrapper">
            <div class="horizontalWrap">
                <span id='tempwrite'>
                    Night Temp:
                </span>
                <span id="nightTempNumber">

                </span>
            </div>
            <div class="horizontalWrap" id="survivableTempHide">
                <span id='tempwrite'>
                    Lowest Survivable Temp:
                </span>
                <span id="surviveTempNumber">

                </span>
                <div id='tempOverviewHidden'>
                </div>
            </div>
            <div id="tempDataWarning"></div>
        </div>
        <div class="horizontalWrap">
            <div id="staminabox">
                Stamina
                <div id="staminawrapper">
                </div>
            </div>
        </div>
        <div id="readywrap">
        </div>
        <div id="playerStatusView">
        </div>
        <div id="HUDPadding">

        </div>
    </div>
    <div id="expandButton">
        <div id="clickHereImage" onclick="displayGameHUD()">
            H<br>U<br>D
        </div>
    </div>
</div>
