<?php
interface forumPost_Interface
{
    function getPostID();
    function setPostID($var);
    function getCreatorID();
    function setCreatorID($var);
    function getPostDate();
    function setPostDate($var);
    function getEditable();
    function setEditable($var);
    function getPostText();
    function setPostText($var);
    function getThreadID();
    function setThreadID($var);
    function getPostCount();
    function setPostCount($var);
}