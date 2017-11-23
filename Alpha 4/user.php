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
                            Avatar Image here
                        </div>
                        <div class="userCardWrap2">
                            <div class="userCardWrap1">
                                <div id="userCardName">
                                    Name here
                                </div>
                                <div id="userCardCountry">
                                    Flag here
                                </div>
                            </div>
                            <div id="userCardScore">
                                This is your level and score
                            </div>
                            <div id="userCardHonour">
                                This is your title
                            </div>
                            <div id="userCardBio">
                                In this section there will be a large amount of writing created by the profile owner. I should be able to extend up to 400 characters and will allow special characters
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
                <div id="userStatistics">
                    <canvas id="myCanvas"></canvas>
                    <div id="myLegend">Legend</div>
                </div>
                <div id="userAchieve">
                    <div id="userAchieveTitle">
                        Achievements
                    </div>
                    <div id="userAchieveList">
                        Achievement list here
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
    ajax_All(35,data);
</script>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/templates/template_pageBottom.php"); ?>
</body>
</html>