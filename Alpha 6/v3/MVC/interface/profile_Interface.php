<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
interface profile_Interface
{
    function getProfileID();
    function setProfileID($profileID);
    function getProfileName();
    function setProfileName($var);
    function getPassword();
    function setPassword($password);
    function getProfilePicture();
    function setProfilePicture($profilePicture);
    function getEmail();
    function setEmail($email);
    function getLastLogin();
    function setLastLogin($lastLogin);
    function getLoginIP();
    function setLoginIP($loginIP);
    function getAccountType();
    function setAccountType($accountType);
    function getGameStatus();
    function setGameStatus($gameStatus);
    function getAvatar();
    function setAvatar($avatar);
    function getPasswordRecovery();
    function setPasswordRecovery();
    function getPasswordRecoveryTimer();
    function setPasswordRecoveryTimer();
    function getCookieKey();
    function setCookieKey();
    function getForumPosts();
    function setForumPosts($var);
    function addForumPosts($var);
    function removeForumPosts($var);
    function getReportTimer();
    function setReportTimer($var);
    function getCreatedMap();
    function setCreatedMap($var);
    function getAccessNewMap();
    function setAccessNewMap($var);
    function getAccessEditMap();
    function setAccessEditMap($var);
    function getAccessEditForum();
    function setAccessEditForum($var);
    function getAccessPostNews();
    function setAccessPostNews($var);
    function getAccessActivated();
    function setAccessActivated($var);
    function getAccessAllGames();
    function setAccessAllGames($var);
    function getAccessAdminPage();
    function setAccessAdminPage($var);
}