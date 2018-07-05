<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
interface profileDetails_Interface
{
    function getProfileID();
    function setProfileID($profileID);
    function getAchievements();
    function setAchievements($achievements);
    function addAchievements($achievements);
    function getAchievementsSolo();
    function setAchievementsSolo($achievements);
    function addAchievementsSolo($achievements);
    function getBio();
    function setBio($var);
    function getCountry();
    function setCountry($var);
    function getGender();
    function setGender($var);
    function getAge();
    function setAge($var);
    function getUploadSecurity();
    function setUploadSecurity();
    function getKeyAchievement1();
    function setKeyAchievement1($var);
    function getKeyAchievement2();
    function setKeyAchievement2($var);
    function getKeyAchievement3();
    function setKeyAchievement3($var);
    function getKeyAchievement4();
    function setKeyAchievement4($var);
    function getFavouriteGod();
    function setFavouriteGod($var);
    function getMainGames();
    function setMainGames($var);
    function increaseMainGames();
    function getSpeedGames();
    function setSpeedGames($var);
    function increaseSpeedGames();
    function getSoloLeaderboard();
    function setSoloLeaderboard($var);
    function getTeamLeaderboard();
    function setTeamLeaderboard($var);
    function getFullLeaderboard();
    function setFullLeaderboard($var);
}