<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/templates/check_login.php");
$u = preg_replace('#[^A-Za-z0-9]#i', '', $_GET["u"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="CSS/profile.css">
    <link rel="icon" href="images/iconSnowman.png" type="image/x-icon"/>
    <link rel="shortcut icon" href="images/iconSnowman.png" type="image/x-icon"/>
    <script src="/js/ingame.js"></script>
    <script src="/js/profile_JS.js"></script>
    <script src="/js/canvasFunctions.js"></script>
    <title>Arctic Lands</title>
</head>
<body>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/templates/template_pageTop.php"); ?>
<div id="profileUsername" style="display:none"><?php echo htmlspecialchars($u);?></div>
<article>
        <div id="userpage">
            <div id="userCard">
                <div class="userCardWrap1">
                    <div id="userCardImage">
                    </div>
                    <div class="userCardWrap2">
                        <div class="userCardWrap1">
                            <div id="userCardName">
                            </div>
                            <div id="userCardCountry">
                            </div>
                        </div>
                        <div id="userCardFavour">
                        </div>
                        <div id="userCardHonour">
                        </div>
                        <div id="userCardBio">
                        </div>
                    </div>
                </div>
                <div class="userCardWrap1" id="userCardInfoWrap">
                    <div id="userCardStatus">
                        Town status here
                    </div>
                    <div id="userCardLogin">
                        Last login date here
                    </div>
                    <div id="userCardAge">
                        Profile Age here
                    </div>
                    <div id="userCardGender">
                        Profile Gender here
                    </div>
                </div>
            </div>
            <div id="userShrines">
                <div id="userShrinesTitle">
                    Favour Gained
                </div>
                <div id="userShrinesWrap">
                </div>
            </div>
                <div id="userStatistics">
                    <div id="userAchieveTitle">
                        Statistics
                    </div>
                    <div id="userCanvasWrap">
                        <canvas id="myCanvas">
                        </canvas>
                        <div id="myLegend">
                        </div>
                    </div>
                </div>
                <div id="userAchieve">
                    <div id="userAchieveTitle">
                        Achievements
                    </div>
                    <div id="userAchieveList">
                        Achievement list here
                    </div>
                    <div id="userCardScore">
                    </div>
                </div>
            <div id="searchNewPlayer">
                <span id="searchTitleText">
                    Search for player
                </span>
                <div class="horizontalWrap" id="playerSearchFormat">
                    <div id="playerSearchInput">
                        <div id="searchBoxWrapper">
                            <span id="searchDetailText">
                                Username:
                            </span>
                            <input type="text" id="searchPlayerName">
                            <button id="submitPlayerSearch" onclick="searchForPlayer()">?</button>
                        </div>
                    </div>
                    <div id="foundPlayersListWrapper" class="verticalWrap">
                        <div id="foundPlayersList">
                        </div>
                        <div id='directionalButtonWrapper' class='horizontalWrap'>
                            <button id='less' onclick='displayUsersLess()'>back</button>
                            <div class='verticalWrap'>
                                <span id='totalResults'>
                                </span>
                                <div id='pageNumber'>
                                </div>
                            </div>
                            <button id='more' onclick='displayUsersMore()'>more</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</article>
<script>
    var data = $("#profileUsername").text();
    ajax_All(35,data,12);
</script>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/templates/template_pageBottom.php"); ?>
</body>
</html>