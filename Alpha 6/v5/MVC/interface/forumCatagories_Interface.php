<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
interface forumCatagories_Interface
{
    function getCatagoryID();
    function setCatagoryID($var);
    function getCatagoryName();
    function setCatagoryName($var);
    function getDescription();
    function setDescription($var);
    function getFlavourText();
    function setFlavorText($var);
    function getAccessType();
    function setAccessType($var);
    function getNewPost();
    function setNewPost($var);
}