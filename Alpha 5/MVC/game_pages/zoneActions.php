<script src="/js/zoneActions_JS.js"></script>
<section id="zoneActionsPageWrap">
    <section class="horizontalWrap">
        <section class="verticalWrapTempDisplay">
            Night Temperature
            <section class="temperatureDisplay">
                <span id="zoneTempDisplay"></span>&degC
            </section>
        </section>
        <section class="verticalWrap">
            <section class="dayShownTitle" id="currentDayDiary">
                Day
                <div id="currentDayInput">

                </div>
            </section>
            <section class="dayShownTitle" id="selectDayDiary">
                View day:
                <select id="daySelectionDrop" name="selectDay">
                    <option value="ERROR">ERROR</option>
                </select>
                <button id="selectDayDiaryButton" onclick="getNewDay()">Find</button>
            </section>
        </section>
        <section class="verticalWrapTempDisplay">
            Survivable Temperature
            <section class="temperatureDisplay">
                <span id="playerTempDisplay"></span>&degC
            </section>
        </section>
    </section>
    <section class="verticalWrap">
        <div id="shrineStatsTitle">
            Favoured Spirits
        </div>
        <div id="shrineStats">
            <canvas id="myCanvas"></canvas>
            <div id="myLegend">Legend</div>
        </div>
    </section>
    <section id="messagesWrapper">
        <section id="messageTypeWrapper">
            <div class="messageTypeSelector" onclick="changeMessages('receive')">
                Letters Received
            </div>
            <div class="messageTypeSelector" onclick="changeMessages('sent')">
                Letters Sent
            </div>
        </section>
        <div id="mailbox">
            <div class="horizontalWrap" id="messagesTitleWrap">
                <div class="titleText">
                Mailbox
                </div>
                <div class="titleTextSmall" id="messagesTypeText">

                </div>
            </div>
            <div id="singleMessagesWrapper">

            </div>
        </div>
    </section>
    <section id="movementLogOverview">
        <div id="movementLogOverviewTitle">
            Zone Diary
        </div>
        <div id="movementLogOverviewActions">

        </div>
    </section>
</section>
<script>
    ajax_All(12,"current",4);
</script>