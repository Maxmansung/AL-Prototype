<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
interface newsComments_Interface
{
    function getCommentID();
    function setCommentID($var);
    function getCommentText();
    function setCommentText($var);
    function getCommentTime();
    function setCommentTime($var);
    function getAuthorID();
    function setAuthorID($var);
    function getNewsID();
    function setNewsID($var);
    function getReported();
    function setReported($var);
    function getEditable();
    function setEditable($var);
}