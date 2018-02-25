<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT']."/error/404.php"));
interface forumThread_Interface
{

    function getThreadID();
    function setThreadID($var);
    function getThreadDefinition();
    function setThreadDefinition($var);
    function getThreadTitle();
    function setThreadTitle($var);
    function getCreatorID();
    function setCreatorID($var);
    function getPosts();
    function setPosts($var);
    function getLastUpdate();
    function setLastUpdate($var);
    function getTableName();
    function setTableName($var);
    function getLastPostBy();
    function setLastPostBy($var);

}