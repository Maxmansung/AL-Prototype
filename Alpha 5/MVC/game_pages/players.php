<script src="/js/players_JS.js"></script>
<section id="playerspagewrap">
    <section id="movementLog">
        <div id="movementLogTitle">
            Party Events
        </div>
        <div id="movementLogActions">

        </div>
    </section>
    <section id="playerBox">
        <div class="titleText">Groups</div>
        <section id="playersList">
        </section>
    </section>
    <script>
        ajax_All(25,"none",10);
    </script>
    <div id="disableScreenWriting" class="disabledScreen" onclick="hideWritingScreen()">

    </div>
    <section id="writeNewMessageWrap">
        <div class="horizontalWrap" id="messagePlayerNameLocation">
        </div>
        <div class="horizontalWrap">
            <div class="messageExplanationText">
                Title
            </div>
            <input type="text" id="messageTitleText">
        </div>
        <div class="horizontalWrap">
            <div class="messageExplanationText">
                Message
            </div>
            <textarea id="messageMainText"></textarea>
        </div>
        <div class="centerButtonWrap">
        <div class="buttonToMessage" onclick="sendMessagePlayer()">
            Send
        </div>
        </div>
    </section>
</section>