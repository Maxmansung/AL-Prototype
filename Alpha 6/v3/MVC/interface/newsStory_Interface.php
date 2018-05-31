<?php
interface newsStory_Interface
{
    function getNewsID();
    function setNewsID($var);
    function getTitle();
    function setTitle($var);
    function getAuthor();
    function setAuthor($var);
    function getTimestampPosted();
    function setTimestampPosted($var);
    function autoTimestampPosted();
    function getPostText();
    function setPostText($var);
    function getComments();
    function setComments($var);
    function increaseComments();
    function getMonth();
    function getDay();
    function autoDayMonth();
    function getVisible();
    function setVisible($var);
}