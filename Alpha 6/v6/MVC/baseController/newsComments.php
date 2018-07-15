<?php
if (!defined('PROJECT_ROOT')) exit(include($_SERVER['DOCUMENT_ROOT'] . "/error/404.php"));
require_once(PROJECT_ROOT . "/MVC/interface/newsComments_Interface.php");
class newsComments implements newsComments_Interface
{

    protected $commentID;
    protected $commentText;
    protected $commentTime;
    protected $authorID;
    protected $newsID;
    protected $reported;
    protected $editable;

    function returnVars()
    {
        return get_object_vars($this);
    }

    function getCommentID()
    {
        return $this->commentID;
    }

    function setCommentID($var)
    {
        $this->commentID = $var;
    }

    function getCommentText()
    {
        return $this->commentText;
    }

    function setCommentText($var)
    {
        $this->commentText = $var;
    }

    function getCommentTime()
    {
        return $this->commentTime;
    }

    function setCommentTime($var)
    {
        $this->commentTime = $var;
    }

    function getAuthorID()
    {
        return $this->authorID;
    }

    function setAuthorID($var)
    {
        $this->authorID = $var;
    }

    function getNewsID()
    {
        return $this->newsID;
    }

    function setNewsID($var)
    {
        $this->newsID = $var;
    }

    function getReported()
    {
        return $this->reported;
    }

    function setReported($var)
    {
        $this->reported = $var;
    }

    function getEditable()
    {
        return $this->editable;
    }

    function setEditable($var)
    {
        $this->editable = $var;
    }
}