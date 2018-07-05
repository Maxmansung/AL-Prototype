<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
interface achievement_Interface
{
    function getAchievementID();
    function getName();
    function setName($var);
    function getDescription();
    function setDescription($var);
    function getIcon();
    function setIcon($var);
    function getScoreAdjustment();
    function setScoreAdjustment($var);
}